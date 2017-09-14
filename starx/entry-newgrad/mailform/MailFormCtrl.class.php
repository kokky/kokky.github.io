<?php
session_start();

class MailFormCtrl {
	
	function MailFormCtrl() {
	}
	
	//-----------------------------------------
	// 実行
	//-----------------------------------------
	function execute() {
		
		$_SESSION['session_mode'] = $mode = $this->mode();
		
		switch ( $mode ) {
			case "confirm":
				$this->confirmAction();
				break;
			case "submit":
				$this->submitAction();
				break;
			case "retry":
				$this->retryAction();
				break;
			default;
				$this->defaultAction();
		}
	}
	
	//-----------------------------------------
	// 確認用
	//-----------------------------------------
	function confirmAction() {
		include_once "libs.php";
		include_once "conf.php";
		header("Content-Type: text/html; charset=".ENC_TYPE.";");
		
		$ERR = $this->inputCheck( $form_check );
		$VAL = $this->escape( $form_check, $_POST );
		
		if ($ERR == null) {
			$_SESSION["form"] = $VAL;
			include $form_tpl["confirm"];
		} else {
			include $form_tpl["form"];
		}
	}
	
	//-----------------------------------------
	// 送信用
	//-----------------------------------------
	function submitAction() {
		include_once "libs.php";
		include_once "conf.php";
		require_once "Mailer.class.php";
		header("Content-Type: text/html; charset=".ENC_TYPE.";");
		
		if ($VAL = $_SESSION["form"]) {
			$from = $VAL["mail"];
			
			foreach ($titles as $k => $v) {
				if ($form_check[$k]["moji"]) {
					$VAL[$k] = $this->convert_error_moji($VAL[$k], $error_moji);
				} else if ($form_check[$k]["checkbox"]) {
					$VAL[$k] = jo($VAL[$k]);
				}
//				$body .= $separate_line."\n";
				$body .= $v.$VAL[$k]."\n";
			}
//			$body .= $separate_line."\n";

			//to admin
			Mailer::send(MAIL_TO, $from, $admin_subject, $admin_header."\n\n".$body.$admin_footer, $Cc_mail_list, $Bcc_mail_list);
			
			//to user
			if ($user_confirm) {
				Mailer::send($from, MAIL_TO, $user_subject, $VAL['name'].$user_header."\n\n".$body.$user_footer, $Cc_mail_list, $Bcc_mail_list);
			}

			$_SESSION = array();
			include $form_tpl["thanks"];
		} else {
			include $form_tpl["form"];
		}
	}
	
	//-----------------------------------------
	// 再記入用
	//-----------------------------------------
	function retryAction() {
		include_once "libs.php";
		include_once "conf.php";
		header("Content-Type: text/html; charset=".ENC_TYPE.";");
		
		$VAL = $_SESSION["form"];
		unset($_SESSION["form"]);
		
		include $form_tpl["form"];
	}
	
	//-----------------------------------------
	// デフォルト用
	//-----------------------------------------
	function defaultAction() {
		include_once "libs.php";
		include_once "conf.php";
		
		$_SESSION = array();
		$_SESSION['session_mode'] = 'default';
		
		include $form_tpl["form"];
	}
	
	//-----------------------------------------
	// モード取得
	//-----------------------------------------
	function mode() {
		
		$mode = isset($_POST["mode"]) ? $_POST["mode"] : "";
		
		if (!isset($_SESSION['session_mode'])) {
			$mode = '';
		}
		else if (isset($_POST["retry_x"]) && isset($_POST["retry_y"])) {
			$mode = "retry";
		}
		else if (isset($_POST["submit_x"]) && isset($_POST["submit_y"])) {
			$mode = "submit";
		}
		
		return $mode;
	}
	
	//-----------------------------------------
	// タイトルリスト作成
	//-----------------------------------------
	function convert_error_moji($str, $error_moji) {
		
		$keys = array_keys($error_moji);
		$match = implode($keys, '|');
		if (preg_match_all('/'.$match.'/', $str, $matches)) {
			foreach ($matches[0] as $v) {
				$str = str_replace($v, $error_moji[$v], $str);
			}
		}
		return $str;
	}
	
	//-----------------------------------------
	// escape
	//-----------------------------------------
	function escape($form_check, $_post) {
		$val = array();
		foreach ($form_check as $k => $v) {
			$tmp = isset($_post[$k]) ? $_post[$k] : '';
			if ((isset($v["num"]) && $v["num"]>0) ||
				(isset($v["tel"]) && $v["tel"]>0)) {
				$tmp = mb_convert_kana($tmp,"a");
			}
			if (isset($v["mail"]) && $v["mail"]) $tmp = mb_convert_kana($tmp, 'an');
			if (isset($v["checkbox"]) && $v["checkbox"] && is_array($tmp)) {
				$val[$k] = $tmp;
				continue;
			}
			$val[$k] = htmlspecialchars(stripslashes($tmp));
		}
		
		return $val;
	}
	
	//-----------------------------------------
	// 以下入力チェック
	//-----------------------------------------
	function inputCheck($form_check) {
		$err = array();

		foreach ($form_check as $title => $list) {

			if (!is_array($list)) continue;
			foreach ($list as $k => $v) {
				switch ($k) {
					//空欄チェック
					case "null":
						if ($v) {
							if ( !isset($_POST[$title]) || $this->checkNull($_POST[$title]) ) {
								$err[$title] = "<p class='error'>{$v}してください</p>";
							}
						}
						break;
					//文字数チェック
					case "length":
						if ($v > 0) {
							if ( isset($_POST[$title]) && $this->checkLength($_POST[$title], $v) ) {
								$n = mb_strlen($_POST[$title], ENC_TYPE) - $v;
								$err[$title] = "<p class='error'>{$n}文字オーバーです</p>";
							}
						}
						break;
					//メールチェック
					case "mail":
						if ($v > 0) {
							if ( isset($_POST[$title]) && $this->checkMail($_POST[$title]) ) {
								$err[$title] = "<p class='error'>メールアドレス形式で記入してください</p>";
							}
						}
						break;
					//メール再確認
					case "mailcheck":
						if ($v) {
							if ( isset($_POST[$title]) && $_POST[$title] != $_POST[$v] ) {
								$err[$title] = "<p class='error'>同じメールアドレスを記入してください</p>";
							}
						}
						break;
					//電話チェック
					case "tel":
						if ($v > 0) {
							if ( isset($_POST[$title]) && $this->checkTel($_POST[$title]) ) {
								$err[$title] = "<p class='error'>数字で記入してください</p>";
							}
						}
						break;
					//数字チェック
					case "num":
						if ($v > 0) {
							if ( isset($_POST[$title]) && $this->checkNum($_POST[$title]) ) {
								$err[$title] = "<p class='error'>数字で記入してください</p>";
							}
						}
						break;
					//チェックボックス
				}
			}

		}
		if (count($err) == 0) return null;
		else return $err;
		
	}

  // checkMail
  function checkMail($value)
  {
  	$value = mb_convert_kana($value,"an");
  	
    if (!preg_match('/^[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+$/',$value) && strlen($value) > 0) {
      return true;
    }
    return false;
  }
	
  // checkTel
	function checkTel($value)
	{
		$value = mb_convert_kana($value,"an");
		$value = str_replace("-", "", $value);
		return ( !is_numeric($value) );
	}
  
  // checkPost
  function checkPost($value)
  {
	$str = str_replace("-", "", $value);
	if ( $this->checkNum($str) ) {
		return true;
	}
	else if (mb_strlen($str, ENC_TYPE) != 7) {
		return true;
	}
	return false;
  }
	
  // checkNum
  function checkNum($value)
  {
  	$value = mb_convert_kana($value,"an");
    if (!is_numeric($value) && $value) {
      return true;
    }else if ( $value < 0 ) {
      return true;
    }
    return false;
  }
	
  // checkLength
  function checkLength($value, $length)
  {
    if ($length < mb_strlen($value, ENC_TYPE)) {
      return true;
    }
    return false;
  }
	
  // checkNull
  function checkNull($value)
  {
    if("" == preg_replace("/\r|\n|\r\n|\t|| /", "", $value)) {
      return true;
    }
    return false;
  }
}

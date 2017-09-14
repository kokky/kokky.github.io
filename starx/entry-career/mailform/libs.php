<?php
$error_moji = array(
"①" => "(1)",
"②" => "(2)",
"③" => "(3)",
"④" => "(4)",
"⑤" => "(5)",
"⑥" => "(6)",
"⑦" => "(7)",
"⑧" => "(8)",
"⑨" => "(9)",
"⑩" => "(10)",
"⑪" => "(11)",
"⑫" => "(12)",
"⑬" => "(13)",
"⑭" => "(14)",
"⑮" => "(15)",
"⑯" => "(16)",
"⑰" => "(17)",
"⑱" => "(18)",
"⑲" => "(19)",
"⑳" => "(20)",
"Ⅰ" => "1",
"Ⅱ" => "2",
"Ⅲ" => "3",
"Ⅳ" => "4",
"Ⅴ" => "5",
"Ⅵ" => "6",
"Ⅶ" => "7",
"Ⅷ" => "8",
"Ⅸ" => "9",
"Ⅹ" => "10",
"ⅰ" => "1",
"ⅱ" => "2",
"ⅲ" => "3",
"ⅳ" => "4",
"ⅴ" => "5",
"ⅵ" => "6",
"ⅶ" => "7",
"ⅷ" => "8",
"ⅸ" => "9",
"ⅹ" => "10",
"㊤" => "(上)",
"㊥" => "(中)",
"㊦" => "(下)",
"㊧" => "(左)",
"㊨" => "(右)",
"㍉" => "ミリ",
"㍍" => "メートル",
"㌔" => "キロ",
"㌘" => "グラム",
"㌧" => "トン",
"㌦" => "ドル",
"㍑" => "リットル",
"㌫" => "パーセント",
"㌢" => "センチ",
"㎝" => "cm",
"㎏" => "kg",
"㎡" => "(m2)",
"㏍" => "k.k.",
"℡" => "Tel",
"№" => "No.",
"㍻" => "平成",
"㍼" => "昭和",
"㍽" => "大正",
"㍾" => "明治",
"㈱" => "(株)",
"㈲" => "(有)",
"㈹" => "(代)"
);



function br($value) {
   $value = str_replace("\r", "", $value);
   $value = str_replace("\n", "<br>", $value);
   return $value;
}

function esc($value) {
    $value = htmlspecialchars($value);
    $value = br($value);
    
    $value = mb_convert_kana($value, "KVa");
    $value = str_replace("\t", " ", $value);
    $value = str_replace('"', "”", $value);
    $value = str_replace("\\", "￥", $value);
    $value = str_replace("`", "‘", $value);
    $value = str_replace("'", "’", $value);
    $value = str_replace(";", "；", $value);
    $value = str_replace("%", "％", $value);
    $value = str_replace(",", "、", $value);
    
    $value = str_replace("javascript:", "javascript：", $value);
    
    return $value;
}

function escAll($ary) {
  $tmp = array();
  foreach ($ary as $key => $value) {
    $tmp[$key] = escape($value);
  }
  return $tmp;
}

function select($name, $arr, $VAL, $placeholder="") {
	$k = $VAL[$name];
	$pull = "<select name='{$name}'>\n";
	if ($placeholder != "") $pull = $pull."<option value=''>".$placeholder."</option>\n";
	foreach ($arr as $key => $val) {
		if ($k!="" && $k == $key){$select = " selected";}
		$pull .= "<option value='".$key."'".$select.">".$val."</option>\n";
		$select = "";
	}
	$pull .= "</select>\n";
	return $pull;
}

function select_group($name, $arr, $VAL, $placeholder="") {
	$k = $VAL[$name];
	$pull = "<select name='{$name}'>\n";
	if ($placeholder != "") $pull = $pull."<option value=''>".$placeholder."</option>\n";
	foreach ($arr as $arr2) {
		if (is_array($arr2)) {
			foreach ($arr2 as $key => $val) {
				if ($k!="" && $k == $key){$select = " selected";}
				$pull .= "<option value='".$key."'".$select.">".$val."</option>\n";
				$select = "";
			}
			$pull .= "</optgroup>\n";
		} else {
			$pull .= "<optgroup label='{$arr2}'>\n";
		}
	}
	$pull .= "</select>\n";
	return $pull;
}

function radio($name, $value, $check, $class=false) {
	$checked = ($value==$check[$name]) ? " checked" : "";
	if ($class!=false) $style = 'class="'.$class.'"';
	return "<input type='radio' name='{$name}' value='{$value}'{$checked} {$style}>";
}

function checkbox1($name, $value, $check, $class=false) {
  $checked = ($value==$check) ? " checked" : "";
  if ($class!=false) $style = 'class="'.$class.'"';
  return "<input type='checkbox'{$style} name='{$name}' value='{$value}'{$checked}>";
}

function checkbox($name, $value, $check, $class = false) {
  $checked = ($value==$check[$name][$value]) ? " checked" : "";
  if ($class!=false) $style = 'class="'.$class.'"';
  return "<input type='checkbox'{$style} name='{$name}[{$value}]' value='{$value}'{$checked}>";
}

function textarea($name, $cols, $rows, $value) {
	return "<textarea name='{$name}' cols='{$cols}' rows='{$rows}'>{$value}</textarea>";
}

function text($name, $length, $max, $value, $class=false) {
	if ($class!=false) $style = 'class="'.$class.'"';
	if ($length!="") $length = 'size="'.$length.'" ';
	return "<input type='text' name='{$name}' {$length} maxlength='{$max}' value='{$value}' {$style}>";
}

function password($name, $length, $max, $value) {
	return "<input type='password' name='{$name}' size='{$length}' maxlength='{$max}' value='{$value}'>";
}

function hidden($name, $value) {
	return "<input type='hidden' name='{$name}' value='{$value}'>";
}

function submit($name, $value) {
	return "<input type='submit' name='{$name}' value='{$value}'>";
}

function euc2sjis($arg) {
  return mb_convert_encoding($arg, "SJIS", "EUC-JP");
}

function sjis2euc($arg) {
  return mb_convert_encoding($arg, "EUC-JP", "SJIS");
}

function sjis2utf($arg) {
  return mb_convert_encoding($arg, "UTF8", "SJIS");
}

function utf2sjis($arg) {
  return mb_convert_encoding($arg, "SJIS", "UTF8");
}

function el($param, $def = "") {
  if ($param != "") {
  	echo $param."<br>";
  }
  else if ($def != "") {
  	echo $def."<br>";
  }
}

function e($str, $def = "") {
  if ($str !== "") {
  	echo $str;
  }
  else if ($def != "") {
  	echo $def;
  }
}

function pr($param) {
  echo "<pre>";
  if (is_array) print_r($param);
  else echo $param;
  echo "</pre>";
}

function h($val) {
	return htmlspecialchars($val, ENT_QUOTES)."&nbsp;";
}

function jo($arr) {
	return implode(', ', $arr);
}

function put($val) {
	if (!is_array($val)) {
		return br(h($val));
	} else {
		return jo($val);
	}
}

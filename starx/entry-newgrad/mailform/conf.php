<?php
define("ENC_TYPE", "UTF-8");
mb_language("Japanese");
mb_internal_encoding(ENC_TYPE);
mb_http_output(ENC_TYPE);

//TO
define("MAIL_TO", "recruit@starx.co.jp");
//CC
$Cc_mail_list = array();
//BCC
$Bcc_mail_list = array();

// for admin ---------------------
//管理者メールタイトル
$admin_subject = "採用サイトから新卒エントリーがありました。";
//管理者メール ヘッダメッセージ
$admin_header = <<< EOF
EOF;
//管理者メール フッタメッセージ
$admin_footer = <<< EOF
EOF;

// for user ---------------------
//確認メール送るかどうか
$user_confirm = true;
//確認メールタイトル
$user_subject = "エントリーありがとうございます。";
//確認メール ヘッダメッセージ
$user_header = <<< EOF
 様


この度は、スタークス株式会社新卒採用に
エントリーいただき誠にありがとうございます。


採用担当より、1週間以内にご連絡させていただきますので、
今しばらくお待ちくださいませ。


以下、ご応募いただいたエントリー内容となっております。


────────────────────────────
EOF;
//確認メール フッタメッセージ
$user_footer = <<< EOF

────────────────────────────
　
　［スタークス株式会社について］
　◆Facebook：https://www.facebook.com/starx.recruit/
　◆社員ブログ：http://starx-members.hatenablog.com/
　◆instagram：https://www.instagram.com/join_starx/


ご不明点な点等ございましたら、
お気兼ねなく下記までお問合せください。


何卒よろしくお願い申し上げます。



＊＊＊−−−−−−−−−−−−−−−−−−−−−−−−−
スタークス株式会社
採用担当

recruit@starx.co.jp


〒184-0043 東京都港区白金台3-19-1興和白金台ビル7F
Tel:03-6455-6921　
Fax:03-6455-6932

−−−−−−−−−−−−−−−−−−−−−−−−−＊＊＊
EOF;

//---------------------------------

$form_check = array(
	 "name"       => array("null" => "入力", "length" => 40,   "moji" => 1)
	,"kana"       => array("null" => "入力", "length" => 40)
	,"mail"       => array("null" => "入力", "length" => 100,  "mail" => 1)
	,"tel"        => array("null" => "入力", "length" => 30, "tel" => 1)
	,"sex"        => array("null" => "選択")
	,"school"     => array("null" => "入力")
	,"department" => array("length" => 200)
	,"graduation" => array("null" => "入力", "length" => 50)
	,"entry"      => array("null" => "選択")
);


$titles = array(
	 "name"     => "【お名前】 "
	,"kana"     => "【フリガナ】 "
	,"mail"     => "【メールアドレス】 "
	,"tel"      => "【電話番号】"
	,"sex"      => "【性別】"
	,"school"     => "【学校名】"
	,"department"  => "【学部名】"
	,"graduation"  => "【卒業見込み年度】"
	,"entry"    => "【エントリーのきっかけ】"
);

$separate_line = "----------------------------------------------";

$form_tpl = array(
	"form"    => "form.html",
	"confirm" => "confirm.html",
	"thanks"  => "thanks.html"
);

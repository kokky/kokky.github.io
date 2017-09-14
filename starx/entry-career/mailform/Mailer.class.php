<?php
class Mailer {
	
	function ENC() {return ENC_TYPE; }
	
	function send( $to, $from, $subject, $body, $Cc = false, $Bcc = false ) {
		
		if (!$from) $from = $to;
		$header  = "From: ".$from."\n";
		$header .= "X-Sender: <".$from.">\n";
		$header .= "X-Mailer: PHP/".phpversion()."\n";
		$header .= "MIME-version: 1.0\n";
		$header .= "Return-Path: ".$to."\n";
		$header .= "Content-Type: text/plain; charset=\"iso-2022-jp\"\n";
		$header .= "Content-Transfer-Encoding: 7bit\n";
		$header .= "X-HOST: ".@gethostbyaddr(getenv("REMOTE_ADDR"))."\n";
		
		//Cc
		if ($Cc && is_array($Cc) && count($Cc) > 0)
			$header .= 'Cc: '. (implode(",", $Cc)) . "\n";
		
		//Bcc
		if ($Bcc && is_array($Bcc) && count($Bcc) > 0)
			$header .= 'Bcc: '. (implode(",", $Bcc)) . "\n";
		
		$header  = Mailer::encode( $header );
		$body    = Mailer::encode( $body );
		$subject = Mailer::encodeSubject( $subject );
		
		if(mail($to,$subject,$body,$header)) return true;
		else return false;
	}
	
	function encode( $str ) {
		return @mb_convert_encoding( $str,"JIS",Mailer::ENC() );
	}

	function encodeSubject($subject) {
		return "=?iso-2022-jp?B?".base64_encode(@mb_convert_encoding($subject,"JIS",Mailer::ENC()))."?=";
	}
}
?>
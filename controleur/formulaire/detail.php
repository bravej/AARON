<?php
	session_start();
?>
<?php
	$uid = $_GET['uid'];
	
	$gmail = 'gmail.com';
	$yahoo = 'mail.yahoo.com';
  		 
	$mbox =imap_open("{imap.".$_COOKIE['boxmail'].":993/imap/ssl}", $_COOKIE['email'], $_COOKIE['pass']);
	
	if (FALSE === $mbox) {			
      die('echec !!!');
    } else {
      
      $headerText = imap_fetchHeader($mbox, $uid, FT_UID);
      $header = imap_rfc822_parse_headers($headerText);

      // REM: Attention s'il y a plusieurs sections
      $corps = imap_fetchbody($mbox, $uid, 1, FT_UID);
    }
	imap_close($mbox);

	$from=$header->from;
	$msg = "Message de:".$from[0]->personal." [".$from[0]->mailbox."@".$from[0]->host."]<br>";
	$msg .= $corps;
	
	include('../../vue/formulaire/Info.php');
?>
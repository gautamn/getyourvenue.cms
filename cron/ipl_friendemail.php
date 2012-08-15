<?php
error_reporting(E_ALL^E_DEPRECATED^E_NOTICE^E_WARNING);
include  "cronsettings.php";
//include dirname(__FILE__) . "/mail.php";

$remote = mysql_connect(DBHOST,DBUSER,DBPASS) or die ('Error ');
mysql_select_db(DBNAME, $remote);

//$mail = new sendmail();
$Query = "SELECT * From  mail_log WHERE status = 0 AND to_mail !='' AND to_mail LIKE  '%@%' ORDER BY id DESC LIMIT 20";
$res = mysql_query($Query, $remote) or die (mysql_error());
while($row = mysql_fetch_array($res)){	
	echo "\nSending mail to ".$row['to_mail']." Subject ".$row['subject']." -- ".$row['mail_time'];
	$mail->to       = stripslashes($row['to_mail']);
	$mail->from     = stripslashes($row['from_mail']);
	$mail->subject  = stripslashes($row['subject']);
	$mail->body	= stripslashes($row['body']);

	$mailStatus = $mail->sendMail();
	if ($mailStatus) {
		$QueryUpdate = "UPDATE tm_mail_log SET status = '1', mail_send = NOW() WHERE id= '".$row['id']."'";
		mysql_query($QueryUpdate, $remote );			
	}
	else {
		$QueryUpdate = "UPDATE tm_mail_log SET counter = counter+1 WHERE id= '".$row['id']."'";
		mysql_query($QueryUpdate, $remote );			
	}	
	usleep(1);
}	
mysql_close($remote);
?>

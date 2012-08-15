<?php
require_once "Mail.php";
include('Mail/mime.php');
class sendmail {
        public $host = MAILHOST;//'nmailer.indiatimes.com';
        public $from;
        public $to;
        public $subject;
        public $body;
        public $bcc;
        public $cc;

        public function sendMail() {
                $body = $this->body;
                $host = MAILHOST;
                $from = MAILFROM;
		
		$sendArray = explode(';',$this->to);
		if(count($sendArray)>1) {
		    foreach($sendArray as $mailto) {
                	$headers = array ('MIME-Version' => "1.0", 'Content-type' => "text/html; charset=iso-8859-1;", 'From' => $from, 'To' => $mailto, 'Reply-To' => MAILREPLYTO, 'Subject' => $this->subject);
                	$smtp = Mail::factory('smtp',
                	array ('host' => $host,'auth' => FALSE ));
                	$mail = $smtp->send($mailto, $headers, $this->body);
		    }
	
		}
		else {
                	$headers = array ('MIME-Version' => "1.0", 'Content-type' => "text/html; charset=iso-8859-1;", 'From' => $from, 'To' => $this->to, 'Reply-To' => MAILREPLYTO, 'Subject' => $this->subject);
                	$smtp = Mail::factory('smtp',
                	array ('host' => $host,'auth' => FALSE ));
                	$mail = $smtp->send($this->to, $headers, $this->body);
		}
                if (PEAR::isError($mail)) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }
}
?>

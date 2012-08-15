<?php
//require_once "Mail.php";
include('Mail/mime.php');

class sendmail {
        public $host = 'smtp.gmail.com';
        public $port = "465";
        public $username = "mirchi.indiatimes@gmail.com";
        public $password = "cmsmirchi";
        public $auth = TRUE;
        public $reply_to = "mirchi.indiatimes@gmail.com";
        public $content_type = "text/html; charset=iso-8859-1";
        public $return_path = "mirchi.indiatimes@gamil.com";

        public $from;
        public $to;
        public $subject;
        public $body;
        public $bcc;
        public $cc;

        public function send() {
                $headers = array ('From' => $this->from, 'To' => $this->to, 'Subject' => $this->subject);

                $params["host"]    = $this->host;
                $params["auth"]    = $this->auth;
                $params["username"]    = $this->username;
                $params["password"]    = $this->password;

                $crlf = "\n";
                $mime = new Mail_mime($crlf);
                $mime->setHTMLBody($this->body);
                $body = $mime->get();
                $hdrs = $mime->headers($headers);
                //$mail =& Mail::factory('mail'); //smtp',$params);
                //$mail->send($this->to, $hdrs, $body);

                //if (PEAR::isError($mail)) {
                        //echo $res->getMessage();
                //}
               // else
                 //       return true;
                }
 }
?>

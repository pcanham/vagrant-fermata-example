<?php
class SMTPClient
{

function SMTPClient ($SmtpServer, $SmtpPort, $from, $to, $subject, $body)
{

$this->SmtpServer = $SmtpServer;
$this->from = $from;
$this->to = $to;
$this->subject = $subject;
$this->body = $body;

if ($SmtpPort == "") 
{
$this->PortSMTP = 25;
}
else
{
$this->PortSMTP = $SmtpPort;
}
}

function SendMail ()
{
if ($SMTPIN = fsockopen ($this->SmtpServer, $this->PortSMTP)) 
{
fputs ($SMTPIN, "EHLO ".$_SERVER['HTTP_HOST']."\r\n"); 
$talk["hello"] = fgets ( $SMTPIN, 1024 ); 
fputs ($SMTPIN, "MAIL FROM: <".$this->from.">\r\n"); 
$talk["From"] = fgets ( $SMTPIN, 1024 ); 
fputs ($SMTPIN, "RCPT TO: <".$this->to.">\r\n"); 
$talk["To"] = fgets ($SMTPIN, 1024); 
fputs($SMTPIN, "DATA\r\n");
$talk["data"]=fgets( $SMTPIN,1024 );
fputs($SMTPIN, "To: <".$this->to.">\r\nFrom: <".$this->from.">\r\nSubject:".$this->subject."\r\n\r\n\r\n".$this->body."\r\n.\r\n");
$talk["send"]=fgets($SMTPIN,256);
//CLOSE CONNECTION AND EXIT ... 
fputs ($SMTPIN, "QUIT\r\n"); 
fclose($SMTPIN); 
// 
} 
return $talk;
} 
}
?>

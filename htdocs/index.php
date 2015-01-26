<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include('SMTPClass.php');
$SmtpServer = $_POST['SmtpServer'];
$SmtpPort = $_POST['SmtpPort'];
$to = $_POST['to'];
$from = $_POST['from'];
$subject = $_POST['sub'];
$body = $_POST['message'];
$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $from, $to, $subject, $body);
$SMTPChat = $SMTPMail->SendMail();
}
?>
<form method="post" action="">
<table>
<tbody>
	<tr>
		<th>Spam Generator</th>
	</tr>
	<tr>
		<td>SMTP Server:</td><td><input type="text" name="SmtpServer" value="localhost" size="35" /></td>
	</tr>
	<tr>
		<td>SMTP Port:</td><td><input type="text" name="SmtpPort" value="2500" size="35" /></td>
	</tr>
	<tr>
		<td>To:</td><td><input type="text" name="to" size="35" value="recipient@example.com" /></td>
	</tr>
	<tr>
		<td>From:</td><td><input type='text' name="from" size="35" value="sender@example.com" /></td>
	</tr>
	<tr>
		<td>Subject:</td><td><input type='text' name="sub" size="35" value="Test Email Subject" /></td>
	</tr>
	<tr>
		<td>Message:</td><td><textarea name="message" cols="31" rows="5"></textarea></td>
	</tr>		
	<tr>
		<td><input type="submit" value=" Send " /></td>
	</tr>
</tbody>
</table>
</form>





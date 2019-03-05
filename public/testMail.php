<?php
$to      = 'nicckk3@gmail.com';
$subject = 'This is test mail';
$message = 'Hello';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>
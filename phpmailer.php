<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
$from = 'no-reply@harbourislandcommonage.com';
$to = 'uroosasehar786@outlook.com';
$subject = 'PHP mail functionality';
$message = 'PHP mail check';
$headers = 'From:'.$from;
if (mail($to, $subject, $message, $headers)) {
    echo 'The email message was sent.';
} else {
    echo 'The email message was not sent.';
}

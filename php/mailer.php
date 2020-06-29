<?php
if (!isset($_POST["name"] || $_POST["email"] || $_POST["subject"] || $_POST["msg"])) {
    echo "Please fill out all form fields";
}
if ($_POST[!empty()]) {
    $to = 'satherc@go.stockton.edu';
    $subject = 'Message from'+$_POST["sender"];
    $message = $_POST["msg"];
    mail($to,$subject,$message);
}


?>
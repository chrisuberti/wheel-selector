<?php

//Do NOT upload this document
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com'; //change this
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'Your email'; //change this
    $config['smtp_pass'] = 'Your Password'; //change this
    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
?>
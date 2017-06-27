<?php

require_once(__DIR__ . '/vendor/autoload.php');
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\SwiftMailerHandler;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Formatter\HtmlFormatter;
// Create the logger
$logger = new Logger('maillogger');
$logtext= new Logger('textlogger');
// Now add some handlers
$logtext->pushHandler(new RotatingFileHandler(__DIR__.'/files/baselog.log',60, Logger::DEBUG));
$logtext->pushProcessor(new IntrospectionProcessor(Logger::INFO));

$transport= new Swift_SmtpTransport("smtp.gmail.com", 465,"ssl");
$transport->setUsername("anand@theiab.org");
$transport->setPassword("admin@2017");
$mailer = new Swift_Mailer($transport);
$htmlFormatter = new HtmlFormatter();
$message=new Swift_Message('Something Went Wrong!');
$message->setFrom(array('anand@theiab.org'=>'Error reporting service'))->setTo(array('admin@fsnow.in'=>'self'));
$message->setBody('','text/html');
$mailstream = new SwiftMailerHandler($mailer,$message,Logger::WARNING);
$mailstream->setFormatter($htmlFormatter);
$logger->pushHandler($mailstream);
//$logtext->addError('test');
// You can now use your logger
//$logger->info('My logger is now ready');
//$logger->addWarning('Warning !!! Houston We are SDSC');

?>
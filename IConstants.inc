<?php
 $docroot = $_SERVER["DOCUMENT_ROOT"];
  $ConstantsArray = array('dbServerUrl' => $docroot .'/bmorders/'
    ,'imageFolderPath' => $docroot .'/dinner/bmorders/'
    ,'docspath' => $docroot .'/bmorders/docs/'
    ,'productImagesFolderPath' => $docroot .'/bmorders/images/productimages/')
  ;
  
  $ConstantsArray['ApplicationURL'] = "http://localhost/bmorders/";
  $ConstantsArray['productImageURL'] = "http://localhost/bmorders/images/productimages/";
  
  //$ConstantsArray = array('dbServerUrl' => '/home/satyain/public_html/giftcard/');
  //Logger::configure($ConstantsArray['dbServerUrl'] .'log4php/log4php.xml');
  $ConstantsArray['ApplicationURL'] = "http://localhost/bmorders";
  $Log4PHP_MyDBLogger = "myDBLogger";
  $Log4PHP_MyMailerLogger = "myMailerLogger";
  $Log4PHP_MyFileLogger = "myFileLogger";
  
?>
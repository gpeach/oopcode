<?php
// works with ImageDisplayTest.php and ImageDisplayClass.php
include_once ('ImageDisplayClass.php');
$unprocessedImage='';
if(isset($_REQUEST ['unprocessedImage']))
$unprocessedImage = $_REQUEST ['unprocessedImage'];
$imageWidth=0;
if(isset($_REQUEST ['imageWidth']))
$imageWidth = $_REQUEST ['imageWidth'];
$imageHeight=0;
if(isset($_REQUEST ['imageHeight']))
$imageHeight = $_REQUEST ['imageHeight'];
$specialFx='';
if(isset($_REQUEST ['specialFx']))
$specialFx = $_REQUEST ['specialFx'];
$myImage = new ImageDisplay ( $unprocessedImage, $imageWidth, $imageHeight, $specialFx );

?>

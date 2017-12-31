<?php
include_once ('ImageDisplayClass.php');
if(isset($_GET ['unprocessedImage']))
$unprocessedImage = $_GET ['unprocessedImage'];
if(isset($_GET ['imageWidth']))
$imageWidth = $_GET ['imageWidth'];
if(isset($_GET ['imageHeight']))
$imageHeight = $_GET ['imageHeight'];
if(isset($_GET ['specialFx']))
$specialFx = $_GET ['specialFx'];
$unprocessedImage='http://localhost/OOPCodeLibrary/graphics/Picture-008.jpg';


$myImage = new ImageDisplay ( $unprocessedImage, $imageWidth, $imageHeight, $specialFx );

?>

<?php
include 'Observer.php';

$magazine=new Publisher;
$display1=new displayObserver1;
$magazine->registerObserver($display1);
$display2=new displayObserver2;
$magazine->registerObserver($display2);
$magazine->setContent('goo');

$magazine->removeObserver($display1);
$magazine->setContent('gaa');
?>
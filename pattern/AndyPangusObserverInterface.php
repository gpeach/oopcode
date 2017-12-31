<?php


interface Subject  {
    function registerObserver($o);
    function removeObserver($o);
    function notifyObservers();
}

interface Observer  {
    function update($sender, $args);
}
?>

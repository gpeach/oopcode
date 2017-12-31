<?php
$image = ImageFactory::factory('/path/to/my.jpg');
//$image is now an instance of Image_JPEG
echo $image->getWidth();
?>
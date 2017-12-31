<?php //initialize the session
if (!isset($_SESSION)) {
  session_start();
}


$imgSrc = $_GET['image'];
$thumbnail_width = 40;
$thumbnail_height =40;
    //getting the image dimensions  
    list($width_orig, $height_orig) = getimagesize($imgSrc);   
    $myImage = imagecreatefromjpeg($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
    
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
    
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
    
    $process = imagecreatetruecolor(round($new_width), round($new_height)); 
    
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
	
	//imagefilter($thumb, IMG_FILTER_GAUSSIAN_BLUR);
	//imagefilter($thumb, IMG_FILTER_SMOOTH, .1);
	//imagefilter($thumb, IMG_FILTER_SELECTIVE_BLUR);
	//pixelate($thumb);
	//blur($thumb);
	//scatter($thumb);
	
	
	header('Content-type: image/jpeg');
	imagejpeg($thumb);

    imagedestroy($process);
    imagedestroy($myImage);

?>
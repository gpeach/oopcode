<?php
/*
 ***************************************************************************************
 * Image Display Class
 * Gary Peach 08/12/11
 * pass 4 parameters 
 * unprocessedImage is the URL to thumbnail
 * imageHeight is the desired height 
 * imageWidth is the desired width 
 * if imageHeight and imageWidth are both specified, image is scaled and center cropped
 * if only imageHeight is specified then imageWidth is adjusted to keep aspect
 * if only imageWidth is specified then imageHeight is adjusted to keep aspect
 * if neither imageHeight nor imageWidth are specified then original image is displayed
 * specialFx options are pixelate, blur, scatter, or leave unset for regular image
 ***************************************************************************************
 */
class ImageDisplay {
	
	protected $unprocessedImage = '';
	protected $imageWidth = '';
	protected $imageHeight = '';
	protected $specialFx = '';
	
	public function __construct($unprocessedImage, $imageWidth=0, $imageHeight=0, $specialFx='') {
				
		$this->unprocessedImage = $unprocessedImage;
		$dimensions = getimagesize ( $this->unprocessedImage );
		
		if ($imageWidth!=0) {
			$this->imageWidth = $imageWidth;
		} //height is set, figure out width
		elseif ($imageWidth == 0  && $imageHeight !=0) {
			$this->imageWidth = round ( $dimensions [0] * ($imageHeight / $dimensions [1]) );
		} else {
			$this->imageWidth = $dimensions [0];
		}
		
		if ( $imageHeight!=0) {
			$this->imageHeight = $imageHeight;
		} elseif ($imageHeight==0 &&  $imageWidth!=0) {
			$this->imageHeight = round ( $dimensions [1] * ($imageWidth / $dimensions [0]) );
		} 

		else {
			$this->imageHeight = $dimensions [1];
		}
		if ( $specialFx !='') {
			$this->specialFx = $specialFx;
		} else {
			$this->specialFx = '';
		}
		$this->thumbJpg ( $this->unprocessedImage, $this->imageWidth, $this->imageHeight, $this->specialFx );
	}
	
	protected function thumbJpg($imageContent, $thumbWidth, $thumbHeight, $specialFx) {
		//resizes image, crops from the center, and applies special effects
		$imgSrc = $imageContent;
		$thumbnail_width = $thumbWidth;
		$thumbnail_height = $thumbHeight;
		//getting the image dimensions  
		list ( $width_orig, $height_orig ) = getimagesize ( $imgSrc );
		$myImage = imagecreatefromjpeg ( $imgSrc );
		$ratio_orig = $width_orig / $height_orig;
		
		if ($thumbnail_width / $thumbnail_height > $ratio_orig) {
			$new_height = $thumbnail_width / $ratio_orig;
			$new_width = $thumbnail_width;
		} else {
			$new_width = $thumbnail_height * $ratio_orig;
			$new_height = $thumbnail_height;
		}
		
		$x_mid = $new_width / 2; //horizontal middle
		$y_mid = $new_height / 2; //vertical middle
		

		$process = imagecreatetruecolor ( round ( $new_width ), round ( $new_height ) );
		
		imagecopyresampled ( $process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig );
		$thumb = imagecreatetruecolor ( $thumbnail_width, $thumbnail_height );
		imagecopyresampled ( $thumb, $process, 0, 0, ($x_mid - ($thumbnail_width / 2)), ($y_mid - ($thumbnail_height / 2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height );
		
		//imagefilter($thumb, IMG_FILTER_GAUSSIAN_BLUR);
		//imagefilter($thumb, IMG_FILTER_SMOOTH, .1);
		//imagefilter($thumb, IMG_FILTER_SELECTIVE_BLUR);
		if ($specialFx == 'pixelate') {
			$this->pixelate ( $thumb );
		}
		if ($specialFx == 'blur') {
			$this->blur ( $thumb );
		}
		if ($specialFx == 'scatter') {
			$this->scatter ( $thumb );
		}
		
		header ( 'Content-type: image/jpeg' );
		imagejpeg ( $thumb );
		
		imagedestroy ( $process );
		imagedestroy ( $myImage );
	
	}
	
	protected function pixelate($image) {
		$imagex = imagesx ( $image );
		$imagey = imagesy ( $image );
		$blocksize = 5;
		
		for($x = 0; $x < $imagex; $x += $blocksize) {
			for($y = 0; $y < $imagey; $y += $blocksize) {
				// get the pixel colour at the top-left of the square
				$thiscol = imagecolorat ( $image, $x, $y );
				
				// set the new red, green, and blue values to 0
				$newr = 0;
				$newg = 0;
				$newb = 0;
				
				// create an empty array for the colours
				$colours = array ();
				
				// cycle through each pixel in the block
				for($k = $x; $k < $x + $blocksize; ++ $k) {
					for($l = $y; $l < $y + $blocksize; ++ $l) {
						// if we are outside the valid bounds of the image, use a safe colour
						if ($k < 0) {
							$colours [] = $thiscol;
							continue;
						}
						if ($k >= $imagex) {
							$colours [] = $thiscol;
							continue;
						}
						if ($l < 0) {
							$colours [] = $thiscol;
							continue;
						}
						if ($l >= $imagey) {
							$colours [] = $thiscol;
							continue;
						}
						
						// if not outside the image bounds, get the colour at this pixel
						$colours [] = imagecolorat ( $image, $k, $l );
					}
				}
				
				// cycle through all the colours we can use for sampling
				foreach ( $colours as $colour ) {
					// add their red, green, and blue values to our master numbers
					$newr += ($colour >> 16) & 0xFF;
					$newg += ($colour >> 8) & 0xFF;
					$newb += $colour & 0xFF;
				}
				
				// now divide the master numbers by the number of valid samples to get an average
				$numelements = count ( $colours );
				$newr /= $numelements;
				$newg /= $numelements;
				$newb /= $numelements;
				
				// and use the new numbers as our colour
				$newcol = imagecolorallocate ( $image, $newr, $newg, $newb );
				imagefilledrectangle ( $image, $x, $y, $x + $blocksize - 1, $y + $blocksize - 1, $newcol );
			}
		}
	}
	
	protected function blur($image) {
		$imagex = imagesx ( $image );
		$imagey = imagesy ( $image );
		$dist = 1;
		
		for($x = 0; $x < $imagex; ++ $x) {
			for($y = 0; $y < $imagey; ++ $y) {
				$newr = 0;
				$newg = 0;
				$newb = 0;
				
				$colours = array ();
				$thiscol = imagecolorat ( $image, $x, $y );
				
				for($k = $x - $dist; $k <= $x + $dist; ++ $k) {
					for($l = $y - $dist; $l <= $y + $dist; ++ $l) {
						if ($k < 0) {
							$colours [] = $thiscol;
							continue;
						}
						if ($k >= $imagex) {
							$colours [] = $thiscol;
							continue;
						}
						if ($l < 0) {
							$colours [] = $thiscol;
							continue;
						}
						if ($l >= $imagey) {
							$colours [] = $thiscol;
							continue;
						}
						$colours [] = imagecolorat ( $image, $k, $l );
					}
				}
				
				foreach ( $colours as $colour ) {
					$newr += ($colour >> 16) & 0xFF;
					$newg += ($colour >> 8) & 0xFF;
					$newb += $colour & 0xFF;
				}
				
				$numelements = count ( $colours );
				$newr /= $numelements;
				$newg /= $numelements;
				$newb /= $numelements;
				
				$newcol = imagecolorallocate ( $image, $newr, $newg, $newb );
				imagesetpixel ( $image, $x, $y, $newcol );
			}
		}
	}
	
	protected function scatter($image) {
		$imagex = imagesx ( $image );
		$imagey = imagesy ( $image );
		
		for($x = 0; $x < $imagex; ++ $x) {
			for($y = 0; $y < $imagey; ++ $y) {
				// #'s in rand call control scatter
				$distx = rand ( - 2, 2 );
				$disty = rand ( - 2, 2 );
				
				if ($x + $distx >= $imagex)
					continue;
				if ($x + $distx < 0)
					continue;
				if ($y + $disty >= $imagey)
					continue;
				if ($y + $disty < 0)
					continue;
				
				$oldcol = imagecolorat ( $image, $x, $y );
				$newcol = imagecolorat ( $image, $x + $distx, $y + $disty );
				imagesetpixel ( $image, $x, $y, $newcol );
				imagesetpixel ( $image, $x + $distx, $y + $disty, $oldcol );
			}
		}
	}
	


} //end class ImageDisplay
?>
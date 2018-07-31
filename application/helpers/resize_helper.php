<?php
	//Fungsi untuk meresize Image
	function resizeImage($imageSumber,$imageTarget, $lebarMax,$tinggiMax,$kualitasImage)
	{
	    list($iWidth,$iHeight,$type)    = getimagesize($imageSumber);
	    $ImageScale             = min($lebarMax/$iWidth, $tinggiMax/$iHeight);
	    $lebarBaru               = ceil($ImageScale*$iWidth);
	    $tinggiBaru              = ceil($ImageScale*$iHeight);
	    $NewCanves              = imagecreatetruecolor($lebarBaru, $tinggiBaru);
	 
	    switch(strtolower(image_type_to_mime_type($type)))
	    {
			//tipe images yg bisa diresize jpeg,png, dan gif
	        case 'image/jpeg':
	        case 'image/png':
	        case 'image/gif':
	            $NewImage = imagecreatefromjpeg($imageSumber);
	            break;
	        default:
	            return false;
	    }
	 
	    // Resize Image
	    if(imagecopyresampled($NewCanves, $NewImage,0, 0, 0, 0, $lebarBaru, $tinggiBaru, $iWidth, $iHeight))
	    {
	        // copy file
	        if(imagejpeg($NewCanves,$imageTarget,$kualitasImage))
	        {
	            imagedestroy($NewCanves);
	            return true;
	        }
	    }
	}
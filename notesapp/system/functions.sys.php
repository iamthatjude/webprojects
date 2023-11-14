<?php
/**
 * functions.sys.php -- Functions
 */


require 'texts.sys.php'; // System Texts Constatnts


// Time Ago functionality
function timeAgo($date){
    $timestamp = strtotime($date);
   
    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if ( $currentTime >= $timestamp ){
        $diff = time()- $timestamp;
        
		for( $i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++ ){
		    $diff = $diff / $length[$i];
		}

		$diff = round($diff);
		return $diff . " " . $strTime[$i] . "(s) ago ";
    }
}


// File Name Randomizer
function randDoc( $fileName ){
    $fileName = $fileName;
    $tmp = explode('.', $fileName);
    $fileExtension = end($tmp);
    $uploadable_file = md5(uniqid(rand(), true)) . '.' . $fileExtension;

    return $uploadable_file; // Random generated File Name
}


// Input NULL Checker
function nullCheck( $input ){
    switch ( $input ){
        case empty($input):
            $newInput = NULL;
            break;
        case $input =='':
            $newInput = NULL;
            break;
        case $input == NULL:
            $newInput = NULL;
            break;
        case $input == 'null':
            $newInput = NULL;
            break;
        default:
            $newInput = $input;
    }
    return $newInput;
}


// Authentication Code Generator
function AuthCode($email, $password){
    // Generate 20 Characters
    $numbers = "1234567890"; // Numbers
	$alphaLower = "abcdefghijklmnopqrstuvwxyz"; // Alphabets = Lowercase
	$alphaUpper = "ABCDEFGHJKLMNOPQRSTUVWXYZ"; // Alphabets = Uppercases

    $seed = str_split( $alphaLower . $email . $numbers . $password . $alphaUpper ); // characters
    shuffle($seed); // Shuffle the characters in $randValues
    $rand = '';
    foreach (array_rand($seed, 20) as $k) $rand .= $seed[$k];
 
    return $rand;
}


// Random Code Generator
function randomCodeGenerator( $type = '', $length ){
    $code = '';

    switch ( $type ){
        case '0': // numbers
            $characters = "0123456789";
            break;
        case 'a': // lowercase letters
            $characters = "abcdefghijklmnopqrstuwxyz";
            break;
        case '0a': // numbers with lowercase letters
            $characters = "0123456789abcdefghijklmnopqrstuwxyz";
            break;
        case 'A': // uppercase letters
            $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case '0A': // numbers with uppercase letters
            $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case 'aA': // lowercase with uppercase letters
            $characters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        default: // numbers with lowercase and uppercase letters
            $characters = "0123456789abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
    }

    for ( $i = 0; $i < $length; $i++ ){
        $randomIndex = rand(0, strlen($characters) - 1);
        $code .= $characters[$randomIndex];
    }

    return $code;
}

// Image Compressor: compress and save
function CompressImage( $tmp_filename, $destination, $quality ){
    $info = getimagesize( $tmp_filename );

    switch ( $info['mime'] ){
        case "image/jpeg":
            $image = imagecreatefromjpeg( $tmp_filename );
            break;
        case "image/png":
            $image = imagecreatefrompng( $tmp_filename );
            break;
    }

    if ( imagejpeg( $image, $destination, $quality ) ){
        return true;
    } else {
        return false;
    }
}


// Get Sent Headers
function getSentHeaders( $option, $header="" ){
    // option: all | response | sent
    switch( $option ){
        case 'request': // get all request headers
            return getallheaders();
        case 'response': // get browser response headers
            return headers_list();
        case 'sent': // get a sent header
            foreach( getallheaders() as $name => $value ){
                if ( $name == $header ){
                    return $value;
                }
            }
    }
}



//---------------------------------------------------------------------------------
// Password Generator
function passwordGen($firstname, $lastname, $email){
    // Generate 14 Characters
    $seed = str_split('E%d'.$firstname.'#u*'.$lastname.'G$'.$email); // characters
    $rand = '';
    foreach (array_rand($seed, 14) as $k) $rand .= $seed[$k];
 
    return $rand;
}
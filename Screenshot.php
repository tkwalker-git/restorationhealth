<?php
//$userid = "none";

//if ( isset ($_POST['UserID']) ) $userid = $_POST['UserID'];

unset($imagename);

if(!isset($_FILES) && isset($HTTP_POST_FILES)) $_FILES = $HTTP_POST_FILES;

if(!isset($_FILES['screenshotUpload'])) $error["image_file"] = "An image was not found.";

$imagename = basename($_FILES['screenshotUpload']['name']);

if(empty($imagename)) $error["imagename"] = "The name of the image was not found.";

if(empty($error)) 
{
	$newimage = "images/" . $imagename;
	echo $newimage;
	$result = @move_uploaded_file($_FILES['screenshotUpload']['tmp_name'], $newimage);
	if ( empty($result) ) $error["result"] = "There was an error moving the uploaded file.";
}
else 
{
	echo "no form data found";
}
?>
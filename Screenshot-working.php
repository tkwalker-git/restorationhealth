<?php
//$userid = "none";
/* 
Four fields will be posted to the service:
UserPK:  This is the primary key value in the Users table
PatientPK:  This is the parimary key value in the Patient table
screenShotUpload:  The actual screen shot data
screenShotUpload.name:  The name of the screen shot.  The name is given the following format for identification as well as uniqueness:
ScreenShot_UserPK_PatientPK_DateTimeStamp.png

The image will be saved as a PNG file to the web server's https://domain_name/images/ directory
*/
if ( isset ($_POST['UserPK']) ) $userid = $_POST['UserPK'];
if ( isset ($_POST['PatientPK']) ) $patientid = $_POST['PatientPK'];

unset($imagename);

if(!isset($_FILES) && isset($HTTP_POST_FILES)) $_FILES = $HTTP_POST_FILES;

if(!isset($_FILES['screenshotUpload'])) $error["image_file"] = "An image was not found.";

$imagename = basename($_FILES['screenshotUpload']['name']);

if(empty($imagename)) $error["imagename"] = "The name of the image was not found.";

if(empty($error)) 
{
	$newimage = "images/" . $imagename;
	echo "Image Name: " . $newimage . PHP_EOL;
	echo "UserPK: " . $userid . PHP_EOL;
	echo "PatientID: " . $patientid;

	$result = @move_uploaded_file($_FILES['screenshotUpload']['tmp_name'], $newimage);
	if ( empty($result) ) $error["result"] = "There was an error moving the uploaded file.";
}
else 
{
	echo "no form data found";
}
?>
<?php

require_once("admin/database.php");

$q = strtolower($_GET["q"]);
if (!$q) return;
$bc_userid			=	$_SESSION['LOGGEDIN_MEMBER_ID'];

$sql = "select DISTINCT concat(firstname,' ',lastname) as firstname,id,city,zip,address from `patients` where clinicid='$bc_userid' && `firstname` LIKE '$q%' || `lastname` LIKE '$q%' ";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$vname = str_replace("|"," ",$rs['firstname']);
	echo $rs['id'] . '|' . "$vname" . "|" . $rs['address'] . "|" . $rs['city'] . "|" . $rs['zip'] . "" . "\n";

}

?>
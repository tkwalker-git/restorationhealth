<?php include_once('admin/database.php');

if($_POST) {

 $centerid=$_POST['centerid'];
 $abc=explode('_',$centerid);
 $val1=$abc[0];
 $valr=$abc[1];
 if($valr==3){
 $val2 = '0';
 }else {
 $val2 = '3';
 }

  $get_dts = mysql_query("update patient_comments set review_status='".$val2."' where id='".$val1."'");

  $chk_final_id = mysql_query("select * from patient_comments where id='".$val1."'");
  while($res_id = mysql_fetch_array($chk_final_id)){
   $pat_id		= $res_id['patient_id'];



   	$chk_final_status1 = mysql_query("select * from patient_comments where clinic_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."' && patient_id='".$pat_id."' && review_status=3");
    $fin_res_rev1 = mysql_num_rows($chk_final_status1);
    $chk_final_status2 = mysql_query("select * from plan where clinic_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."' && patient_id='".$pat_id."' && review_status=3");
    $fin_res_rev2 = mysql_num_rows($chk_final_status2);
    $fin_res_rev = $fin_res_rev1 + $fin_res_rev2;
  if(!$fin_res_rev) {
	mysql_query("update patients set status='4' where id='".$pat_id ."'");
  }else{
	  mysql_query("update patients set status='3' where id='".$pat_id ."'");
	  }
  }


  }
?>

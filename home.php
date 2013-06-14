<?php
	require_once('admin/database.php');
	$page	= 'login';
	$loginPageUrl	=	"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	if($_SERVER['HTTP_REFERER']!=$loginPageUrl){
	$_SESSION['REFERER'] = $_SERVER['HTTP_REFERER'];
	}

	if ( isset ($_GET['rUrl']) )
		$_SESSION['REDIRECT_URL'] = urldecode($_GET['rUrl']);

	if(!isset($_SESSION['logedin'])){
		$_SESSION['logedin'] = '';
		$_SESSION['LOGGEDIN_MEMBER_ID'] = '';
		$_SESSION['LOGGEDIN_MEMBER_TYPE'] = '';
	}

	if ( $_SESSION['LOGGEDIN_MEMBER_ID'] > 0 )
		echo "<script>window.location.href='dashboard.php';</script>";

	include_once('includes/header-tk.php');

	if (isset($_POST['username'])){

		$errors = "";
		$user = $_POST['username'];
		$pass = $_POST['password'];


		$userChk_q = "select id, usertype, username, password, email from users where (email = '$user' ||  username = '$user') and password = '$pass'";
		$userChk_q2 = "select id, usertype, username, password, email from users where (email = '$user' ||  username = '$user') and password = '$pass'";

		$user_res = mysql_query($userChk_q);
		$user_res2 = mysql_query($userChk_q2);

		if($user_r1 = mysql_fetch_assoc($user_res)){

		$thisUserId = $user_r1['id'];

		$rs = mysql_query("select * from `users` where `id`='$thisUserId'");
		while($ro = mysql_fetch_array($rs)){
		$status = $ro['enabled'];
		$usertype = $ro['usertype'];
		}

				if($status!=0){

				$_SESSION['logedin'] = '1';
				$_SESSION['LOGGEDIN_MEMBER_ID'] = $user_r1['id'];
				if($usertype==1){
				$_SESSION['usertype']= 'clinic';
				}elseif($usertype==2) {
				$_SESSION['usertype']= 'doctor';
				}



				if ( $_SESSION['REDIRECT_URL'] != '' )
					echo "<script>window.location.href='". urldecode($_SESSION['REDIRECT_URL']) ."';</script>";
				else
					echo "<script>window.location.href='".$_SESSION['REFERER']."';</script>";
		}
		else{
			$errors = "Your Account is not Active";
		}

		}elseif($user_r2 = mysql_fetch_assoc($user_res2)){
			$errors = "Your Account is not Active";
		}else{

			$errors = "Invalid email or password  &nbsp; &nbsp;<b>OR </b>&nbsp; &nbsp;  If you are a Patient &nbsp; <b><a href='user_login.php'>Login Here</a></b>";
		}
		if ( count( $errors) > 0 ) {

				$err = '<table border="0" width="90%"><tr><td class="error" ><ul>';
				//for ($i=0;$i<count($errors); $i++) {
					$err .= '<li>' . $errors . '</li>';
				//}
				$err .= '</ul></td></tr></table>';
		}

	}


?>
	<style>

    .addEInput {
        width:225px!important;
        height:30px!important;
    }

	.required{
		font-size:14px;
		padding-left:3px;
		}
	.log_txt {
	text-align:center; line-height:30px;
	color:#666666;
	font-family:Arial, Helvetica, sans-serif;
	font-size:13px;
	font-weight:bold;
	}

    </style>
<script>
 $(document).ready(function(){
	 $('#username').focus();
 });
</script>
    <div id="main">
      <div id="login-main">
        <div id="login-main-top"></div>
        <div id="login-main-middle">
          <div id="">
            <div id="" style="width:100%; font-size:18px; line-height:28px; padding-bottom:5px; text-align:center;" >Are You A Doctor or Patient?</div>
            <!--<div id="already-member"><span><a href="user_login.php"> Click Here to login as a Patient</a></span></div>-->
          </div>
          <!--login-head -->
          <div id="shadow"></div>
          <div class="error"><?php echo $err; ?></div>

          <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:30px;">
  <tr>
    <td align="center">
	<a href="login.php">
	<img src="<?php echo ABSOLUTE_PATH;?>images/doctor-a.jpg" alt="" style="border:#eeeeee solid 1px;" border="0" />
	</a></td>
    <td align="center">
	<a href="user_login.php">
	<img src="<?php echo ABSOLUTE_PATH;?>images/patient-1.jpg" alt="" style="border:#eeeeee solid 1px;" border="0" />
	</a>
	</td>
  </tr>
  <tr>
    <td class="log_txt">Doctor</td>
    <td class="log_txt">Patient</td>
  </tr>
</table>
        </div>
        <!-- login-main-middle-->
        <div id="login-main-bottom"></div>
      </div>
      <!-- login-main -->
    </div>
    <div class="clr"></div>

    <?php include_once('includes/footer.php'); ?>

<?php
require_once('admin/database.php');
require_once('site_functions.php');


if (!$_SESSION['LOGGEDIN_MEMBER_ID']>0)
		echo "<script>window.location.href='login.php';</script>";


$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];

if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){
$member_full_name = attribValue('users', 'concat(firstname," ",lastname)', "where id='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'");
}else {
$member_full_name = attribValue('patients', 'concat(firstname," ",lastname)', "where id='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'");
}
$meta_title	= 'Dashboard';
include_once('includes/header.php');

?>
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH;?>js/jquery-1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo ABSOLUTE_PATH;?>fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH;?>fancybox/jquery.fancybox-1.3.1.pack.js"></script>
<script type="text/javascript">

		$(document).ready(function() {

				$("#various").fancybox({
					'autoScale'			: true,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic',
					'type'				: 'iframe'
				});

		});

	$(document).ready(function() {
		$("a#profileImage").fancybox({
			'titleShow'		: false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});

	$('.video').click(function() {
		var vSrc	= $(this).attr('src');
		var vName	= vSrc.split('/hqdefault.jpg');
		vName		= vName[0].split('vi/');
		vName		= vName[1];
		$('#videoArea').slideDown(1000);
		$("#videoArea span").html('<iframe width="824" height="540" src="http://www.youtube.com/embed/'+vName+'" frameborder="0" allowfullscreen></iframe>');
		$('html,body').animate({
			        scrollTop: $("#videoArea").offset().top},
        			'slow');
	});

	$('.closeVd').click(function() {
		$('#videoArea').slideUp(1000);
	});

});	// end $(document).ready
</script>

<link href="<?php echo ABSOLUTE_PATH; ?>dashboard1.css" rel="stylesheet" type="text/css">
<div class="topContainer">
  <div class="welcomeBox"></div>
  <!--End Hadding -->
  <!-- Start Middle-->
  <div id="middleContainer">
    <div class="clr"></div>
    <div class="gredBox">
      <?php include('dashboard_menu_tk.php'); ?>
      <div class="whiteTop">
        <div class="whiteBottom">
          <div class="whiteMiddle" style="padding-top:7px;">
		 <div style="padding-bottom:50px; overflow:hidden;">


            <div class="db_box" style="margin-right:14px;">
			<?php

			if($completeness==100 && mysql_num_rows($resActive) > 0){

			?>

			  <?php
			}
			else{
			?>
			<?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){	?>
                <div class="head">BEGIN SETTING UP YOUR CLINIC HERE </div>
				<?php  }else {?>
				<div class="head">FOLLOW THE STEPS BELOW <a href="#" style="text-decoration:none; float:right;">
				<!-- <input type="button" name="start" value="Start" style="padding:2px 15px; border:; cursor:pointer; background:#FFFFFF;" /> -->
				</a>
				</div>
				<?php } ?>

                <div style="width:100%; margin:auto; font-size: 15px; font-weight: bold; ">
				<?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){	?>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links">
                                                <tr>
            	            <td><strong>Step 1:</strong><a href="<?php echo ABSOLUTE_PATH; ?>patient_invitation.php" id="various" style="color:#0066FF; font-size:15px;">&nbsp; Email Patient Invitation&nbsp;</a><span> | </span>&nbsp;<a href="<?php echo ABSOLUTE_PATH; ?>create_patient.php" style="color:#0066FF; font-size:14px;">Register Patient Manually</a></td>
                        </tr>
                        <tr>
	                        <td><strong>Step 2:</strong><a href="<?php echo ABSOLUTE_PATH; ?>create_supplement.php" style="color:#0066FF; font-size:15px;">&nbsp; Add New Supplement</a></td>
                        </tr>
                        <tr>
    	                    <td><strong>Step 3:</strong><a href="<?php echo ABSOLUTE_PATH; ?>create_protocol.php" style="color:#0066FF; font-size:15px;">&nbsp; Create New Protocol</a></td>
                        </tr>
                        <tr>
    	                    <td><strong>Step 4:</strong><a href="<?php echo ABSOLUTE_PATH; ?>create_plan.php" style="color:#0066FF; font-size:15px;">&nbsp; Create New Plan</a></td>
                        </tr>
                        <tr>
        	                <td><strong>Step 5:</strong><a href="<?php echo ABSOLUTE_PATH; ?>create_test.php" style="color:#0066FF; font-size:15px;">&nbsp; Add New Test</a></td>
                        </tr>

                    </table>
					<?php  }else {?>


					<?php
					$sql = "select * from `patients` where  `id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";
					?>




					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links">


                       <tr>
	                        <td><strong>Step 1:</strong> <a href="<?php echo ABSOLUTE_PATH; ?>Clinical_Intake_Form.php" style="color:#0066FF; font-size:15px;"<a onclick="return confirm('Notice: This form could take up to 10 seconds to load... \n Click OK to continue');">  Fill-Out Clinical Intake Form</a></td>
                        </tr>

                       <?php

                       $clinic_id	= getSingleColumn('clinicid',"select * from `patients` where `id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'");

                       if( $clinic_id == 48 ){	?>

                        <tr>
    	                    <td><strong>Step 2:</strong> Take Health Assessments<br /><br />
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey.php?NoviFormName=TestIFA" style="color:#0066FF; font-size:14px;" <a onclick="return confirm('Please Wait: This survey could take up to 10 seconds to load...');">Test Survey</a>&nbsp;,&nbsp;
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey.php?NoviFormName=RestorationHealthAssessment" style="color:#0066FF; font-size:14px;" >Restoration Health Assessment</a>&nbsp;,&nbsp;
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey.php?NoviFormName=DrRondaFemaleHealthHistory" style="color:#0066FF; font-size:14px;" >Female Health History</a>
    	                    </td>
                        </tr>

                       <?php  }else {?>

                        <tr>
    	                    <td><strong>Step 2:</strong> Take Health Assessments <span> (Select Assessment)</span><br /><br />
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey.php?NoviFormName=TestIFA" style="color:#0066FF; font-size:14px; margin-left:55px;" <a onclick="return confirm('Notice: This survey could take up to 10 seconds to load... \n Click OK to continue');">Test Survey</a>&nbsp;,&nbsp;
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey.php?NoviFormName=pangeaquestionnaire" style="color:#0066FF; font-size:14px;" <a onclick="return confirm('Notice: This survey could take up to 10 seconds to load... \n Click OK to continue');">Take Health Assessment</a>
    	                    </td>
                        </tr>
                       <?php } ?>



<?php
					$sql = "select * from `patients` where  `id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";
					?>

                        <tr>
            	            <td><strong>Step 3:</strong><a href="patient-portal.php?id=<?php echo $member_id;?>&type=assesments#l"style="color:#0066FF; font-size:15px;">  View My Assessments & Reports</a></td>
                        </tr>


                         <tr>
                	        <td><strong>Step 4:</strong> <a href="<?php echo ABSOLUTE_PATH; ?>request_appointment.php"style="color:#0066FF; font-size:15px;">  Request Appointment</a></td>
                        </tr>

                         <tr>
                	        <!-- <td><strong>Step 5:</strong> Pre-Visit Forms<br /><br /> -->
                	        <td><strong>Step 5:</strong> Pre-Visit Forms <span> (Select Appointment Date)</span><br /><br />
                	         <?php 	$dat=date("m.d.y");
									 	$vgw = "select * from `schedule_dates` where `patient_id`='$member_id' && `cons_date` >= '$dat' order by cons_date ASC";
									 	$nxt_dt = mysql_query($vgw);
									 	$rect = mysql_num_rows($nxt_dt);

								 ?>

		                          <span style="color:black; margin-left:55px;">
		                          <?php if($rect >= 1){
										 while($sat_dta=mysql_fetch_array($nxt_dt)){
										  $nexta_date = $sat_dta['cons_date'];
										  $next_appt = date("M d, Y", strtotime($nexta_date));
										  $appt_date = date("m/d/Y", strtotime($nexta_date));
										  ?>

										  <a href="<?php echo ABSOLUTE_PATH; ?>pre_visit_form.php?date=<?php echo $appt_date;?> "style="color:#0066FF; font-size:15px;"><?php echo $next_appt;?></a><span> | </span>
										<?php }
										 }else { echo "No Visits Scheduled";}
										 ?>


								</span>

                	        </td>
                        </tr>

                         <tr>
                	        <td><strong>Step 6:</strong><a href="<?php echo ABSOLUTE_PATH; ?>patient-portal.php?id=<?php echo $row['id'];?>&type=plans#l"style="color:#0066FF; font-size:15px;"> View My Plan </a></td>
                        </tr>


                    </table>

					<?php  } ?>
                </div>
			  <?php } ?>
            </div>
			<!-- /db_box -->

            <div class="db_box">

             <?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){ ?>
              <div class="head"><a href="settings.php?p=my-profile"><img src="<?php echo IMAGE_PATH; ?>db_edit_profile.png" align="right" /></a>CLINIC ACTIVITY</div>
              <?php } else {?>
              <!-- <div class="head"><a href="settings.php?p=patient-profile"><img src="<?php echo IMAGE_PATH; ?>db_edit_profile.png" align="right" /></a>Hello <?php echo $member_full_name; ?></div> -->
              <div class="head"><a href="settings.php?p=patient-profile"><img src="<?php echo IMAGE_PATH; ?>db_edit_profile.png" align="right" /></a>QUICK LINKS</div>
              <?php } ?>

              <div class="db_detailEvn">
                  <?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){ ?>

                  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links2">

                        <tr>
	                       <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=todays"style="color:#0066FF; font-size:15px;">Today's Appointments </a>&nbsp;
		                       <span style="color:#FF0000;">
		                      <?php

				                        $today=date("Y-m-d");


				                      	echo "[";
										echo getSingleColumn('tot',"select count(*) as tot from schedule_dates where cons_date ='$today' && clinic_id='$member_id'");
										/* echo $qry2; */
										echo "]";
									?>
		                       </span>
	                        </td>
                        </tr>

                       <tr>
	                       <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=requests"style="color:#0066FF; font-size:15px;">Requested Appointments </a>&nbsp;
		                       <span style="color:#FF0000;">
		                      <?php
		                      	echo "[";
								echo getSingleColumn('tot',"select count(*) as tot from request_appt where `clinic_id`='$member_id'");
								echo "]";
							?>
		                       </span>
	                        </td>
                        </tr>

                        <tr>
	                        <td colspan="3">
								<a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=upcoming"style="color:#0066FF; font-size:15px;">Scheduled Appointments </a>&nbsp;
		                        <span style="color:#FF0000;">
				                      <?php

				                        $today=date("Y-m-d");


				                      	echo "[";
										echo getSingleColumn('tot',"select count(*) as tot from schedule_dates where cons_date >='$today' && clinic_id='$member_id'");
										/* echo $qry2; */
										echo "]";
									?>
								</span>
	                        </td>
                        </tr>

                        <tr>
    	                    <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=absent"style="color:#0066FF; font-size:15px;">No Shows</a>&nbsp; <span style="color:#FF0000;"> <?php $today=date("Y-m-d"); echo "[";
						echo getSingleColumn('tot',"select count(*) as tot from schedule_dates_status where cons_date ='$today' &&  status='1' && clinic_id='$member_id'");
						echo "]";
					?> </span></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=open-consultations"style="color:#0066FF; font-size:15px;">Notes/Plan Awaiting Release   </a>&nbsp; <span style="color:#FF0000;"> <?php $today=date("Y-m-d"); echo "[";

						 $fres = "select * from patient_comments where comment_date ='$today' &&  status <= '1' && clinic_id='$member_id' group by patient_id";
						 $bhuw =  mysql_query($fres);
						 echo  mysql_num_rows($bhuw);

						echo "]";
					?> </span></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=follow-up"style="color:#0066FF; font-size:15px;">Review Required (Notes/Plan) </a>&nbsp;<span style="color:#FF0000;"> <?php $today=date("Y-m-d");
							echo "[";

							 $sdaf =  "SELECT count(*) as tot FROM `patients` where status='3' && clinicid='".$_SESSION['LOGGEDIN_MEMBER_ID']."' ";

							 /*?>$sdaf =  "SELECT count(*) as tot FROM `patients` AS pa INNER JOIN `patient_comments` AS pc ON pa.`id` = pc.patient_id INNER JOIN `schedule_dates_status` AS sd ON pa.`id` = sd.patient_id WHERE pa.status=3 && pa.clinicid='".$member_id."' &&  pc.comment_date='$today' && pc.status >= '0' && pc.clinic_id='".$member_id."' && sd.clinic_id='".$member_id."' &&  sd.cons_date='".$today."'";
<?php */
		$njus =mysql_query($sdaf);
		while($ghat = mysql_fetch_array($njus)){
		echo $ghat['tot'];
		echo "]";
		}
					?> </span></td>
                        </tr>

                    </table>
					<?php } else {?>

					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links2">
                        <tr>




								 <?php 	$dat=date("m.d.y");
									 	$vgw = "select * from `schedule_dates` where `patient_id`='$member_id' && `cons_date` >= '$dat' order by cons_date ASC limit 1";
									 	$nxt_dt = mysql_query($vgw);
									 	$rect = mysql_num_rows($nxt_dt);

								 ?>



	                        <td colspan="3"><span style="color:black;">Next Appointment:</span>&nbsp;
		                         <strong style="color:red;"> <?php if($rect >= 1){
										 while($sat_dta=mysql_fetch_array($nxt_dt)){
										  $nexta_date = $sat_dta['cons_date'];
										  echo $next_appt = date("M d, Y", strtotime($nexta_date));
										 }
										 }else { echo "No Visits Scheduled";} ?>
		                         </strong>
	                        </td>
                        </tr>

                        <tr>
    	                    <td colspan="3"><a href="patient-portal.php?id=<?php echo $member_id;?>&type=assesments#l"style="color:#0066FF; font-size:15px;">View Assessments and Reports</a></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="patient-portal.php?id=<?php echo $member_id;?>&type=tests#l"style="color:#0066FF; font-size:15px;">View Recommended Tests</a></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>patient_calendar.php" style="color:#0066FF; font-size:15px;">View Upcoming Events</a></td>
                        </tr>


                    </table>
					<?php } ?>
                </div>

              <div class="active_event">
                <div class="db_showEvn2">
					<div style="padding-left:29px;">
                  <?php
				  $member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
				if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){
					$image = getSingleColumn('image_name',"select * from users where id=" . $member_id);
				} else
					$image = getSingleColumn('image_name',"select * from patients where id=" . $member_id);

				if ($image != '' && file_exists(DOC_ROOT . 'images/members/' . $image ) ) {
					$img = returnImage( ABSOLUTE_PATH . 'images/members/' . $image,97,2000 );
					$img = '<a href="/images/members/'.$image.'" id="profileImage" ><img align="center" '. $img .' /></a>';
				} else
					$img = '<img src="' . IMAGE_PATH . 'user_awatar.png" height="109px" width="97" border="0" />';
					echo $img;
				?>
				</div>
				<div align="center">
				<?php
					echo "<span id='name'>".$member_full_name."</span>";
					if($_SESSION['usertype']==2)
						$type = "Premium";
					else
						$type = "Standard";
				//	echo "<span id='type'>".$type."</span>";
				?>
				</div>
                </div>

               <!-- end db_detailEvn -->
              </div>

            </div>

			</div>

			<div class="head_new">RESTORATION HEALTH LEARNING LIBRARY</div>

			<div class="videos_boxs">
            <?php
			 if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){
				$res = mysql_query("select * from `learning_library` where clinic_id='-1'");
				}
				else {
				$res = mysql_query("select * from `learning_library` where clinic_id >= '1'");
				}

				$i=0;
				while($row = mysql_fetch_array($res)){
				$i++;
					$bc_title	= DBout($row['title']);

					$video	= DBout($row['video']);
					$video = explode("embed/", $video);
					$video = explode("\"", $video[1]);
					$video = $video[0];

					if($i%4==0)
						$padding	= "padding-right:0";
					else
						$padding	= "";
				?>
                <div class="vBox" style=" <?php echo $padding; ?>">
                    <span><?php
						if(strlen($bc_title) > 25)
							echo substr($bc_title, 0, 25)."...";
						else
							echo $bc_title;
						?>
                    </span>
                    <div>
        	            <img src="http://i2.ytimg.com/vi/<?php echo $video; ?>/hqdefault.jpg" width="186" class="video" height="104">
                    </div>
                </div>
                <?php } ?>
				<br class="clear" />
			</div>
			<!-- /videos_boxs -->
			<br class="clear" />
			<div align="center" id="videoArea">
				<span></span>
				<img src="<?php echo IMAGE_PATH; ?>delete.png" align="right" class="closeVd" title="Close" />
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('includes/footer.php'); ?>

<script>

<?php if($_SESSION['usertype']=='clinic'){	?>
//specify message to alert
var alertmessage="Disclaimer: \n This software is intended to support licensed physicians and other licensed
health care providers and aid them in their decision making process. It is
not a substitute for professional medical advice, diagnosis or treatment.
It has not been evaluated by the FDA. The recommendations of nutrients is
provided with the intent of supporting the physiological and biochemical
processes of the human body, and not to diagnose, treat, cure, or prevent
any disease or condition."

<?php } else {?>
	var alertmessage="Disclaimer: \n The content on this site is for informational purposes only. It is not
intended to replace professional medical advice or care from physicians or
trained medical professionals. If experiencing symptoms or health problems,
seek the advice of your healthcare providers."

<?php } ?>


///No editing required beyond here/////

//Alert only once per browser session (0=no, 1=yes)
var once_per_session=1


function get_cookie(Name) {
  var search = Name + "="
  var returnvalue = "";
  if (document.cookie.length > 0) {
    offset = document.cookie.indexOf(search)
    if (offset != -1) { // if cookie exists
      offset += search.length
      // set index of beginning of value
      end = document.cookie.indexOf(";", offset);
      // set index of end of cookie value
      if (end == -1)
         end = document.cookie.length;
      returnvalue=unescape(document.cookie.substring(offset, end))
      }
   }
  return returnvalue;
}

function alertornot(){
if (get_cookie('alerted')==''){
loadalert()
document.cookie="alerted=yes"
}
}

function loadalert(){
alert(alertmessage)
}

if (once_per_session==0)
loadalert()
else
alertornot()

</script>
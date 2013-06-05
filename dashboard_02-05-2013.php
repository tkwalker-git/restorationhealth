<?php 
require_once('admin/database.php');
require_once('site_functions.php');


// echo $_SESSION['usertype'];

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

// <iframe width="420" height="315" src="http://www.youtube.com/embed/c0F5dKMqw-M" frameborder="0" allowfullscreen></iframe>

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
             <?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){ ?>
              <div class="head"><a href="settings.php?p=my-profile"><img src="<?php echo IMAGE_PATH; ?>db_edit_profile.png" align="right" /></a>Hello Dr. <?php echo $member_full_name; ?></div>
              <?php } else {?>
              <div class="head"><a href="settings.php?p=patient-profile"><img src="<?php echo IMAGE_PATH; ?>db_edit_profile.png" align="right" /></a>Hello <?php echo $member_full_name; ?></div>
              <?php } ?>
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
                <div class="db_detailEvn">
                  <?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){ ?>
                  
                  
                  
                  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links2">
                        <tr>

                       <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=requests"style="color:#0066FF; font-size:15px;">1. Request</a>&nbsp;
                       <span>
                      <?php
                      	echo "[";
						echo getSingleColumn('tot',"select count(*) as tot from request_appt where `clinic_id`='$member_id'");
						echo "]";
					?> 
                       </span>
                        </td>

                    </div>
 
	                        
	                        
	                        
	                        
	                        <!-- <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>consultation_manager.php?p=requests"style="color:#0066FF; font-size:15px;">Appointment Requests</a></td>	 -->                        
                        </tr>
                        <tr>
	                        <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=upcoming"style="color:#0066FF; font-size:15px;">2.  Scheduled</a>&nbsp;
	                        <span>
                      <?php
                     /*
 $qry2 = "select count(*) from schedule_dates where cons_date='$today' && clinic_id='$member_id' order by start_time";

                                    $rest123 = mysql_query($qry2);
                                    $totl_records=mysql_num_rows($rest123);
                        $today=date("Y-m-d");
*/
                      	
                      	echo "[";
						echo getSingleColumn('tot',"select count(*) as tot from schedule_dates where cons_date >='$today' && clinic_id='$member_id'");
						/* echo $qry2; */
						echo "]";
					?> 
                       </span>
	                        </td>
	                        
	                        
                        </tr>
                        <tr>
    	                    <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=patients"style="color:#0066FF; font-size:15px;">3. Visit Completed</a></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=open-consultations"style="color:#0066FF; font-size:15px;">4. Release Session Notes </a></td>        	              
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php?p=patients"style="color:#0066FF; font-size:15px;">5. Review Required</a></td>
                        </tr>
                      
                      <!--
  <tr>
            	            <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>consultation_manager.php?p=unpaid-bills"style="color:#0066FF; font-size:15px;">Outstanding Payments</a></td>
                        </tr>
-->

                        
                       <!--
 <tr>
                        	<td colspan="3" align="center">Profile Status</td>
                        </tr>
                        <tr>
                        	<td style="border:none" align="center"><a href="#">Users</a></td>
                            <td style="border:none"  align="center"><a href="#">Affiliate</a></td>
                            <td style="border:none"  align="center"><a href="#">Coach</a></td>
                        </tr>
-->
                    </table>
					<?php } else {?>
					
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links2">
                        <tr>
	                        <td colspan="3"><a href="#">Next Appointment</a></td>
                        </tr>
                        <tr>
	                        <!-- <td colspan="3"><a href="<?php echo ABSOLUTE_PATH; ?>settings.php?p=patient-profile">Request Appointment</a></td> -->
                        </tr>
                        <tr>
    	                    <td colspan="3"><a href="#">Questionnaires</a></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="#">View Recommendations</a></td>
                        </tr>
                        <tr>
        	                <td colspan="3"><a href="#">View Upcoming Events</a></td>
                        </tr>


                    </table>
					<?php } ?>
                </div>
                <!-- end db_detailEvn -->
              </div>
			
            </div>
			
			
            <div class="db_box">
			<?php
			$fildes = 'name,lname,email,password,image_name,zip,gender,dob';
			$filde = explode(",", $fildes);
			$total_flds = count($filde);
			$profile_completeness = 0;
			foreach($filde as $colum){
				$rec = getSingleColumn($colum,"select * from `users` where id=$member_id");
				if($rec!='')
					$profile_completeness++;
			}

			$profile_completeness	= ($profile_completeness*100)/$total_flds;

			$notifFildes = 'new_recommended,events_calendar,free_tickets,my_profile,new_features,special_event';
			$notifFildes = explode(",", $notifFildes);
			$total_notifFildes = count($notifFildes);
			$notifications_completeness = 0;

			foreach($notifFildes as $colum){
				$rec = getSingleColumn($colum,"select * from `notifications` where `user_id`='$member_id'");
				if($rec!='' && $rec!=0)
					$notifications_completeness++;
			}

			$notifications_completeness		= ($notifications_completeness*100)/$total_notifFildes;

			$syncUser	= getSingleColumn("sync", "select * from `completeness` where `user_id`='$member_id'");
			if($syncUser == 1)
				$sync_completeness	= 100;
			else
				$sync_completeness	= 0;

			$inviteFrnds	= getSingleColumn("invite", "select * from `completeness` where `user_id`='$member_id'");
			if($inviteFrnds == 1)
				$invite_completeness	= 100;
			else
				$invite_completeness	= 0;

			$completeness	= number_format(($profile_completeness+$notifications_completeness+$sync_completeness+$invite_completeness)*100/400);

			// $completeness	= 100;

			$sqlActive = "select *,(select event_date from event_dates where expired=0 AND event_id=events.id ORDER by event_date ASC LIMIT 1) as event_date from events where `userid`='$member_id' && `event_status`='1' && `is_expiring`='1' && `event_type`!='0' ORDER by event_date ASC LIMIT 0 , 1";
			$resActive = mysql_query($sqlActive);


			if($completeness==100 && mysql_num_rows($resActive) > 0){

				while($rows2 = mysql_fetch_array($resActive)){
					$event_id		= $rows2['id'];
					$event_name 	= breakStringIntoMaxChar(DBout($rows2['event_name']),20);
					$full_name		= DBout($rows2['event_name']);
					$event_date 	= getEventStartDates($rows2['id']);
					$source			= $rows2['event_source'];
					$event_image	= getEventImage($rows2['event_image'],$source,'1');
					$event_url		= getEventURL($rows2['id']);					
				}
			?>
			 <div class="head">
			 	<a href="<?php echo ABSOLUTE_PATH; ?>create_event.php?id=<?php echo $event_id; ?>">
						<img src="<?php echo IMAGE_PATH; ?>db_edit_event.png" align="right" style="margin-right:10px">
					</a>
				Active Event
                <div style="float:right">
					<?php
					if($total_rec > 1){?>
					<div id="img" style="width:20px; float:left">	
							<img title="" src="<?php echo IMAGE_PATH; ?>ar_lft.png" />
							<a href="javascript:loadActvEvnt('<?php echo ABSOLUTE_PATH;?>','next',1)">
							<img title="Next" src="<?php echo IMAGE_PATH; ?>ar_rght_actv.png" />
						</a>
					</div>
					<?php
					}
					?>
				</div>
              </div>

				<div class="active_event">
                <div class="db_showEvn">
                  <div class="db_nameEvn"><a href="<?php echo $event_url;?>" title="<?php echo $full_name;?>"><?php echo ucwords(strtolower($event_name));?></a></div>
                  <div class="db_dateEvn"><?php echo $event_date; ?></div>
                  <div style="padding-top:11px;"><a style="display:block; height:155px; overflow:hidden;" href="<?php echo $event_url;?>" alt="<?php echo $full_name;?>" title="<?php echo $full_name;?>"><?php echo str_replace('align="left"','',$event_image);?></a></div>
                </div>
                <div class="db_detailEvn">
                  <div class="db_dtdRow">
                    <div class="ev_fltlft" align="right" style="width:56%">Schedule Patients</div>
                    <div class="db_fl2"><?php // echo getTicketsRecord($event_id,'Sold'); ?></div>
                    <div class="clr"></div>
                  </div>
                  <div class="db_dtdRow">
                    <div class="ev_fltlft" align="right" style="width:56%">Actions Items</div>
                    <div class="db_fl2"><?php // echo "$".number_format(getTicketGross2($event_id,'event'),2); ?></div>
                    <div class="clr"></div>
                  </div>
                  <div class="db_dtdRow">
                    <div class="ev_fltlft" align="right" style="width:56%">Patient List</div>
                    <div class="db_fl2"><?php // echo getTicketsRecord($event_id,'Tickets Left'); ?></div>
                    <div class="clr"></div>
                  </div>
                  <div class="db_dtdRow">
                    <div class="ev_fltlft" align="right" style="width:56%">Bill</div>
                    <div class="db_fl2"><?php echo getSingleColumn('view',"select * from `events` where `id`='$event_id'"); ?></div>
                    <div class="clr"></div>
                  </div>
                  <div class="db_dtdRow">
                    <div class="ev_fltlft" align="right" style="width:56%">Conversion Rate:</div>
                    <div class="db_fl2"><?php echo conversionRate($event_id)."%";?></div>
                    <div class="clr"></div>
                  </div>
                  <div class="db_dtdRow">
                    <div class="ev_fltlft" align="right" style="width:56%">Time till Event:</div>
                    <div class="db_fl2">
                      <?php
						 echo $time_till = timeTillEvent($event_id);
						?>
                    </div>
                    <div class="clr"></div>
                  </div>
                </div>
              </div>
			  <?php
			}
			else{
			?>
			<?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){	?>
                <div class="head">CLINIC SETUP </div> 
				<?php  }else {?>
				<div class="head">GET STARTED HERE <a href="#" style="text-decoration:none; float:right;">
				<!-- <input type="button" name="start" value="Start" style="padding:2px 15px; border:; cursor:pointer; background:#FFFFFF;" /> -->
				</a>
				</div> 				
				<?php } ?> 
				             
                <div style="width:100%; margin:auto; font-size: 15px; font-weight: bold; ">
				<?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){	?>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links">
                                                <tr>
            	            <td><a href="<?php echo ABSOLUTE_PATH; ?>patient_invitation.php" id="various" style="color:#0066FF; font-size:14px;">Invite New Patient via Email&nbsp;</a><span> | </span>&nbsp;<a href="<?php echo ABSOLUTE_PATH; ?>create_patient.php" style="color:#0066FF; font-size:14px;">Register Patient Manually</a></td>
                        </tr>
                        <tr>
	                        <td><a href="<?php echo ABSOLUTE_PATH; ?>create_supplement.php" style="color:#0066FF; font-size:15px;">Add New Supplement</a></td>	                       
                        </tr>
                        <tr>
    	                    <td><a href="<?php echo ABSOLUTE_PATH; ?>create_protocol.php" style="color:#0066FF; font-size:15px;">Create New Protocol</a></td>    	                    
                        </tr>
                        <tr>
    	                    <td><a href="<?php echo ABSOLUTE_PATH; ?>create_plan.php" style="color:#0066FF; font-size:15px;">Create New Plan</a></td>    	                    
                        </tr>
                        <tr>
        	                <td><a href="<?php echo ABSOLUTE_PATH; ?>create_test_tk.php" style="color:#0066FF; font-size:15px;">Add New Test</a></td>
                        </tr>

                       <!--
 <tr>
                	        <td style="border:none"><a href="<?php echo ABSOLUTE_PATH; ?>help_support.php">Help - Support</a></td>
                        </tr>
-->
                    </table>
					<?php  }else {?>
					
					
					<?php
					$sql = "select * from `patients` where  `id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";
					?>
					
					
					
					
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="add_links">
                       
                       
                       <tr>
	                        <td><strong>Step 1:</strong> <a href="<?php echo ABSOLUTE_PATH; ?>Clinical_Intake_Form.php" style="color:#0066FF; font-size:15px;">  Fill-Out Clinical Intake Form</a></td>
                        </tr>                    
                       
                       <?php 
                       
                       $clinic_id	= getSingleColumn('clinicid',"select * from `patients` where `id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'");

                       if( $clinic_id == 21 ){	?>
                       
                        <tr>
    	                    <td><strong>Step 2:</strong> Take Health Assessments<br /><br />
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey-test.php" style="color:#0066FF; font-size:14px;" >Test Survey</a>&nbsp;,&nbsp;
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey.php" style="color:#0066FF; font-size:14px;" >Take Health Assessment</a>&nbsp;,&nbsp;
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey-r1.php" style="color:#0066FF; font-size:14px;" >Restoration Health Assessment</a>&nbsp;,&nbsp;
    	                    <a href="<?php echo ABSOLUTE_PATH; ?>survey-r2.php" style="color:#0066FF; font-size:14px;" >Female Health History</a>    	                      	                    
    	                    </td>
                        </tr>
                        
                       <?php  }else {?>
                       
                        <tr>
    	                    <td><strong>Step 2:</strong><a href="<?php echo ABSOLUTE_PATH; ?>survey.php"style="color:#0066FF; font-size:15px;">  Take Health Assessment </a></td>  	                  
                        </tr>
                       <?php } ?> 
                       
   
                 
                                                                      
                        
                        
<!--
                         <tr>
            	            <td><a href="survey_report.php"><strong>Step 3:</strong>   View My Assessments & Reports</a></td>
                        </tr>-->

                        
            
                        
                        

                        
                        <tr>
            	            <td><strong>Step 3:</strong><a href="patient-portal.php?id=<?php echo $row['id'];?>&type=assesments#l"style="color:#0066FF; font-size:15px;">  View My Assessments & Reports</a></td>
                        </tr>
                        
                        
                         <tr>
                	        <td><strong>Step 4:</strong> <a href="<?php echo ABSOLUTE_PATH; ?>request_appointment.php"style="color:#0066FF; font-size:15px;">  Request Appointment</a></td>
                        </tr>
                        
                         <tr>
                	        <td><strong>Step 5:</strong> <a href="<?php echo ABSOLUTE_PATH; ?>pre_visit_form.php"style="color:#0066FF; font-size:15px;">  Fill-out Pre-Visit Form</a></td>
                        </tr>
                        
                         <tr>
                	        <td><strong>Step 6:</strong><a href="<?php echo ABSOLUTE_PATH; ?>patient-portal.php?id=<?php echo $row['id'];?>&type=plans#l"style="color:#0066FF; font-size:15px;"> View My Plan </a></td>
                        </tr>
                        
<!--
                        <tr>
        	                <td><a href=""https://pangeaifa.com:8443/PatientForms/DisplayForm.jsp?encountertemplate=Followup&schemaName="+Util.getSession().get("schemaname")+"&encounterdate="+encounterDate+"&patientId="+Util.getSession().get("patientId")"target="_blank"><strong>Step 5:</strong>   View My Recommended Tests</a></td>
                        </tr> 
-->                                            

                    </table>
					
					<?php  } ?>
                </div>
			  <?php } ?>
            </div>
			<!-- /db_box -->
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
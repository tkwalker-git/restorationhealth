	  <div class="dash_menu">
        <table cellpadding="10" cellspacing="0" align="center" width="100%">
          <tr>
		  <?php if($_SESSION['usertype']=='clinic' || $_SESSION['usertype']=='doctor'){?>	    
		
            <td  align="center" valign="middle" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>dashboard.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_dashboard.png" /><br />
					Dashboard
				</a>
			</td>
			
            <td valign="bottom" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>clinic_manager.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_manager.png" /><br />
					Clinic Manager
				</a>
			</td>
			
			<td valign="bottom" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>my_calendar.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_calander.png" /><br />
					Calendar
				</a>
			</td>
			
			
            <td valign="bottom" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>marketing_manager.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_promote.png" /><br />
					Marketing
				</a>
			</td>
			
			

            <td valign="bottom" class="bordr">
					<a href="<?php echo ABSOLUTE_PATH; ?>emr_manager.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_create_Event.png" /><br />
					EHR
				</a>
			</td>

			
			 <td valign="bottom" class="bordr">
			 
<?php

					$clinicID = getSingleColumn('clinicid',"select * from users where id=" . $member_id);

?>
					<a target="_blank" href="<?php echo ABSOLUTE_PATH; ?>simulation.php?clinicid=<?php echo $clinicID;?>">
					<img src="<?php echo IMAGE_PATH; ?>sim.png" /><br />
					Simulation
				</a>
			</td>
            
<td valign="bottom">
				<a href="<?php echo ABSOLUTE_PATH; ?>settings.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_settings.png" /><br />
					Settings
				</a>
			</td>
<?php  }elseif($_SESSION['usertype']=='patient') {?>

<td valign="bottom" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>dashboard.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_dashboard.png" /><br />
					Dashboard
				</a>
			</td>
			<td valign="bottom" class="bordr">


<?php

$sql = "select * from `patients` where  `id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";

$res = mysql_query($sql);
$i=0;
$bg = "ffffff";
$row = mysql_fetch_array($res);
?>

				<a href="patient-portal.php?id=<?php echo $row['id'];?>">	
					<img src="<?php echo IMAGE_PATH; ?>icon_manager.png" /><br />
					My Health
				</a>
			</td>
			<!--
<td valign="bottom" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>patient_manager.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_create_Event.png" /><br />
					Patient Manager
				</a>
			</td>
-->
			<td valign="bottom" class="bordr">
				<a href="<?php echo ABSOLUTE_PATH; ?>patient_calendar.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_calander.png" /><br />
					Calendar
				</a>
			</td>
			<td valign="bottom">
				<a href="<?php echo ABSOLUTE_PATH; ?>settings.php">
					<img src="<?php echo IMAGE_PATH; ?>icon_settings.png" /><br />
					Settings
				</a>
			</td>
		  

 <?php }?>
          </tr>
        </table>
      </div>
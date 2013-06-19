<?php
	if($_GET['p'] == 'forms' && isset($_GET['del'])){
		mysql_query("delete from `doctor_forms` where id='". $_GET['del'] ."'");
	}
?>
                            	<div class="yellow_bar">
									<table cellpadding="0"  cellspacing="0" width="99%" align="center">
										<tr>
											<td width="1%"></td>
											<td width="40%">Form Title</td>
											<td width="40%">Link Name</td>
											<td width="20%">Actions</td>
										</tr>
									</table>
								</div> <!-- /yellow_bar -->

								<!-- Adding code for affiliate - Start -->

								<?php
								if(isset($_GET['search'])){
									$search=$_GET['search'];
									$sql = "select * from `doctor_forms` where `form_name` like '%$search%' AND `doctor_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";
									}else {
									if(get_affiliate() && get_affiliate() != ""){
											 $af_id	=get_affiliate();
									$sql = "select * from `doctor_forms` where  `doctor_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."' || `doctor_id`='".$af_id."'  ORDER BY form_name ASC";
											 }else {
									$sql = "select * from `doctor_forms` where  `doctor_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."' ORDER BY form_name ASC";
									}
									}



								$res = mysql_query($sql);
								$i=0;
								$bg = "ffffff";
								while($row = mysql_fetch_array($res)){
									if($bg=='ffffff')
										$bg='f6f6f6';
									else
										$bg = "ffffff";
								?>

								<!-- Adding code for affiliate - End -->



								<div class="ev_eventBox" style="background:#<?php echo $bg; ?>">
									<table cellpadding="0" cellspacing="0" width="99%" align="center">
										<tr>
											<td width="40%" valign="top" class="event_name">
												 <?php echo $row['form_name']; ?>
										  </td>
										  <td width="40%" valign="top" class="event_name">
												 <?php echo $row['link_name']; ?>
										  </td>


											<td width="20%" valign="top" align="center" class="sales">
											<a href="add_form.php">Add </a> | <a href="add_form.php?id=<?php echo $row['id']; ?>">Edit </a> | <a onclick="return confirm('Are you sure you want delete this form?');" href="?p=forms&del=<?php echo $row['id']; ?>">Delete</a>
											<td>
										</tr>
									</table>
								</div>
								<?php }?>
								<div align="right" style="padding-right:10px;"><br />
									<strong><a href="<?php echo ABSOLUTE_PATH; ?>add_form.php">Add Clinic Form</a></strong>
								</div>

                               </div>
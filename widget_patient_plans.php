<div class="blocker">
  <div class="blockerTop"></div>
  <!--end blockerTop-->
  <div class="blockerRepeat">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
      <tr>
        <td align="left" height="" valign="top" style="font-size:13px" ><div class="ew-heading">My Plans</div> </td>
      </tr>
    </table>
	<br/>

	<div class="yellow_bar">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td class="topleft"><strong>Plan Name</strong></td>
			<td class="topleft"><strong>Date Created</strong></td>
			<td class="topleftright"><strong>View Plan</strong></td>
		</tr>

		<?php
			$pdo = getSingleColumn("clinicid","select * from `patients` where `id`='".$_SESSION['LOGGEDIN_MEMBER_ID']."'");
			$sql10 = "select * from `plan` where patient_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."' && clinic_id='".$pdo."' && status = 2 order by id DESC";
			$res10 = mysql_query($sql10);
			while ($row10 = mysql_fetch_assoc($res10)){?>

				<tr>
				<td class="botleft"><a href="view_plan_report_user.php?id=<?php echo $row10['id']; ?>" style="color:#0066FF;" target="_blank"><?php echo $row10['plan_name']; ?> </td>
				<td class="botleft"><?php echo $row10['plan_date']= date("M d, Y"); ?> </td>
				<td class="botleftright"><a href="view_plan_report_user.php?id=<?php echo $row10['id']; ?>" style="color:#0066FF;" target="_blank">View Plan</a></td>
				</tr>
			<?php }  ?>

	</table>


				<br /><br />

  <table cellspacing="0" cellpadding="0" border="0" width="100%">
      <tr>
        <td align="left" height="" valign="top" style="font-size:13px" ><div class="ew-heading">Notes</div> </td>
      </tr>
	  </table>
	<br />


	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td class="topleft" width="20%"><strong>Comment Date</strong></td>
			<td class="topleftright"><strong>Doctor Comment </strong></td>

		</tr>
		<?php
			$pdo = getSingleColumn("clinicid","select * from `patients` where `id`='".$_SESSION['LOGGEDIN_MEMBER_ID']."'");
			$sqlt="select * from patient_comments where patient_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."' && clinic_id='".$pdo."' && status = 2";
			$dfre=mysql_query($sqlt);
			while($get_co_id=mysql_fetch_array($dfre)){?>

					<tr>
					<td class="botleft"><?php echo $get_co_id['comment_date']; ?></td>
					<td class="botleftright"><?php echo $get_co_id['comment']; ?></td>
					</tr>
					<?php } 	?>
	</table>



<br />

	</div>
  </div>
  <div class="blockerBottom"></div>
</div>


<!--end center_contents-->
<div class="clr"></div>
 <!--end blocker-->
<div class="blocker">
  <div class="blockerTop"></div>
  <!--end blockerTop-->
  <div class="blockerRepeat">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
      <tr>
        <td align="left" height="" valign="top" style="font-size:13px" ><div class="ew-heading">Plans</div> </td>
      </tr>
    </table>
	<br/>

	<div class="yellow_bar">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="15%" class="topleft"><strong>Plan Name</strong></td>
			<td width="25%" class="topleft"><strong>Plan Description</strong></td>
			<td width="15%" class="topleftright"><strong>Plan Date</strong></td>
			<td width="45%" class="topleftright"><strong>Actions</strong></td>
		</tr>
		<?php

				$sql = "select * from `plan` where `patient_id`='".$row['id']."' && clinic_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."' order by id DESC";
				$res = mysql_query($sql);

			if($res)
			{
				while($row=mysql_fetch_array($res))
				{

					$sqlt="select * from patient_comments where patient_id=".$_GET['id']." && clinic_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."'";
					$dfre=mysql_query($sqlt);
					$no=1;

							$gstst = $get_co_id['status'];

							$stats_pat = $get_co_id['review_status'];
				?>
					<tr>
					<td class="botleft"><a target="_blank" href="view_plan_report.php?id=<?php echo $row['id']; ?>"style="color:#0066FF;"><?php echo  $row['plan_name'];?></a></td>
					<td class="botleft"><a target="_blank" href="view_plan_report.php?id=<?php echo $row['id']; ?>"style="color:#0066FF;"><?php echo $row['plan_detail']; ?></td>
					<td class="botleftright"><a target="_blank" href="view_plan_report.php?id=<?php echo $row['id']; ?>"style="color:#0066FF;"><?php echo date("M d, Y",strtotime($row['plan_date'])); ?></td>
					<td class="botleftright">
					<input type="radio" name="pri<?php echo $no; ?>" <?php if($gstst==1){?> checked="checked" <?php } ?> value="<?php echo $patient_id."_3";  ?>" onClick="chng_com_status('<?php echo $get_co_id['id']."_1";  ?>');">&nbsp;Keep Private&nbsp;&nbsp;&nbsp;
					<input type="radio" name="pri<?php echo $no; ?>" <?php if($gstst==2){?> checked="checked" <?php } ?> value="<?php echo $patient_id."_4"; ?>" onClick="chng_com_status('<?php echo $get_co_id['id']."_2";  ?>');">&nbsp; Release to Patient&nbsp;&nbsp;&nbsp;


					<input type="checkbox" name="review_req" value="3" <?php if($stats_pat==3){?> checked="checked" <?php } ?> onclick="chng_rev_status('<?php echo $get_co_id['id']."_".$stats_pat; ?>');" />&nbsp;Review Required&nbsp;&nbsp;

				</td>
					</tr>

		<?php }
			}

		?>


	</table>
	</div>
  </div>
  <div class="blockerBottom"></div>
</div>


<!--end center_contents-->
<div class="clr"></div>
 <!--end blocker-->
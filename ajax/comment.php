<?php 



require_once('../admin/database.php');

require_once('../site_functions.php');

$suc = false;



$id	 		= $_GET['event_id'];

$type		= $_GET['type'];



if ( $_SESSION['LOGGEDIN_MEMBER_ID'] > 0 ) {

	$ok = true;

	$member_id 	= $_SESSION['LOGGEDIN_MEMBER_ID'];

	$username 	=  attribValue('users', 'firstname', "where id='$member_id'");

} else {

	$ok = false;

}	

?>



<input type="hidden" name="userid" id="userid" value="<?php echo $member_id;?>" />

<input type="hidden" name="id1" id="id1" value="<?php echo $id;?>" />

<input type="hidden" name="ty" id="ty" value="<?php echo $type;?>" />

<table width="601" border="0" cellspacing="0" cellpadding="0" >

  <tr>

    <td colspan="3" width="601" height="77" valign="middle"  style="background-image:url(<?php echo ABSOLUTE_PATH;?>ajax/images/lb_top.png); background-repeat:no-repeat;" ><br />



		<table width="525" border="0" cellspacing="0" cellpadding="0" align="center">

      	<tr>

			<td style=" font-size:14px!important; color:#FCFBF9; padding-left:20px !important">Write Comment</td>

	        <td width="16" nowrap="nowrap"  align="right" >

				<a href="javascript:void(0)" onClick="hideOverlayer(1)" style="color:#D7FD02; font-size:12px;">

					<img src="<?php echo ABSOLUTE_PATH;?>ajax/images/close.gif" width="16" height="16" border="0" align="left" /></a>

				</td>

    	  </tr>

   	  </table>

	</td>

  </tr>

  <tr>

    <td width="32" style="background-image:url(<?php echo ABSOLUTE_PATH;?>ajax/images/lb_left.png); background-repeat:repeat-y">&nbsp;</td>

    <td width="538" align="center" style="background-color:#FFFFFF" >

		<?php if ( $ok  ) { ?><br />



		<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#FFFFFF">  

		<tr>    

		<td width="23%" height="40" align="right" class="inputlLabel">Your Name:</td>

		<td width="77%" align="left"><?php echo $username;?></td>

		</tr> 

		<tr>    

		<td align="right" class="inputlLabel">Comments:</td>

			

		<td align="left"><textarea name="reviews" id="reviews" style="width:300px" rows="8"></textarea>    </td></tr>  

		<tr>    

		<td align="right" class="inputlLabel" >&nbsp;</td>

		<td align="left"  valign="middle" id="maincdiv" style="color:#006666; font-family:Arial, Helvetica, sans-serif; font-size:13px">

			<a href="javascript:void(0)" onclick="javascript:postComment2('<?php echo  ABSOLUTE_PATH;?>')" >

				<img src="<?php echo  ABSOLUTE_PATH;?>images/post_comment.png" name="Image4" width="121" height="20" border="0"  />

			</a>

		</td>

		</tr>

		<tr>

		  <td colspan="2"  align="center" style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:13px" id="errordiv">&nbsp;</td>

		  </tr>

		</table>

		<?php } else { ?>

			<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#FFFFFF">

			<tr><td align="center" height="250">

				<font color="red">Please <a href="<?php echo ABSOLUTE_PATH;?>login.php">login</a> OR <a href="<?php echo ABSOLUTE_PATH;?>signup.php">Signup</a> to write a comment.</font>

			</td></tr>

			</table>	

		<?php } ?>

	</td>

    <td width="31" style="background-image:url(<?php echo  ABSOLUTE_PATH;?>ajax/images/lb_right.png); background-repeat:repeat-y">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="3"><img src="<?php echo  ABSOLUTE_PATH;?>ajax/images/lb_bottom.png" width="601" height="56" /></td>

  </tr>

</table>
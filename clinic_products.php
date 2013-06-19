<?php
if($_GET['p'] == 'patient' && isset($_GET['del'])){
	if(validateID($_SESSION['LOGGEDIN_MEMBER_ID'],'patients',$_GET['del']) =='true'){
		mysql_query("delete from `patients` where id='". $_GET['del'] ."'");
	}
	else{
		echo "<script>window.location.href='clinic_manager.php';</script>";
	}
}
?>

                            	<div class="yellow_bar">
									<table cellpadding="0"  cellspacing="0" width="99%" align="left">
										<tr>
											<td width="3%"></td>
											<td width="80%">My Products</td>
										</tr>
									</table>
								</div> <!-- /yellow_bar -->

								<?php
						if(isset($_GET['search'])){
			$search=$_GET['search'];
			$rest1 = "select * from `clinic_products` where (`product_id` like '%$search%' || `product_title` like '%$search%' || `product_price` like '%$search%' ) AND `user_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";
			}elseif($_GET['sort']){
			$sort	=	$_GET['sort'];
			$rest1 = "select * from `clinic_products` where `user_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."' order by status ASC";
			}else {
			$rest1 = "select * from `clinic_products` where  `user_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."'";
			}


			$rest123	=	mysql_query($rest1);
			$totl_records=mysql_num_rows($rest123);

			$lim_record=20;             // records per page
			             // records per page
			$total_pages=ceil($totl_records/$lim_record);     // ceil rounds to ceil number(4.2 to 5)
			$page_num=0;
			if(isset($_REQUEST['page']))
			{
			$page_num=$_REQUEST['page']; // from pagination_interface.php file..........
			}
			else
			{
			$page_num=1;
			}
			if($page_num==1)
			{
			$start_record=0;  // As we know In mysql database records index starts from 0
			}
			else
			{
			$start_record= $page_num*$lim_record - $lim_record;
			}


			if(isset($_GET['search'])){
			$search=$_GET['search'];
			 $sql = "select * from `clinic_products` where (`product_id` like '%$search%' || `product_title` like '%$search%' || `product_price` like '%$search%' ) AND `user_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."' LIMIT $start_record,$lim_record";
			}elseif($_GET['sort']){
			$sort	=	$_GET['sort'];
			$sql = "select * from `clinic_products` where `user_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."' order by status ASC LIMIT $start_record,$lim_record";
			}else {
			$sql = "select * from `clinic_products` where  `user_id`='". $_SESSION['LOGGEDIN_MEMBER_ID'] ."' LIMIT $start_record,$lim_record";
			}


$res = mysql_query($sql);
$checkrec	=	mysql_num_rows($res);
if($checkrec){
$i=0;
$bg = "ffffff";
while($row = mysql_fetch_array($res)){
	if($bg=='ffffff')
		$bg='f6f6f6';
	else
		$bg = "ffffff";
?>
								<div class="ev_eventBox" style="background:#<?php if($row['id']==$_GET['id']){echo "c9e8ca";}else {echo $bg; } ?>">
									<table cellpadding="0" cellspacing="0" width="99%" align="center">
										<tr>
											<td width="1%" valign="top" class="event_name">&nbsp;</td>

										  <td width="75%" valign="top" align="left" class="event_name">
												<table width="100%" border="0" cellspacing="7" cellpadding="0">
  <tr>
    <td width="25%"> PRODUCT NAME :</td>
    <?php
    $product_title = $row['product_title'];
    $product_title_s = strip_tags($product_title);
    ?>
    <td><span><?php echo $row['product_title']; ?></span></td>
  </tr>

  <tr>
    <td> PRODUCT DESCRIPTION :</td>
    <?php
    $product_description = $row['product_description'];
    $product_description_s = strip_tags($product_description);
    ?>
    <td><span><?php echo $product_description_s ?></span></td>
  </tr>

  <tr>
    <td>PRODUCT PRICE :</td>
    <td><span><?php echo $row['product_price']; ?></span></td>
  </tr>

  <tr>
    <td>PRODUCT CODE :</td>
    <td><span><?php echo $row['product_id']; ?></span></td>
  </tr>

</table>

<br /><br />
											<div>
												<span>Product Link:</span>&nbsp;
												<a href="<?php echo ABSOLUTE_PATH; ?>subscription.php?product_id=<?php echo $row['product_id']; ?>"><?php echo ABSOLUTE_PATH; ?>subscription.php?product_id=<?php echo $row['product_id']; ?></a>
											 </div>


	</td>

	<td width="1%" valign="top" class="event_name">
	 	<?php  	$pla_id = getSingleColumn("id","select * from `plan` where `patient_id`='".$row['id']."' && clinic_id='".$member_id."' order by id desc limit 1");

				$prot_id = getSingleColumn("protocol_id","select * from `plan_protocol` where `patient_id`='".$row['id']."' && plan_id='$pla_id' limit 1 ");

				$pln_name = getSingleColumn("plan_name","select * from `plan` where `patient_id`='".$row['id']."' && clinic_id='".$_SESSION['LOGGEDIN_MEMBER_ID']."' order by id DESC limit 1");
		?>

								</td>


									</tr>



									</table>
								</div>
								<?php }?>
								 <div align="center" class="pagi"><?php include("pagination_interface.php"); ?></div>
								<?php  }?>
								<div align="right" style="padding-right:10px;"><br />
									<strong><a href="<?php echo ABSOLUTE_PATH; ?>add_product.php">Add New Product</a></strong>
								</div>

                               </div>
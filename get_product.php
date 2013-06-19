<?php

include_once('admin/database.php');
include_once('site_functions.php');
include_once('admin/xmlparser.php');

$products = getChargifyProducts();

$product_id=$_POST['product_id'];

?>

<div class="pro_duct">
	<input type="radio" name="clinic_product" value="<?php echo $product_id; ?>" <?php if($bc_clinic_product==$product_id || $i==$b){?> checked="checked" <?php } ?> />&nbsp;
	<strong><?php echo $products[$product_id][0]; ?>&nbsp;(<?php echo "$".$products[$product_id][1].".00"; ?>)</strong><br  />
	<p><?php echo $products[$product_id][2]; ?></p>
	<?php
		$res_val = $products[$product_id][3];
		if($res_val >= 1)
			echo "<p>".$res_val."&nbsp;".$products[$product_id][4]."&nbsp;"."Trial Period. No Obligations or Charges During Your Trial Period"."</p>";
	?>
</div>
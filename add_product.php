<?php
include_once('admin/database.php');
include_once('site_functions.php');

if (!$_SESSION['LOGGEDIN_MEMBER_ID']>0)
		echo "<script>window.location.href='login.php';</script>";
if($_GET['id']){

	if(validateID($_SESSION['LOGGEDIN_MEMBER_ID'],'clinic_products',$_GET['id']) =='false'){
		echo "<script>window.location.href='settings.php?p=clinic-products';</script>";
	}
}

$bc_product_name		= DBin($_POST["product_name"]);
$bc_description			= DBin($_POST["description"]);
$bc_cost					= $_POST["cost"];
$bc_product_code		= $_POST["product_code"];
$bc_user_id				= $_SESSION['LOGGEDIN_MEMBER_ID'];
$bc_product_int			= 0;
$bc_product_int_unt	= 'month';

$bc_clinic_id = getSingleColumn("clinicid","select * from `users` where `id`='".$_SESSION['LOGGEDIN_MEMBER_ID']."'");


$frmID		= $_GET["id"];
$action1	= isset($_POST["bc_form_action"]) ? $_POST["bc_form_action"] : "";

$action = "save";
$sucMessage = "";

$errors = array();

if ($_POST["product_name"] == "")
	$errors[] = "Product Name can not be empty";
if ($_POST["description"] == "")
	$errors[] = "Description can not be empty";
if ($_POST["product_code"] == "")
	$errors[] = "Product Code can not be empty";

$err = '<table border="0" width="90%"><tr><td class="error" ><ul>';
for ($i=0;$i<count($errors); $i++) {
	$err .= '<li>' . $errors[$i] . '</li>';
}
$err .= '</ul></td></tr></table>';

if (isset($_POST["submit"]) ) {

	if (!count($errors)){

		 if ($action1 == "save") {
			$sql	=	"insert into clinic_products (clinic_id,user_id,product_id,product_title,product_description,product_price,product_int,product_int_unt) values ('" . $bc_clinic_id . "','" . $bc_user_id . "','" . $bc_product_code . "','" . $bc_product_name . "','" . $bc_description . "','" . $bc_cost . "','" . $bc_product_int . "','" . $bc_product_int_unt . "')";
			$res	=	mysql_query($sql);
			$frmID = mysql_insert_id();
			if ($res) {
				$sucMessage = "Record Successfully inserted.";
				echo "<script>window.location.href='settings.php?p=clinic-products&id=$frmID';</script>";
			} else {
				$sucMessage = "Error 1: Please try Later";
			} // end if res
		} // end if

		if ($action1 == "edit") {
			$sql	=	"update clinic_products set clinic_id = '" . $bc_clinic_id . "', user_id = '" . $bc_user_id . "', product_id = '" . $bc_product_code . "', product_title = '" . $bc_product_name . "', product_description = '" . $bc_description . "', product_price = '" . $bc_cost . "',product_int = '" . $bc_product_int . "',product_int_unt = '" . $bc_product_int_unt . "' where id=$frmID";
			$res	=	mysql_query($sql);
			if ($res) {
				$sucMessage = "Record Successfully updated.";
				echo "<script>window.location.href='settings.php?p=clinic-products&id=$frmID';</script>";
			} else {
				$sucMessage = "Error 2: Please try Later";
			} // end if res
		} // end if

	} // end if errors

	else {
		$sucMessage = $err;
	}
} // end if submit


$sql	=	"select * from clinic_products where id=$frmID";
$res	=	mysql_query($sql);
if ($res) {
	if ($row = mysql_fetch_assoc($res) ) {
		$bc_product_name	=	DBout($row["product_title"]);
		$bc_description		=	DBout($row["product_description"]);
		$bc_product_code	=	$row["product_id"];
		$bc_cost			=	$row["product_price"];
		$bc_product_int		=	$row["product_int"];
		$bc_product_int_unt		=	$row["product_int_unt"];

	} // end if row
	$action = "edit";
} // end if

$meta_title	= "Add New Product";

include_once('includes/header.php');
?>
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>admin/tinymce/tiny_mce.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ABSOLUTE_PATH; ?>eventDatesPicker/calendar.css" />

<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>js/jquery-1.4.2.min2.js"></script>
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>js/jquery-1.2.6.js"></script>
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>js/jquery.formatCurrency-1.4.0.js"></script>
<script type="text/javascript">
            // Sample 1
            $(document).ready(function()
            {
                $('#currencyButton').click(function()
                {
                    $('#cost').formatCurrency();
                });
            });

            // Sample 2
            $(document).ready(function()
            {
                $('.currency').blur(function()
                {
                    $('.currency').formatCurrency();
                });
            });



</script>

<style>

.ev_title input{
	color: #808080;
	font-weight:normal;
	}

.new_ticket_right td{
	height:48px;
	padding:0 16px;
	}

.ev_new_box_center{
	margin:auto;
	width:936px;
	}

.ev_new_box_center .basic_box, .ev_new_box_center .featured_box, .ev_new_box_center .premium_box, .ev_new_box_center .custom_box{
	width:234px;
	height:528px;
	float:left;
	position:absolute
	}


.ev_new_box_center .basic_box ul, .ev_new_box_center .featured_box ul, .ev_new_box_center .premium_box ul, .ev_new_box_center .custom_box ul{
	padding:10px 0 0 18px;
	margin:0
}

.ev_new_box_center .basic_box ul li, .ev_new_box_center .featured_box ul li, .ev_new_box_center .premium_box ul li, .ev_new_box_center .custom_box ul li{
	list-style:circle;
	font-size:12px
}

.ev_new_box_center .basic_box{
	background:url(images/basic_box.gif) no-repeat;
	}

.ev_new_box_center .featured_box{
	background:url(images/featured_box.gif) no-repeat;
	left:234px;
	}

.ev_new_box_center .premium_box{
	background:url(images/premium_box.gif) no-repeat;
	left:468px;
	}

.ev_new_box_center .custom_box{
	background:url(images/custom_box.gif) no-repeat;
	left:702px;
	}


.ev_new_box_center .basic_box .black, .ev_new_box_center .featured_box .black, .ev_new_box_center .premium_box .black, .ev_new_box_center .custom_box .black{
	filter:alpha(opacity=15);
	-ms-filter:alpha(opacity=15);
	-moz-opacity:0.15;
	opacity:0.15;
	background:#000000;
	width:234px;
	height:528px;
	position:absolute;
	}


.ev_new_box_center .black:hover{
	display:none;
	}

.ev_new_box_center .basic_box:hover > .black, .ev_new_box_center .featured_box:hover > .black, .ev_new_box_center .premium_box:hover > .black, .ev_new_box_center .custom_box:hover > .black{
	display:none;
	}


.ev_new_box_center .basic_box:hover, .ev_new_box_center .featured_box:hover, .ev_new_box_center .premium_box:hover, .ev_new_box_center .custom_box:hover{
	z-index:9999;
	-moz-box-shadow:0px 0px 7px 2px #464646;
	-webkit-box-shadow:0px 0px 7px 2px #464646;
	-khtml-box-shadow:0px 0px 7px 2px #464646;
	box-shadow:0px 0px 7px 2px #464646;
	filter: progid:DXImageTransform.Microsoft.Shadow(Color=#464646, Strength=5, Direction=0),
           progid:DXImageTransform.Microsoft.Shadow(Color=#464646, Strength=5, Direction=90),
           progid:DXImageTransform.Microsoft.Shadow(Color=#464646, Strength=5, Direction=180),
           progid:DXImageTransform.Microsoft.Shadow(Color=#464646, Strength=5, Direction=270);
	}
	.ev_new_box_center .detail{
	padding:132px 10px 0;
	height:280px;
	font-size:13px;
	font-family:Arial, Helvetica, sans-serif;
	line-height:18px;
}

#showimg1,#showimg3{
	padding: 5px 0 5px 20px;
	width: 45%
	}

#showimg2,#showimg4{
	padding: 5px 0 5px 27px;
	width:45%;
	}


#accordion h3 {
    border-bottom: 1px solid #89C76F;
    border-radius: 5px 5px 5px 5px;
    color: #FFFFFF;
    cursor: pointer;
	background: none repeat scroll 0 0 #43BB9A;
    font-size: 18px;
    font-weight: bold;
    margin: 0;
    padding: 10px;
}

</style>
<link href="<?php echo ABSOLUTE_PATH; ?>dashboard1.css" rel="stylesheet" type="text/css">
<div class="topContainer">
<div class="welcomeBox"></div>
<script language="javascript">
	$(document).ready(function() {
		$(".fancybox2").fancybox({
			'titleShow'		: false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'width'			: 540,
			'height'		: 700,
			'type'			: 'iframe'
		});
	});
</script>
  <!--End Hadding -->
  <!-- Start Middle-->
  <span id="campaign"></span>
  <div id="middleContainer">
    <div class="creatAnEventMdl" style="font-size:55px; text-align:center; width:100%"> Add New Product</div>
    <div class="clr"><?php echo $sucMessage; ?></div>
    	<div class="gredBox">
			<form id="z_listing_event_form" action="" method="post" accept-charset="utf-8" onSubmit="return checkErr();" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="ABSOLUTE_PATH" id="ABSOLUTE_PATH" value="<?php echo ABSOLUTE_PATH; ?>" />
				<input type="hidden" name="bc_form_action" class="bc_input" value="<?php echo $action; ?>"/>
				<div class="clr"></div>
				<?php include('dashboard_menu_tk.php'); ?>
				<div class="whiteTop">
					<div class="whiteBottom">
						<div class="whiteMiddle" style="padding-top:1px;">
							<div id="accordion">
								<h3><span>ADD PRODUCT INFORMATION</span></h3>
								<div id="box" class="box">
									<div id="head">Product Name</div>
									<div class="ev_title">
										<input type="text" name="product_name" id="product_name" class="" style="width:815px;" value="<?php echo $bc_product_name; ?>"/>
									</div>
										<div id="head">Product Description</div>
										<div>
											<textarea  name="description" id="description" class="bc_input" style="width:825px;height:250px;" /><?php echo $bc_description; ?></textarea>
										</div>

										<div style="float:left; width:33%"><br />
											<div id="head">Product Code</div>
											<input type="text" name="product_code" id="product_code" class="new_input" value="<?php echo $bc_product_code; ?>"/>
										</div>

										<div style="float:left; width:33%"><br />
											<div id="head">Cost</div>
											<input type="text" name="cost" id="cost" class="currency" value="<?php echo $bc_cost; ?>"/>
										</div>

									<div class="clr"></div>
									<div class="create_event_submited"><br /><br />
										<input type="image" src="<?php echo IMAGE_PATH; ?>submit-btn.png" name="submit" value="Add Product" align="right" />
										<input type="hidden" name="submit" value="Add Product" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php include_once('includes/footer.php');?>
<script>
	tinyMCE.init({
		// General options
		mode : "exact",
		theme : "simple",
		elements : "description",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,imagemanager",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,cut,copy,paste,pastetext,pasteword",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,forecolor,backcolor,|,fullscreen,|,print,|,ltr,rtl,|,styleprops,hr,removeformat,|,preview,help,code",
		theme_advanced_buttons3 : "visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,insertlayer,moveforward,movebackward,absolute,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak",
//		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "style.css",
	});


</script>
<?php
include_once('admin/database.php');
include_once('site_functions.php');

if (!$_SESSION['LOGGEDIN_MEMBER_ID']>0)
		echo "<script>window.location.href='login.php';</script>";
if($_GET['id']){

	if(validateID($_SESSION['LOGGEDIN_MEMBER_ID'],'supplement',$_GET['id']) =='false'){
		echo "<script>window.location.href='clinic_manager.php?p=supplement';</script>";
	}
}

$bc_supplement_name	= $_POST["supplement_name"];
$bc_description		= DBin($_POST["description"]);
$bc_suppliers		= $_POST["suppliers"];
$bc_cost			= $_POST["cost"];
$bc_retail_price	= $_POST["retail_price"];
$bc_dosage			= $_POST['dosage'];
$bc_comment			= $_POST['comment'];
$bc_without_food	= $_POST['without_food'];
$bc_breakfast		= $_POST['breakfast'];
$bc_snack1			= $_POST['snack1'];
$bc_lunch			= $_POST['lunch'];
$bc_snack2			= $_POST['snack2'];
$bc_dinner			= $_POST['dinner'];
$bc_before_bed		= $_POST['before_bed'];
$bc_clinic_id		= $_SESSION['LOGGEDIN_MEMBER_ID'];

$frmID		= $_GET["id"];
$action1	= isset($_POST["bc_form_action"]) ? $_POST["bc_form_action"] : "";

$action = "save";
$sucMessage = "";

$errors = array();

if ($_POST["supplement_name"] == "")
	$errors[] = "Supplement Name can not be empty";
if ($_POST["description"] == "")
	$errors[] = "Description can not be empty";

$err = '<table border="0" width="90%"><tr><td class="error" ><ul>';
for ($i=0;$i<count($errors); $i++) {
	$err .= '<li>' . $errors[$i] . '</li>';
}
$err .= '</ul></td></tr></table>';

if (isset($_POST["submit"]) ) {

	if (!count($errors)){

		 if ($action1 == "save") {
			$sql	=	"insert into supplement (supplement_name,description,suppliers,cost,retail_price,clinic_id,dosage,comment,without_food,breakfast,snack1,lunch,snack2,dinner,before_bed) values ('" . $bc_supplement_name . "','" . $bc_description . "','" . $bc_suppliers . "','" . $bc_cost . "','" . $bc_retail_price . "','" . $bc_clinic_id . "','" . $bc_dosage . "','" . $bc_comment . "','" . $bc_without_food . "','" . $bc_breakfast . "','" . $bc_snack1 . "','" . $bc_lunch . "','" . $bc_snack2 . "','" . $bc_dinner . "','" . $bc_before_bed ."')";
			$res	=	mysql_query($sql);
			$frmID = mysql_insert_id();
			if ($res) {
				$sucMessage = "Record Successfully inserted.";
				echo "<script>window.location.href='clinic_manager.php?p=supplement&id=$frmID';</script>";
			} else {
				$sucMessage = "Error 1: Please try Later";
			} // end if res
		} // end if

		if ($action1 == "edit") {
			$sql	=	"update supplement set supplement_name = '" . $bc_supplement_name . "', description = '" . $bc_description . "', suppliers = '" . $bc_suppliers . "', cost = '" . $bc_cost . "', retail_price = '" . $bc_retail_price . "', dosage = '" . $bc_dosage . "',comment = '" . $bc_comment . "',without_food = '" . $bc_without_food . "',breakfast = '" . $bc_breakfast . "',snack1 = '" . $bc_snack1 . "',lunch = '" . $bc_lunch . "',snack2 = '" . $bc_snack2 . "',dinner = '" . $bc_dinner . "',before_bed = '" . $bc_before_bed . "' where id=$frmID";
			$res	=	mysql_query($sql);
			if ($res) {
				$sucMessage = "Record Successfully updated.";
				echo "<script>window.location.href='clinic_manager.php?p=supplement&id=$frmID';</script>";
			} else {
				$sucMessage = "Error 2: Please try Later";
			} // end if res
		} // end if

	} // end if errors

	else {
		$sucMessage = $err;
	}
} // end if submit


$sql	=	"select * from supplement where id=$frmID";
$res	=	mysql_query($sql);
if ($res) {
	if ($row = mysql_fetch_assoc($res) ) {
		$bc_supplement_name	=	$row["supplement_name"];
		$bc_description		=	DBin($row["description"]);
		$bc_suppliers		=	$row["suppliers"];
		$bc_cost			=	$row["cost"];
		$bc_retail_price	=	$row["retail_price"];
		$bc_dosage			=	$row['dosage'];
		$bc_comment			=	$row['comment'];
		$bc_without_food	=	$row['without_food'];
		$bc_breakfast		=	$row['breakfast'];
		$bc_snack1			=	$row['snack1'];
		$bc_lunch			=	$row['lunch'];
		$bc_snack2			=	$row['snack2'];
		$bc_dinner			=	$row['dinner'];
		$bc_before_bed		=	$row['before_bed'];
	} // end if row
	$action = "edit";
} // end if

$meta_title	= "Create Supplement";

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
                    $('#retail_price').formatCurrency();
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
    <div class="creatAnEventMdl" style="font-size:55px; text-align:center; width:100%"> Create Supplement</div>
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

                <h3><span>ADD Supplement INFORMATION</span></h3>
                <div id="box" class="box">
                  <div id="head">Supplement</div>
                  <div class="ev_title">
                    <input type="text" name="supplement_name" id="supplement_name" class="" style="width:815px;" value="<?php echo $bc_supplement_name; ?>"/>
                  </div>

                  <div id="head">Description</div>
                  <div>
                    <textarea  name="description" id="description" class="bc_input" style="width:825px;height:250px;" /><?php echo $bc_description; ?></textarea>
                  </div>

                  	<div style="float:left; width:33%"><br />
	                  <div id="head">Suppliers</div>
		               <input type="text" name="suppliers" id="suppliers" class="new_input" value="<?php echo $bc_suppliers; ?>"/>
		              </div>

		            <div style="float:left; width:33%"><br />
	                  <div id="head">Cost</div>
	                    <input type="text" name="cost" id="cost" class="currency" value="<?php echo $bc_cost; ?>"/>
		            </div>

		            <div style="float:left; width:33%"><br />
	                    <div id="head">Retail Price</div>
	                    <input type="text" name="retail_price" id="retail_price" class="currency" value="<?php echo $bc_retail_price; ?>"/>
		            </div>

		              <div class="clr"></div><br>


                  <div style="float:left; width:35%">
                  <div id="head">Dosage</div>
                  	<table>
                    	<tr>
                        	<td width="82"><strong>Dosage</strong>:</td>
                            <td width="145"><input type="text" name="dosage" class="new_input" value="<?php echo $bc_dosage; ?>" /></td>
                        </tr>

                        <tr>
                        	<td><strong>Without food</strong>:</td>
                            <td><input type="checkbox" value="1" name="without_food" class="new_input" <?php if ($bc_without_food == 1){ echo 'checked="checked"';} ?>  /></td>
                        </tr>
                        <tr>
                        	<td><strong>Breakfast</strong>:</td>
                            <td><input type="text" name="breakfast" class="new_input" value="<?php echo $bc_breakfast; ?>"></td>
                        </tr>
                         <tr>
                        	<td><strong>Snack1</strong>:</td>
                            <td><input type="text" name="snack1" class="new_input" value="<?php echo $bc_snack1; ?>"></td>
                        </tr>
                         <tr>
                        	<td><strong>Lunch</strong>:</td>
                            <td><input type="text" name="lunch" class="new_input" value="<?php echo $bc_lunch; ?>"></td>
                        </tr>
                         <tr>
                        	<td><strong>Snack2</strong>:</td>
                            <td><input type="text" name="snack2" class="new_input" value="<?php echo $bc_snack2; ?>"></td>
                        </tr>
                         <tr>
                        	<td><strong>Dinner</strong>:</td>
                            <td><input type="text" name="dinner" class="new_input" value="<?php echo $bc_dinner; ?>"></td>
                        </tr>
                        <tr>
                        	<td><strong>Before Bed</strong>:</td>
                            <td><input type="text" name="before_bed" class="new_input" value="<?php echo $bc_before_bed; ?>"></td>
                        </tr>

                    </table>
                  </div>



                    <div style="float:right; width:60%">
                  <div id="head">Special Dosage Instructions</div>
                  	<table>

                        <tr>
                            <td><input type="text" name="comment" id="comments" class="new_input" style="width:470px;height:255px;" value="<?php echo $bc_comment; ?>"></td>
                        </tr>

                    </table>

                    </div>
                    <div class="clr"></div>
                    <div class="create_event_submited"><br /><br />
		            <input type="image" src="<?php echo IMAGE_PATH; ?>submit-btn.png" name="submit" value="Create Supplement" align="right" />
		            <input type="hidden" name="submit" value="Create Supplement" />
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
		elements : "description, comments",
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
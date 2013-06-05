<?php
include_once('admin/database.php'); 
include_once('site_functions.php');

if (!$_SESSION['LOGGEDIN_MEMBER_ID']>0)
		echo "<script>window.location.href='login.php';</script>";



$bc_userid				=	$_SESSION['LOGGEDIN_MEMBER_ID'];

$bc_event_music = array();

$already_uploaded = 0;




if ($event_id != "" || isset($_POST["submit"])) {

    $dates_q = "select * from event_dates where event_id = '$event_id' ORDER BY event_date ASC";
	$dates_res = mysql_query($dates_q);
	$first_date = "";
	$dates = "";
	$i = 0;

	while($dates_r = mysql_fetch_assoc($dates_res)){
		if(mysql_num_rows($dates_res) > 0){
			$date = date("m/d/Y",strtotime($dates_r['event_date']));
			if($i<1){ $first_date = $date; $i++;}
			$dates = $dates."'".$date."', ";
		}else{
			$date = $dates_r['event_date'];
			$first_date = $date;
			$dates = "'".date("m/d/Y",strtotime($date))."'";
		}
	}
}

if($first_date != ''){
	$yr = date("Y",strtotime($first_date));
	$mon = date("m",strtotime($first_date));
	$mon1 = $mon - 1;
	$dy = date("d",strtotime($first_date));
	$first_date = $yr.", ".$mon1.", ".$dy;
}



include_once('includes/header.php');

?>

<script src="<?php echo  ABSOLUTE_PATH; ?>js/jquery.stylish-select.js" type="text/javascript"></script><!--
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>/js/jquery-ui_1.8.7.js"></script>
<script type="text/javascript" src="<?php echo ABSOLUTE_PATH; ?>js/jquery-ui.multidatespicker.js"></script>-->



<script>
$(document).ready(function(){
         $('#my-dropdown, #my-dropdown2').sSelect();
		 $('#my-dropdownCountries').sSelect({ddMaxHeight: '300px'});
    });
$(document).ready(function(){
		$( "#accordion" ).accordion();
	});
	
	$(document).ready(function(){
var $unique = $('input.unique');
$unique.click(function(){
$unique.removeAttr('checked');
$(this).attr('checked', true);
});
});

$(function() {
		$('#multi-months').multiDatesPicker({
			numberOfMonths: 3,
			<?php if ( trim($dates) != '' ) { ?>
				addDates: [<?php echo $dates; ?>], 
			<?php } ?>
			onSelect: function(dateText, inst) {
				var dates = $('#multi-months').multiDatesPicker('getDates');
				document.getElementById("selected_dates").value = dates;
							
			}
		});
		
		$('#multi-months').datepicker('setDate', new Date(<?php echo $first_date; ?>));
	});
</script>
<style>

.addEInput
{
	width:225px!important;
	height:30px!important;
}

</style>

<div style="padding-top:20px;">
  <form method="post" name="bc_form" id="bc_form" enctype="multipart/form-data" action=""  >
    <input type="hidden" name="selected_dates" id="selected_dates" class="bc_input" value="" />
    <div class="">
      <div class="width96">
        <div class="creatAnEventMdl"> Create Your Digital Flyer</div>
      </div>
    </div>
    <!-- /creatAnEvent -->
    <div class="width96" style="padding-top:23px">
      <div id="accordion">
        <h3>STEP 1: ADD EVENT INFORMATION</h3>
        <div id="box">
          <div id="head">Event Title</div>
          <div class="ev_title">
            <input type="text" name="eventname" value="<?php if ($bc_event_name){echo $bc_event_name;} else{ echo "Enter only the name of your event";} ?>" id="event" onFocus="removeText(this.value,'Enter only the name of your event','event');" onBlur="returnText('Enter only the name of your event','event');">
          </div>
          <div id="head">Event Details</div>
          <div>
            <textarea name="event_description" id="event_description" class="bc_input" style="width:637px; height:370px"><?php echo $bc_event_description; ?></textarea>
          </div>
        </div>
        <h3>STEP 2: CREATE TICKETS</h3>
        <div id="box">
          <div id="ticketButton"> <img src="<?php echo  IMAGE_PATH; ?>create_ticket.png" align="left" /> &nbsp;
            You can create multiple ticket types for your event</div>
          <div id="event_cost">
            <input type="checkbox"  />
            &nbsp; This is not a ticketed event &nbsp; &nbsp; &nbsp; &nbsp; 
            Event Cost:    $
            <input type="text" class="new_input" style="width:50px; font-weight:bold" />
          </div>
        </div>
        <h3>STEP 3: ADD EVENT ATTRIBUTES</h3>
        <div id="box">
          <div  class="ev_fltlft" style="width:65%">
            <div id="head" >Primary Category</div>
            <select id="my-dropdown" name="my-dropdown">
              <option value="">-- Select Primary Category --</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
            </select>
          </div>
          <div  class="ev_fltlft" style="width:35%">
            <div id="head" >Secondary Category</div>
            <select id="my-dropdown2" name="my-dropdown2">
              <option value="">-- Select Secondary Category --</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
              <option>2</option>
              <option>3</option>
            </select>
          </div>
          <div class="clr" style="height:85px">&nbsp;</div>
          <div class="stpBox">
            <div class="title">Age Requirements</div>
            <div class="data"><b>Minimum Age Allowed:</b>
              <div id="info"></div>
              <div class="age">
                <?php $sqlAge = "SELECT name,id FROM age";
							$resAge = mysql_query($sqlAge);
							$totalAge= mysql_num_rows($resAge);
							while($rowAge = mysql_fetch_array($resAge))
							{	
							?>
                <div style="float:left; width:50%;padding: 3px 0;"> &nbsp;
                  <input name="age" class="unique" type="checkbox" value="<?php echo $rowAge['id']?>" <?php if($rowAge['id']==$bc_event_age_suitab)
							{ echo 'selected'; }?>>
                  <?php echo $rowAge['name'];
			?>
                </div>
                <?php }?>
                <div class="clr"></div>
                <b>Preferred Age Demographic:</b>
                <div id="info"></div>
              </div>
              <div class="preferredAge"> <span>Men</span>
                <select class="inp3" name="event_age_suitab" style="width:104px" id="event_age_suitab">
                  <option value="">-Select age-</option>
                  <?php $sqlAge = "SELECT name,id FROM age";
							$resAge = mysql_query($sqlAge);
							$totalAge= mysql_num_rows($resAge);
							while($rowAge = mysql_fetch_array($resAge))
							{	
							?>
                  <option value="<?php echo $rowAge['id']?>" <?php if($rowAge['id']==$bc_event_age_suitab)
							{ echo 'selected'; }?>>
                  <?php echo $rowAge['name']?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              <div class="preferredAge"> <span>Women</span>
                <select class="inp3" name="event_age_suitab" style="width:104px" id="event_age_suitab">
                  <option value="">-Select age-</option>
                  <?php $sqlAge = "SELECT name,id FROM age";
							$resAge = mysql_query($sqlAge);
							$totalAge= mysql_num_rows($resAge);
							while($rowAge = mysql_fetch_array($resAge))
							{	
							?>
                  <option value="<?php echo $rowAge['id']?>" <?php if($rowAge['id']==$bc_event_age_suitab)
							{ echo 'selected'; }?>>
                  <?php echo $rowAge['name']?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              <div class="clr"></div>
            </div>
            <div>
              <div class="clr"></div>
            </div>
          </div>
          <div class="stpBox" style="float:right">
            <div class="title">Age Requirements</div>
            <div class="data">
              <ul style="list-style:none; margin:0px; padding:18px 0 0 6px">
                <?php 
								$sqlMusic = "SELECT name,id FROM music";
								$resMusic = mysql_query($sqlMusic);
								$totalMusic= mysql_num_rows($resMusic);
								$no = 0;
								
								if ( !is_array($bc_event_music) )
									$bc_event_music = array();
								
								while($rowMusic = mysql_fetch_array($resMusic))
								{
									if ( in_array($rowMusic['id'],$bc_event_music) )
										$che = 'checked="checked"';
									else
										$che = '';		
								?>
                <li style="width:50%; float:left; padding:3px 0">
                  <label for="<?php echo $no; ?>">
                  <input <?php echo $che;?> id="<?php echo $no; ?>" type="checkbox" style="float:left" name="event_music[]" value="<?php echo $rowMusic['id']?>"   />
                  <div style="float:left; margin-right:5px">
                    <?php echo $rowMusic['name']?>
                  </div>
                  </label>
                </li>
                <?php $no++;} ?>
              </ul>
              <div class="clr"></div>
            </div>
            <div>
              <div class="clr"></div>
            </div>
          </div>
          <div class="clr"></div>
          <div class="occupation">
            <div class="title">Occupation Target</div>
            <div class="data">
              <?php
			$rt = mysql_query("select * from `occupation` ORDER BY `id` ASC");
			while($rw = mysql_fetch_array($rt)){
			echo '<div style="float:left; width:50%; padding:3px 0"><label><input type="checkbox" value="'.$rw['id'].'" /> &nbsp;'.$rw['occupation'].'</label></div>';
			}
			?>
              <div class="clr"></div>
            </div>
          </div>
        </div>
        <h3>STEP 4: ADD IMAGES AND VIDEO</h3>
        <div id="box">
          <div id="head">Main Event Image:
            <div id="info"></div>
          </div>
          <div class="ev_fltlft">
            <input type="file" />
          </div>
          <div class="ev_fltlft" style="padding:0 0 0 10px;">Must be JPG, GIF or PNG.<br />
            Dimensions are limited to 550 x 640px.</div>
          <div id="head">Image Galleries:
            <div id="info"></div>
          </div>
          <div class="gallery_area">
            <div id="head" style="padding:16px 0 12px; font-size:22px">Gallery Name:
              <div id="info"></div>
            </div>
            <input type="text" name="" value="<?php echo "Create a name for your image gallery (i.e. Dress Code)"; ?>" id="gname" onFocus="removeText(this.value,'Create a name for your image gallery (i.e. Dress Code)','gname');" onBlur="returnText('Create a name for your image gallery (i.e. Dress Code)','gname');" class="new_input" style="width:534px;">
            <div class="ev_fltlft" style="width:50%; padding:5px 0">
              <input type="file" />
            </div>
            <div class="ev_fltlft" style="width:50%; padding:5px 0">
              <input type="file" />
            </div>
            <div class="clr"></div>
            <div class="ev_fltlft" style="width:50%; padding:5px 0">
              <input type="file" />
            </div>
            <div class="ev_fltlft" style="width:50%; padding:5px 0">
              <input type="file" />
            </div>
            <div class="clr"></div>
            <div align="right"><br />
              <br />
              <img src="<?php echo  IMAGE_PATH; ?>add_another_gallery.png" /></div>
          </div>
          <div id="head">Event Video:
            <div id="info"></div>
          </div>
          <div class="gallery_area">
            <div id="head" style="padding:16px 0 12px; font-size:22px">Video Name:</div>
            <input type="text" name="" value="<?php echo "Enter the name of your video"; ?>" id="video_name" onFocus="removeText(this.value,'Enter the name of your video','video_name');" onBlur="returnText('Enter the name of your video','video_name');" class="new_input" style="width:534px;">
            <div id="head" style="padding:16px 0 12px; font-size:22px">Copy and Paste the Video Embed Code Here:</div>
            <textarea class="new_input" style="width:534px; height:130px;"></textarea>
          </div>
        </div>
        <h3>STEP5: ADD EVENT DATE AND TIMES</h3>
        <div id="box">
		<div id="head">Select Event Date(s)</div>
		
		<div id="z_tab_calender_view" class="z-calendar-view z-tab-content" style="display: block">
            <label><sup>&#42;</sup> Click one or more dates for your event or event series on the calendars below.</label>
            <div class="yui-skin-sam">
              <div id="z_calendar_container"></div>
              <div class="clear"></div>
            </div>
          </div>
</div>
        <h3>STEP 6: ADD LOCATION</h3>
        <div id="box"> <br>
          <br>
          <input type="text" name="venue_name" id="venue_name" class="new_input" value="<?php if ($bc_venue_name){ echo $bc_venue_name; }else{ echo "Start Typing Location Name"; } ?>" onfocus="removeText(this.value,'Start Typing Location Name','venue_name');" onblur="returnText('Start Typing Location Name','venue_name');" style="margin-bottom:2px; width:274px" />
          <br>
          <a href="javascript:void(0)" style="color:#0066FF; text-decoration:underline" onclick="windowOpener(525,645,'Add New Location','add_venue.php')"> Can't find your location? Add it here </a><br>
          <br>
          <input type="hidden" name="venue_id" id="venue_id" value="<?php echo $bc_venue_id; ?>" />
          <input type="text" name="address1" id="ev_address1" class="new_input" value="<?php if ($bc_venue_address){ echo $bc_venue_address; } else{ echo 'Address'; } ?>"  onFocus="removeText(this.value,'Address','ev_address1');" onBlur="returnText('Address','ev_address1');" style="width:274px">
          <br>
          <br>
          <input type="text" name="city" id="ev_city" class="new_input" value="<?php if ($bc_venue_city){ echo $bc_venue_city; } else{ echo 'City'; } ?>"  onFocus="removeText(this.value,'City','ev_city');" onBlur="returnText('City','ev_city');" style="width:274px">
          <br>
          <br>
          <input type="text" name="zip" id="ev_zip" class="new_input" value="<?php if ($bc_venue_zip){ echo $bc_venue_zip; } else{ echo 'Zip / Postal Code'; } ?>"  onFocus="removeText(this.value,'Zip / Postal Code','ev_zip');" onBlur="returnText('Zip / Postal Code','ev_zip');" style="width:274px">
        </div>
      </div>
    </div>
    <input type="hidden" name="submt" value="submt" />
  </form>
</div>
<?php include_once('includes/footer.php');?>
<div id="dwindow" style="position:absolute;background-color:#fff;cursor:hand;left:0px;top:0px;display:none; z-index:9999">
  <div  style="background:url(images/titlebar.gif) repeat-x #fff; font-size: 14px; font-weight: bold; height: 18px; padding: 5px 7px 0 7px;width: 786px; border:#000000 solid 1px; border-bottom:none;">Create Ticket<img src="<?php echo  IMAGE_PATH;?>closePopUp.gif" onClick="closeit()" style="cursor:pointer;" title="Close" align="right"></div>
  <div id="dwindowcontent" style="height:100%">
    <iframe id="cframe" src="" width="800px" height="100%" style="border:#000 solid 1px; border-top:none; background:#fff"></iframe>
  </div>
</div>
<script>
tinyMCE.init({
	mode : "exact",
	elements : "event_description",
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,forecolor,backcolor,bullist,numlist,outdent,indent,blockquote,anchor,cleanup",
	theme_advanced_buttons2 : "cut,copy,paste,styleselect,formatselect,fontselect,fontsizeselect,hr,code,image",
	theme_advanced_font_sizes: "10px,11px,12px,13px,14px,15px,16px,17,18px,19px,20px,22px,24px,26px,28px,30px,36px",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	remove_script_host : false,
    convert_urls : false,
	content_css : "site_styles.css?1",
	plugins : 'inlinepopups,imagemanager'
});
</script>

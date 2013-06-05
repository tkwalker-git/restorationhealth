<?php


function showCatList($catId){

	$query = "select * from categories where id = '$catId'"; 
	$res = mysql_query($query);
	while ($r = mysql_fetch_assoc($res)){
			$cat_seo_name	= DBout($r['seo_name']);
			echo '<span><a href="'. ABSOLUTE_PATH . 'category/' . $cat_seo_name .'.html" class="home_cat_title">'.$r['name'].'</a></span>';
			 
			$query2 = "select * from sub_categories where categoryid = '$catId'";		
			$res2 = mysql_query($query2);
				echo '<ul>';
					
				while($r2 = mysql_fetch_assoc($res2)){
						echo '<li><a href="category-all/'.$r['seo_name']."/".$r2[seo_name].'.html'.'">'.$r2['name'].'</a></li>';
				}
	}
	
	echo "</ul>";
}

function ShowCatMeta($category, $sub_category){
	
	$pcat_meta_q = "select * from categories where seo_name = '$category'";
		$subcat_meta_q 	= "select * from sub_categories where seo_name = '$sub_category'";
		$pcat_meta_res 	= mysql_query($pcat_meta_q) or die("Error");
		$pcat_meta_row 	= mysql_fetch_assoc($pcat_meta_res);
		$pcat_title 	= DBout($pcat_meta_row['meta_title']);
		$pcat_meta_desc = DBout($pcat_meta_row['meta_desc']);
		$pcat_meta_keywords = DBout($pcat_meta_row['meta_keywords']);
		
		$subcat_meta_row = mysql_fetch_assoc($subcat_meta_res);
		$subcat_meta_res = mysql_query($subcat_meta_q) or die("Error");
		$subcat_meta_row = mysql_fetch_assoc($subcat_meta_res);
		
		$subcat_title 			= DBout($subcat_meta_row['meta_title']);
		$subcat_meta_desc 		= DBout($subcat_meta_row['meta_desc']);
		$subcat_meta_keywords 	= DBout($subcat_meta_row['meta_keywords']); 
		
		$cat_title = $pcat_title." - ".$subcat_title;
		$cat_meta_desc = $subcat_meta_desc." ".$subcat_meta_desc;
		$cat_meta_keywords = $pcat_meta_keywords.", ".$subcat_meta_keywords;
}

function validateUrl($url) {

	if(preg_match("/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/",$url))

		return true;

	else	

		return false;

}

function getEventImage($image,$source="EventFull",$small=0)
{
	
	if ( $small ) {
		$h = 157;
		$w = 127;
	} else {
		$h = 200;
		$w = 163;
	}
	
	if ( substr($image,0,7) != 'http://' && substr($image,0,8) != 'https://' ) {
	
		if ( $image != '' && file_exists(DOC_ROOT . 'event_images/th_' . $image ) ) {
			$img = returnImage( ABSOLUTE_PATH . 'event_images/th_' . $image,$w,$h );
			$img = '<img align="left" '. $img .' />';	
		} else
			$img = '<img src="' . IMAGE_PATH . 'imgg.png" align="left" width="'. $w .'" height="'. $h .'"/>';	
	} else {
		if ( $source != "EventFull")
			$img_params 	= returnImage($image,$w,$h);
		else {
			if ( strtolower(substr($image,-4,4)) != '.gif')
				$image = str_replace("/medium/","/large/",$image);
			$img_params		= 'src="'. $image .'" width="'. $w .'" height="' . $h .'"';	
		}	
		$img 			= '<img align="left" '. $img_params .' />';	
	}	
	
	return $img;
}

function returnImage($image,$mxWidth=163,$mxHeight=200)
{
	$image = str_replace("%20"," ",$image);

	if ($mxWidth > 0 ) {
		list($width, $height, $type, $attr) = @getimagesize($image);
		list($width, $height) = getPropSize($width, $height, $mxWidth,$mxHeight );
	} else {
		list($width, $height, $type, $attr) = @getimagesize($image);
	}
		
	$ret = 'src="'. $image .'" width="'. $width .'" height="'. $height .'"';
	
	return $ret;
}	

function getPropSize($actualWidth,$actualHeight,$resultWidthidth,$resultHeighteight)
{
	if ($actualWidth < $resultWidthidth && $actualHeight  <	$resultHeighteight ) {
		$resultWidth = $actualWidth;
		$resultHeight = $actualHeight;
	} else {
		if ($actualWidth >= $actualHeight) {
			$resultWidth        = number_format($resultWidthidth, 0, ',', '');
			$resultHeight       = number_format(($actualHeight / $actualWidth) * $resultWidthidth, 0, ',', '');
		} else {
			$resultHeight       = number_format($resultHeighteight, 0, ',', '');
			$resultWidth        = number_format(($actualWidth / $actualHeight) * $resultHeighteight, 0, ',', '');
		}
		
		if ($actualWidth > $resultWidthidth) {
			$resultWidth        = number_format($resultWidthidth, 0, ',', '');
			$resultHeight       = number_format(($actualHeight / $actualWidth) * $resultWidthidth, 0, ',', '');
		}	
		
	}
	
	
	return array($resultWidth,$resultHeight);
}

function breakStringIntoMaxChar($string,$max)
{
	if (strlen($string) > $max)	{
		$str 	= substr($string,0, $max);
		$str1	= strrev($str);
		$st		= strpos($str1," ");
		$str1	= substr($str1,$st);
		$str	= strrev($str1);
		$str = $str . '...';
	} else {
		$str = $string;
	}	
	return $str;
}

function getEventDates($event_id)
{
	$sql = "select * from event_dates where event_id='". $event_id ."'";
	$res = mysql_query($sql);
	$dates = array();
	while ( $row = mysql_fetch_assoc($res) ) 
		$dates[] = $row['event_date'];
	
	$tot = count($dates);
	
	$sdate = $dates[0];
	$edate = $dates[$tot-1];
	
	if ( $sdate != '' )
		$date1 = date("l F d, Y",strtotime($sdate));
	
	if ( $edate != $sdate )	{
		if ( $edate != '' )
			$date2 = ' - ' .date("l F d, Y",strtotime($edate));	
	} else {
		$date2 = '';
	}
		
	return $date1 . $date2;	
	
}

function getEventStartDates($event_id)
{
	$sql = "select * from event_dates where event_id='". $event_id ."'";
	$res = mysql_query($sql);
	$dates = array();
	while ( $row = mysql_fetch_assoc($res) ) 
		$dates[] = $row['event_date'];
	
	$tot = count($dates);
	
	$sdate = $dates[0];
	$edate = $dates[$tot-1];
	
	if ( $sdate != '' )
		$date1 = date("F d, Y",strtotime($sdate));
	
	return $date1;	
	
}


function getEventLocations($event_id)
{
	$sql = "select * from venue_events where event_id='". $event_id ."'";
	$res = mysql_query($sql);
	if ( $rows = mysql_fetch_assoc($res) ) {
		$sql1 = "select * from venues where id='". $rows['venue_id'] ."'";
		$res1 = mysql_query($sql1);
		if ( $row = mysql_fetch_assoc($res1) ) {
			
			$location[] 	= $row['venue_name'];
			$location[] 	= $row['venue_address'];
			$location[] 	= $row['venue_city'] . ' ' . $row['venue_state'] . ' , ' . $row['venue_zip'] . '<br>';
				
		}
	}
	
	if ( is_array($location) ) 
		$locations = implode("<br>",$location);
	else 
		$locations = 'Venue not yet decided.';	
	
	$ret[0] = $locations;
	$ret[1] = $row;
	
	return $ret;	
}

function getReTweetBtn($url="")
{
	if ($url == "" ) 
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	?>
		<script type="text/javascript">
			tweetmeme_url = '<?php echo $url;?>';
			tweetmeme_style = 'compact';
			
			</script>
			<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
	<?php		

}

function getFShareBtn($url="")
{
	if ($url == "" ) 
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	?>	
	<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent('<?php echo $url;?>')+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><a href="http://www.facebook.com/share.php?u=<?php echo $url;?>" onclick="return fbs_click()" target="_blank"><img src="<?php echo ABSOLUTE_PATH;?>images/fshare.png" alt="Share on Facebook" align="top"/></a>
  <?php	
}


function getSingleColumn($column,$sql)
{
	$res = mysql_query($sql);
	if ( $row = mysql_fetch_assoc($res) )
		return $row[$column];
}


function getCurrentWeek()
{

	$dayofweek 	= date("N");
	
	$start		= $dayofweek - 1;
	$end		= 7- $dayofweek ;
	
	$start 	= strtotime("now") - $start * 86400;
	$end 	= strtotime("now") + $end * 86400;
	
	$ret['start'] = $start;
	$ret['end']   = $end;
	
	return $ret;
}


function getEventURL($event_id)
{
	$category_id 			= attribValue('events', 'category_id', "where id='$event_id'");
	$scategory_id 			= attribValue('events', 'subcategory_id', "where id='$event_id'");
	
	$category_seo_name 		= attribValue("categories","seo_name","where id=" . $category_id);
	$subcategory_seo_name 	= attribValue("sub_categories","seo_name","where id=" . $scategory_id);
	
	if ( $category_seo_name == "" )
		$category_seo_name = 'uncategorized';
		
	if ( $subcategory_seo_name == "" )
		$subcategory_seo_name = 'uncategorized';
	
	$event_url	= ABSOLUTE_PATH . 'category/' . $category_seo_name . '/' . $subcategory_seo_name . '/' . $event_id . '.html';
	
	return $event_url;
}

function getAddToWallButton($event_id,$small=0)
{
	$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
	$already = attribValue('event_wall', 'id', "where event_id='$event_id' and userid='$member_id'");
	if ( $small == 0 ) {
		if ( $already > 0 ) 
			echo  '<img src="'. ABSOLUTE_PATH .'images/added_to_event_btn_small.png" />';
		else
			echo '<a href="javascript:void(0)" onclick="addToEventWall(\''. ABSOLUTE_PATH .'\','. $event_id .')"><img src="'. ABSOLUTE_PATH .'images/add_event22.png" /></a>';
	} else {
		if ( $already > 0 ) 
			echo  '<img src="'. ABSOLUTE_PATH .'images/added_to_event_btn_small1.png" />';
		else
			echo '<a href="javascript:void(0)" onclick="addToEventWall(\''. ABSOLUTE_PATH .'\','. $event_id .')"><img src="'. ABSOLUTE_PATH .'images/add_to_event_btn_small.png" /></a>';
	}		
}

function getEventReviewMember($event_id)
{
	$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
	$sql = "select comment from comment where key_id=$event_id and c_type='event' and by_user=$member_id";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$comment = $row['comment'];
	echo $comment;
}

function getEventRatingMember($event_id)
{
	/*$sql = "select sum(rating) as agg from comment where key_id=$event_id and c_type='event'";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$agg = $row['agg'];
	*/
	$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
	$sql = "select rating from comment where key_id=$event_id and c_type='event' and by_user=$member_id";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$rating = $row['rating'];
	
	if ( $rating > 0 ) {
		$rating2 = ceil($rating/2);
		for($i=1; $i<=$rating2;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'on_star.png" width="15" height="14" border="0" />';	
		for($i=$rating2+1; $i<=5;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'off_star.png" width="15" height="14" border="0" />';	
		
	} else {
		for($i=1; $i<=5;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'off_star.png" width="15" height="14" border="0" />';	
	}
}

function getEventRatingAggregate($event_id)
{
	$sql = "select sum(rating) as agg from comment where key_id=$event_id and c_type='event'";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$agg = (int)$row['agg'];
	
	$sql = "select id from comment where key_id=$event_id and c_type='event' ";
	$res = mysql_query($sql);
	$tot = mysql_num_rows($res);
	
	if ( $tot > 0 )
		$rating = ceil($agg/$tot);
	else
		$rating = 0;	
	
	?>
	<a href="javascript:void(0)" onclick="showReviewBox('<?php echo ABSOLUTE_PATH;?>',<?php echo $event_id;?>,'event')">
	<?php
	
	if ( $rating > 0 ) {
		$rating2 = ceil($rating/2);
		for($i=1; $i<=$rating2;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'on_star.png" width="15" height="14" border="0" />';	
		for($i=$rating2+1; $i<=5;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'off_star.png" width="15" height="14" border="0" />';	
		
	} else {
		for($i=1; $i<=5;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'off_star.png" width="15" height="14" border="0" />';	
	}
	?>
	</a>
	<?php
}


function getReviewStarRating($venue_id,$memb,$c_type)
{
	$sql = "select rating from comment where key_id=$venue_id and c_type='". $c_type ."' and by_user=$memb";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$rating = $row['rating'];
	?>
	<a href="javascript:void(0)" onclick="showReviewBox('<?php echo ABSOLUTE_PATH;?>',<?php echo $venue_id;?>,'<?php echo $c_type;?>')">
	<?php
	if ( $rating > 0 ) {
		$rating2 = ceil($rating/2);
		for($i=1; $i<=$rating2;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'on_star.png" width="15" height="14" border="0" />';	
		for($i=$rating2+1; $i<=5;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'off_star.png" width="15" height="14" border="0" />';	
		
	} else {
		for($i=1; $i<=5;$i++)
			echo '<img style="margin:0px 3px;" src="'. IMAGE_PATH.'off_star.png" width="15" height="14" border="0" />';	
	}
	?>
	</a>
	<?php
}


function returnFormatedEvents($res1,$tot_events,$category_id,$sub_cat_id,$view='',$showNextPrev=1)
{
?>
	<span id="sbc<?php echo $sub_cat_id ;?>">
	  <?php 
	  	
	if ( $tot_events > 0 ) {
		$i=0;
		while ($rows1 = mysql_fetch_assoc($res1) )
	  	{
			$i++;
			if ( $view != 'all' ) {	
				if ( $i > 4 )
					break;
			}	
			$event_name 	= breakStringIntoMaxChar(DBout($rows1['event_name']),25);
			$full_name		= DBout($rows1['event_name']);
			$event_date 	= getEventStartDates($rows1['id']);
			$source			= $rows1['event_source'];
			$event_image	= getEventImage($rows1['event_image'],$source);
			$event_url		= getEventURL($rows1['id']);
			
	  ?>
	  <table style="width:233px; float:left;">
	  <tr>
		<td width="233">
			<div class="txt2"><a href="<?php echo $event_url;?>" title="<?php echo $full_name;?>"><?php echo $event_name;?></a></div>
			<div class="date"><?php echo $event_date;?></div>
			<div class="imag" ><div style="overflow:hidden; width:163px; height:200px"><a href="<?php echo $event_url;?>" alt="<?php echo $full_name;?>" title="<?php echo $full_name;?>"><?php echo $event_image;?></a></div></div>
			<div class="add_event2">
				<!-- <a href="<?php echo $event_url;?>"><img src="<?php echo IMAGE_PATH;?>add_event22.png" /></a> -->
				<?php getAddToWallButton($rows1['id']); ?>
			</div>
		</td>
	  </tr>
	  <tr>
		<td align="center">
			<?php getEventRatingAggregate($rows1['id']);?>
		</td>
	  </tr>
	  </table>

	  	<?php 
	  		}
			
		if ( $tot_events > 4 ) {
			if ( $view != 'all' ) {		
		?>
		<table width="100%" cellpadding="0" cellspacing="0" style="float:none; clear:both">
		  <tr>
			<td width="823"><div class="prev">
				<a href="javascript:void(0)">
					<img src="<?php echo IMAGE_PATH;?>prev_disabled.png" />
				</a></div> 
				</td>
			<td width="84">
				<?php if ( $showNextPrev ) { ?>
				<div class="next"><a href="javascript:loadNextSubCategory('<?php echo ABSOLUTE_PATH;?>','<?php echo $category_id;?>','<?php echo $sub_cat_id;?>','next',1)"><img src="<?php echo IMAGE_PATH;?>next.png" /></a></div>
				<?php } ?>
			</td>
		  </tr>
		</table>
		
	<?php } } ?>
	</span>
<?php } else {	?>
	<table width="100%">
	  <tr>
		<td height="100" ><div class="txt2" style="color:#990000!important; text-align:center; width:80%!important">
			No event found in this category.
		</div></td>
	  </tr>
	  </table>
<?php
	}
}  // end returnFormatedEvents


function getMemberPrefrences()
{
	$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
	$rsc = mysql_query("select * from categories ");
	while ( $rowc = mysql_fetch_assoc($rsc) ) {
		$cid		= $rowc['id'];
		$attr_name 	= DBout($rowc['name']);
		$attr_name	= ucwords($attr_name);
		$val = attribValue("member_prefrences","selection","where prefrence_type=" . $cid . " and member_id=" . $member_id );
		
		if ( $val == 'O' )
			$value = 'Often';
		else if ( $val == 'S' )
			$value = 'Sometimes';	
		else if ( $val == 'N' )
			$value = 'Never';		
		
		$pref[] = array($attr_name,$value);
		
	}
	
	return $pref;	
}


function getReviewsList($key_id,$c_type)
{

	$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
?>

<div class="recommendedBlock" style="border: 1px solid #C1C1C1;; margin-top:10px;">
		<div class="recommended_heading heading_dark_16">
			<?php echo ucwords($c_type);?> Reviews
			<a href="javascript:void(0)" onclick="showReviewBox('<?php echo ABSOLUTE_PATH;?>',<?php echo $key_id;?>,'<?php echo $c_type;?>')">
				<img src="<?php echo IMAGE_PATH;?>write_review.png" width="141" height="30" align="right" style="float:right; margin-top:-8px; " border="0" />
			</a>	
		</div>
		<?php
			
			$sqlv = "select * from comment where key_id='".$key_id . "' AND c_type='". $c_type."'";
				$resv = mysql_query($sqlv);
				$totv = mysql_num_rows($resv);
				
				if ($totv > 0 ) {
			
		?>
		<ul class="recommend_ul">
			
			<?php
				
				
					while ($rowv = mysql_fetch_assoc($resv) ) {
						$review_id = $rowv['id'];
						$sqm = "select * from members where id='" . $rowv['by_user'] . "'";
						$resm = mysql_query($sqm);
						if ( $rowm = mysql_fetch_assoc($resm) ) {
							$mid			= $rowm['id'];
							$member_image 	= $rowm['image_name'];
							$member_name 	= $rowm['name'];
						}
						
						$cdate 		= date("M d, Y",strtotime($rowv['date_posted']));
						$comment	= DBout($rowv['comment']);
			?>
			
			<li style="width:865px; margin-left: 10px;  padding: 20px; border-bottom: 1px solid #d8d8d8;">
				<div class="eventList">
					<div>
						<img src="<?php echo IMAGE_PATH;?>members/<?php echo $member_image;?>"  border="0" /><br />
						<span class="heading_colored_14" style="text-decoration:underline;"><?php echo $member_name;?></span>
					</div>
				</div>
				<div class="eventList_dt">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td>
							<?php getReviewStarRating($key_id,$mid,$c_type);?>
							&nbsp;<span class="heading_dark_14_bold" style="margin-left:20px;"><?php echo $cdate;?></span></td>
					  </tr>
					  <tr>
					  	<td class="heading_dark_14"  style="padding-top:10px;">
							<?php echo $comment;?>
						</td>
					  </tr>
					   <tr>
					  	<td class="heading_dark_14" valign="top"  style="padding-top:10px;">
							<?php

								$already = attribValue("review_helpfull","id","where review_id=" . $review_id . " AND userid='". $member_id ."'");
								$said    = attribValue("review_helpfull","status","where review_id=" . $review_id . " AND userid='". $member_id ."'");
								if ( $said == 0 )
									$sai = 'No';
								if ( $said == 1 )
									$sai = 'Yes';
								if ( $said == 2 )
									$sai = 'Inappropriate';		
								if ( $already > 0 ) {
									echo '<span class="heading_dark_16">Was this review helpfull? You said "'. $sai .'"</span>';
								} else {	
								
							?>
							<span class="heading_dark_16">Was this review helpfull?</span>
								<button onclick="reviewHelpFull('<?php echo ABSOLUTE_PATH;?>',<?php echo $review_id;?>,1)" class="jes_btn"></button>
								<button onclick="reviewHelpFull('<?php echo ABSOLUTE_PATH;?>',<?php echo $review_id;?>,0)" class="no_btn"></button>
								<button onclick="reviewHelpFull('<?php echo ABSOLUTE_PATH;?>',<?php echo $review_id;?>,2)"  class="inap_btn"></button>
							<?php } ?>	
						</td>
					  </tr>
					  <tr>
					  	<td class="heading_dark_14" valign="top"  style="padding-top:10px;">
							<?php
								$total_reviews1	= getSingleColumn('tot',"select count(*) as tot from review_helpfull where review_id=" . $review_id);
								$total_helpfull	= getSingleColumn('tot',"select count(*) as tot from review_helpfull where status=1 and review_id=" . $review_id);
								
								if ( $total_reviews1 > 0 )
									$total_helpfull_precent = ceil( ($total_helpfull/$total_reviews1) * 100);
								else
									$total_helpfull_precent = 0;	
								
							?>
							<?php echo $total_helpfull;?> out of <?php echo $total_reviews1;?> members found this review helpful
						</td>
					  </tr>
					  <tr>
					  	<td class="heading_dark_14" valign="top"  style="padding-top:15px;">
							<span class="d_style">Total Reviews:</span> <?php echo $total_reviews1;?>
						</td>
					  </tr>

					  <tr>
					  	<td class="heading_dark_14" valign="top">
							<span class="d_style">Helpfull Percent:</span> <?php echo $total_helpfull_precent;?>%
						</td>
					  </tr>
					</table>

				</div>
			</li>
			<?php }  } else { ?>
			<div style="padding:30px; text-align:center; color:#990000">
				No review found for this <?php echo $c_type;?>. Be the first to write a review. 
				<a href="javascript:void(0)" onclick="showReviewBox('<?php echo ABSOLUTE_PATH;?>',<?php echo $key_id;?>,'<?php echo $c_type;?>')">
					Click Here.
				</a>
			</div>
			<?php } ?>
			<div class="clr"></div>
		</ul>
	
	</div><!--end recommendedBlock-->

<?php
}

function getViewEventURL()
{
	$sql = "select seo_name from categories order by id LIMIT 1";
	$res = mysql_query($sql);
	if ( $r = mysql_fetch_assoc($res) )  {
		$seo_name = $r['seo_name'];
	}
	
	return ABSOLUTE_PATH . 'category/' . $seo_name . '.html';
}

function getTwitterStatus($userid){
	//http://twitter.com/statuses/user_timeline/eventgrabber.xml?count=1
	$url = "http://twitter.com/statuses/user_timeline/$userid.xml?count=1";
	$xml = simplexml_load_file($url) or die("could not connect");

	foreach($xml->status as $status) {
	   $text = $status->text;
	   $date = $status->created_at;
	}
	
	$a['tweet'] = $text;
	$a['date']  = $date;
	
	return  $a;
}


function determineMemberEventWeights()
{
	$member_id = $_SESSION['LOGGEDIN_MEMBER_ID'];
	$rs	= mysql_query("select id from categories");
	while ( $r = mysql_fetch_assoc($rs) ) {

		$rs2	= mysql_query("select id from sub_categories where categoryid=" . $r['id']);
		while ( $r2 = mysql_fetch_assoc($rs2) ) {
			$score[$r['id']][$r2['id']] = 0;
			$s3 = "select selection from member_prefrences where member_id='". $member_id ."' AND prefrence_type=" . $r2['id'];
			$rs3 = mysql_query($s3);
			if ( $r3 = mysql_fetch_assoc($rs3) ) {
				$selection = $r3['selection'];
				//echo $r['id'] . ' = ' . $r2['id'] . ' = ' . $selection . '<br>';
				if ( $selection == 'O')
					$score[$r['id']][$r2['id']] += 10;
				if ( $selection == 'S')
					$score[$r['id']][$r2['id']] += 5;
				else
					$sc = 0;
			}	
			
		}
	}
	
	return $score;
}

function returnSubCatEventList($cat) 
{
	$ids = array();
	$score = determineMemberEventWeights();
	$scores = $score[$cat];
	$sql1 = '';
	$sql2 = '';
	$pscr = -1;
	arsort($scores);
	foreach ($scores as $subcat => $score) {
		if ( $score > 0 ) {
			$sql[] = "select id from events where subcategory_id='". $subcat ."' and event_status=1 ";
		}	
	}
	
	if ( count($sql) > 0 ) {
		$rsql = implode(" UNION ",$sql);
		
		$res = mysql_query($rsql);
		while ($r = mysql_fetch_assoc($res) )
			$ids[] = $r['id'];
	}
	
	return $ids;	
}

?>
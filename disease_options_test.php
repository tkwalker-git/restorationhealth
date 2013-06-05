                <div  class="ev_fltlft" style="width:33%">
                    <div id="head" >Category</div>
                    <select name="disease_category" id="disease_category" class="selectBig" onChange="dynamic_Select('ajax/disease_subcategory.php', this.value, '0','subcategory_id' );">
                        <option value="">-- Select Category --</option>
                        <?php
$res = mysql_query("select * from `disease_category` ORDER BY `cat_name` ASC");
while($row = mysql_fetch_array($res)){
	if ( $row['id'] == $bc_disease_category )
		$sele = 'selected="selected"';
	else
		$sele = ''; ?>
                        	<option <?php echo $sele; ?> value="<?php echo $row['id']; ?>"><?php echo $row['cat_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div  class="ev_fltlft" style="width:33%">
                    <div id="head" >Sub-category</div>
                <span id="subcategory_id">
					<?php
if($bc_disease_subcategory!=''){?>
                        <select name="disease_subcategory" class="selectBig" onChange="dynamic_Select('ajax/disease_conditions.php', this.value, '', 'conditions' );">
							<?php
	$subcat_q = "SELECT * FROM `disease_subcategory` WHERE cat_id = '". $bc_disease_subcategory ."' ORDER BY id ASC";
	$res = mysql_query($subcat_q);
	while( $r = mysql_fetch_assoc($res) ){
		if ( $r['id'] == $_GET['subcat'] )
			$sele = 'selected="selected"';
		else
			$sele = '';
?>
            	                <option value="<?php echo $r['id']; ?>" <?php if ($bc_disease_subcategory==$r['id']){ echo 'selected="selected"'; }?>><?php echo $r['sub_cat_name']; ?></option>
                            <?php
	}
?>
                        </select>
                    <?php
}
else{
?>
                        <select name="subcategory_id" class="selectBig">
                        	<option value="">-- Sub-category --</option>
                        </select>
                    <?php } ?>
                </span>
                <br /><br />
                </div>


							<script>
        function dynamic_Select(ajax_page,category_id,sub_category,resp_id)
         {
             $.ajax({
                type: "GET",
                url: ajax_page,
                data: "cat=" + category_id + "&subcat=" + sub_category + "&class=selectBig",
                dataType: "text/html",
                success: function(html){
                $("#"+resp_id).html(html);
                }
            });
          }
        </script>
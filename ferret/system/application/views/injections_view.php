<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<h2>Experement input</h2>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>


<p><a href="index.php?c=injections&m=add">Add new Injection </a></p>
<p><a href="index.php?c=labelledsites&m=add">Add new Labelled Site</a></p>


<?php endif;?>


<?php if($action == 'add'):?>


<h2>Add New Injection</h2>

<?php if(isset($add_message)):?>
<p><?=$add_message?></p>
<?php endif;?>


<a href="#" onclick="show_coding_rules('injections'); return false;">Coding rules for Injection</a>
<form method="post" id="frm" name="frm" action="index.php?c=injections&m=insert">

<table border="0" cellpadding="3" cellspacing="1">

<tr><td colspan="3"><b>First, you need to find Literature where this injection was discribed</b></td></tr>

<tr id="auto_block_inj">
	<td>Search for publication<br/> to find publication of injection and method </td>
	<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth_inj" class="input"/>
	<br/>Start type title of a literature, select method below 
	</td>
</tr>

<tr id="lit_block_inj" style="display:none;">
	<td>Selected Literature <br/> for this injection</td>
	<td id="literature_inj"></td>
</tr>

<tr id="method_block" >
	<td>
		Select Method
		<br/> for this injection:
		<br/>Can't find or nothing found? 
		<br/> <a target="_blank" href="index.php?c=methods&m=show">Check Methods first</a>
	</td>
	<td id="method_block_data">Select Paper first above</td>
</tr>

<tr><td colspan="3"><b>Second, you need to find Literature where a brain map of necessary b site was discribed.</b><br/>Please remember that publication can use different bmap!</td></tr>


<tr id="auto_block">
	<td>Search for publication<br/> to find Brain Map </td>
	<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth" class="input"/>
	<br/>Start type title of a literature, after that type acronym of brain site below 
	</td>
</tr>

<tr id="lit_block" style="display:none;">
	<td>Selected Literature <br/> for this injection:</td>
	<td id="literature"></td>
</tr>




<tr id="bsite_auto_block" >
	<td>Search for Brain Site<br/> for this Injection </td>
	<td><input title="Please, start to type acronym of brain site" type="text" id="autocomplite_bsite" class="input" disabled/></td>
</tr>

<tr style="display:none;" id="bsite_block">
	<td>Selected Brain Site <br/> for this injection</td>
	<td id="sel_bsite"></td>
</tr>

<tr>	
	
	<td>PDC_EC</td>
	<td><?php echo form_dropdown('PDC_EC', $pdc_options);?> <a href="#" onclick="show_coding_rules('pdc_ec'); return false;"> Coding rules</a></td>	
	
</tr>

<tr>	
	
	<td>Extension codes</td>
	<td><?php echo form_dropdown('EC', $ec_options);?><a href="#" onclick="show_coding_rules('ec'); return false;"> Coding rules</a></td>	
	
</tr>




<?php foreach($fields as $field): ?>

 
<?php if (($field->primary_key == 1) OR ($field->name == 'methods_id') OR ($field->name == 'PDC_site') OR ($field->name == 'PDC_laminae') OR ($field->name == 'injections_laminae') OR ($field->name == 'site_type') OR ($field->name == 'PDC_EC') OR ($field->name == 'EC') OR ($field->name == 'literature_id') OR ($field->name == 'brain_sites_id') OR ($field->name == 'injections_index')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>

<tr><td colspan="3"><strong>Third, you need to input Laminae data ! if exists !</strong> <a href="#" onclick="show_lamina(); return false;" id="lamina_show_button">Yes, show fields</a><a style="display:none;" id="lamina_hide_button" href="#" onclick="hide_lamina(); return false;">Hide, lamina </a></td></tr>

<tr style="display:none;" id="lamina_fields_1">	
	
	<td>Injections Laminae<br/><a href="#" onclick="show_coding_rules('laminae'); return false;"> Coding rules</a></td>

	<td><input class="input" name="injections_laminae" value="" size="30" /> </td>
</tr>

<tr style="display:none;" id="lamina_fields_2">	
	
	<td>PDC_laminae</td>
	<td><?php echo form_dropdown('PDC_laminae', $pdc_options);?> <a href="#" onclick="show_coding_rules('pdc_laminae'); return false;"> Coding rules</a></td>	
	
</tr>


</table>

<input type="submit" class="submit" value="Insert" />

</form>





<br/>
<div id="help_div"></div>




<script type="text/javascript">
//<![CDATA[

new Autocomplete('autocomplite_auth_inj', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit/', 
	onSelect: function(value, data){
		sel_lit_inj_num = data;
		literature_for_inj_select();
		
	}
 });
           

new Autocomplete('autocomplite_auth', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit/', 
	onSelect: function(value, data){
		sel_lit_num = data;
		literature_select();
		
	}
 });


new Autocomplete('autocomplite_bsite', { 
	serviceUrl:'index.php/brainsites/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_bsite_num = data;

		bsite_select();
		
	}
 });


<?php if(isset($lit_data)):?>
sel_lit_inj_num = <?=$lit_data->literature_id?>;
$('autocomplite_auth_inj').value = '<?=$lit_data->literature_title?> <?=$lit_data->literature_index?>';
literature_for_inj_select();
<?php endif;?>
 

$('frm').onsubmit = function () { return check_form(this)}

//]]>
</script>




<?php endif;?>




<?php if($action == 'edit'):?>

<div id="edit_inj_block">
<a href="javascript:history.go(-1)" >Back</a>
<h2>Edit Injection</h2>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>



<?php if(isset($inj_data)):?>

<a href="#" onclick="show_coding_rules('injections'); return false;">Coding rules for Injection</a>

<form method="post" id="frm" name="frm" action="index.php?c=injections&m=update&injid=<?=$inj_data->injections_id?>">

<table border="0" cellpadding="3" cellspacing="1">


<tr id="auto_block_inj" style="display:none;">
	<td>Search for publication<br/> to find publication of injection and method </td>
	<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth_inj" class="input"/>
	<br/>Start type title of a literature, after that type acronym of brain site below 
	</td>
</tr>

<tr id="lit_block_inj" >
	<td>Selected Literature <br/> for this injection</td>
	<td id="literature_inj">
		<span id="<?=$lit_data->literature_id?>">
		<input type="hidden" name="literature_id" value="<?=$lit_data->literature_id?>">
		<?=$lit_data->literature_title?> <?=$lit_data->literature_year?>
		<a href="#" onclick="lit_replace('<?=$lit_data->literature_id?>'); return false;"> Replace</a>
		</span><br/>
	</td>
</tr>

<tr id="method_block" >
	<td>
		Select Method 
		<br/>Can't find or nothing to select? 
		<br/> <a target="_blank" href="index.php?c=methods&m=show">Check Methods first</a>
	</td>
	<td id="method_block_data">Select Paper first above</td>
</tr>



<tr id="bsite_auto_block" style="display:none;">
	<td>Search for Brain Site<br/> for this Injection </td>
	<td><input title="Please, start to type ID of Brain Map" type="text" id="autocomplite_bsite" class="input" disabled/></td>
</tr>

<tr  id="bsite_block">
	<td>Selected Brain Site <br/> for new Injection</td>
	<td id="sel_bsite">
	
	<span id="<?=$bsite_data->brain_sites_id?>"><?=$bsite_data->brain_sites_index?> <?=$bsite_data->acronym_full_name?>
	<input type="hidden" name="brain_sites_id" value="<?=$bsite_data->brain_sites_id?>">
	<a href="#" onclick="bsite_replace('<?=$bsite_data->brain_sites_id?>'); return false;"> Replace</a><br/></span>
	
	</td>
</tr>



<tr>	
	
	<td>PDC_EC</td>
	<td><?php echo form_dropdown('PDC_EC', $pdc_options,$inj_data->PDC_EC);?> <a href="#" onclick="show_coding_rules('pdc_ec'); return false;"> Coding rules</a></td>	
	
</tr>

<tr>	
	
	<td>Extension codes</td>
	<td><?php echo form_dropdown('EC', $ec_options,$inj_data->EC);?><a href="#" onclick="show_coding_rules('ec'); return false;"> Coding rules</a></td>	
	
</tr>




<?php foreach($fields as $field): ?>


<?php if (($field->primary_key == 1)   OR ($field->name == 'methods_id') OR ($field->name == 'PDC_laminae') OR ($field->name == 'injections_laminae') OR ($field->name == 'PDC_site')OR ($field->name == 'site_type') OR ($field->name == 'PDC_EC') OR ($field->name == 'EC') OR ($field->name == 'literature_id') OR ($field->name == 'brain_sites_id') OR ($field->name == 'injections_index')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($inj_data->$f); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($inj_data->$f); ?>" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>
<tr><td colspan="3"><strong>Third, you need to input Laminae data ! if exists !</strong></td></tr>
<tr>	
	<td>injections_laminae<br/><a href="#" onclick="show_coding_rules('laminae'); return false;"> Coding rules</a></td>
	<td><input class="input" name="injections_laminae" value="<?php echo form_prep($inj_data->injections_laminae); ?>" size="30" /> </td>
</tr>

<tr>	
	
	<td>PDC_laminae</td>
	<td><?php echo form_dropdown('PDC_laminae', $pdc_options,$inj_data->PDC_laminae);?> <a href="#" onclick="show_coding_rules('pdc_laminae'); return false;"> Coding rules</a></td>	
	
</tr>

</table>

<input type="submit" class="submit" value="Update" />

</form>
<br/>
<div id="help_div"></div>
</div>

<?php if(isset($labelled_num)):?>
<p>
This injection has <?=$labelled_num?> labelled sites 
<span id="a_show_all"> <a href="#" onclick="show_labelled_sites_block('<?=$inj_data->injections_id?>')">Show all</a></span>
<span id="a_hide_all_refresh" style="display:none;"> <a href="#" onclick="hide_labelled_sites_block()">Hide</a> &nbsp; <a href="#" onclick="show_labelled_sites_block('<?=$inj_data->injections_id?>')">Refresh</a> </span>


</p>
<?php endif;?>


<div id="labelled_sites_block"></div>





<script type="text/javascript">
//<![CDATA[

new Autocomplete('autocomplite_auth_inj', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit/', 
	onSelect: function(value, data){
		sel_lit_inj_num = data;
		literature_for_inj_select();
		
	}
 });

new Autocomplete('autocomplite_bsite', { 
	serviceUrl:'index.php/brainsites/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_bsite_num = data;

		bsite_select();
		
	}
 });

sel_bsite_num = <?=$bsite_data->brain_sites_id?>;
sel_lit_inj_num = <?=$lit_data->literature_id?>

get_methods();

$('frm').onsubmit = function () { return check_form(this)}

//]]>
</script>

<?php endif;?>

<?php endif;?>


<?php $this->load->view('footer'); 


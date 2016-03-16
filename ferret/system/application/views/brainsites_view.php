<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>


<?php if($action == 'index'):?>
<h2>Mapping data input</h2>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<p><a href="index.php?c=brainsites&m=add">Add new Brain Sites </a></p>
<p><a href="index.php?c=brainmaps&m=add">Add new Brain Maps </a></p>
<p><a href="index.php?c=acronyms&m=add">Add new Acronyms </a></p>


<?php endif;?>


<?php if($action == 'add'):?>


<a href="javascript:history.go(-1)" >Back</a>

<h2>Add New Brain Site</h2>

<?php if(isset($add_message)):?>
<p><?=$add_message?></p>
<?php endif;?>



<form method="post" id="frm" name="frm" action="index.php?c=brainsites&m=insert">

<table border="0" cellpadding="3" cellspacing="1">

<tr id="auto_block_2">
	<td>Search for publication<br/> to find Brain map </td>
	<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth_bsite" class="input"/>
	<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
	</td>
</tr>

<tr id="lit_block_2" style="display:none;">
	<td>Selected Literature</td>
	<td id="literature_2"></td>
</tr>



<tr id="acron_auto_block">
	<td>
		Search for Acronym
		<br/> for this Brain Site
		<br/> Can't find? 
		<br/> <a href="index.php?c=acronyms" target="_blank">Check Acronyms first</a>
		  
	</td>
	<td><input title="Please, start to type name or full name of Acronym" type="text" id="autocomplite_acron" class="input"/></td>
</tr>

<tr style="display:none;" id="acron_block">
	<td>Selected Acronym <br/> for new Brain Site</td>
	<td id="sel_acron"></td>
</tr>





<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'brain_sites_class') OR ($field->name == 'brain_sites_index') OR ($field->name == 'brain_sites_acronyms_id') OR ($field->name == 'brain_maps_id')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>	
	
	<?php if ($field->name == 'brain_sites_type'): ?>
	<td><?php echo form_dropdown($field->name, $type_options,1,'id="brain_sites_type"');?> <a href="#" onclick="show_coding_rules('bsitetype'); return false;">Coding rules</a></td>
	<?php endif; ?>
	
	<?php if ($field->name == 'brain_sites_class'): ?>
	<td><?php echo form_dropdown($field->name, $classes_options);?> <a href="#" onclick="show_coding_rules('bsiteclass'); return false;">Coding rules</a></td>
	<?php endif; ?>	
	
</tr>
<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Insert" />

</form>
<br/>
<div id="help_div"></div>


<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_auth_bsite', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit/', 
	onSelect: function(value, data){
		sel_lit_num = data;
		literature_select_2();
		
	}
 });
new Autocomplete('autocomplite_acron', { 
	serviceUrl:'index.php/acronyms/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_acron_num = data;

		acron_select();
		
	}
 });

<?php if(isset($bmap_data)):?>
sel_lit_num = <?=$bmap_data->literature_id?>;
$('autocomplite_auth_bsite').value = '<?=$bmap_data->literature_title?> <?=$bmap_data->literature_index?>';
literature_select_2();
<?php endif;?>
 
$('frm').onsubmit = function () { return check_form(this)}

//]]>
</script>

<?php endif;?>



<?php if($action == 'edit'):?>

<a href="javascript:history.go(-1)" >Back</a>

<h2>Edit Brain Site</h2>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>


	<?php if(isset($bs_data)):?>
	
	<form method="post" id="frm" name="frm" action="index.php?c=brainsites&m=update&bsid=<?=$bs_data->brain_sites_id?>">
	
	<table border="0" cellpadding="3" cellspacing="1">
	
	
	<tr id="auto_block_2">
		<td>Search for publication<br/> to find Brain map </td>
		<td>
			<input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth_bsite" class="input"/>
			<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
		</td>
	</tr>

	<tr id="lit_block_2" style="display:none;">
		<td>Selected Literature</td>
		<td id="literature_2"></td>
	</tr>
	
	<tr id="acron_auto_block" style="display:none;">
		<td>
			Search for Acronym
			<br/> for this Brain Site
			<br/> Can't find? 
			<br/> <a href="index.php?c=acronyms" target="_blank">Check Acronyms first</a>
		 
		</td>
		<td><input title="Please, start to type name or full name of Acronym" type="text" id="autocomplite_acron" class="input"/></td>
	</tr>
	
	<tr id="acron_block">
		<td>Selected Acronym <br/> for Brain Site</td>
		<td id="sel_acron">
			<span id="<?=$acr_data->brain_site_acronyms_id?>"><input type="hidden" name="brain_sites_acronyms_id" value="<?=$acr_data->brain_site_acronyms_id?>"> <?=$acr_data->acronym_name?> - <?=$acr_data->acronym_full_name?> <a href="#" onclikck="acron_replace('<?=$acr_data->brain_site_acronyms_id?>'); return false;"> Replace</a><br/></span>
		</td>
	</tr>
	
	
	
	
	
	<?php foreach($fields as $field): ?>
	
	<?php if (($field->primary_key == 1) OR ($field->name == 'brain_sites_class') OR ($field->name == 'brain_sites_index') OR ($field->name == 'brain_sites_acronyms_id') OR ($field->name == 'brain_maps_id')) continue; ?>
	
	<tr>
		<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>	
		<?php if ($field->name == 'brain_sites_type'): ?>
		<td><?php echo form_dropdown($field->name, $type_options,$bs_data->brain_sites_type,'id="brain_sites_type"');?> <a href="#" onclick="show_coding_rules('bsitetype'); return false;">Coding rules</a></td>
		<?php endif; ?>
		<?php if ($field->name == 'brain_sites_class'): ?>
		<td><?php echo form_dropdown($field->name, $classes_options,$bs_data->brain_sites_class);?></td>
		<?php endif; ?>	
		
	</tr>
	<?php endforeach; ?>
	</table>
	
	<input type="submit" class="submit" value="Update" />
	
	</form>
	
	<div id="help_div"></div>
	
	
	<script type="text/javascript">
	//<![CDATA[
	
	new Autocomplete('autocomplite_acron', { 
		serviceUrl:'index.php/acronyms/ajaxAtocomplit', 
		onSelect: function(value, data){
			sel_acron_num = data;
	
			acron_select();
			
		}
	 });


	new Autocomplete('autocomplite_auth_bsite', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_lit_num = data;
			literature_select_2();
			
		}
	 });
	
	sel_acron_num = <?=$acr_data->brain_site_acronyms_id?>;
	
	sel_lit_num = <?=$bmap_data->literature_id?>;

	$('autocomplite_auth_bsite').value = '<?=$bmap_data->literature_title?> <?=$bmap_data->literature_index?>'; 
	
	literature_select_2();
	
	 
	 
	$('frm').onsubmit = function () { return check_form(this)}
	
	//]]>
	</script>
	
	<?php endif;?>

<?php endif;?>



<?php $this->load->view('footer'); 
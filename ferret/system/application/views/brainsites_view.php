<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Brain sites input</h1>

	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>

	<h2><a href="index.php?c=brainsites&m=add">Add new Brain Sites </a> &nbsp; | &nbsp; <a href="index.php?c=brainsites&m=search">Search Brain Sites </a></h2> 
	<a href="index.php?c=brainsites&m=show">All brain maps list</a>

<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="index.php?c=brainsites">Back</a> <!-- Back button -->

	<h1>Add new Brain Site</h1>

	<?php if(isset($add_message)):?>
		<p><?=$add_message?></p>

	<?php endif;?>

	<!-- Form -->

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
			<br/> <a href="index.php?c=acronyms&m=show" target="_blank">Check Acronyms first</a>
			  
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
				<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>	
	
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

	<!-- Java scripts -->

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


<!-- Edit -->

<?php if($action == 'edit'):?>

	<p align="right"><a href="index.php?c=brainsites">Back</a> <!-- Back button -->

	<h1>Edit Brain Site</h1>

	<?php if(isset($block_message)):?>
		<p><?=$block_message?></p>
	<?php endif;?>

	<!-- Form --> 

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
					<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>	
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
	
		<!-- Form -->

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

<!-- Show -->

<?php if($action == 'show'):?>

	<p align="right"><a href="index.php?c=brainsites">Back</a> <!-- Back button -->

	<h1>All Brain Sites</h1>
	<p><a href="index.php?c=brainsites&m=add">Add new Brain Sites</a></p>

	<?php if(isset($block_data)):?>
		
		<table>
			<tr>
			<?php foreach($block_fields as $field): ?>

					<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
				
			<?php endforeach; ?>
			<td>Actions</td>
			</tr>
		
		<?php foreach($block_data->result() as $bdata): ?>
		<tr>

			<?php foreach($block_fields as $field): ?>
		
			<td><?=$bdata->$field;?></td>
			
			<?php endforeach;?>
			<td><a href="index.php?c=brainsites&m=edit&id=<?=$bdata->brain_sites_id?>">details</a> &nbsp; | &nbsp; <a href="index.php?c=brainsites&m=confirm&id=<?=$bdata->brain_sites_id?>">delete</a></td>
					
		</tr>
		<?php endforeach; ?>

			</table>
	<?php else:?>
		<p>Nothing was found.</p>
	<?php endif;?>


<?php endif;?>

<!-- Search -->

<?php if($action == 'search'):?>

	<p align="right"><a href="index.php?c=brainsites">Back</a> <!-- Back button -->

	<h1>Search Brain Sites</h1>

	<?php if(isset($search_message)):?>
		<p><?=$search_message?></p>
	<?php endif;?>

	<!-- Browser -->

	<form method="post" id="frm" name="frm" action="#">

	<table border="0" cellpadding="3" cellspacing="1">

	<tr id="auto_block">
		<td>Search Brain Sites</td>
		<td>
		<input title="Please, start to type an index of a brain site" type="text" id="autocomplite_2" class="input" />
		</td>
	</tr>

	</table>
	</form>
	<br/>
	<div id="search_result"></div>

	<!-- Java scripts -->

	<script type="text/javascript">
	//<![CDATA[
	new Autocomplete('autocomplite_2', { 
		serviceUrl:'index.php/brainsites/ajaxAtocomplitC',
		onSelect: function(value, data){
			sel_lit_num = data;
			search_do();
	
		} 

	 });
	 

	//]]>
	</script>

<?php endif;?>

<!-- Load the footer -->

<?php $this->load->view('footer'); 

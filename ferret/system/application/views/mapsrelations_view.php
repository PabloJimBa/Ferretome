<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Maps relations data input</h1>

	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>

	<h2><a href="index.php?c=mapsrelations&m=add">Add new Relations</a></h2>

<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Add new Maps Relations</h1>

	<?php if(isset($add_message)):?>
		<p><?=$add_message?></p>
	<?php endif;?>

	<!-- Form -->

	<a href="#" onclick="show_coding_rules('mrelations'); return false;">Coding rules for Maps Relations</a>
	<form method="post" id="frm" name="frm" action="index.php?c=mapsrelations&m=insert">

	<table border="0" cellpadding="3" cellspacing="1">

	<tr>
		<td colspan="2"><strong>First you need to specify source of this relation</strong></td>
	
	</tr>

	<tr id="auto_block">
		<td>
		Search for publication
		<br/> for this Brain Map Relation
		<br/> as a source of relation
		</td>
		<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth" class="input"/></td>
	
	</tr>

	<tr id="lit_block" style="display:none;">
		<td>Selected Literature <br/> for  Brain Map:</td>
		<td id="literature"></td>
	
	</tr>

	<tr>
		<td colspan="2"><strong>Second you need to find literature where bmap of FIRST bsite defined</strong></td>
	
	</tr>

	<tr id="auto_block_a">
		<td>Search for publication<br/> to find brain map <br/> for brain site A </td>
		<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth_a" class="input"/></td>
	
	</tr>

	<tr id="lit_block_a" style="display:none;">
		<td>Selected Literature <br/> for  First Brain Map:</td>
		<td id="literature_a"></td>
	
	</tr>

	<tr id="bsite_auto_block_a" style="display:none;">
		<td>Search for First <br/> (A) Brain Site<br/> for this Relation </td>
		<td><input title="Please, start to type ID of Brain Map" type="text" id="autocomplite_bsite_a" class="input" /></td>
	
	</tr>

	<tr style="display:none;" id="bsite_block_a">
		<td>Selected Brain Site (A) <br/> for new maps rel</td>
		<td id="sel_bsite_a"></td>
	
	</tr>

	<tr>
		<td>Maps relations code</td>	
		<td><?php echo form_dropdown('maps_relations_code', $rel_options,1,'id="maps_relations_code"');?> <a href="#" onclick="show_coding_rules('rc'); return false;"> Please see coding rules</a></td>	
	
	
	</tr>

	<tr>
		<td colspan="2"><strong>Third you need to find literature where bmap of SECOND bsite defined</strong></td>
	
	</tr>

	<tr id="auto_block_b">
		<td>Search for publication<br/> to find brain map <br/> for brain site B  </td>
		<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth_b" class="input"/></td>
	
	</tr>

	<tr id="lit_block_b" style="display:none;">
		<td>Selected Literature <br/> for  Second Brain Map:</td>
		<td id="literature_b"></td>
	
	</tr>

	<tr id="bsite_auto_block_b" style="display:none;">
		<td>Search for Second <br/> (B) Brain Site<br/> for this Relation </td>
		<td><input title="Please, start to type ID of Brain Map" type="text" id="autocomplite_bsite_b" class="input" /></td>
	
	</tr>

	<tr style="display:none;" id="bsite_block_b">
	<td>Selected Brain Site (B) <br/> for new maps rel</td>
		<td id="sel_bsite_b"></td>
	
	</tr>
	
	<tr>	
	
		<td>PDC relation</td>
		<td><?php echo form_dropdown('PDC_RELATION', $pdc_options,1,'id="PDC_RELATION"');?><a href="#" onclick="show_coding_rules('pdc_relation'); return false;"> Please see coding rules</a></td>	
	
	
	</tr>


	<?php foreach($fields as $field): ?>


		<?php if (($field->primary_key == 1) OR ($field->name == 'literature_id') OR ($field->name == 'brain_sites_id_a') OR ($field->name == 'brain_sites_id_b') OR ($field->name == 'maps_relations_id') OR ($field->name == 'maps_relations_code') OR ($field->name == 'PDC_RELATION')) continue; ?>

		<tr>
		<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>	
		<?php if ($field->type == 'blob'): ?>
			<td><textarea class="textarea" id="<?php echo $field->name; ?>" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
		<?php else : ?>
			<td><input class="input" id="<?php echo $field->name; ?>" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="30" /></td>
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
	new Autocomplete('autocomplite_auth', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_lit_num = data;
			literature_select();
		
		}
	 });

	new Autocomplete('autocomplite_auth_a', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_lit_num_a = data;
			literature_select_a();
		
		}
	 });
	new Autocomplete('autocomplite_auth_b', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_lit_num_b = data;
			literature_select_b();
		
		}
	 });

	new Autocomplete('autocomplite_bsite_a', { 
		serviceUrl:'index.php/brainsites/ajaxAtocomplitA', 
		onSelect: function(value, data){
			sel_bsite_num_a = data;

			bsite_select_a();
		
		}
	 });

	new Autocomplete('autocomplite_bsite_b', { 
		serviceUrl:'index.php/brainsites/ajaxAtocomplitB', 
		onSelect: function(value, data){
			sel_bsite_num_b = data;

			bsite_select_b();
		
		}
	 });
	 

	<?php if(isset($lit_data)):?>
	sel_lit_num = <?=$lit_data->literature_id?>;
	$('autocomplite_auth').value = '<?=$lit_data->literature_title?> <?=$lit_data->literature_index?>';
	literature_select();
	<?php endif;?>

	$('frm').onsubmit = function () { return check_form(this)}

	//]]>
	</script>

<?php endif;?>


<!-- Edit -->

<?php if($action == 'edit'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Edit Maps Relations</h1>

	<?php if(isset($block_message)):?>
		<p><?=$block_message?></p>
	<?php endif;?>

	<!-- Form -->

	<?php if(isset($mr_data)):?>

		<a href="#" onclick="show_coding_rules('mrelations'); return false;">Coding rules for Maps Relations</a>

		<form method="post" id="frm" name="frm" action="index.php?c=mapsrelations&m=update&mrid=<?=$mr_data->maps_relations_id?>">

		<table border="0" cellpadding="3" cellspacing="1">

		<tr>
			<td colspan="2"><strong>First you need to specify source of this relation</strong></td>
	
		</tr>


		<tr id="auto_block" style="display:none;">
			<td>Search for publication<br/> for this Brain Map Relation </td>
			<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth" class="input"/></td>
	
		</tr>

		<tr id="lit_block">
			<td>Selected Literature <br/> for new Brain Map:</td>
			<td id="literature"><span id="<?=$mr_data->literature_id?>"><input type="hidden" name="literature_id" value="<?=$mr_data->literature_id?>"><?=$mr_data->ltitle?> - <?=$mr_data->lindex?> <a href="#" onclick="lit_replace('<?=$mr_data->literature_id?>'); return false;"> Replace</a><br/></span></td>
	
		</tr>

		<tr>
			<td colspan="2"><strong>Second you need to find literature where bmap of FIRST bsite defined</strong></td>
	
		</tr>

		<tr id="auto_block_a" style="display:none;">
			<td>Search for publication<br/> for this Brain Map Relation </td>
			<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth_a" class="input"/></td>
	
		</tr>

		<tr id="lit_block_a">
			<td>Selected Literature <br/> for  First Brain Map:</td>
			<td id="literature_a">
				<span id="lit_a_<?=$mr_data_a->literature_id_a?>"><?=$mr_data_a->ltitle_a?> - <?=$mr_data_a->lindex_a?> <a href="#" onclick="lit_replace_a('<?=$mr_data_a->literature_id_a?>'); return false;"> Replace</a><br/></span>
			</td>
	
		</tr>




		<tr id="bsite_auto_block_a" style="display:none;">
			<td>Search for First <br/> (A) Brain Site<br/> for this Relation </td>
			<td><input title="Please, start to type ID of Brain Map" type="text" id="autocomplite_bsite_a" class="input" /></td>
	
		</tr>

		<tr  id="bsite_block_a">
			<td>Selected Brain Site (A) <br/> for new maps rel</td>
			<td id="sel_bsite_a">
				<span id="b_site_a_<?=$mr_data->brain_sites_id_a?>"><input type="hidden"  name="brain_sites_id_a" value="<?=$mr_data->brain_sites_id_a?>"> 
				<?=$mr_data->bsinda?>
				<a href="#" onclick="bsite_replace_a('<?=$mr_data->brain_sites_id_a?>'); return false;"> Replace</a><br/></span>
			</td>
	
		</tr>

		<tr>
			<td>Maps relations code</td>	
			<td><?php echo form_dropdown('maps_relations_code', $rel_options,$mr_data->maps_relations_code);?> <a href="#" onclick="show_coding_rules('rc'); return false;"> Please see coding rules</a></td>	
		</tr>



		<tr>
			<td colspan="2"><strong>Third you need to find literature where bmap of SECOND bsite defined</strong></td>
		</tr>

		<tr id="auto_block_b" style="display:none;">
			<td>Search for publication<br/> for this Brain Map Relation </td>
			<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth_b" class="input"/></td>
		</tr>

		<tr id="lit_block_b" >
			<td>Selected Literature <br/> for  Second Brain Map:</td>
			<td id="literature_b">
				<span id="lit_b_<?=$mr_data_b->literature_id_b?>"><?=$mr_data_b->ltitle_b?> - <?=$mr_data_b->lindex_b?> <a href="#" onclick="lit_replace_b('<?=$mr_data_b->literature_id_b?>'); return false;"> Replace</a><br/></span>
			</td>
		</tr>


		<tr style="display:none;" id="bsite_auto_block_b" >
			<td>Search for Second <br/> (B) Brain Site<br/> for this Relation </td>
			<td><input title="Please, start to type ID of Brain Map" type="text" id="autocomplite_bsite_b" class="input" /></td>
		</tr>

		<tr  id="bsite_block_b">
			<td>Selected Brain Site (B) <br/> for new maps rel</td>
			<td id="sel_bsite_b">
			<span id="b_site_b_<?=$mr_data->brain_sites_id_b?>"><input type="hidden" name="brain_sites_id_b" value="<?=$mr_data->brain_sites_id_b?>"> 
			<?=$mr_data->bsindb?>
			<a href="#" onclick="bsite_replace_b('<?=$mr_data->brain_sites_id_b?>'); return false;"> Replace</a><br/></span>
	
			</td>
		</tr>



	
		<tr>	
	
			<td>PDC_relation</td>
			<td><?php echo form_dropdown('PDC_RELATION', $pdc_options,$mr_data->PDC_RELATION)?><a href="#" onclick="show_coding_rules('pdc_relation'); return false;"> Please see coding rules</a></td>	
	
		</tr>


		<?php foreach($fields as $field): ?>


			<?php if (($field->primary_key == 1) OR ($field->name == 'literature_id') OR ($field->name == 'brain_sites_id_a') OR ($field->name == 'brain_sites_id_b') OR ($field->name == 'maps_relations_id') OR ($field->name == 'maps_relations_code') OR ($field->name == 'PDC_RELATION')) continue; ?>

			<tr>
			<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>	
			<?php if ($field->type == 'blob'): ?>
				<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($mr_data->$f); ?></textarea></td>
			<?php else : ?>
				<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($mr_data->$f); ?>" size="30" /></td>
			<?php endif; ?>
	
			</tr>
		<?php endforeach; ?>
		</table>

		<input type="submit" class="submit" value="Update" />

		</form>

		<br/>
		<div id="help_div"></div>

		<!-- Java scripts -->

		<script type="text/javascript">
		//<![CDATA[
		new Autocomplete('autocomplite_auth', { 
			serviceUrl:'index.php/literature/ajaxAtocomplit/', 
			onSelect: function(value, data){
				sel_lit_num = data;
				literature_select();
		
			}
		 });


		new Autocomplete('autocomplite_auth_a', { 
			serviceUrl:'index.php/literature/ajaxAtocomplit/', 
			onSelect: function(value, data){
				sel_lit_num_a = data;
				literature_select_a();
		
			}
		 });
		new Autocomplete('autocomplite_auth_b', { 
			serviceUrl:'index.php/literature/ajaxAtocomplit/', 
			onSelect: function(value, data){
				sel_lit_num_b = data;
				literature_select_b();
		
			}
		 });

		new Autocomplete('autocomplite_bsite_a', { 
			serviceUrl:'index.php/brainsites/ajaxAtocomplit', 
			onSelect: function(value, data){
				sel_bsite_num_a = data;

				bsite_select_a();
		
			}
		 });

		new Autocomplete('autocomplite_bsite_b', { 
			serviceUrl:'index.php/brainsites/ajaxAtocomplit', 
			onSelect: function(value, data){
				sel_bsite_num_b = data;

				bsite_select_b();
		
			}
		 });
		sel_lit_num = <?=$mr_data->literature_id?>;
		sel_bsite_num_a = <?=$mr_data->brain_sites_id_a?>;
		sel_bsite_num_b = <?=$mr_data->brain_sites_id_b?>;

		sel_lit_num_a = <?=$mr_data_b->literature_id_a?>;
		sel_lit_num_b = <?=$mr_data_b->literature_id_b?>;

		set_pub_id();
		 
		 

		$('frm').onsubmit = function () { return check_form(this)}

		//]]>
		</script>

	<?php endif;?>

<?php endif;?>


<!-- Load the footer -->

<?php $this->load->view('footer'); 

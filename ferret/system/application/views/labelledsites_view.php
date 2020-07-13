<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Experiment input</h1>

	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>


	<h2><a href="index.php?c=labelledsites&m=add">Add new Labelled Site</a></h2>


<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<h1>Add New Labelled Site</h1>

	<?php if(isset($add_message)):?>
		<p><?=$add_message?></p>
	<?php endif;?>

	<!-- Form -->

	<a href="#" onclick="show_coding_rules('lsites'); return false;">Coding rules for Labelled Sites</a>
	<form method="post" id="frm" name="frm" action="index.php?c=labelledsites&m=insert">

	<table border="0" cellpadding="3" cellspacing="1">

	<tr><td colspan="3"><b>First, you need to find Literature where this injection was described</b></td></tr>


	<tr id="auto_block">
		<td>Search for publication<br/> to find Injections </td>
		<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth" class="input"/>
		<br/>Start type title of a literature, after that type name of the brain site acronym in field below 
		</td>
	</tr>

	<tr id="lit_block" style="display:none;">
		<td>Selected Literature</td>
		<td id="literature"></td>
	</tr>





	<tr>

		<td>
			Selected labelling outcome
			<br/> Cannot find it?
			<br/><a target="_blank" href="index.php?c=labelingoutcome&m=add">Add Labeling Outcome</a> 
		</td>
		<td id="injection_block">
		<?php if(isset($inj_options)):?>
			<?php echo form_dropdown('outcome_id', $inj_options);?>
		<?php endif;?> 
		</td>

	</tr>


	<tr><td colspan="3"><b>Second, you need to find Literature where a brain map of necessary b site was discribed.</b><br/>Please remember that publication can use different bmap!</td></tr>


	<?php if(!isset($lit_data_2)):?>


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

	<?php endif;?>

	<?php if(isset($lit_data_2)):?>


	<tr id="auto_block_2" style="display:none;">
		<td>Search for publication<br/> to find Brain map </td>
		<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth_bsite" class="input"/>
		<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
		</td>
	</tr>

	<tr id="lit_block_2" >
		<td>Selected Literature <br/> for Brain sites</td>
		<td id="literature_2">
			<span id="<?=$lit_data_2->literature_id?>_2">
			<?=$lit_data_2->literature_title?> - <?=$lit_data_2->literature_index?> 
			<a href="#" onclick="lit_replace_2('<?=$lit_data_2->literature_id?>'); return false;"> Replace</a>
			</span>
		</td>
	</tr>



	<?php endif;?>




	<tr id="bsite_auto_block" >
		<td>Search for Brain Site </td>
		<td><input title="Please, start to type name of acronym" type="text" id="autocomplite_bsite" class="input" <?php if(!isset($lit_data_2)):?>disabled<?php endif;?> /> <br/> Please, start to type name of acronym</td>
	</tr>

	<tr style="display:none;" id="bsite_block">
		<td>Selected  Brain Site</td>
		<td id="sel_bsite"></td>
	</tr>

	<tr>	
	
		<td>PDC_EC</td>
		<td><?php echo form_dropdown('PDC_EC', $pdc_options);?> <a href="#" onclick="show_coding_rules('pdc_ec'); return false;"> Coding rules</a></td>	
	
	</tr>

	<tr>	
	
		<td>Extension codes</td>
		<td><?php echo form_dropdown('EC', $ec_options,3);?> <a href="#" onclick="show_coding_rules('ec'); return false;">Coding Rules</a></td>	
	
	</tr>

	<tr>	
	
		<td>Density of labelled sites</td>
		<td><?php echo form_dropdown('labelled_sites_density', $dens_options);?> </td>	
	
	</tr>


	<tr>	
	
		<td>Density PDC</td>
		<td><?php echo form_dropdown('PDC_DENSITY', $pdc_density);?> <a href="#" onclick="show_coding_rules('pdc_density'); return false;"> Coding rules</a></td>	
	
	</tr>





	<?php foreach($fields as $field): ?>



	<?php if (($field->primary_key == 1)  OR ($field->name == 'PDC_LAMINAE') OR ($field->name == 'labelled_sites_laminae') OR ($field->name == 'labelled_sites_density') OR ($field->name == 'PDC_DENSITY') OR ($field->name == 'PDC_SITE') OR ($field->name == 'labelled_sites_type') OR ($field->name == 'PDC_EC') OR ($field->name == 'EC') OR ($field->name == 'outcome_id') OR ($field->name == 'brain_sites_id')) continue; ?>

	<tr>
		<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
		<?php if ($field->type == 'blob'): ?>
		<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
		<?php else : ?>
		<td><input class="input" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="30" /></td>
		<?php endif; ?>
	
	</tr>
	<?php endforeach; ?>


	<tr><td colspan="3"><b>Third, you need to input Laminae data ! if exists !</td></tr>

	<tr>	
		<td>Injection Laminae<br/><a href="#" onclick="show_coding_rules('laminae'); return false;"> Coding rules</a></td>
		<td><?php echo form_dropdown('injections_laminae', $injections_laminae); ?></td>
	</tr>
	
		<td>PDC_laminae</td>
		<td><?php echo form_dropdown('PDC_LAMINAE', $pdc_options);?> <a href="#" onclick="show_coding_rules('pdc_laminae'); return false;"> Coding rules</a></td>	
	
	</tr>




	</table>

	<input type="submit" class="submit" value="Insert" />

	</form>

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

	new Autocomplete('autocomplite_auth_bsite', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_lit_num_2 = data;
			literature_select_2();
		
		}
	 });

	new Autocomplete('autocomplite_bsite', { 
		serviceUrl:'index.php/brainsites/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_bsite_num = data;
			bsite_select();
		
		}
	 });



	<?php if(isset($lit_data_2)):?>

	sel_lit_num_2 = <?=$lit_data_2->literature_id?>;

	<?php endif;?>


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

	<p align="right"><a href="index.php?c=labelledsites">Back</a> <!-- Back button -->

	<h2>Edit Labelled Site</h2>

	<?php if(isset($block_message)):?>
		<p><?=$block_message?></p>
	<?php endif;?>


	<?php if(isset($ls_data)):?>


		<a href="#" onclick="show_coding_rules('lsites'); return false;">Coding rules for Labelled Sites</a>
		<form method="post" id="frm" name="frm" action="index.php?c=labelledsites&m=update&id=<?=$ls_data->labelled_sites_id?>">

		<table border="0" cellpadding="3" cellspacing="1">

		<tr><td colspan="3"><b>First, you need to find Literature where this injection was described</b></td></tr>


	<?php if(isset($lit_data)):?>


		<tr id="auto_block" style="display:none;">
			<td>Search for publication<br/> to find Injections </td>
			<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth" class="input"/>
			<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
			</td>
	
		</tr>

		<tr id="lit_block" >
			<td>Selected Literature <br/> for outcomes:</td>
			<td id="literature">
			<span id="<?=$lit_data->literature_id?>"><?=$lit_data->literature_title?> - <?=$lit_data->literature_index?> <a href="#" onclick="lit_replace('<?=$lit_data->literature_id?>'); return false;"> Replace</a></span>
	
			</td>
	
		</tr>



	<?php endif;?>

	<tr>

		<td>
			Selected outcome
			<br/> Can't Find?
			<br/><a target="_blank" href="index.php?c=labelingoutcome&m=add">Add Labelling Outcome</a> 
		</td>
		<td id="injection_block">
		<?php if(isset($inj_options)):?>
			<?php echo form_dropdown('outcome_id', $inj_options,$ls_data->outcome_id);?>
		<?php endif;?> 
		</td>
	


	</tr>

	<tr><td colspan="3"><b>Second, you need to find Literature where a brain map of necessary b site was discribed.</b><br/>Please remember that publication can use different bmap!</td></tr>


	<?php if(isset($lit_data_2)):?>


		<tr id="auto_block_2" style="display:none;">
			<td>Search for publication<br/> to find Brain map </td>
			<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth_bsite" class="input"/>
			<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
			</td>
	
		</tr>

		<tr id="lit_block_2" >
			<td>Selected Literature <br/> for Brain sites</td>
			<td id="literature_2">
				<span id="<?=$lit_data_2->literature_id?>_2">
				<?=$lit_data_2->literature_title?> - <?=$lit_data_2->literature_index?> 
				<a href="#" onclick="lit_replace_2('<?=$lit_data_2->literature_id?>'); return false;"> Replace</a>
				</span>
			</td>
	
		</tr>



	<?php endif;?>




	<tr id="bsite_auto_block" style="display:none;">
		<td>Search for Brain Site </td>
		<td><input title="Please, start to type name of acronym" type="text" id="autocomplite_bsite" class="input" <?php if(!isset($lit_data_2)):?>disabled<?php endif;?> /> <br/> Please, start to type name of acronym</td>
	
	</tr>

	<tr  id="bsite_block">
		<td>Selected  Brain Site</td>
		<td id="sel_bsite">
			<span id="<?=$bsite_data->brain_sites_id?>"><?=$bsite_data->brain_sites_index?> <?=$bsite_data->acronym_full_name?>
			<input type="hidden" name="brain_sites_id" value="<?=$bsite_data->brain_sites_id?>">
			<a href="#" onclick="bsite_replace('<?=$bsite_data->brain_sites_id?>'); return false;"> Replace</a><br/></span>
		</td>
	
	</tr>

	<tr>	
	
		<td>PDC_EC</td>
		<td><?php echo form_dropdown('PDC_EC', $pdc_options,$ls_data->PDC_EC);?> <a href="#" onclick="show_coding_rules('pdc_ec'); return false;"> Coding rules</a></td>	
	
	</tr>

	<tr>	
	
		<td>Extension codes</td>
		<td><?php echo form_dropdown('EC', $ec_options,$ls_data->EC);?> <a href="#" onclick="show_coding_rules('ec'); return false;">Coding Rules</a></td>	
	
	</tr>

	<tr>	
	
		<td>Density of labelled sites</td>
		<td><?php echo form_dropdown('labelled_sites_density', $dens_options,$ls_data->labelled_sites_density);?> </td>	
	
	</tr>


	<tr>	
	
		<td>Density PDC</td>
		<td><?php echo form_dropdown('PDC_DENSITY', $pdc_options,$ls_data->PDC_DENSITY);?> <a href="#" onclick="show_coding_rules('pdc_density'); return false;"> Coding rules</a></td>	
	
	</tr>





	<?php foreach($fields as $field): ?>



		<?php if (($field->primary_key == 1)  OR ($field->name == 'outcome_id') OR ($field->name == 'PDC_LAMINAE') OR ($field->name == 'labelled_sites_laminae') OR  ($field->name == 'labelled_sites_density') OR ($field->name == 'PDC_DENSITY') OR ($field->name == 'PDC_SITE') OR ($field->name == 'labelled_sites_type') OR ($field->name == 'PDC_EC') OR ($field->name == 'EC') OR ($field->name == 'injections_id') OR ($field->name == 'brain_sites_id')) continue; ?>

		<tr>
			<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
			<?php if ($field->type == 'blob'): ?>
				<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($ls_data->$f); ?></textarea></td>
			<?php else : ?>
				<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($ls_data->$f); ?>" size="30" /></td>
			<?php endif; ?>
	
		</tr>
	<?php endforeach; ?>

	<tr><td colspan="3"><strong> you need to input Laminae data ! if exists !</strong></td></tr>

	<tr>	
	
		<td>Labelled site laminae<br/><a href="#" onclick="show_coding_rules('laminae'); return false;"> Coding rules</a></td>

	<td><input class="input" name="labelled_sites_laminae" value="<?php echo form_prep($ls_data->labelled_sites_laminae); ?>" size="30" /> </td>
	</tr>

	<tr>	
	
		<td>PDC_laminae</td>
		<td><?php echo form_dropdown('PDC_LAMINAE', $pdc_options,$ls_data->PDC_LAMINAE);?> <a href="#" onclick="show_coding_rules('pdc_laminae'); return false;"> Coding rules</a></td>	
	
	</tr>

	</table>

	<input type="submit" class="submit" value="update" />

	</form>

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

	new Autocomplete('autocomplite_auth_bsite', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_lit_num_2 = data;
			literature_select_2();
		
		}
	 });

	new Autocomplete('autocomplite_bsite', { 
		serviceUrl:'index.php/brainsites/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_bsite_num = data;
			bsite_select();
		
		}
	 });



	sel_lit_num = <?=$lit_data->literature_id?>;


	sel_lit_num_2 = <?=$lit_data_2->literature_id?>;

	sel_bsite_num = <?=$ls_data->brain_sites_id?>;
	 
	 

	$('frm').onsubmit = function () { return check_form(this)}

	//]]>
	</script>

		<?php endif;?>

<?php endif;?>


<!-- Load the footer -->

<?php $this->load->view('footer'); 


<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

	<!-- Load the header -->

	<?php  $this->load->view('header');  ?>

	
	<!-- Index -->

	<?php if($action == 'index'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>Brain Maps input</h1>

		<?php if(isset($index_message)):?>
			<p><?=$index_message?></p>
		<?php endif;?>


		<h2><a href="index.php?c=brainmaps&m=add">Add new Brain Maps </a> &nbsp; | &nbsp; <a href="index.php?c=brainmaps&m=search">Search Brain Map </a></h2> <!-- Options -->
		<a href="index.php?c=brainmaps&m=show">All brain maps list</a>

	<?php endif;?>


	<!-- Add -->

	<?php if($action == 'add'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>Add new Brain Map</h1>

		<?php if(isset($add_message)):?>
			<p><?=$add_message?></p>
		<?php endif;?>


		<a href="#" onclick="show_coding_rules('bmaps'); return false;">Show coding rules</a> <!-- Coding rules -->

		<!-- Form -->
		
		<form method="post" id="frm" name="frm" action="index.php?c=brainmaps&m=insert">

		<table border="0" cellpadding="3" cellspacing="1">

		<tr id="auto_block">
			<td>Search for publication<br/> for this Brain Map </td>
			<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth" class="input"/></td>
		</tr>

		<tr style="display:none;" id="lit_block">
			<td>Selected Literature <br/> for new Brain Map:</td>
			<td id="literature"></td>
	
		</tr>


		<tr>
			<td>
			Brain map type:
			</td>
			<td>
			<input type="checkbox" name="delin" value="" />Delineated<br/>
			<input type="checkbox" name="adop" value=""/>Adopted
			</td>
		</tr>




		<?php foreach($fields as $field): ?>

		<?php if (($field->primary_key == 1) OR ($field->name == 'literature_id') OR ($field->name == 'brain_maps_index') OR ($field->name == 'brain_maps_type') ) continue; ?>

		<tr>
			<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
			<?php if ($field->type == 'blob'): ?>
			<td><textarea class="textarea" id="<?php echo $field->name; ?>" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
			<?php else : ?>
			<td><input class="input"  id="<?php echo $field->name; ?>" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="30" /></td>
			<?php endif; ?>
	
		</tr>
		<?php endforeach; ?>



		</table>


		<input type="submit" class="submit" value="Insert" />

		</form>
		<br/>

		<div id="help_div"></div>

		<!-- Java scrips -->

		<script type="text/javascript">
		//<![CDATA[
		new Autocomplete('autocomplite_auth', { 
			serviceUrl:'index.php/literature/ajaxAtocomplit', 
			onSelect: function(value, data){
				sel_lit_num = data;
				literature_select();
		
			}
		 });


		<?php if(isset($literature_data)):?>
		sel_lit_num = <?=$literature_data->literature_id?>;
		$('autocomplite_auth').value = '<?=$literature_data->literature_title?> - <?=$literature_data->literature_index?>';
		literature_select();
		<?php endif;?>


		$('frm').onsubmit = function () { return check_form(this)}

		//]]>
		</script>

	<?php endif;?>

	
	<!-- Edit -->

	<?php if($action == 'edit'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<div id="edit_bmap_block">

		<h1>Edit Brain Map</h1>

		<?php if(isset($block_message)):?>
			<p><?=$block_message?></p>
		<?php endif;?>

		<!-- Form -->

		<?php if(isset($map_data)):?>
	
			<a href="#" onclick="show_coding_rules('bmaps'); return false;">Show coding rules</a>
			<form method="post" id="frm" name="frm" action="index.php?c=brainmaps&m=update&id=<?=$map_data->brain_maps_id?>">
		
			<table border="0" cellpadding="3" cellspacing="1">
		
			<tr style="display:none;" id="auto_block">
				<td>Search for publication<br/> for this Brain Map </td>
				<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth" class="input"/></td>
			</tr>
		
			<tr  id="lit_block">
				<td>Selected Literature <br/> for Brain Map:</td>
				<td id="literature"><span id="<?=$lit_data->literature_id?>"><input type="hidden" id="literature_id" name="literature_id" value="<?=$lit_data->literature_id?>"><?=$lit_data->literature_title?> <?=$lit_data->literature_year?><a href="#" onclick="lit_replace('<?=$lit_data->literature_id?>'); return false;"> Replace</a></span><br/></td>
			
			</tr>
		
		
		
			<tr >
				<td>Brain map type:</td>
				<td>
			
				<?php if ($map_data->brain_maps_type[0] =='t'):?>
					<input type="checkbox" name="delin" value="" checked="checked"/>Delineated<br/>
				<?php else: ?>
					<input type="checkbox" name="delin" value=""/>Delineated<br/>
				<?php endif; ?>
			
			
				<?php if ($map_data->brain_maps_type[1] =='t'):?>
					<input type="checkbox" name="adop" value="" checked="checked"/>Adopted
				<?php else: ?>
					<input type="checkbox" name="adop" value=""/>Adopted
				<?php endif; ?>
			
				</td>
			
			</tr>
		
		
			<?php foreach($fields as $field): ?>
		
				<?php if (($field->primary_key == 1) OR ($field->name == 'literature_id') OR ($field->name == 'brain_maps_type')) continue; ?>
		
				<tr>
					<td>
					<?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?>
					</td>
			
					<?php if ($field->type == 'blob'): ?>
					<td><textarea id="<?php echo $field->name; ?>" class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($map_data->$f); ?></textarea></td>
					<?php else : ?>
					<td><input class="input"  id="<?php echo $field->name; ?>" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($map_data->$f); ?>" size="30" /></td>
					<?php endif; ?>
			
			
				</tr>
			<?php endforeach; ?>
			
			</table>
		
			<input type="submit" class="submit" value="Update" />
		
			</form>
			<div id="help_div"></div>
		
			</div>
		
			<?php if(isset($bsites_number)):?>
				<p>
				This Brain map has <?=$bsites_number?> brain sites 
				<span id="a_show_all"> <a href="#" onclick="show_brain_sites_block('<?=$map_data->brain_maps_id?>'); return false;">Show all</a></span> &nbsp;
				<span> <a href="index.php?c=brainsites&m=add&id=<?=$map_data->literature_id?>" target="_blank">Add new Brain site to this Map</a></span>
				<span id="a_hide_all_refresh" style="display:none;"> <a href="#" onclick="hide_brain_sites_block()">Hide</a> &nbsp; <a href="#" onclick="show_brain_sites_block('<?=$map_data->brain_maps_id?>')">Refresh</a> </span>
		
				</p>
			<?php endif;?>
		
			<?php if(!isset($bsites_number)):?>
				<p>This brain map has no brain sites</p>
				<span> <a href="index.php?c=brainsites&m=add&id=<?=$map_data->literature_id?>" target="_blank">Add new Brain site to this Map</a></span>
			<?php endif;?>
		
			<div id="brain_sites_block"></div>
		
			<!-- Java scripts -->

			<script type="text/javascript">
			//<![CDATA[
			new Autocomplete('autocomplite_auth', { 
				serviceUrl:'index.php/literature/ajaxAtocomplit', 
				onSelect: function(value, data){
					sel_lit_num = data;
				
				}
			 });
		
			sel_lit_num = <?=$lit_data->literature_id?>; 
		
			$('frm').onsubmit = function () { return check_form(this)}
		
			//]]>
			</script>
	
		<?php endif;?>

	<?php endif;?>


	<!-- Search -->

	<?php if($action == 'search'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>Search Brain Maps</h1>

		<?php if(isset($search_message)):?>
			<p><?=$search_message?></p>
		<?php endif;?>

		<!-- Browser -->

		<form method="post" id="frm" name="frm" action="#">

		<table border="0" cellpadding="3" cellspacing="1">

		<tr id="auto_block">
			<td>Search Brain Maps</td>
			<td>
			<input title="Please, start to type an index of a brain map" type="text" id="autocomplite_2" class="input" />
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
			serviceUrl:'index.php/brainmaps/ajaxAtocomplit',
			onSelect: function(value, data){
				sel_lit_num = data;
				search_do();
		
			} 
	
		 });
		 

		//]]>
		</script>

	<?php endif;?>


	<!-- Show -->

	<?php if($action == 'show'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>All Brain Maps</h1>
		<p><a href="index.php?c=brainmaps&m=add">Add new Brain Map</a></p>

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
				<td><a href="index.php?c=brainmaps&m=edit&id=<?=$bdata->brain_maps_id?>">edit</a> &nbsp; | &nbsp; <a href="index.php?c=brainmaps&m=confirm&id=<?=$bdata->brain_maps_id?>">delete</a></td>
						
			</tr>
			<?php endforeach; ?>
	
				</table>
		<?php else:?>
			<p>Nothing was found.</p>
		<?php endif;?>


	<?php endif;?>


<!-- Load the footer -->

<?php $this->load->view('footer');

<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Outcome input</h1>

	<?php if(isset($index_message)):?>
	<p><?=$index_message?></p>
	<?php endif;?>

	<h2><a href="index.php?c=labelingoutcome&m=add">Add new Labeling Outcome</a></h2>


<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="index.php?c=labelingoutcome">Back</a> <!-- Back button -->

	<h1>Add New Labelling Outcome</h1>

	<?php if(isset($add_message)):?>
		<p><?=$add_message?></p>
	<?php endif;?>



	<table border="0" cellpadding="3" cellspacing="1">

	<tr id="auto_block">
		<td>
			<input title="Please, start to type title of publication" type="text" id="autocomplite_lit" class="input"/>
			<input title="Please, start to type a surname/name of an author" type="text" id="autocomplite_auth" class="input" style="display:none"/>
			<br/>Search publication using:<span id="search_type_1"> <strong>Title</strong></span><span id="search_type_2" style="display:none"> <strong>Authors</strong></span> - 
			<a href="#" id="search_link_2"  onclick="switch_search(2); return false;">Switch to Authors</a> 	<!-- Change the browser method -->
			<a href="#" id="search_link_1" onclick="switch_search(1); return false;" style="display:none">Switch to Title</a>
	
	</tr>

	<div id="search_result"></div>

	<tr style="display:none;" id="lit_block">
		<td>Selected Literature</td>
		<td id="literature"></td>
		
	</tr>


	<tr style="display:none;" id="data_row">	
	
		<td><a href="#" onclick="add_outcome(); return false;">Add new outcome</a></td>
		<td id="data_column"></td>
	
	</tr>


	</table>

	<br/>
	<div id="help_div"></div>


	<!-- Java scripts -->

	<script type="text/javascript">
	//<![CDATA[

	new Autocomplete('autocomplite_lit', { 
		serviceUrl:'index.php/literature/ajaxAtocomplit', 
		onSelect: function(value, data){
			sel_lit_num = data;
			literature_select();
		
		}
	 });

	new Autocomplete('autocomplite_auth', { 
		serviceUrl:'index.php/authors/ajaxAtocomplit',
		onSelect: function(value, data){
			sel_auth_num = data;
		
			search_do();

			$('autocomplite_auth').value = '';
		
		} 
	
	 });

	<?php if(isset($lit_block)):?>
	sel_lit_num = <?=$lit_block->literature_id?>;
	$('autocomplite_auth').value = '<?=$lit_block->literature_title?> - <?=$lit_block->literature_index?>';
	literature_select();
	<?php endif;?>
		   

	function show_table(table_display,table_state, row_state) {
		var tableID = document.getElementById(table_display);
		var tablestate = document.getElementById(table_state);
		var row = document.getElementById(row_state); 

		switch(tableID.style.display) {
			case "none":
			tableID.style.display = "inline-table";
			table_state.innerHTML = "Hide";
			row.innerHTML = ""; 
			break;
			default:
			tableID.style.display = "none";
			table_state.innerHTML = "Show";
			break;
		}
	}
	//]]>
	</script>

<?php endif;?>


<!-- Edit -->

<?php if($action == 'edit'):?>

	<div id="edit_outcome_block">
	
	<p align="right"><a href="index.php?c=labelingoutcome">Back</a> <!-- Back button -->

	<h2>Edit Labeling Outcome</h2>

	<?php if(isset($block_message)):?>
	<p><?=$block_message?></p>
	<?php endif;?>


		<?php if(isset($block_data)):?>
	
			<!-- Form -->
	
			<form method="post" id="frm" name="frm" action="index.php?c=labelingoutcome&m=update&id=<?=$block_data->outcome_id?>">
		
			<table border="0" cellpadding="3" cellspacing="1">
		
			<tr style="display:none;" id="auto_block">
				<td>Search for publication<br/> for this Brain Map </td>
				<td><input title="Please, start to type a surname of an author" type="text" id="autocomplite_auth" class="input"/></td>
				<td><a href="#" onclick="literature_select(); return false;" id="lit_select">Select</a></td>
			</tr>
		
			<tr  id="lit_block">
				<td>Selected Literature <br/> for new Brain Map:</td>
				<td id="literature"><span id="<?=$lit_data->literature_id?>"><input type="hidden" name="literature_id" value="<?=$lit_data->literature_id?>"><?=$lit_data->literature_title?> <?=$lit_data->literature_index?><a href="#" onclick="lit_replace('<?=$lit_data->literature_id?>'); return false;"> Replace</a></span><br/></td>
				
			</tr>
		
			<tr>	
	
				<td>Type of labelling outcome</td>
				<td><?php echo form_dropdown('outcome_type', $labelling_options,$block_data->outcome_type);?></td>	
		
			</tr>
		
			<tr>
	
				<td>Name of labelling outcome</td>
				<td><input class="input" name="outcome_name" value="<?php echo form_prep($block_data->outcome_name); ?>" size="30" /> </td>
		
			</table>
		
			<input type="submit" class="submit" value="Update" />
		
			</form>
			</div>
		
			<?php if(isset($bsites_number)):?>
			<p>
			This Brain map has <?=$bsites_number?> brain sites 
			<span id="a_show_all"> <a href="#" onclick="show_brain_sites_block('<?=$map_data->brain_maps_id?>')">Show all</a></span>
			<span id="a_hide_all_refresh" style="display:none;"> <a href="#" onclick="hide_brain_sites_block()">Hide</a> &nbsp; <a href="#" onclick="show_brain_sites_block('<?=$map_data->brain_maps_id?>')">Refresh</a> </span>
		
			</p>
			<?php endif;?>
		
			<div id="brain_sites_block"></div>
		
		
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


<!-- Load the footer -->

<?php $this->load->view('footer'); 

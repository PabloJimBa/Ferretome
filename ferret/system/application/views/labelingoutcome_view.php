<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<h2>Experement input</h2>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>


<p><a href="index.php?c=injections&m=add">Add new Injection </a></p>
<p><a href="index.php?c=labelingoutcome&m=add">Add new Labeling Outcome</a></p>


<?php endif;?>


<?php if($action == 'add'):?>


<h2>Add New or Edit Labeling Outcome</h2>

<?php if(isset($add_message)):?>
<p><?=$add_message?></p>
<?php endif;?>


<a href="#" onclick="show_coding_rules('labelingoutcome'); return false;">Coding rules for Labeling Outcome</a>


<table border="0" cellpadding="3" cellspacing="1">

<tr id="auto_block">
	<td>Search for publication<br/> to find Labeling outcomes </td>
	<td><input title="Please, start to type title of publication" type="text" id="autocomplite_auth" class="input"/></td>
	
</tr>

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




<script type="text/javascript">
//<![CDATA[

new Autocomplete('autocomplite_auth', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_lit_num = data;
		literature_select();
		
	}
 });



<?php if(isset($lit_block)):?>
sel_lit_num = <?=$lit_block->literature_id?>;
$('autocomplite_auth').value = '<?=$lit_block->literature_title?> - <?=$lit_block->literature_index?>';
literature_select();
<?php endif;?>
           


//]]>
</script>




<?php endif;?>




<?php if($action == 'edit'):?>
<div id="edit_outcome_block">
<a href="javascript:history.go(-1)" >Back</a>

<h2>Edit Labeling Outcome</h2>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>


	<?php if(isset($block_data)):?>
	
	
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
			<td><td>
		</tr>
		
		<tr>	
	
			<td>Type of labeling</td>
			<td><?php echo form_dropdown('outcome_type', $outcome_type,$block_data->outcome_type);?></td>	
			<td></td>
		
		</tr>
		
		
		
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





<?php $this->load->view('footer'); 
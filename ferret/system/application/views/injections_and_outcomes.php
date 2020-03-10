<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1> Injections and Outcomes input </h1>

	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>

	<h2><a href="index.php?c=injectionsoutcomes&m=add">Add new Injections and Outcomes </a>

<?php endif;?>

<!-- Add -->

<?php if($action == 'add'):?>


	<h1>Add New or Edit Relation of Injections and Outcomes</h1>

	<?php if(isset($add_message)):?>
		<p><?=$add_message?></p>
	<?php endif;?>



	<table id="ioutcomes_table">

	<tr id="auto_block">
		<td>Search for publication<br/> to find Brain site </td>
	
		<td>
			<input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth" class="input"/>
			<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
		</td>
	
	</tr>

	<tr id="lit_block" style="display:none;">
		<td>Selected Literature</td>
		<td id="literature"></td>
	
	</tr>

	<tr id="data_block" style="display:none;">
	
		<td id="data_column" colspan="2"></td>
	<tr>

	</table>

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


	<?php if(isset($lit_block)):?>
	sel_lit_num = <?=$lit_block->literature_id?>;
	$('autocomplite_auth').value = '<?=$lit_block->literature_title?> - <?=$lit_block->literature_index?>';
	literature_select();
	<?php endif;?>


	//]]>
	</script>

<?php endif;?>

<!-- Load the footer -->

<?php $this->load->view('footer'); 

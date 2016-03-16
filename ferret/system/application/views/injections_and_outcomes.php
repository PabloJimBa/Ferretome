<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<h2>Add New or Edit Realation of Injections and Outcomes</h2>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
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


<?php $this->load->view('footer'); 

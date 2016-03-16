<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Architecture parametrs</h2>

<p><a href="index.php?c=parameters&m=add">Add new Architecture param </a></p>
<p><a href="index.php?c=parameters&m=show">Show all </a></p>



<?php endif;?>



<?php if($action == 'add'):?>

<a href="javascript:history.go(-1)" >Back</a>

<h2>New Injection Data </h2>


<form method="post" id="frm" name="frm" action="index.php?c=parameters&m=insert">

<table id="source_table" style="display:none;">
<tr>
	<td>Selecting New Source Paper for parameter</td><td></td><td><a href="#" onclick="cancel_source()">Cancel</a></td> 
</tr> 
<tr id="source_auto_block">
	<td>Search for publication <br/> as source of data </td>
	<td>
		<input title="Please, start to type a title of a literature" type="text" id="autocomplite_source" class="input"/>
		<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
	</td>
</tr>

<tr style="display:none;" id="source_block">
	<td>Selected  Paper as source<br/> for architecture data</td>
	<td id="selected_source"></td>
</tr>

</table>



<table id="data_table">

<tr id="auto_block">
	<td>Search for publication<br/> to find Injections </td>
	<td><input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth" class="input"/>
	<br/>Start type title of a literature, after that select an injection in field below 
	</td>
</tr>

<tr id="lit_block" style="display:none;">
	<td>Selected Literature:</td>
	<td id="literature"></td>
</tr>



<tr id="injections_tr" style="display:none;">

	<td>Selected injection: </td>
	<td id="injection_block"></td>
	
</tr>

<tr id="data_block" style="display:none;">

	<td>
		Data:
		<br/><a href="#" onclick="add_data(); return false;">Add new data</a>
		<br/>Can't find proper parameter of data?
		<br/><a href="index.php?c=injectionsparameters&m=show" target="_blank">Check parameters first</a>
	</td>
	<td id="parameters_block"></td>
	
</tr>





</table>


</form>


<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_auth', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit/', 
	onSelect: function(value, data){
		sel_lit_num = data;
		literature_select();
		
	}
 });



new Autocomplete('autocomplite_source', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit/', 
	onSelect: function(value, data){
		sel_source_num = data;
		source_select();
		
	}
 });



//]]>
</script>



<?php endif;?>
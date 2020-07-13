<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>


	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Architecture input</h1>

	<h2><a href="index.php?c=architecture&m=add">Add new Architecture of Brain sites </a> &nbsp; | &nbsp; <a href="index.php?c=parameters&m=add">Add new Architecture parameters </a></h2>
	<a href="index.php?c=parameters&m=show">Show all Architecture parameters


	<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="index.php?c=architecture">Back</a> <!-- Back button -->

	<h1>Add new Architecture of Brain sites</h1>

	<!-- Form -->

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



	<table id="architecture_table">

	<tr id="auto_block">
		<td>Search for publication<br/> to find Brain site </td>
		<td>
			<input title="Please, start to type a title of a literature" type="text" id="autocomplite_auth" class="input"/>
			<br/>Start type title of a literature, after that type name of  acronym of brain site in field below 
		</td>
	<td></td>
	</tr>

	<tr id="lit_block" style="display:none;">
		<td>Selected Literature</td>
		<td id="literature"></td>
	<td></td>
	</tr>




	<tr id="bsite_auto_block" >
		<td>Search for Brain Site </td>
		<td><input title="Please, start to type name of acronym" type="text" id="autocomplite_bsite" class="input" <?php if(!isset($lit_data_2)):?>disabled<?php endif;?> /> <br/> Please, start to type name of acronym</td>
	<td></td>
	</tr>

	<tr style="display:none;" id="bsite_block">
		<td>Selected  Brain Site</td>
		<td id="sel_bsite"></td>
	<td></td>
	</tr>






	<tr id="layer_menu" style="display:none;"><td>Layers</td>

	<td>	<a href="#" onclick="add_layer('0'); return false;">Add parameters to the whole bsite</a><br/>

		Add by layer: 
		<a href="#" onclick="add_layer('1'); return false;">I</a>&nbsp; 
		<a href="#" onclick="add_layer('2'); return false;">II</a>&nbsp;
		<a href="#" onclick="add_layer('3'); return false;">III</a>&nbsp;
		<a href="#" onclick="add_layer('4'); return false;">IV</a>&nbsp;
		<a href="#" onclick="add_layer('5'); return false;">V</a>&nbsp;
		<a href="#" onclick="add_layer('6'); return false;">VI</a>&nbsp; 

	<td> 
	Cannot find any proper parameter?<br> <a target="_blank" href="index.php?c=parameters&m=add">Change set of parameters</a></td>
	</td></tr>

	<tr id="layer_0" style="display:none;"><td>The Whole Brain Site <br/><a href="#" onclick="add_parameter('0')">add parameter</a></td>
		<td id="layer_0_parameters"></td>
		<td><a href="#" onclick="del_layer('0'); return false;"> Delete</a></td>
	</tr>

	<tr id="layer_1" style="display:none;"><td>Layer 1<br/> <a href="#" onclick="add_parameter('1')">add parameter</a></td>
		<td id="layer_1_parameters"></td>
		<td><a href="#" onclick="del_layer('1'); return false;"> Delete layer</a></td>
	</tr>

	<tr id="layer_2" style="display:none;"><td>Layer 2 <br/><a href="#" onclick="add_parameter('2')">add parameter</a></td>
		<td id="layer_2_parameters"></td>
		<td><a href="#" onclick="del_layer('2'); return false;"> Delete layer</a></td>
	</tr>

	<tr id="layer_3" style="display:none;"><td>Layer 3<br/> <a href="#" onclick="add_parameter('3')">add parameter</a></td>
		<td id="layer_3_parameters"></td>
		<td><a href="#" onclick="del_layer('3'); return false;"> Delete layer</a></td>
	</tr>

	<tr id="layer_4" style="display:none;"><td>Layer 4 <br/><a href="#" onclick="add_parameter('4')">add parameter</a></td>
		<td id="layer_4_parameters"></td>
		<td><a href="#" onclick="del_layer('4'); return false;"> Delete layer</a></td>
	</tr>

	<tr id="layer_5" style="display:none;"><td>Layer 5<br/> <a href="#" onclick="add_parameter('5')">add parameter</a></td>
		<td id="layer_5_parameters"></td>
		<td><a href="#" onclick="del_layer('5'); return false;"> Delete layer</a></td>
	</tr>

	<tr id="layer_6" style="display:none;"><td>Layer 6 <br/><a href="#" onclick="add_parameter('6')">add parameter</a></td>
		<td id="layer_6_parameters"></td>
		<td><a href="#" onclick="del_layer('6'); return false;"> Delete layer</a></td>
	</tr>


	</table>


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


	new Autocomplete('autocomplite_bsite', { 
		serviceUrl:'index.php/brainsites/ajaxAtocomplit/', 
		onSelect: function(value, data){
			sel_bsite_num = data;
			bsite_select();
		
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


<!-- Load the footer -->

<?php $this->load->view('footer'); 

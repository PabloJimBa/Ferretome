<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<h1>Welcome to FBBD!</h1>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Methods</h2>

<p><a href="index.php?c=methods&m=add">Add new Method </a></p>
<p><a href="index.php?c=methods&m=show">Show all </a></p>



<?php endif;?>



<?php if($action == 'add'):?>

<p><a href="index.php?c=methods&m=show">Show all </a></p>

<h2>New Injection Method </h2>


<a href="#" onclick="show_coding_rules('methods'); return false;">Coding rules for Methods</a>
<form method="post" id="frm" name="frm" action="index.php?c=methods&m=insert">

<table border="0" cellpadding="3" cellspacing="1">

<tr id="auto_block">
	<td>Search for publication<br/> for this injection method </td>
	<td><input title="Please, start to type a title" type="text" id="autocomplite_auth" class="input"/></td>
</tr>

<tr style="display:none;" id="lit_block">
	<td>Selected Literature <br/> for new injection method:</td>
	<td id="literature"></td>
	
</tr>


<tr id="auto_block_tracer">
	<td>Search for tracer<br/> for this injection method <br/> Can't find? <a href="index.php?c=tracers" target="_blank">Check tracers</a> </td>
	<td><input title="Please, start to type a title" type="text" id="autocomplite_tracer" class="input"/></td>
</tr>

<tr style="display:none;" id="tracer_block">
	<td>Selected Tracer <br/> for injection method:</td>
	<td id="tracer"></td>
	
</tr>


<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR  ($field->name == 'literature_id') OR ($field->name == 'tracers_id')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Insert" />

</form>

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


new Autocomplete('autocomplite_tracer', { 
	serviceUrl:'index.php/tracers/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_tracer_num = data;
		tracer_select();
		
	}
 });
 
$('frm').onsubmit = function () { return check_form(this)}

//]]>
</script>


<?php endif;?>






<?php if($action == 'show'):?>

<p><a href="index.php?c=methods">Back </a></p>
<p><a href="index.php?c=methods&m=add">Add new Method </a></p>

<h2>All methods</h2>

<table border="0" cellpadding="3" cellspacing="1">
<tr><td>tracer name</td><td>injection method</td><td>survival time</td><td></td></tr>
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->tracers_name?></td>
	<td><?=$bdata->injection_method?></td>
	<td><?=$bdata->survival_time?></td> 
	<td><a href="index.php?c=methods&m=edit&id=<?=$bdata->methods_id?>">edit</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>





<?php if($action == 'edit'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>

<h2>Edit Injection Method</h2>

<?php if(isset($block_data)):?>


<a href="#" onclick="show_coding_rules('methods'); return false;">Coding rules for Methods</a>

<form method="post" id="frm" name="frm" action="index.php?c=methods&m=update&id=<?=$block_data->methods_id?>">

<table border="0" cellpadding="3" cellspacing="1">


<tr style="display:none;" id="auto_block">
	<td>Search for publication<br/> for this injection method </td>
	<td><input title="Please, start to type a title" type="text" id="autocomplite_auth" class="input"/></td>
</tr>

<tr  id="lit_block">
	<td>Selected Literature <br/> for new injection method:</td>
	<td id="literature">
		<span id="<?=$block_data->literature_id?>">
		<input type="hidden" name="literature_id" value="<?=$block_data->literature_id?>">
		<?=$block_data->literature_title?> <?=$block_data->literature_index?>
		<a href="#" onclick="lit_replace('<?=$block_data->literature_id?>'); return false;"> Replace</a>
		</span>
	
	</td>
</tr>


<tr style="display:none;" id="auto_block_tracer">
	<td>Search for tracer<br/> for this injection method <br/> Can't find? <a target="_blank" href="index.php?c=tracers" target="_blank">Check tracers</a> </td>
	<td><input title="Please, start to type a title" type="text" id="autocomplite_tracer" class="input"/></td>
</tr>


<tr id="tracer_block">
	<td>Selected Tracer <br/> for injection method:</td>
	<td id="tracer">
	<span id="tracer_<?=$block_data->tracers_id?>">
	<input type="hidden" name="tracers_id" value="<?=$block_data->tracers_id?>"><?=$block_data->tracers_name?>
	<a href="#" onclick="tracer_replace('<?=$block_data->tracers_id?>'); return false;"> Replace</a>
	</span>
	
	</td>
</tr>




<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'literature_id') OR ($field->name == 'tracers_id')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($block_data->$f); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($block_data->$f); ?>" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Update" />

</form>

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


new Autocomplete('autocomplite_tracer', { 
	serviceUrl:'index.php/tracers/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_tracer_num = data;
		tracer_select();
		
	}
 });

sel_lit_num = <?=$block_data->literature_id?>;
sel_tracer_num = <?=$block_data->tracers_id?>;

 
$('frm').onsubmit = function () { return check_form(this)}

//]]>
</script>

<?php endif;?>

<?php endif;?>



<?php $this->load->view('footer');
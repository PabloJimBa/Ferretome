<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Architecture parametrs</h2>

<p><a href="index.php?c=parameters&m=add">Add new Architecture Parameter </a></p>
<p><a href="index.php?c=parameters&m=show">Show all </a></p>



<?php endif;?>



<?php if($action == 'add'):?>

<p><a href="index.php?c=parameters&m=show">Show all </a></p>

<h2>new Architecture parameter</h2>



<form method="post" id="frm" name="frm" action="index.php?c=parameters&m=insert">

<table border="0" cellpadding="3" cellspacing="1">


<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'parameters_type')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>


<tr>
	<td>
	parameter type
	</td>
	<td>
		<?php echo form_dropdown('parameters_type', $types_options, '1');?>
	</td>
</tr>

</table>

<input type="submit" class="submit" value="Insert" />

</form>

<?php endif;?>






<?php if($action == 'show'):?>

<p><a href="index.php?c=parameters">Back </a></p>
<p><a href="index.php?c=parameters&m=add">add new Architecture param </a></p>

<h2>All Architecture Parameters</h2>

<table border="0" cellpadding="3" cellspacing="1">
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->parameters_name?></td>	
	<td><a href="index.php?c=parameters&m=edit&id=<?=$bdata->parameters_id?>">edit</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>


<?php if($action == 'edit'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>

<h2>Edit Architecture parameter</h2>



<form method="post" id="frm" name="frm" action="index.php?c=parameters&m=update&id=<?=$block_data->parameters_id?>">

<table border="0" cellpadding="3" cellspacing="1">




<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'parameters_type')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($block_data->$f); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($block_data->$f); ?>" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>


<tr>
	<td>
	parameter type
	</td>
	<td>
		<?php echo form_dropdown('parameters_type', $types_options, $block_data->parameters_type);?>
	</td>
</tr>


</table>

<input type="submit" class="submit" value="Update" />

</form>

<?php endif;?>





<?php $this->load->view('footer');





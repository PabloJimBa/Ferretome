<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<h1>Welcome to FBBD!</h1>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Tracers</h2>

<p><a href="index.php?c=tracers&m=add">Add new Tracer </a></p>
<p><a href="index.php?c=tracers&m=show">Show all </a></p>



<?php endif;?>



<?php if($action == 'add'):?>

<p><a href="index.php?c=tracers&m=show">Show all </a></p>

<h2>new injection tracer </h2>



<form method="post" id="frm" name="frm" action="index.php?c=tracers&m=insert">

<table border="0" cellpadding="3" cellspacing="1">


<?php foreach($fields as $field): ?>

<?php if ($field->primary_key == 1) continue; ?>

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

<?php endif;?>






<?php if($action == 'show'):?>

<p><a href="index.php?c=tracers">Back </a></p>
<p><a href="index.php?c=tracers&m=add">Add new Tracer </a></p>

<h2>All Tracers</h2>

<table border="0" cellpadding="3" cellspacing="1">
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->tracers_name?></td>
	<td><?=$bdata->tracers_description?></td> 
	<td><a href="index.php?c=tracers&m=edit&id=<?=$bdata->tracers_id?>">edit</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>


<?php if($action == 'edit'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>

<h2>Edit Tracer</h2>



<form method="post" id="frm" name="frm" action="index.php?c=tracers&m=update&id=<?=$block_data->tracers_id?>">

<table border="0" cellpadding="3" cellspacing="1">




<?php foreach($fields as $field): ?>

<?php if ($field->primary_key == 1) continue; ?>

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

<?php endif;?>





<?php $this->load->view('footer');





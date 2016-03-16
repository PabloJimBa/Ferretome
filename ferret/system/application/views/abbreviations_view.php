<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>



<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Journals/ Books / Etc</h2>

<p><a href="index.php?c=abbreviations&m=add">Add new Literature Abbr. </a></p>
<p><a href="index.php?c=abbreviations&m=show">Show all </a></p>



<?php endif;?>



<?php if($action == 'add'):?>

<p><a href="index.php?c=abbreviations&m=show">Show all </a></p>

<h2>new Literature Abbr. </h2>



<form method="post" id="frm" name="frm" action="index.php?c=abbreviations&m=insert">

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

<p><a href="index.php?c=abbreviations">Back </a></p>
<p><a href="index.php?c=abbreviations&m=add">Add new Abbr. </a></p>

<h2>All Literature Abbr.</h2>

<table border="0" cellpadding="3" cellspacing="1">
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->abbreviations_short?></td>
	<td><?=$bdata->abbreviations_full?></td> 
	<td><a href="index.php?c=abbreviations&m=edit&id=<?=$bdata->abbreviations_id?>">edit</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>


<?php if($action == 'edit'):?>

<p><a href="index.php?c=abbreviations&m=show">Show all</a></p>


<h2>Edit Literature Abbr.</h2>



<form method="post" id="frm" name="frm" action="index.php?c=abbreviations&m=update&id=<?=$block_data->abbreviations_id?>">

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





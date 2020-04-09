<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>

	<h1>Coding rules input </h1>

	<h2><a href="index.php?c=codingrules&m=add">Add new Coding Rule </a> &nbsp; | &nbsp; <a href="index.php?c=codingrules&m=show">Show all </a></h2>

<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>New Coding Rule</h1>

	<form method="post" id="frm" name="frm" action="index.php?c=codingrules&m=insert">

	<table border="0" cellpadding="3" cellspacing="1">

	<!-- Form -->

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


<!-- Show -->

<?php if($action == 'show'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>All Coding Rules</h1>

	<p><a href="index.php?c=codingrules&m=add">Add new Coding rule </a></p>

	<table border="0" cellpadding="3" cellspacing="1">
	<?php foreach($block_data->result() as $bdata): ?>
	<tr>
		<td><?=$bdata->coding_rules_name?></td> 
		<td><a href="index.php?c=codingrules&m=edit&id=<?=$bdata->coding_rules_id?>">edit</a> &nbsp; | &nbsp; <a href="index.php?c=codingrules&m=confirm&id=<?=$bdata->coding_rules_id?>">delete</a></td>
	</tr>
	<?php endforeach; ?>
	</table>

<?php endif;?>


<!-- Edit -->

<?php if($action == 'edit'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Edit Coding Rule</h1>

	<!-- Form -->

	<form method="post" id="frm" name="frm" action="index.php?c=codingrules&m=update&id=<?=$block_data->coding_rules_id?>">

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


<!-- Load the footer -->

<?php $this->load->view('footer');

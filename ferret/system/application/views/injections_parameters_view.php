<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Injections input</h1>

	<?php if(isset($index_message)):?>
	<p><?=$index_message?></p>
	<?php endif;?>


	<h2><a href="index.php?c=injectionsparameters&m=add">Add new Injection Parameters </a> &nbsp; | &nbsp; <a href="index.php?c=injectionsparameters&m=show">Show all Injection Parameters </a></h2>

<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>New  Injection parameter </h1>

	<p><a href="index.php?c=injectionsparameters&m=show">Show all </a></p>

	<!-- Form -->

	<form method="post" id="frm" name="frm" action="index.php?c=injectionsparameters&m=insert">

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


<!-- Show -->

<?php if($action == 'show'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>All Injection Parameters</h1>

	<p><a href="index.php?c=injectionsparameters&m=add">Add new parameters </a></p>

	<table border="0" cellpadding="3" cellspacing="1">
	<?php foreach($block_data->result() as $bdata): ?>
	<tr>
		<td><?=$bdata->parameters_name?></td>
		<td><?=$bdata->parameters_description?></td> 
		<td><a href="index.php?c=injectionsparameters&m=edit&id=<?=$bdata->parameters_id?>">edit</a></td>
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif;?>


<!-- Edit -->

<?php if($action == 'edit'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Edit Injection parameter</h1>

	<!-- Form -->

	<form method="post" id="frm" name="frm" action="index.php?c=injectionsparameters&m=update&id=<?=$block_data->parameters_id?>">

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
			<?php echo form_dropdown('parameters_type', $types_options, '1');?>
		</td>
	</tr>
	</table>

	<input type="submit" class="submit" value="Update" />

	</form>

<?php endif;?>


<!-- Load the footer -->

<?php $this->load->view('footer');




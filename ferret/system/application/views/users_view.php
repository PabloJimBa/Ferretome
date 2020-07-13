<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

	<!-- Load the header -->

	<?php  $this->load->view('header');  ?>


	<!-- Index -->

	<?php if($action == 'index'):?>

	
		<?php if(isset($index_message)):?>
			<p><?=$index_message?></p>
		<?php endif;?>


		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>All Users</h1>
		<p><a href="index.php?c=users&m=add">Add new User</a></p>

		<?php if(isset($block_data)):?>
			
			<table>
				<tr>
				<?php foreach($block_fields as $field): ?>
	
						<?php if ($field == "user_id" or $field == "user_password") continue; ?>
						<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
					
				<?php endforeach; ?>
				<td>Actions</td>
				</tr>
			
			<?php foreach($block_data->result() as $bdata): ?>
			<tr>
	
				<?php foreach($block_fields as $field): ?>
					<?php if ($field == "user_id" or $field == "user_password") continue; ?>
					<td><?=$bdata->$field;?></td>
				
				<?php endforeach;?>
				<td><a href="index.php?c=users&m=edit&id=<?=$bdata->user_id?>">edit</a> &nbsp; | &nbsp; <a href="index.php?c=users&m=confirm&id=<?=$bdata->user_id?>">delete</a></td>						

			</tr>
			<?php endforeach; ?>
	
				</table>
		<?php else:?>
			<p>Nothing was found.</p>
		<?php endif;?>


	<?php endif;?>


	<!-- Add -->

	<?php if($action == 'add'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>Add new User</h1>
		<p><a href="index.php?c=users&m=show">Show all</a></p>


		<form method="post" id="frm" name="frm" action="index.php?c=users&m=insert">

		<table border="0" cellpadding="3" cellspacing="1">


		<!-- Form -->	

		<?php foreach($fields as $field): ?>
				
			<?php if ($field->name == 'user_reg_time' or $field->name == 'user_class' or $field->name == 'user_id') continue; ?>
				<tr>
					<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
					<?php if ($field->type == 'blob'): ?>
						<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
					<?php else : ?>
						<td><input class="input" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="30" /></td>
					<?php endif; ?>
	
				</tr>
		<?php endforeach; ?>

		</table>

		<input type="submit" class="submit" value="Insert" />

		</form>

	<?php endif;?>


	<!-- Edit -->

	<?php if($action == 'edit'):?>

		<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

		<h1>Edit User</h1>

		<?php if(isset($block_message)):?>
		<p><?=$block_message?></p>
		<?php endif;?>


		<?php if(isset($user_data)):?>

			<form method="post" id="frm" name="frm" action="index.php?c=users&m=update&aid=<?=$user_data->user_id?>">
	
			<table border="0" cellpadding="3" cellspacing="1">
	
	
	
			<?php foreach($fields as $field): ?>
	
			<?php if ($field->primary_key == 1 or $field->name == 'user_reg_time') continue; ?>
	
				<tr>
					<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
		
					<?php if ($field->type == 'blob'): ?>
						<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($user_data->$f); ?></textarea></td>
					<?php else : ?>
						<?php if ($field->name == 'user_password'): ?>
							<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; ?>" size="30" /></td>
						<?php else : ?>
							<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($user_data->$f); ?>" size="30" /></td>
						<?php endif; ?>
					<?php endif; ?>
		
				</tr>
			<?php endforeach; ?>
			</table>
	
			<input type="submit" class="submit" value="Update" /> &nbsp; <strong>If you edit the password, it will be saved encrypted</strong>
	
			</form>

		<?php endif;?>

	<?php endif;?>

<!-- Load the footer -->

<?php $this->load->view('footer'); 

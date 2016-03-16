<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<p><a href="index.php?c=authors&m=add">Add new Authors </a></p>
<?php endif;?>


<?php if($action == 'show'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>
<p><a href="index.php?c=authors&m=add">Add new Author</a></p>

<h2>All Authors</h2>


	<?php if(isset($block_data)):?>
			
		<table>
			<tr>
			<?php foreach($block_fields as $field): ?>
		
					<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
						
			<?php endforeach; ?>
			<td>actions</td>
			</tr>
				
		<?php foreach($block_data->result() as $bdata): ?>
		<tr>
		
			<?php foreach($block_fields as $field): ?>
				
			<td><?=$bdata->$field;?></td>
					
			<?php endforeach;?>
			<td><a href="index.php?c=authors&m=edit&id=<?=$bdata->authors_id?>">edit</a></td>
							
		</tr>
		<?php endforeach; ?>
	
		</table>
	<?php else:?>
		<p>Nothing was found</p>
	<?php endif;?>


<?php endif;?>



<?php if($action == 'add'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>
<p><a href="index.php?c=authors&m=show">Show all</a></p>

<h2>Add new Author</h2>



<form method="post" id="frm" name="frm" action="index.php?c=authors&m=insert">

<table border="0" cellpadding="3" cellspacing="1">




<?php foreach($fields as $field): ?>

<?php if ($field->primary_key == 1) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
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



<?php if($action == 'search'):?>

<a href="javascript:history.go(-1)" >Back</a>

<h2>Search for Author</h2>

<?php if(isset($search_message)):?>
<p><?=$search_message?></p>
<?php endif;?>

<form method="post" id="frm" name="frm" action="#">

<table border="0" cellpadding="3" cellspacing="1">

<tr id="auto_block">
	<td>Search for Authors</td>
	<td>
	<input title="Please, start to type a surname of an author" type="text" id="autocomplite_2" class="input" />
	</td>
	<td><input type="submit" class="submit" value="Go" /></td>
</tr>

</table>
</form>
<br/>
<div id="search_result"></div>

<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_2', { 
	serviceUrl:'index.php/authors/ajaxAtocomplit',
	onSelect: function(value, data){
		sel_auth_num = data;
		
		search_do();
		
	} 
	
 });
 

//]]>
</script>

<?php endif;?>



<?php if($action == 'edit'):?>

<a href="javascript:history.go(-1)" >Back</a>

<p><a href="index.php?c=authors&m=show">Show all</a></p>

<h2>Edit Author</h2>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>


	<?php if(isset($auth_data)):?>

		<form method="post" id="frm" name="frm" action="index.php?c=authors&m=update&aid=<?=$auth_data->authors_id?>">
		
		<table border="0" cellpadding="3" cellspacing="1">
		
		
		
		<?php foreach($fields as $field): ?>
		
		<?php if ($field->primary_key == 1) continue; ?>
		
		<tr>
			<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
			
			<?php if ($field->type == 'blob'): ?>
			<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($auth_data->$f); ?></textarea></td>
			<?php else : ?>
			<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($auth_data->$f); ?>" size="30" /></td>
			<?php endif; ?>
			
		</tr>
		<?php endforeach; ?>
		</table>
		
		<input type="submit" class="submit" value="Update" />
		
		</form>

	<?php endif;?>

<?php endif;?>





<?php $this->load->view('footer'); 








<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<h1>Welcome to FBBD!</h1>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Add new Acronym</h2>

<p><a href="index.php?c=acronyms&m=add">Add new Acronyms </a></p>
<p><a href="index.php">Back to Main menu </a></p>


<?php endif;?>


<?php if($action == 'show'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>
<p><a href="index.php?c=acronyms&m=add">Add new Author</a></p>

<h2>All Acronyms</h2>


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
			<td><a href="index.php?c=acronyms&m=edit&id=<?=$bdata->brain_site_acronyms_id?>">edit</a></td>
							
		</tr>
		<?php endforeach; ?>
	
		</table>
	<?php else:?>
		<p>Nothing was found</p>
	<?php endif;?>


<?php endif;?>






<?php if($action == 'add'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>
<p><a href="index.php?c=acronyms&m=show">Show all</a></p>

<h2>New Acronym</h2>

<?php if(isset($add_message)):?>
<p><?=$add_message?></p>
<?php endif;?>



<form method="post" id="frm" name="frm" action="index.php?c=acronyms&m=insert">

<table border="0" cellpadding="3" cellspacing="1">


<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) ) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="30" /></td>
	<?php endif; ?>
	<td></td>
	
</tr>
<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Insert" />

</form>

<?php endif;?>



<?php if($action == 'search'):?>

<h2>Search for Acronym</h2>

<?php if(isset($search_message)):?>
<p><?=$search_message?></p>
<?php endif;?>

<form method="post" id="frm" name="frm" action="#">

<table border="0" cellpadding="3" cellspacing="1">

<tr id="auto_block">
	<td>Search for Acronyms</td>
	<td>
	<input title="Please, start to type acronym" type="text" id="autocomplite_2" class="input" />
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
	serviceUrl:'index.php/acronyms/ajaxAtocomplit', 
	onSelect: function(value, data){
		sel_acr_num = data;
		search_do();
	}
 });
 

//]]>
</script>

<?php endif;?>



<?php if($action == 'edit'):?>

<h2>Edit Acronym</h2>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>

<a href="javascript:history.go(-1)" >Back</a>

<?php if(isset($acr_data)):?>


		
<form method="post" id="frm" name="frm" action="index.php?c=acronyms&m=update&id=<?=$acr_data->brain_site_acronyms_id?>">

<table border="0" cellpadding="3" cellspacing="1">




<?php foreach($fields as $field): ?>

<?php if ($field->primary_key == 1) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; echo ' '.$field->default; ?></td>
	
	<?php if ($field->type == 'blob'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($acr_data->$f); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($acr_data->$f); ?>" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Update" />

</form>

<?php endif;?>

<?php endif;?>





<?php $this->load->view('footer');


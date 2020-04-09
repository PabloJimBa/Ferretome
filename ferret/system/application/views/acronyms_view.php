<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>


<!-- Index -->

<?php if($action == 'index'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Acronyms input</h1> 

	<?php if(isset($index_message)):?>
		<p><?=$index_message?></p>
	<?php endif;?>

	<h2><a href="index.php?c=acronyms&m=add">Add new Acronym </a> &nbsp; | &nbsp; <a href="index.php?c=acronyms&m=search">Search Acronym </a></h2> <!-- Options -->
	<a href="index.php?c=acronyms&m=show">All acronym list</a>
<?php endif;?>


<!-- Show -->

<?php if($action == 'show'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>All Acronyms</h1>

	<p><a href="index.php?c=acronyms&m=add">Add new Acronym</a></p>

	<!-- Form -->

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
					<td><a href="index.php?c=acronyms&m=edit&id=<?=$bdata->brain_site_acronyms_id?>">edit</a> &nbsp; | &nbsp; <a href="index.php?c=acronyms&m=confirm&id=<?=$bdata->brain_site_acronyms_id?>">delete</a></td>
						
				</tr>
			<?php endforeach; ?>

		</table>
	<?php else:?>
		<p>Nothing was found</p>
	<?php endif;?>


<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Add new Acronym</h1>

	<p><a href="index.php?c=acronyms&m=show">Show all</a></p>

	<?php if(isset($add_message)):?>
	<p><?=$add_message?></p>
	<?php endif;?>

	<!-- Form -->

	<form method="post" id="frm" name="frm" action="index.php?c=acronyms&m=insert">

	<table border="0" cellpadding="3" cellspacing="1">


	<?php foreach($fields as $field): ?>

		<?php if (($field->primary_key == 1) ) continue; ?>

			<tr>
				<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
				<?php if ($field->type == 'blob'): ?>
					td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php echo form_prep($field->default); ?></textarea></td>
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


<!-- Search -->

<?php if($action == 'search'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Search for Acronyms</h1>

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
	</tr>

	</table>
	</form>
	<br/>
	<div id="search_result"></div>

	<!-- Java scripts -->

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


<!-- Edit -->

<?php if($action == 'edit'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Edit Acronym</h1>

	<?php if(isset($block_message)):?>
		<p><?=$block_message?></p>
	<?php endif;?>

	<?php if(isset($acr_data)):?>

		<!-- Form -->

		<form method="post" id="frm" name="frm" action="index.php?c=acronyms&m=update&id=<?=$acr_data->brain_site_acronyms_id?>">

		<table border="0" cellpadding="3" cellspacing="1">

		<?php foreach($fields as $field): ?>

			<?php if ($field->primary_key == 1) continue; ?>

			<tr>
				<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
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


<!-- Load the footer -->

<?php $this->load->view('footer');

<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php $this->load->view('header.php'); ?>


<?php if ($action =='index'): ?>
<!-- ///////////////// _index_ /////////////// -->
<?php if(isset($page_data)):?>
<?=$page_data?>
<?php endif; ?>



<?php endif; ?>



<?php if($action == 'show'):?>

<p><a href="index.php?c=pages&m=add">Add new Page </a></p>

<h2>All Pages</h2>

<table>
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->page_name?></td>
	<td><?=$types_options[$bdata->page_type]?></td>  
	<td>link to the page: <input width="150" type="text" value="<?php echo form_prep('index.php?c=pages&p='.$bdata->page_name)?>"/></td>
	<td><a href="index.php?c=pages&p=<?=$bdata->page_name?>">preview</a></td>
	<td><a href="index.php?c=pages&m=edit&id=<?=$bdata->page_id?>">edit</a></td>
</tr>
<?php endforeach; ?>
</table>



<?php endif;?>


<?php if($action == 'add'):?>

<p><a href="index.php?c=pages&m=show">Show all </a></p>

<table>
<tr>
	<td>

<h2>New Page</h2>

<form method="post" id="frm" name="frm" action="index.php?c=pages&m=insert">

<table border="0" cellpadding="3" cellspacing="1">

<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'page_type')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; ?></td>
	
	<?php if ($field->type == 'text'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>

<tr>
	<td>
	page type
	</td>
	<td>
		<?php echo form_dropdown('page_type', $types_options, '1');?>
	</td>
</tr>


</table>

<input type="submit" class="submit" value="Insert" />

</form>

</td>
	<td valign="top">
	<h2>Your files</h2>
	<a href="#" id="uploader"> Upload new</a>
	<br/>
	<br/>
	<div id="files_block">
		<?php if(isset($files_data)):?>
			<?php $this->load->view('files_view'); ?>
		<?php endif;?>
	</div>
	
	
	</td>
</tr>
</table>

<script type="text/javascript">
//<![CDATA[
           
var uploader = document.getElementById('uploader');

upclick(
  {
   element: uploader,
   action: 'index.php/pages/uploadFile', 
   onstart:
     function(filename)
     {
       alert('Start upload: '+filename);
     },
   oncomplete:
     function(response_data) 
     {
       if(response_data != 'FAIL') {

           refresh_file_list(response_data);
           alert(response_data);
       } else {

           alert('An Error has occured, try once again!');

       }
     }
  });
  
//]]>
</script>

<?php endif;?>



<?php if($action == 'edit'):?>

<p><a href="index.php?c=pages&m=show">Show all </a></p>

<table>
<tr>
	<td>

<h2>Edit Page</h2>



<form method="post" id="frm" name="frm" action="index.php?c=pages&m=update&id=<?=$block_data->page_id?>">

<table>


<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'page_type')) continue; ?>

<tr>
	<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; ?></td>
	
	<?php if ($field->type == 'text'): ?>
	<td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($block_data->$f); ?></textarea></td>
	<?php else : ?>
	<td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($block_data->$f); ?>" size="30" /></td>
	<?php endif; ?>
	
</tr>
<?php endforeach; ?>


<tr>
	<td>
	page type
	</td>
	<td>
		<?php echo form_dropdown('page_type', $types_options,$block_data->page_type);?>
	</td>
</tr>

</table>

<input type="submit" class="submit" value="Update" />

</form>

	</td>
	<td valign="top">
	<h2>Your files</h2>
	<a href="#" id="uploader"> Upload new</a>
	<br/>
	<br/>
	<div id="files_block">
		<?php if(isset($files_data)):?>
			<?php $this->load->view('files_view'); ?>
		<?php endif;?>
	</div>
	
	
	</td>
</tr>
</table>

<script type="text/javascript">
//<![CDATA[
           
var uploader = document.getElementById('uploader');

upclick(
  {
   element: uploader,
   action: 'index.php/pages/uploadFile', 
   onstart:
     function(filename)
     {
       alert('Start upload: '+filename);
     },
   oncomplete:
     function(response_data) 
     {
       if(response_data != 'FAIL') {

           refresh_file_list(response_data);
           alert(response_data);
       } else {

           alert('An Error has occured, try once again!');

       }
     }
  });
  
//]]>
</script>	



<?php endif;?>




<?php $this->load->view('footer.php'); ?>
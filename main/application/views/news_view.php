<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php $this->load->view('header.php'); ?>


<?php if ($action =='index'): ?>
<!-- ///////////////// _index_ /////////////// -->

<div id="main_page">
	<?php if (isset($news_one)): ?> 
	
		<p><?=$news_one->user_name?> <?=$news_one->user_surname?> on <?php $str = explode(" ",$news_one->news_posted); echo $str[0]?>: </p>
		<p><strong><?=$news_one->news_title?></strong></p>
		<p><?=$news_one->news_text?></p>
	 
	<?php else: ?>
	
		<?php if(isset($news)):?>
	
			
			<?php foreach ($news->result() as $new):?>		
				<h5>  <?=$new->news_title?> </h5>
					<?=$new->news_text?>	
				<p> Posted by  <?=$new->user_name?> <?=$new->user_surname?> on <?php $str = explode(" ",$new->news_posted); echo $str[0]?> </p>
						
			<?php endforeach;?>	
			
	
		<?php endif;?>
	
	
	
	<?php endif; ?>
</div>

<div id="news_block">
	
	Recent:
	
	<?php if(isset($news)):?>

		<?php foreach ($news->result() as $new):?>
			<h5>  <?=$new->news_title?> </h5>		
			<p> Posted by  <?=$new->user_name?> <?=$new->user_surname?> on <?php $str = explode(" ",$new->news_posted); echo $str[0]?> </p>
			<p><a href="index.php?c=news&id=<?=$new->news_id?>">Read more ...</a></p>		
		<?php endforeach;?>
	
	

	<?php endif;?>

</div>
	



<!-- ///////////////// _END_of_index_ /////////////// -->
<?php endif; ?>





<?php if($action == 'show'):?>
<!-- ///////////////// show /////////////// -->

<p><a href="index.php?c=news&m=add">Add News </a></p>

<h2>All News</h2>

<table>
<tr>
	<?php foreach($fields as $field): ?>

		<?php if (($field->primary_key == 1) OR ($field->name == 'news_text') OR ($field->name == 'news_state') OR ($field->name == 'user_id')) continue; ?>

		<td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo $fn." "; }; ?></td>
		
	<?php endforeach;?>
	
	<td>type</td>
	<td>action</td>
	
	
</tr>
	
	
<?php foreach($block_data->result() as $bdata): ?>
<tr>

	<?php foreach($fields as $field): ?>

	<?php if (($field->primary_key == 1) OR ($field->name == 'news_text') OR ($field->name == 'news_state') OR ($field->name == 'user_id')) continue; ?>
	
	<td><?php $f=$field->name; echo $bdata->$f;?></td>
		
	<?php endforeach;?>

	<td><?=$types_options[$bdata->news_state]?></td>
	<td><a href="index.php?c=news&m=edit&id=<?=$bdata->news_id?>">edit</a></td>
	
</tr>
<?php endforeach; ?>
	

</table>


<!-- ///////////////// end of show /////////////// -->
<?php endif;?>






<?php if($action == 'add'):?>

<p><a href="index.php?c=news&m=show">Show all </a></p>


<table>
<tr>
	<td>
<h2>Add News</h2>


<form method="post" id="frm" name="frm" action="index.php?c=news&m=insert">

<table>

<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'news_state') OR ($field->name == 'user_id') OR ($field->name == 'news_posted')) continue; ?>

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
	news type
	</td>
	<td>
		<?php echo form_dropdown('news_state', $types_options, '1');?>
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

<p><a href="index.php?c=news&m=show">Show all </a></p>


<table>
<tr>
	<td>

<h2>Edit News</h2>

<form method="post" id="frm" name="frm" action="index.php?c=news&m=update&id=<?=$block_data->news_id?>">

<table>


<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'news_state') OR ($field->name == 'user_id') OR ($field->name == 'news_posted')) continue; ?>

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
	news type
	</td>
	<td>
		<?php echo form_dropdown('news_state', $types_options,$block_data->news_state);?>
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
<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Architecture parametrs</h2>

<p><a href="index.php?c=parameters&m=add">Add new Architecture Parameter </a></p>
<p><a href="index.php?c=parameters&m=show">Show all </a></p>



<?php endif;?>



<?php if($action == 'add'):?>

<p><a href="index.php?c=parameters&m=show">Show all </a></p>

<h2>new Architecture parameter</h2>

<?php if(isset($current_job)):?>

<?php $local_data = array(); $local_data['output_data'] =$block_data; $local_data['fields_data'] = $parameter_fields; $this->load->view('standart_edit_record_view',$local_data);?>



<?php endif;?>



<?php endif;?>






<?php if($action == 'show'):?>

<p><a href="index.php?c=parameters">Back </a></p>
<p><a href="index.php?c=parameters&m=add">Add new Architecture param </a></p>

<h2>All Architecture Parameters</h2>

<table border="0" cellpadding="3" cellspacing="1">
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->parameters_name?></td>	
	<td><a href="index.php?c=parameters&m=edit&id=<?=$bdata->parameters_id?>">edit</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>


<?php if($action == 'edit'):?>

<p><a href="javascript:history.go(-1)" >Back</a></p>



<h2>Edit Architecture parameter</h2>



<?php if(isset($block_data)):?>

<?php $local_data = array(); $local_data['output_data'] =$block_data; $local_data['fields_data'] = $parameter_fields; $this->load->view('standart_edit_record_view',$local_data);?>

<?php endif;?>




<script type="text/javascript">
//<![CDATA[

load_fields('<?=$parameter_id?>');

//]]>
</script>


<?php endif;?>





<?php $this->load->view('footer');





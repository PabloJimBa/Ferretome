<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<h2>Jouranl of actions</h2>

<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<a href="index.php?c=journal">Refresh</a>

<table border="0" cellpadding="3" cellspacing="1">
<?php foreach($block_data->result() as $bdata): ?>
<tr>
	<td><?=$bdata->user_email?></td> 
	<td><?=$bdata->user_surname?></td>
	<td><?=$bdata->user_name?></td>
	<td><?=$bdata->tables_descriptions_name?></td>
	<td><?=$act_types[$bdata->log_action]?></td>
	<td><?=$bdata->log_time?></td>
	
	<td> see how it is now <a target="_blank" href="index.php?c=<?=$bdata->tables_controller?>&m=edit&id=<?=$bdata->log_entry_id?>">number <?=$bdata->log_entry_id?></a></td>
	<?php if($act_types[$bdata->log_action] =='Update'): ?>
		<td> 
			<span style="display:none;" id="log_details_block_<?=$bdata->log_id?>">
				<a href="#" onclick="hide_log_details('<?=$bdata->log_id?>'); return false;">Hide</a> 
				<br/><?php $dat = unserialize($bdata->log_previous_data);?>
				<?php foreach ($dat as $key => $value ):?>
					<br><?=$key?> - <?=$value?>
				<?php endforeach;?> 
			</span> 
			<span id="log_details_<?=$bdata->log_id?>"><a href="#" onclick="show_log_details('<?=$bdata->log_id?>'); return false;">click here</a> to see how it was</span>  
		</td>
		<td>
		<?=$bdata->parameter_name?>
		</td>
		<td>
		<?=$bdata->log_comment?>
		</td>
	<?php else:?>
		<td>-</td>
		<td>-</td>
		<td>-</td>
	<?php endif;?>
	
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>


<?php $this->load->view('footer.php'); ?>




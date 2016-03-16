<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if($action == 'input_form'):?>
<span id="relation_id_<?=$rel_id?>">
	<form id="save_form_<?=$rel_id?>" name="save_form_<?=$rel_id?>">
	<input type="hidden" name="outcome_id" value="<?=$oid?>">
	
	<?php echo form_dropdown('injections_id', $injections_data,'1','id="injections_id_'.$rel_id.'"');?>
	
				
	</form>
	
<a href="#" onclick="delete_relation('<?=$rel_id?>')">Cancel</a> &nbsp; <a href="#" onclick="save_relation('<?=$rel_id?>'); return false;">Save</a>	
	
</span>
<?php endif;?>

<?php if($action == 'load_data'):?>


<table>
<tr><td>Labeling outcome</td><td>Involved injections</td></tr>

	<?php foreach($outcomes_data->result() as $odata): ?>
				
		<tr>
			<td>
				<strong><?=$odata->outcome_id?>_<?=$outcome_type[$odata->outcome_type]?></strong>
				- This outcome has <?=$labeled_number[$odata->outcome_id]?> total labeled sites 
				<a href="#" id="labeled_sites_show_button_<?=$odata->outcome_id?>" onclick="show_labeled('<?=$odata->outcome_id?>')">Show</a>
				<a style="display:none;" href="#" id="labeled_sites_hide_button_<?=$odata->outcome_id?>" onclick="hide_labeled('<?=$odata->outcome_id?>')">Hide</a>
				<br/><br/>
				<span style="display:none;" id="labeled_sites_<?=$odata->outcome_id?>">
				<?php foreach($labeled_data[$odata->outcome_id]->result() as $ldata): ?>
					<?=$ldata->brain_sites_index?>-<?=$ldata->acronym_full_name?><br/> 
				<?php endforeach; ?>
				</span>
			</td>
			
			<td id="outcome_injections_column_<?=$odata->outcome_id?>">
			<a href="#" onclick="add_relation('<?=$odata->outcome_id?>'); return false;">Add injection to outcome</a><br/>
				<?php foreach($rel_data[$odata->outcome_id]->result() as $rdata): ?>
					<span id="relation_id_<?=$rdata->relation_id?>"><?=$rdata->brain_sites_index?>-<?=$rdata->acronym_full_name?>-<?=$rdata->tracers_name?>  <a href="#" onclick="delete_relation('<?=$rdata->relation_id?>')">Delete</a><br/></span>
				<?php endforeach; ?>
				
			</td>
		</tr>
				
	<?php endforeach; ?>


</table>


<?php endif;?>

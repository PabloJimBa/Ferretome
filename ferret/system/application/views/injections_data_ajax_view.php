<?php if($action == 'output_data'):?>

	<?php foreach($block_data->result() as $bdata): ?>
		<span id="data_<?=$bdata->data_id?>">
			<?=$bdata->parameters_name?>: <?=$bdata->parameters_value?> <br>
			<strong>was defined in:</strong><span title="<?=$bdata->literature_title?>"> <?=substr($bdata->literature_title, 0,50)?>...<?=$bdata->literature_index?></span><br>
			<a href="#" onclick="del_data('<?=$bdata->data_id?>')">Delete</a><br/>
		</span> 
	<?php endforeach; ?>

<?php endif;?>

<?php if($action == 'output_data_form'):?>

<span id="data_<?=$data_id?>">
<br/>
<br/>
<form id="data_form_<?=$data_id?>">
<table>
<tr><td>
<input type="hidden" name="data_id" value="<?=$data_id?>"/>
<input type="hidden" name="literature_id" id="literature_id_<?=$data_id?>" value="<?=$literature_id?>"/>
Specify parameter</td><td><?php echo form_dropdown('parameters_id', $parameters, '1', 'id="parameters_id" onchange="change_input(); return false;"');?>  &nbsp; <a href="#" onclick="show_description(); return false;">Show description</a><div id="popup_block" style="display:none;"></div></td></tr>
<tr><td>Specify value</td><td><input type="text" id="parameters_value" name="parameters_value" value=""/><br/></td></tr>
<tr><td>Source of data</td><td><span id="selected_source_parameter_<?=$data_id?>" title="<?=$fullltitle?>"><?=$ltitle?></span> <a href="#" onclick="specify_literature('<?=$data_id?>')">Select another paper</a></td></tr>
<tr><td><a href="#" onclick="del_data('<?=$data_id?>')">Cancel</a></td><td><a href="#" onclick="save_data('<?=$data_id?>')">Save data</a></td></tr>

</table>
</form>

</span>



<?php endif;?>



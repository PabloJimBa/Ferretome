<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<div id="parameter_<?=$param?>">	
	<form id="layer_<?=$layer?>_parameter_<?=$param?>" >
	<table>
	<tr>
		<td>
			<input type="hidden" name="architecture_id" value="<?=$param?>"/>
			<input type="hidden" name="brain_sites_id" value="<?=$bsite?>"/>
			<input type="hidden" name="layer_number" value="<?=$layer?>"/>
			<input type="hidden" name="literature_id" id="literature_id_<?=$param?>" value="<?=$lid?>"/>
			Select parameter
		</td>
		<td>
			<?php echo form_dropdown('parameters_id', $arc_param, '1', 'id="parameters_id" onchange="change_input(); return false;"');?> &nbsp; <a href="#" onclick="show_description(); return false;">Show description</a><div id="popup_block" style="display:none;"></div>
		</td>
	</tr>
	<tr>
		<td>
			Specify value
		</td>
			
		<td id="parameters_value_block">
		<input type="text" id="parameters_value" name="parameters_value" value=""/>
		</td>
	</tr>
	
	<tr>
		<td>
			Architecture PDC
		</td>
			
		<td>
		 <?php echo form_dropdown('architecture_pdc',$pdc_options, '1', 'id="architecture_pdc"');?> &nbsp; <a href="#" onclick="show_coding_rules('arch_pdc'); return false;">Coding rules</a>
		</td>
	</tr>
	
	
	<tr>
		<td>
		Selected source of data
		</td>
		<td>
		<span id="selected_source_parameter_<?=$param?>" title="<?=$fullltitle?>"><?=$ltitle?></span>
		<br/><a href="#" onclick="specify_literature('<?=$param?>')">Select another paper</a>
		
		</td>
	</tr>
	
	<tr>
		<td>
			<a href="#" onclick="remove_parameter('<?=$param?>')">Cancel</a>
		</td>
		<td>
			<a href="#" onclick="save_parameter('<?=$param?>','<?=$layer?>')">Save parameter</a>
		</td>
	</tr>
		
	</table>
	 </form>
</div>

<?php if($action == 'load'):?>

<div id="edit_inj_block">


<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>



<?php if(isset($inj_data)):?>


<table>

	
	<?php foreach($inj_data as $idata):?>
	
	
	
		<tr>
		
			<td>Mehtod of injection</td>
			<td>
				<table>
				<tr><td>Tracer</td><td><?=$method_data[$idata->injections_id]->tracers_name?></td></tr>
				<tr><td>Reference Text</td><td><?=$method_data[$idata->injections_id]->reference_text?></td></tr>
				<tr><td>Reference Figures</td><td><?=$method_data[$idata->injections_id]->reference_figures?></td></tr>
				<tr><td>Bilateral use</td><td><?=$method_data[$idata->injections_id]->bilateral_use?></td></tr>
				<tr><td>Injection method</td><td><?=$method_data[$idata->injections_id]->injection_method?></td></tr>
				<tr><td>Survival time</td><td><?=$method_data[$idata->injections_id]->survival_time?></td></tr>
				<tr><td>Thikness</td><td><?=$method_data[$idata->injections_id]->thickness?></td></tr>
				</table>
			
			
			 </td>
			
		
		</tr>
		
		
		
		
		<?php foreach($fields as $field): ?>


			<?php if (($field->primary_key == 1)  OR ($field->name == 'PDC_laminae') OR ($field->name == 'methods_id') OR ($field->name == 'PDC_site')OR ($field->name == 'site_type') OR ($field->name == 'PDC_EC') OR ($field->name == 'EC') OR ($field->name == 'literature_id') OR ($field->name == 'brain_sites_id') OR ($field->name == 'injections_index')) continue; ?>
	
			<tr>
				<td><?php $f=$field->name; $fn = explode("_", $f); echo $fn[1];?></td>
				<td><?php  echo form_prep($idata->$f); ?></td>
				
			</tr>
		
		<?php endforeach; ?>

		
		
		

		

		<tr>
		
			<td>Injected Brain site</td>
			<td><?=$bsite_data[$idata->injections_id]->brain_sites_index?> - <?=$bsite_data[$idata->injections_id]->brain_site_acronyms_acronymFullName?> </td>
		
		</tr>
		
			<tr>
		
			<td>Labelled Brain sites</td>
			<td>
				<?php foreach($bsite_data_labelled[$idata->injections_id]->result() as $blab): ?>
			
					<span id="labelled_brain_site_short_<?=$blab->labelled_sites_id?>"><a href="#" onclick="show_labelled_brain_site('<?=$blab->labelled_sites_id?>'); return false;"><?=$blab->bsindex?></a> - <?=$blab->acr_fname?><br/></span>
					<span id="labelled_brain_site_full_<?=$blab->labelled_sites_id?>"></span>
				<?php endforeach; ?>		 
			
			</td>
		
		</tr>
	
	
	
	
	<?php endforeach;?>



</table>


<?php endif;?>

</div>


<?php endif;?>
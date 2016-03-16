<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>


<?php if($action == 'load'):?>
<!-- ///////////////// _load_ /////////////// -->



<div id="bmaps_block">



<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>



<?php if(isset($labelled_bsite_data)):?>




<table>
	<tr> <td>Full name of brain site</td> <td><?=$labelled_bsite_data->acr_name?> - <?=$labelled_bsite_data->acr_fname?> <a href="#" onclick="hide_labelled_brain_site('<?=$labelled_bsite_data->labelled_sites_id?>'); return false;">Hide</a></td></tr>
	<tr><td>Validity of info</td><td><?=$labelled_bsite_data->extension_codes_name?> - <?=$labelled_bsite_data->extension_codes_desc?></td></tr>
	<tr><td>Density of label</td><td><?=$dens_options[$labelled_bsite_data->labelled_sites_density]?></td></tr>
	<tr><td>Total Labelled Neurons Number</td><td><?=$labelled_bsite_data->labelled_sites_totalNeuronsNumber?> </td></tr>
	<tr><td>Percent of Neurons labelled</td><td><?=$labelled_bsite_data->labelled_sites_percentNeuronLabel?></td></tr>
	
</table>


			
			
		

<?php endif;?>


</div>

<?php endif;?>


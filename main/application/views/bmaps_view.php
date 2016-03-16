<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>


<?php if($action == 'load'):?>
<!-- ///////////////// _load_ /////////////// -->



<div id="bmaps_block">



<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>



<?php if(isset($block_data)):?>

<table>
	<tr>
		<td>Brain map short description</td>
		<td><?php  echo form_prep($block_data->brain_maps_index); ?></td>
	
	</tr>
	
	<tr>
		<td>Brain map type</td>
		<td><?php  echo form_prep($block_data->brain_maps_type); ?></td>
	
	</tr>
	
	<tr>
		<td>Mapped Brain sites</td>
		<td>
		
			<?php foreach($bsite_data->result() as $blab): ?>
			
				<span id="mapped_brain_site_short_<?=$blab->bsid?>"><a href="#" onclick="show_mapped_brain_site('<?=$blab->bsid?>'); return false;"><?=$blab->bsindex?></a> - <?=$blab->acr_fname?><br/></span>
				<span id="mapped_brain_site_full_<?=$blab->bsid?>"></span>
					
			<?php endforeach; ?>
		
		</td>
	
	</tr>
	
	
	
	
</table>


<?php endif;?>


</div>

<?php endif;?>


<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>


<?php if($action == 'load'):?>
<!-- ///////////////// _load_ /////////////// -->



<div id="bmaps_block">



<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>



<?php if(isset($bsite_data)):?>


<a href="#" onclick="hide_mapped_brain_site('<?=$bsite_data->bsid?>'); return false;">Hide</a>

<table>
	<tr> <td>Full name of brain site</td> <td><?=$bsite_data->acr_name?> - <?=$bsite_data->acr_fname?></td></tr>
	<tr> <td>Known architeture</td>
	 <td>
	 <?php if(isset($bsite_architecture_data)):?>
	 <table>
	 	<?php foreach($bsite_architecture_data as $layer => $val): ?>
	 		<tr><td> Layer <strong><?=$layer?></strong></td>
	 			<td>
		 			<?php foreach($val as $ar): ?>
		 			<?=$ar?>
		 			<?php endforeach; ?>
		 		</td>
			</tr>	
		<?php endforeach; ?>
	 </table>	
	 <?php endif;?>
	 
	 <?php if(!isset($bsite_architecture_data)):?>
	 No architecture was defined yet
	 <?php endif;?>
		
	 </td>
	</tr>
	
</table>


			
			
		

<?php endif;?>


</div>

<?php endif;?>


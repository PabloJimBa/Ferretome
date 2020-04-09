<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if(isset($output_data)):?>

<table>
	<tr>
		<?php foreach($fields_data as $field => $val): ?> <!-- Print table titles -->
	
			<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td> <!-- Change every "_" to " " and also make the first letter uppercase -->
					
		<?php endforeach; ?>
		<td></td>
	</tr>
			
	<?php foreach($output_data->result() as $bdata): ?>
	<tr>
	
		<?php foreach($fields_data as $field => $val): ?> <!-- Print table data -->
			<td>
			<?php if($val['type']=='array'):?>
				
				<?=$val['array_data'][$bdata->$val['real_name']]?>
				
			<?php endif;?>
					
			<?php if($val['type']=='string'):?>
		
				<?=$bdata->$val['real_name']?>
				
			<?php endif;?>
			
			
			<?php if($val['type']=='replace'):?>
		
				<?php $f=$val['real_name']; echo str_replace('{'.$f.'}', $bdata->$f, $val['replace_data']);?>
				<td><a href="index.php?c=literature&m=confirm&id=<?=$bdata->$f?>)">delete</a></td>
				
			<?php endif;?>

			</td>
			
		<?php endforeach;?>

	</tr>

	<?php endforeach; ?>

</table>

<?php endif;?>

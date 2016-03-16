<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if(isset($output_data)):?>

<table>

<?php foreach($fields_data as $field => $val): ?>
	<tr>
	
			<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; }; $f=$val['real_name'];?></td>
	
			<td>
			
			<?php if($val['type']=='string'):?>
		
				<?=$output_data->$f?>
				
			<?php endif;?>
			
			<?php if($val['type']=='array'):?>
		
				<?=$val['array_data'][$output_data->$f]?>
				
			<?php endif;?>
						
			<?php if($val['type']=='replace'):?>
		
				<?php echo str_replace('{'.$f.'}', $output_data->$f, $val['replace_data']);?>
				
			<?php endif;?>
			</td>
	</tr>
<?php endforeach;?>

</table>

<?php endif;?>
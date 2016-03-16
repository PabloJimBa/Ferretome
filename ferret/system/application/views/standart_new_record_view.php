<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if(isset($output_data)):?>

<table>

<?php foreach($fields_data as $field => $val): ?>
	<tr>
	
			<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; }; $f=$val['real_name'];?></td>
	
			<td>
			
			<?php if($val['type']=='string'):?>
		
				
				<input class="input" id="<?php echo $f; ?>" name="<?php echo $f; ?>" value="<?php if (!empty($output_data[$f])) echo form_prep($output_data[$f]); ?>" size="30" />
				
			<?php endif;?>
			
			<?php if($val['type']=='text'):?>

				<textarea class="textarea" id="<?php echo $f; ?>" name="<?php echo $f; ?>" cols="30" rows="10" ><?php if (!empty($output_data[$f])) echo form_prep($output_data[$f]); ?></textarea>
				
			<?php endif;?>
		
			
			<?php if($val['type']=='array'):?>
		
				<?=$val['array_data'][$output_data[$f]]?>
				
			<?php endif;?>
						
			<?php if($val['type']=='replace'):?>
		
				<?php if (!empty($output_data[$f])) echo str_replace('{'.$f.'}', $output_data[$f], $val['replace_data']);?>
				
			<?php endif;?>
			
			<?php if($val['type']=='complex_replace'):?>
			
				<?php $this->load->view($val['type'],$output_data);  ?>
				
			<?php endif;?>
			
			
			</td>
	</tr>
<?php endforeach;?>

</table>

<?php endif;?>
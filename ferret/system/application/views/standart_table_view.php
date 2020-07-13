<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if(isset($output_data)):?>

<table>
	<tr>
		<td style='background-color:#040E7A;color:white'>Authors</td>
		<td style='background-color:#040E7A;color:white'>
			Title
			<a style='color:white' href="index.php?c=literature&m=standart_table_view" onclick="title_asc_f('literature_title','asc'); return false;" title="Click here to order by title">a..z</a>
			<a style='color:white' href="index.php?c=literature&m=viewAll" onclick="title_desc_f('literature_title','desc'); return false;" title="Click here to order by title">z..a</a>
		
		</td>
		<td style='background-color:#040E7A;color:white'>
			Year
			<a style='color:white' href="index.php?c=literature&m=viewAll" onclick="year_asc_f('literature_year','asc'); return false;" title="Click here to order by year">1..9</a>
			<a style='color:white' href="index.php?c=literature&m=viewAll" onclick="year_desc_f('literature_year','desc'); return false;" title="Click here to order by year">9..1</a>
		</td>
		<td style='background-color:#040E7A;color:white'>
			Source
			<a style='color:white' href="index.php?c=literature&m=viewAll" onclick="source_asc_f('abbreviations_full','asc'); return false;" title="Click here to order by source">a..z</a>
			<a style='color:white' href="index.php?c=literature&m=viewAll" onclick="source_desc_f('abbreviations_full','desc'); return false;" title="Click here to order by source">z..a</a>

		</td>
		<td style='background-color:#040E7A;color:white'>Actions</td>
		<td style='background-color:#040E7A;color:white'></td>
	</tr>
	
	<!-- Normal data -->
	<div id="year_asc">		
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
	</div>

	

<?php endif;?>

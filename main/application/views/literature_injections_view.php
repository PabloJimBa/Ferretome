<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

	<table>
		
			<?php foreach ($inj_data->result() as $idata): ?>
		<tr>
				<td><?=$idata->methods_id?></td>
				<td><?=$idata->literature_id?></td>
		</tr>
			<?php endforeach;?>

	</table>

<?php endif;?>

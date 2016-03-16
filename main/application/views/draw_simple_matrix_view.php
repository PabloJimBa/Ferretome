<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
	<tr>
		<td>
		</td>
		<?php foreach ($matrix as $key => $val):?>
		<td>
		<?=$key?>
		</td>
		<?php endforeach;?>
	</tr>
	<?php foreach ($matrix as $key => $val):?>
	<tr>
		<td >
		<?=$key?>
		</td>
		<?php foreach ($val as $val2):?>
		<td>
		<?=$val2?>
		</td>
		<?php endforeach;?>
	</tr>
	<?php endforeach;?>
</table>






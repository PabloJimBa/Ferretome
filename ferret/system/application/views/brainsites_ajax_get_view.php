<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Brain site</td> <td>Full name</td> <!--<td>Class</td> -->  <td>type</td><td></td> </tr>

	<?php foreach ($lit_data->result() as $ldata): ?>
<tr>
	<td><?=$ldata->brain_sites_index?></td>
	<td><?=$ldata->acronym_full_name?></td>
	
	<td><?=$type_options[$ldata->brain_sites_type]?></td>
	
	<td><a target="_blank" href="index.php?c=brainsites&m=edit&id=<?=$ldata->brain_sites_id?>">details</a></td>
</tr>
	<?php endforeach;?>

</table>

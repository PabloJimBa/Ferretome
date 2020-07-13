<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Brain site A</td> <td>Relation Code</td> <td>Brain site B</td> <td>PDC Relaction</td> <td></td> </tr>

	<?php foreach ($mr_data->result() as $ldata): ?>
<tr>
	<td><?=$ldata->bsinda?></td> 
	<td><?=$rel_options[$ldata->maps_relations_code]?></td> 
	<td><?=$ldata->bsindb?></td>
	<td><?=$pdc_options[$ldata->PDC_RELATION]?></td> 
	<td><a target="_blank" href="index.php?c=mapsrelations&m=edit&id=<?=$ldata->maps_relations_id?>">details</a></td>
</tr>
	<?php endforeach;?>

</table>

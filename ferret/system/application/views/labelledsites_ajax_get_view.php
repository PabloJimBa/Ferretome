<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Brain site</td> <td>Extension Code</td> <td>PDC EC</td> <td>PDC Density</td> <td>Number labelled neurons</td> <td>Number neurons %</td> <td></td> </tr>

	<?php foreach ($lit_data->result() as $ldata): ?>
<tr>
	<td><?=$ldata->bsindex?></td> 
	<td><?=$ec_options[$ldata->EC]?></td> 
	<td><?=$pdc_options[$ldata->PDC_EC]?></td>
	<td><?=$pdc_options[$ldata->PDC_DENSITY]?></td> 
	<td><?=$ldata->total_neurons_number?></td>
	<td><?=$ldata->percent_neurons_labeled?></td>
	<td><a target="_blank" href="index.php?c=labelledsites&m=edit&id=<?=$ldata->labelled_sites_id?>">details</a></td>
</tr>
	<?php endforeach;?>

</table>

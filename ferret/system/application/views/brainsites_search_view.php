<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Brain site</td> <td>Brain map</td><td></td></tr>
<tr><td><?=$bs_data->brain_sites_index?></td><td><?=$bs_data->brain_maps_id?></td>

<td><a target="_blank" href="index.php?c=brainsites&m=edit&id=<?=$bs_data->brain_sites_id?>">details</a> &nbsp; | &nbsp; <a href="index.php?c=brainsites&m=confirm&id=<?=$bs_data->brain_sites_id?>">delete</a></td>

</tr>
</table>


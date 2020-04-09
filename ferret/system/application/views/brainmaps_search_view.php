<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Brain Map</td> <td>Literature</td><td></td></tr>
<tr><td><?=$map_data->brain_maps_index?></td> <td><?=$map_data->literature_id?></td>

<td><a target="_blank" href="index.php?c=brainmaps&m=edit&id=<?=$map_data->brain_maps_id?>">details</a> &nbsp; | &nbsp; <a href="index.php?c=brainmaps&m=confirm&id=<?=$map_data->brain_maps_id?>">delete</a></td>

</tr>
</table>



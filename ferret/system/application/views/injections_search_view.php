<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Injection</td> <td>Injection method</td><td>Brain site</td><td></td></tr>
<tr><td><?=$inj_data->injections_index?></td><td><?=$inj_data->methods_id?></td><td><?=$inj_data->brain_sites_id?></td>

<td><a target="_blank" href="index.php?c=injections&m=edit&id=<?=$inj_data->injections_id?>">details</a> &nbsp; | &nbsp; <a href="index.php?c=injections&m=confirm&id=<?=$inj_data->injections_id?>">delete</a></td>

</tr>
</table>


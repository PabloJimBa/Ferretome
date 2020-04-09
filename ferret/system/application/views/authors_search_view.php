<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Author Surname</td> <td>Author Name</td> <td>Author Middlename</td><td></td></tr>
<tr><td><?=$auth_data->authors_surname?></td> <td><?=$auth_data->authors_name?></td> <td><?=$auth_data->authors_middleName?></td>

<td><a target="_blank" href="index.php?c=authors&m=edit&id=<?=$auth_data->authors_id?>">details</a> &nbsp; | &nbsp; <a href="index.php?c=authors&m=confirm&id=<?=$auth_data->authors_id?>">delete</a></td>

</tr>
</table>

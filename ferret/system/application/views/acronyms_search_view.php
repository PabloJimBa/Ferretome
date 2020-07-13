<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<table>
<tr><td>Acronym shortname</td> <td>Acronym fullname</td> <td></td></tr>
<tr><td><?=$acr_data->acronym_name?></td> <td><?=$acr_data->acronym_full_name?></td> 

<td><a href="index.php?c=acronyms&m=edit&id=<?=$acr_data->brain_site_acronyms_id?>">details</a> &nbsp; | &nbsp; <a href="index.php?c=acronyms&m=confirm&id=<?=$acr_data->brain_site_acronyms_id?>">delete</a></td>

</tr>
</table>


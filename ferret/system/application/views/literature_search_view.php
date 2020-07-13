<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php if(isset($search_title)):?>
<p><?=$search_title?>
<?php endif; ?>
<table>
<tr><td>Authors</td> <td>Title</td> <td>Year</td> <td>Source</td><td></td><td></td></tr>


<?php foreach ($lit_data as $sldata): ?>
	<?php foreach ($sldata->result() as $ldata): ?>
<tr>
	<td>
	<?php if (isset($auth_data)):?>
		<?php foreach ($auth_data[$ldata->literature_id]->result() as $adata): ?>
			<a href="#" onclick="search_by_author('<?=$adata->authors_id?>')"><?=$adata->authors_surname?></a>  <?=$adata->authors_name?>  <?=$adata->authors_middleName?><br/>
		<?php endforeach;?>
	<?php endif; ?>
	</td> 
	<td><?=$ldata->literature_title?></td> <td><?=$ldata->literature_year?></td> 
	<td><?=$ldata->abbreviations_short?> - <?=$ldata->abbreviations_full?></td>
	<td><a href="index.php?c=literature&m=edit&id=<?=$ldata->literature_id?>">details</a></td> <td><a href="index.php?c=literature&m=confirm&id=<?=$ldata->literature_id?>">delete</a></td>
</tr>
	<?php endforeach;?>
<?php endforeach;?>


</table>
















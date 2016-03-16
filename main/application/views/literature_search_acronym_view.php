<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<br>
<p>Results for brain sites</p>
<table>
<tr>
	<td>Brain site</td>
	<td>
		Found in 
	</td>
	<td>
		Year
	</td>
	<td>
		Source
	</td>
	<td>Actions</td>
</tr>

<?php foreach ($liter_data as $sldata): ?>
	<?php foreach ($sldata->result() as $ldata): ?>
<tr>
	<td>
	<?=$ldata->acronym_name?> - <?=$ldata->acronym_full_name?>	
	</td> 
	<td><?=$ldata->literature_title?></td> 
	<td><?=$ldata->literature_year?></td> 
	<td><?=$ldata->abbreviations_full?></td>
	<td><a href="index.php?c=literature&m=view&id=<?=$ldata->literature_id?>">Details</a></td>
</tr>
	<?php endforeach;?>
<?php endforeach;?>
</table>
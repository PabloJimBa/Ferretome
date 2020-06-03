<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
	<br>
	<p>Results for literature</p>
	<table>
	<tr>
		<td>Authors</td>
		<td>
			Title
			<a href="#" onclick="change_order('literature_title','asc'); return false;" title="Click here to order by title">a..z</a>
			<a href="#" onclick="change_order('literature_title','desc'); return false;" title="Click here to order by title">z..a</a>
		
		</td>
		<td>
			Year
			<a href="#" onclick="change_order('literature_year','asc'); return false;" title="Click here to order by year">1..9</a>
			<a href="#" onclick="change_order('literature_year','desc'); return false;" title="Click here to order by year">9..1</a>
		</td>
		<td>
			Source
			<a href="#" onclick="change_order('abbreviations_full','asc'); return false;" title="Click here to order by source">a..z</a>
			<a href="#" onclick="change_order('abbreviations_full','desc'); return false;" title="Click here to order by source">z..a</a>

		</td>
		<td>Actions</td>
	</tr>

	<?php foreach ($lit_data as $sldata): ?>
		<?php foreach ($sldata->result() as $ldata): ?>
		<tr>
			<td>
				<?php foreach ($auth_data[$ldata->literature_id]->result() as $adata): ?> 
				<a href="#" title="Show all publications by this author" onclick="search_literature_by_authors_id(<?=$adata->authors_id?>); return false;"><?=$adata->authors_surname?></a> <?=$adata->authors_name?> <?=$adata->authors_middleName?><br/>
				<?php endforeach;?>
			</td> 
			<td><?=$ldata->literature_title?></td> 
			<td><a href="#" title="Show all publications in this year" onclick="search_by(<?=$ldata->literature_year?>,'year'); return false;"><?=$ldata->literature_year?></a></td> 
			<td><a href="#" title="Show all publications in this journal" onclick="search_by(<?=$ldata->literature_source?>,'journal'); return false;"><?=$ldata->abbreviations_full?></a></td>
			<td><a href="index.php?c=literature&m=view_index&id=<?=$ldata->literature_id?>">Details</a></td>
		</tr>
		<?php endforeach;?>
	<?php endforeach;?>
	</table>

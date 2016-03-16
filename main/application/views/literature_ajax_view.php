<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>


<?php if($action == 'view'):?>
<!-- ///////////////// _view_ /////////////// -->



<div id="literature_block">



<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>



<?php if(isset($lit_data)):?>



<table border="0" cellpadding="3" cellspacing="1">
<tr cellspacing>
	<td colspan="1">
	<p><strong>Literature details:</strong></p>
	</td>
	<td align="right">
	<span><a href="#" onclick="hide_literature_details(); return false;">Hide</a></span>
	</td>

</tr>
<tr>
	<td>Authors list:</td>
	<td id="auth_list">
	<?php $i=1; foreach ($auth_data->result() as $adata):?>	
	<span id="<?=$adata->authors_id?>"><?=$adata->authors_surname?> <?=$adata->authors_name?> <?=$adata->authors_middleName?> <br/></span>
	<?php endforeach; ?>
	</td>
	
</tr>


<?php foreach($fields as $field): ?>

<?php if (($field->primary_key == 1) OR ($field->name == 'literature_physicalCopy') OR ($field->name == 'literature_tracingData') OR ($field->name == 'literature_mappingData') OR ($field->name == 'literature_index') ) continue; ?>
<tr>
	<td><?php $f=$field->name; $fn = explode("_", $f); echo $fn[1];?></td>
	<td><?php  echo form_prep($lit_data->$f); ?></td>
	
	
</tr>
<?php endforeach; ?>

<tr>
	<td>Mapping data</td>
	<td>
		<?php if(isset($bmaps_data)):?>
		<div id="literature_bmap_block"><a href="#" onclick="show_bmaps(<?=$lit_data->literature_id?>); return false;">Show brain maps for this Literature</a></div>
		<div id="literature_bmap_block_output" style="display:none"></div>
		<?php else:?>
		<p>This Literature has no mapping data</p>
		<?php endif;?>
	</td>
</tr>

</table>





<h3>Injections data:</h3>

<?php if(isset($inj_data)):?>
<div id="literature_injections_block"><a href="#" onclick="show_injections(<?=$lit_data->literature_id?>); return false;">Show injections for this Literature</a></div>
<div id="literature_injections_block_output" style="display:none"></div>
<?php else:?>
<p>This Literature has no experimental data</p>
<?php endif;?>


</div>



<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_auth', { 
	serviceUrl:'index.php/authors/ajaxAtocomplit', 
	onSelect: function(value, data){
    	auth_id = data;
	}
 });

auth_num = auth_num+<?=$auth_data_numr?>; 

$('frm').onsubmit = function () { return check_form(this);}

//]]>
</script>


		<?php endif;?>




<?php endif;?>

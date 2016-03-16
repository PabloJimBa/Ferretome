<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php  $this->load->view('header');  ?>

<?php if($action == 'index'):?>
<!-- ///////////////// index /////////////// -->



<div id=search_block>

	<form method="post" id="frm" name="frm" action="#">
			
			<span id="title_search_field">
				Simple search using:<strong> Literature title</strong> - <a href="#" id="search_link_2"  onclick="switch_search('authors'); return false;">switch to Authors</a><br/>
				<input title="Please, start to type literature title" type="search" id="autocomplite_1" class="input" placeholder=" Search for publication - type some words from publication title here"/>
			</span>
			
			<span id="authors_search_field" style="display:none">
				Simple search using: <strong>Authors</strong> - <a href="#" id="search_link_1" onclick="switch_search('title'); return false;" >switch to Title</a><br/>
				<input title="Please, start to type a lastname of an author" type="search" id="autocomplite_2" class="input" placeholder="Search for publication - type authors last name here"/>
			</span>
		   	
	<input type="submit" class="submit" value="Go" />
	</form>
</div>

<div id="search_result"></div>


<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_1', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit',
	onSelect: function(value, data){
		search_string = data;
		
		search_do();
		
	} 
	
 });
new Autocomplete('autocomplite_2', { 
	serviceUrl:'index.php/literature/ajaxAtocomplitAuthors',
	onSelect: function(value, data){
		search_string = data;
		
		search_do();
		
	} 
	
 });
 
$('frm').onsubmit = function () { return check_form(this);}
//]]>
</script>

<?php endif;?>





<?php if($action == 'view'):?>
<!-- ///////////////// _view_ /////////////// -->

<div id="literature_block">

<h3>Literature details:</h3>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>


<?php if(isset($lit_data)):?>





<table border="0" cellpadding="3" cellspacing="1">

<tr>
	<td>authors list</td>
	<td id="auth_list">
	<?php foreach ($auth_data->result() as $adata):?>	
	<span id="<?=$adata->authors_id?>"><?=$adata->authors_surname?> <?=$adata->authors_name?> <?=$adata->authors_middleName?> <br/></span>
	<?php endforeach; ?>
	</td>
	
</tr>


<?php foreach($fields as $field): ?>

<tr>
	<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
	
	<td><?php  echo form_prep($lit_data->$field); ?></td>
	
	
</tr>
<?php endforeach; ?>




<?php if(!empty($lit_data->doi_id)):?>

<tr >
	<td>
		DOI web link
	</td>
	<td>
	<a target="_blank" href="http://dx.doi.org/<?=$lit_data->doi_id?>">Click here to open in new window</a>
	</td>	
</tr>


<?php endif;?>

<?php if(!empty($lit_data->pubmed_id)):?>

<tr >
	<td>
		pub med web link
	</td>
	<td>
	<a target="_blank" href="http://www.ncbi.nlm.nih.gov/pubmed/<?=$lit_data->pubmed_id?>">Click here to open in new window</a>
	</td>	
</tr>


<?php endif;?>


</table>

<br/>
<h3>Mapping data:</h3>

<?php if(isset($bmaps_data)):?>

	<table>
	<?php foreach($mfields as $field): ?>
	
	<tr>
		<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
		
		<td><?php  echo form_prep($bmaps_data->$field); ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td>map type</td>
		
		<td><?=$map_types[$bmaps_data->brain_maps_type] ?></td>
	</tr>
	
	<tr>
		<td>defined brain sites</td>
			
		
		<td>
		<?php if(isset($bs_data)):?>
		
		
			<table>
			<tr>
			<?php foreach($bsfields as $field): ?>
	
					<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
					
			<?php endforeach; ?>
			</tr>
			
			<?php foreach($bs_data->result() as $bdata): ?>
				<tr>
	
				<?php foreach($bsfields as $field): ?>
		
					<td><?=$bdata->$field;?></td>
			
				<?php endforeach;?>
						
				</tr>
			<?php endforeach; ?>

			</table>
		<?php else:?>
			<p>this map has no brain sites</p>
		<?php endif;?>
		
		</td>
	</tr>
	</table>


<?php else:?>

<p>This Literature has no mapping data</p>

<?php endif;?>



<h3>Experimental data:</h3>

<?php if(isset($inj_data)):?>
<table>

<?php foreach($inj_data->result() as $idata): ?>

	<?php foreach($injfields as $field): ?>
	<tr>
		<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
		
		<td><?php  echo form_prep($idata->$field); ?></td>
	</tr>
	<?php endforeach; ?>
	
	
	
	<tr>
		<td>site of injection</td>
			
		
		<td>
		<?php if(isset($inj_bs_data[$idata->injections_id])):?>
		
		
			<table>
			<tr>
			<?php foreach($bsfields as $field): ?>
	
					<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
					
			<?php endforeach; ?>
			</tr>
			
			<?php foreach($inj_bs_data[$idata->injections_id]->result() as $bdata): ?>
				<tr>
	
				<?php foreach($bsfields as $field): ?>
		
					<td><?=$bdata->$field;?></td>
			
				<?php endforeach;?>
						
				</tr>
			<?php endforeach; ?>

			</table>
		<?php endif;?>
		</td>
		
	</tr>
	
	
	<tr>
		<td>injection outcomes</td>
			
		
		<td>
		<?php if(isset($inj_out_data[$idata->injections_id])):?>
		
		
			<table>
			
			<?php foreach($inj_out_data[$idata->injections_id]->result() as $outdata): ?>
				<tr>
					<td><?=$outcomes_types[$outdata->outcome_type]?></td>
					<td>
					
					
					<?php if(isset($out_ls_data[$outdata->outcome_id])):?>
		
		
						<table>
						<tr>
						<?php foreach($outlsfields as $field): ?>
				
								<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
								
						<?php endforeach; ?>
						</tr>
						
						<?php foreach($out_ls_data[$outdata->outcome_id]->result() as $bdata): ?>
							<tr>
				
							<?php foreach($outlsfields as $field): ?>
					
								<td><?=$bdata->$field;?></td>
						
							<?php endforeach;?>
									
							</tr>
						<?php endforeach; ?>
			
						</table>
						
					<?php endif;?>
					
					
					
					</td>
				</tr>
					
			<?php endforeach; ?>
			
			</table>
			
		<?php endif;?>
			
		</td>
		
	</tr>
	
	<?php if(isset($mtm_data[$idata->injections_id])):?>
	<tr>
		<td>method of injection</td>
		
		<td>
		
					<?php if(isset($mtm_data[$idata->injections_id])):?>
		
		
						<table>
						<tr>
						<?php foreach($mtmfields as $field): ?>
				
								<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
								
						<?php endforeach; ?>
						</tr>
						
						<?php foreach($mtm_data[$idata->injections_id]->result() as $bdata): ?>
							<tr>
				
							<?php foreach($mtmfields as $field): ?>
					
								<td><?=$bdata->$field;?></td>
						
							<?php endforeach;?>
									
							</tr>
						<?php endforeach; ?>
			
						</table>
						
					<?php endif;?>
		
		
		</td>
		
	
	</tr>
	<?php endif;?>
	
	
	
	<tr><td colspan="2"></tr>

<?php endforeach; ?>


</table>

<?php else:?>

<p>This Literature has no experimental data</p>
<?php endif;?>


</div>
<h3>Maps relation data:</h3>

<?php if(isset($mrm_data)):?>
<table>
			<tr>
			<?php foreach($mrmfields as $field): ?>
	
					<td><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo $fn." "; };?></td>
					
			<?php endforeach; ?>
			</tr>
			
			<?php foreach($mrm_data->result() as $bdata): ?>
				<tr>
	
				<?php foreach($mrmfields as $field): ?>
		
					<td><?=$bdata->$field;?></td>
			
				<?php endforeach;?>
						
				</tr>
			<?php endforeach; ?>


</table>

<?php else:?>

<p>This Literature has no Maps relation data</p>
<?php endif;?>




<?php endif;?>




<?php endif;?>









<?php $this->load->view('footer');
<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

	<!-- Load header -->

	<?php  $this->load->view('header');  ?>


	<!-- Load index -->

	<?php if($action == 'index'):?>

		<div id=search_block>

			<form method="post" id="frm" name="frm" action="#">
			
					<span id="title_search_field">
						Simple search using:<strong> Literature title</strong> - <a href="#" id="search_link_2"  onclick="switch_search('authors'); return false;">switch to Authors</a><br/>
						<input title="Please, start to type literature title" type="search" id="autocomplite_1" class="input" placeholder=" Search for publication - type some words from publication title here"/>

			<input type="submit" class="submit" value="Go" />
					</span>
			
					<span id="authors_search_field" style="display:none">
						Simple search using: <strong>Authors</strong> - <a href="#" id="search_link_1" onclick="switch_search('title'); return false;" >switch to Title</a><br/>
						<p><input title="Please, start to type a lastname of an author" type="search" id="autocomplite_2" class="input" placeholder="Search for publication - type authors last name here"/></p>
					</span>
	
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



	<!-- Load index view -->

	<?php if($action == 'view_index'):?>

		

		LITERATURE DETAILS &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_map&id=<?=$lit_data->literature_id?>">MAPPING DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_exp&id=<?=$lit_data->literature_id?>">EXPERIMENTAL DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_rel&id=<?=$lit_data->literature_id?>">MAPS RELATION DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=pdf&id=<?=$lit_data->literature_id?>">DOWNLOAD PDF</a>

		<p align='right'><a href="index.php?c=literature">Change literature</a></p>

		<p><a target="_blank" href="../ferret/index.php?c=literature&m=edit&id=<?=$lit_data->literature_id?>">Edit literature details</a></p>

		<h3>Literature details:</h3>

		<?php if(isset($block_message)):?>
			<p><?=$block_message?></p>
		<?php endif;?>

		<div class="magnifiable">
		<?php if(isset($lit_data)):?>


			<table border="1" cellpadding="3" cellspacing="1" >

			<tr>
				<td style='background-color:#040E7A;color:white'>Authors list</td>
				<td id="auth_list">
				<?php foreach ($auth_data->result() as $adata):?>	
					<span id="<?=$adata->authors_id?>"><?=$adata->authors_surname?> <?=$adata->authors_name?> <?=$adata->authors_middleName?> <br/></span>
				<?php endforeach; ?>
				</td>
	
			</tr>
		
			<?php foreach($fields as $field): ?>

				<?php if($field == 'abbreviations_full'):?>
				<tr>

					<td style='background-color:#040E7A;color:white'> Journal </td>
					<td><?php  echo form_prep($lit_data->$field); ?></td>
				</tr>
				<?php endif;?>
			<?php endforeach; ?>
			
			<?php foreach($fields as $field): ?>

				<?php if ($field == 'literature_physicalCopy' or $field == 'abbreviations_full') continue;?> 
				<tr>
					<td style='background-color:#040E7A;color:white'><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
	
					<td><?php  echo form_prep($lit_data->$field); ?></td>
	
				

				</tr>
			
			<?php endforeach; ?>
			
			


			<?php if(!empty($lit_data->doi_id)):?>
			
				<tr >
					<td style='background-color:#040E7A;color:white'>
						DOI web link
					</td>
					<td>
					<a target="_blank" href="http://dx.doi.org/<?=$lit_data->doi_id?>">Click here to open in new window</a>
					</td>	
				</tr>


			<?php endif;?>

			<?php if(!empty($lit_data->pubmed_id)):?>

				<tr >
					<td style='background-color:#040E7A;color:white'>
						PubMed web link
					</td>
					<td>
					<a target="_blank" href="http://www.ncbi.nlm.nih.gov/pubmed/<?=$lit_data->pubmed_id?>">Click here to open in new window</a>
					</td>	
				</tr>


			<?php endif;?>


			</table border="1" cellpadding="3" cellspacing="1">



		<?php endif;?>




	<?php endif;?>


	<!-- Load map view -->

	<?php if($action == 'view_map'):?>

		<?php if(isset($block_message)):?>
			<p><?=$block_message?></p>
		<?php endif;?>

		<a href="index.php?c=literature&m=view_index&id=<?=$bmaps_data->literature_id?>">LITERATURE DETAILS</a> &nbsp; | &nbsp;
		MAPPING DATA &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_exp&id=<?=$bmaps_data->literature_id?>">EXPERIMENTAL DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_rel&id=<?=$bmaps_data->literature_id?>">MAPS RELATION DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=pdf&id=<?=$bmaps_data->literature_id?>">DOWNLOAD PDF</a>

		<p align='right'><a href="index.php?c=literature">Change literature</a></p>

		<h3>Mapping data:</h3>

		<p><a target="_blank" href="../ferret/index.php?c=brainmaps&m=edit&id=<?=$bmaps_data->literature_id?>">Edit brain map</a> &nbsp; | &nbsp; <a target="_blank" href="../ferret/index.php?c=brainmaps&m=add">Add brain map</a></p>

		<div class="magnifiable">
		<?php if(isset($bmaps_data)):?>

			<table border="1" cellpadding="3" cellspacing="1">

			<?php foreach($mfields as $field): ?>
	
				<tr>
					<td style='background-color:#040E7A;color:white'><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
		
					<td><?php  echo form_prep($bmaps_data->$field); ?></td>
				</tr>
			<?php endforeach; ?>
				<tr>
					<td style='background-color:#040E7A;color:white'>Map type</td>
		
					<td><?=$map_types[$bmaps_data->brain_maps_type] ?></td>
				</tr>
			</table>
		</div>
			<br>
		<div class="magnifiable">
			<table border="1" cellpadding="3" cellspacing="1">
				<tr>
					<td align='center' style='background-color:#040E7A;color:white'>Defined brain sites</td>
			
		
					</td>
				</tr>
				<tr>
					<?php if(isset($bs_data)):?>
		
		
						<table border="1" cellpadding="3" cellspacing="1">
						<tr>
						<?php foreach($bsfields as $field): ?>
	
							<td align='center' style='background-color:#040E7A;color:white'><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
					
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
		</div>

		<?php else:?>
	
		<p>This Literature has no mapping data</p>

		<?php endif;?>

	<?php endif;?>



	<!-- Load experimental view -->
	<?php if($action == 'view_exp'):?>



		<?php if(isset($block_message)):?>
			<p><?=$block_message?></p>
		<?php endif;?>

		<a href="index.php?c=literature&m=view_index&id=<?=$literature_id?>">LITERATURE DETAILS</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_map&id=<?=$literature_id?>">MAPPING DATA</a> &nbsp; | &nbsp;
		EXPERIMENTAL DATA &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_rel&id=<?=$literature_id?>">MAPS RELATION DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=pdf&id=<?=$literature_id?>">DOWNLOAD PDF</a>

		<p align='right'><a href="index.php?c=literature">Change literature</a></p>

		<h3>Experimental data:</h3>

		<p><a target="_blank" href="../ferret/index.php?c=injections&m=add">Add injection data</a></p>

		<p>* Click on individual boxes to expand/collapse data</p>

		<?php if(isset($inj_data)):?>
		
		
		<?php foreach($inj_data->result() as $idata): ?>
			<table style='background-color:#fff' border="1" cellpadding="3" cellspacing="1">
			<?php foreach($injfields as $field): ?>
			<tr>
				
				
				<?php if ($field == 'injections_index'):?>
					
					<td style='background-color:#040E7A;color:white'><?php echo ($idata->$field) ;?></td><td style='background-color:#040E7A'></td>
					<?php $num = $idata->$field ;?>
					

					<tr>
						<td><div style='color:#040E7A' id="inj_data_<?=$idata->$field?>" onclick="show_table('data_table_<?=$idata->$field?>','inj_data_<?=$idata->$field?>','data_row')"><strong>Injection data</strong></div></td>
						<td>
		<div class="magnifiable">
		
					<table border="1" cellpadding="3" cellspacing="1" id="data_table_<?=$idata->$field?>" style="background-color:#fff;display:none;">

				<?php endif;?>
			</tr>
			
			<?php endforeach; ?>
			

			
			<?php foreach($injfields as $field): ?>

				<?php if ($field == 'injections_index') continue;?>
					<tr>
					
					<td style='background-color:#E7E7E7;color:#000' id="data_row_<?=$idata->$field?>"><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
		
					<td><?php  echo form_prep($idata->$field); ?></td>
					
					</tr>
				
			
			<?php endforeach; ?>
					<td></td><td><a target="_blank" href="../ferret/index.php?c=injections&m=edit&id=<?=$idata->injections_id?>">Edit injection data</a></td>
					</table>
					
				</td>
			</tr>
		</div>
			<tr>
				
				<?php if(isset($inj_bs_data[$idata->injections_id])):?>
					<td><div style='color:#040E7A' id="site_data_<?=$num?>" onclick="show_table('site_table_<?=$num?>','inj_site_<?=$num?>','site_row')"><strong>Site of injection</strong></div></td>
			
		
					<td>
		<div class="magnifiable">
					<table border="1" cellpadding="3" cellspacing="1" id="site_table_<?=$num?>" style="background-color:#fff;display:none;">

					<tr>
					<?php foreach($bsfields as $field): ?>
	
							<td style='background-color:#E7E7E7;color:#000' id="site_row_<?=$num?>"><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
					
					<?php endforeach; ?>
					</tr>
			
					<?php foreach($inj_bs_data[$idata->injections_id]->result() as $bdata): ?>
						<tr>
	
						<?php foreach($bsfields as $field): ?>
		
							<td><?=$bdata->$field;?></td>
							
						<?php endforeach;?>
						</tr>
					<?php endforeach; ?>
					<td><p><a target="_blank" href="../ferret/index.php?c=injections&m=edit&id=<?=$idata->injections_id?>">Edit site of injection</a></p></td><td></td><td></td>
					</table>
					</td>
				<?php endif;?>
				
		
			</tr>
		</div>
	
			<tr>
				<td><div style='color:#040E7A' id="inj_out_<?=$num?>" onclick="show_table('out_table_<?=$num?>','inj_out_<?=$num?>','out_row')"><strong>Injection outcomes</strong></div></td>
				
			
		
				<td>
				<a target="_blank" href="../ferret/index.php?c=labelingoutcome&m=add">Add labeling outcome</a>
				<?php if(isset($inj_out_data[$idata->injections_id])):?>
		
					<div class="magnifiable">
					<table border="1" cellpadding="3" cellspacing="1" id="out_table_<?=$num?>" style="background-color:#fff;display:none;">
			
					<?php foreach($inj_out_data[$idata->injections_id]->result() as $outdata): ?>
						<tr>
							<td style='background-color:#E7E7E7;color:#000' id="out_row_<?=$num?>"><?=$outcomes_types[$outdata->outcome_type]?></td>
							
					
							<td>
							<?php if(isset($out_ls_data[$outdata->outcome_id])):?>
		
		
								<table style='background-color:#fff' border="1" cellpadding="3" cellspacing="1">
								<tr>
								<?php foreach($outlsfields as $field): ?>
				
										<td style='background-color:#E7E7E7;color:#000'><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
								
								<?php endforeach; ?>
								</tr>
						
								<?php foreach($out_ls_data[$outdata->outcome_id]->result() as $bdata): ?>
									<tr>
				
									<?php foreach($outlsfields as $field): ?>
					
										<td><?=$bdata->$field;?></td>
						
									<?php endforeach;?>
									<td><a target="_blank" href="../ferret/index.php?c=labelledsites&m=edit&id=<?=$outdata->outcome_id?>">Edit</a></td>
									</tr>
								<?php endforeach; ?>
								
								</table>
						
							<?php endif;?>
					
					
					
							</td>
						</tr>
					
					<?php endforeach; ?>
			
					</table>
					</div>
				<?php endif;?>
			
				</td>
		
			</tr>
	
			<?php if(isset($mtm_data[$idata->injections_id])):?>
			<tr>
				<td><div style='color:#040E7A' id="inj_meth_<?=$num?>" onclick="show_table('meth_table_<?=$num?>','inj_meth_<?=$num?>','meth_row')"><strong>Injection method</strong></td>
		
				<td>
				<a target="_blank" href="../ferret/index.php?c=methods&m=add">Add injection method</a>
							<?php if(isset($mtm_data[$idata->injections_id])):?>
		
								<div class="magnifiable">
								<table border="1" cellpadding="3" cellspacing="1" id="meth_table_<?=$num?>" style="background-color:#fff;display:none;">
								<tr>
								<?php foreach($mtmfields as $field): ?>
				
										<td style='background-color:#E7E7E7;color:#000' id="meth_row_<?=$num?>"><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
								
								<?php endforeach; ?>
								</tr>
						
								<?php foreach($mtm_data[$idata->injections_id]->result() as $bdata): ?>
									<tr>
				
									<?php foreach($mtmfields as $field): ?>
					
										<td><?=$bdata->$field;?></td>
						
									<?php endforeach;?>
									</tr>
								<?php endforeach; ?>
								<td><a target="_blank" href="../ferret/index.php?c=injections&m=edit&id=<?=$idata->injections_id?>">Edit injection method</a></td>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
								</table>
								</div>
							<?php endif;?>
		
		
				</td>
		
	
			</tr>
			<?php endif;?>
	
	
	
			<tr><td colspan="2"></tr>
			</table>	
		<?php endforeach; ?>


		

		<?php else:?>

		<p>This Literature has no experimental data</p>
		<p><a target="_blank" href="../ferret/index.php?c=injections&m=add">Add new injections</a></p>
		
		<?php endif;?>

	
		<script type="teXt/javascript">
		function show_table(table_display,table_state, row_state) {
			var tableID = document.getElementById(table_display);
			var tablestate = document.getElementById(table_state);
			var row = document.getElementById(row_state); 

			switch(tableID.style.display) {
				case "none":
				tableID.style.display = "inline-table";
				table_state.innerHTML = "Hide";
				row.innerHTML = ""; 
				break;
				default:
				tableID.style.display = "none";
				table_state.innerHTML = "Show";
				break;
			}
		}
		</script> 

	<?php endif;?>



	<!-- Load maps relation view -->

	<?php if($action == 'view_rel'):?>

		<div id="literature_block">

		<?php if(isset($block_message)):?>
			<p><?=$block_message?></p>
		<?php endif;?>

		<a href="index.php?c=literature&m=view_index&id=<?=$literature_id?>">LITERATURE DETAILS</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_map&id=<?=$literature_id?>">MAPPING DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_exp&id=<?=$literature_id?>">EXPERIMENTAL DATA</a> &nbsp; | &nbsp;
		MAPS RELATION DATA &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=pdf&id=<?=$literature_id?>">DOWNLOAD PDF</a>

		<p align='right'><a href="index.php?c=literature">Change literature</a></p>

		<h3>Maps relation data:</h3>

		<p><a target="_blank" href="../ferret/index.php?c=mapsrelations&m=add">Add maps relation</a></p>

		<div class="magnifiable">
		<?php if(isset($mrm_data)):?>
			<table  border="1" cellpadding="3" cellspacing="1">
				<tr>
				<?php foreach($mrmfields as $field): ?>

					<td style='background-color:#040E7A;color:white'><?php $fname = explode("_", $field); foreach ($fname as $fn) { echo ucfirst($fn." "); };?></td>
			
				<?php endforeach; ?>
				<td style='background-color:#040E7A;color:white'></td>
				</tr>
	
				<?php foreach($mrm_data->result() as $bdata): ?>
					<tr>

					<?php foreach($mrmfields as $field): ?>

						<td><?=$bdata->$field;?></td>
	
					<?php endforeach;?>
					<td><a target="_blank" href="../ferret/index.php?c=mapsrelations&m=edit&id=<?=$bdata->maps_relations_id?>">Edit</a></td>
					</tr>
				<?php endforeach; ?>


			</table>
		
		<?php else:?>
		</div>
		<p>This Literature has no Maps relation data</p>
		<p><a target="_blank" href="../ferret/index.php?c=mapsrelations&m=add">Add new maps relations</a></p>
		

		<?php endif;?>


	<?php endif;?>

	<?php if($action == 'pdf'):?>

		<a href="index.php?c=literature&m=view_index&id=<?=$lit_data->literature_id?>">LITERATURE DETAILS</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_map&id=<?=$lit_data->literature_id?>">MAPPING DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_exp&id=<?=$lit_data->literature_id?>">EXPERIMENTAL DATA</a> &nbsp; | &nbsp;
		<a href="index.php?c=literature&m=view_rel&id=<?=$lit_data->literature_id?>">MAPS RELATION DATA</a> &nbsp; | &nbsp;
		DOWNLOAD PDF

		<p align='right'><a href="index.php?c=literature">Change literature</a></p>

		<h3>Link to download the literature pdf:</h3>
		<p><a href="../ferret/upload/<?=$lit_data->literature_physicalCopy?>" download><?=$lit_data->literature_title?></a>

		

	<?php endif;?>


<?php $this->load->view('footer');

<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>


<?php if($action == 'load_outcomes'):?>

<?php if($mode == 'normal'):?>
	<?php if(isset($outcome_options)):?>
	
		<?php echo form_dropdown('outcome_id', $outcome_options);?> 
	
	<?php endif;?>
<?php endif;?>


<!-- <?=$out->outcome_id?> - -->

<?php if($mode == 'extended'):?>

	<?php if(isset($outcomes)):?>
	
		<?php foreach ($outcomes->result() as $out): ?>
		
			<span id="outcome_<?=$out->outcome_id?>"><strong><?=$outcome_type[$out->outcome_type]?></strong> - has  <?=$outcome_data[$out->outcome_id]?>
			
			  labeled sites
			  <a href="#" id="labeled_sites_show_button_<?=$out->outcome_id?>" onclick="show_labeled('<?=$out->outcome_id?>')">Show</a> <br> <a  href="index.php?c=labelingoutcome&m=edit&id=<?=$out->outcome_id?>">Edit</a> &nbsp; | &nbsp;
				<a style="display:none;" href="#" id="labeled_sites_hide_button_<?=$out->outcome_id?>" onclick="hide_labeled('<?=$out->outcome_id?>')">Hide</a>
				 
			  <br/><br/></span>
			  
			  <span style="display:none;" id="labeled_sites_<?=$out->outcome_id?>">
			  
			  	<?php $local_data = array(); $local_data['output_data'] = $labeled_data[$out->outcome_id]; $local_data['fields_data'] = $labeled_fields; $this->load->view('standart_table_view',$local_data);?>

			  	<br/>
			  	
			  </span>


		
		<?php endforeach; ?> 
	
	<?php endif;?>

<?php endif;?>



<?php endif;?>

<?php if($action == 'new_outcome'):?>
	<span id="outcome_<?=$frmid?>">
		<form name="insert_form_<?=$frmid?>" id="insert_form_<?=$frmid?>">
			<input name="literature_id" type="hidden" value="<?=$lid?>">
			<?php echo form_dropdown('outcome_type', $outcome_type);?>
		</form>
		<a href="#" onclick="delete_outcome('<?=$frmid?>')">Cancel</a> &nbsp; <a href="#" onclick="save_outcome('<?=$frmid?>')">Save</a>
	</span>
<?php endif;?>

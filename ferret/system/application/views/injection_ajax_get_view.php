<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if(isset($inj_options)):?>
	<?php if(isset($special)):?>
		<?php echo form_dropdown('injections_id', $inj_options,1,$special);?> 
		<a href="#" id="sel_injection_block_button_select" onclick="load_data(); return false;"> Select </a>
		<span id="sel_injection_block" style="display:none;"></span>
		<a href="#" id="sel_injection_block_button" onclick="replace_injection(); return false;" style="display:none;">Replace</a>
	<?php endif;?>
	
	<?php if(!isset($special)):?>
		<?php echo form_dropdown('injections_id', $inj_options);?>
	<?php endif;?>
<?php endif;?>

<?php if(isset($met_options)):?>
<?php echo form_dropdown('methods_id', $met_options);?>
<?php endif;?>

<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if($action == 'load_data'):?>

<?php if(isset($left_menu)):?>
	<?php foreach ($left_menu->result() as $lmenu):?>
		
		<?php if($lmenu->item_type == '0'):?>
			<p>
			<strong><?=$lmenu->item_caption?></strong> - <?=$lmenu->item_mass?>
			- <a href="#" onclick="move_down(<?=$lmenu->item_id?>); return false;">down</a> - <a href="#" onclick="move_up(<?=$lmenu->item_id?>); return false;">up</a>
			</p>
		<?php endif;?>
		
		<?php if($lmenu->item_type == '1'):?>
			<p>
			<a href="<?=$lmenu->item_link?>"><?=$lmenu->item_caption?></a> - <?=$lmenu->item_mass?>
			- <a href="#" onclick="move_down(<?=$lmenu->item_id?>); return false;">down</a> - <a href="#" onclick="move_up(<?=$lmenu->item_id?>); return false;">up</a>
			</p>
		<?php endif;?>
		
		
	<?php endforeach;?>
<?php endif;?>


<?php endif;?>


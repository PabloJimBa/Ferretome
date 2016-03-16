<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<?php if(isset($index_message)):?>
<p><?=$index_message?></p>
<?php endif;?>

<h2>Left menu editor</h2>
<table>
<tr>
	<td>
	
	<div id="menu_structure">
		<?php if(isset($left_menu)):?>
			<?php foreach ($left_menu->result() as $lmenu):?>
				
				<?php if($lmenu->item_type == '0'):?>
					<p>
					<strong><?=$lmenu->item_caption?></strong> - <?=$lmenu->item_mass?>
					- <a href="#" onclick="move_down(<?=$lmenu->item_id?>); return false;">down</a> - <a href="#" onclick="move_up(<?=$lmenu->item_id?>); return false;">up</a></p>
					
					</p>
				<?php endif;?>
				
				<?php if($lmenu->item_type == '1'):?>
					<p><a href="<?=$lmenu->item_link?>"><?=$lmenu->item_caption?></a> - <?=$lmenu->item_mass?> 
					- <a href="#" onclick="move_down(<?=$lmenu->item_id?>); return false;">down</a> - <a href="#" onclick="move_up(<?=$lmenu->item_id?>); return false;">up</a></p>
				<?php endif;?>
				
				
			<?php endforeach;?>
		<?php endif;?>
	</div>


	</td>
	
	<td>
	
	<div id="menu_tool">
	<form id="new_menu_item_form" name="new_menu_item_form">
	<table>
	<tr><td>Item Caption</td><td><input type="text" id="item_caption" name="item_caption"/></td></tr>
	<tr><td>Link</td><td><input type="text" id="item_link" name="item_link"/></td></tr>
	<tr><td>Type</td><td><?php echo form_dropdown('item_type', $item_type_options, '1', 'id="item_type"');?></td></tr>
	<tr><td>Item Mass</td><td><input type="text" id="item_mass" name="item_mass"/></td></tr>
	</table>
	<a href="#" onclick="save_new_item()">Save</a>
	
	</form>
	
	</div>

	
	
	</td>

</tr>

</table> 



<?php endif;?>

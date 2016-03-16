<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php if($state == -1):?>
<p> Nothing was sent</p>
<?php endif;?>
<?php if($state == 0):?>
<p> This literature has no bmap</p>
<?php endif;?>
<?php if($state == 1):?>
<p> This bmap has no bsites</p>
<?php endif;?>

<?php if($state == 2):?>

<table>
	<tr>
		<td>
		</td>
		<?php foreach ($matrix as $key => $val):?>
		<td title="<?=$blist[$key]['stype']?>">
		<?=$aname[$blist[$key]['acr_id']]['aname']?>
		</td>
		<?php endforeach;?>
	</tr>
	<?php foreach ($matrix as $key => $val):?>
	<tr>
		<td title="<?=$blist[$key]['stype']?>">
		<?=$aname[$blist[$key]['acr_id']]['aname']?>
		</td>
		<?php foreach ($val as $key2 => $val2):?>
		<td>
			<?php if($val2 != '-'):?>
				<a href="#" title="<?=$explanation[$key][$key2]?>" onclick="show_logic('<?=$key?>','<?=$key2?>'); return false;"><?=$val2?></a>
			<?php else:?>
				<?=$val2?>
			<?php endif;?>
		</td>
		<?php endforeach;?>
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>






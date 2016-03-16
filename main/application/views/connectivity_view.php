<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php $this->load->view('header.php'); ?>

<?php $this->load->view('connectivity_menu_view.php')?>

<?php if($action == 'index'):?>

<h3> Ferret connectivity</h3>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>


<!-- ///////////////// index /////////////// -->



<div id=search_block>

	<form method="post" id="frm" name="frm" action="#">
			
			<span id="title_search_field">
				Find brain map using literature title<br/>
				<input title="Please, start to type literature title" type="search" id="autocomplite_1" class="input" placeholder=" Search for publication - type some words from publication title here"/>
			</span>
	</form>
	
	<span id="selected_lit_block" style="display:none">
	Selected literature: <span id="selected_lit_field"></span> <a href="#" onclick="replace_lit(); return false;">replace</a>	
	</span>
</div>
<br/>
<br/>

<div id="connectivity_output"></div>

<div id="connectivity_explanation"></div>

<div id="export_tools" style="display:none">
<p><a href="#">Save as XML</a></p>
<p><a href="#">Save as JSON</a></p>
</div>



<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_1', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit',
	onSelect: function(value, data){
		
		sel_lit_num = data;

		lit_title = value;

		select_lit();
		
		
	} 
	
 });

<?php if(isset($selected_literature)):?>

sel_lit_num =<?=$selected_literature['lit_id']?>;
lit_title = <?=$selected_literature['lit_id']?>;
select_lit();

<?php endif;?>

//]]>
</script>




<?php endif;?>


<?php if($action == 'cat_conn_with_ferret'):?>

<h3> Ferret with cat connectivity</h3>

<?php if(isset($block_message)):?>
<p><?=$block_message?></p>
<?php endif;?>

<p>This option is under development and will be relized soon</p>

<?php endif;?>

<?php $this->load->view('footer.php'); ?>
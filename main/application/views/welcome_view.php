<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php $this->load->view('header.php'); ?>


<?php if ($action =='index'): ?>
<!-- ///////////////// _index_ /////////////// -->

<?php if (isset($block_message)): ?>        
<p><font color="Red"><?= $index_message ?></font></p>
<?php endif; ?>

<h1>Welcome to Ferret brain connectivity DB</h1>
<p>This is the main page, to find some info check sections below:</p>
<p><a href="index.php?c=login">Login into system </a></p>



<?php endif; ?>




<?php if ($action =='startpage'): ?>
<!-- ///////////////// _startpage_ /////////////// -->

	



<div id="main_page">	
	<?php if(isset($main_page)):?>
		<?=$main_page?>
	<?php endif;?>
</div>

	
<div id="news_block">
	<h2>Latest news:</h2>
	
	<?php if(isset($news)):?>
	
		<?php foreach ($news->result() as $new):?>		
		<p><strong><?=$new->news_title?></strong></p>		
		<p> Posted by  <?=$new->user_name?> <?=$new->user_surname?> on <?php $str = explode(" ",$new->news_posted); echo $str[0]?> </p>
		<p><a href="index.php?c=news&id=<?=$new->news_id?>">Read more ...</a></p>		
		<?php endforeach;?>
		
		<p><a href="index.php?c=news">All news</a></p>	
	
	<?php endif;?>
	
	
</div>


<div id="logos">

<br clear='left'><br><br><br>


<p align='center'>
<img src="uke.png" width='120' height='120' alt="UKE">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="icns.jpg" width='225' height='120' alt="ICNS">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="SFB_logo.png" width='200' height='120' alt="SFB">
</p>



</div>
	

<script type="text/javascript">
//<![CDATA[
new Autocomplete('autocomplite_1', { 
	serviceUrl:'index.php/literature/ajaxAtocomplit',
	onSelect: function(value, data){
		sel_lit_num = data;
		
		search_do();
		
	} 
	
 });
new Autocomplete('autocomplite_2', { 
	serviceUrl:'index.php/literature/ajaxAtocomplitAuthors',
	onSelect: function(value, data){
		sel_auth_num = data;
		
		search_do();
		
	} 
	
 });
 

//]]>
</script>









<?php endif; ?>


<?php $this->load->view('footer.php'); ?>

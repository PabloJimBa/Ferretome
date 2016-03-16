<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<h1>Welcome to FBDB!</h1>

<table>
<tr>
	<td>
	Data input
	</td>
	
	<td>
	Search and edit data
	</td>
	
	<td>
	Additional
	</td>
</tr>

<tr>
	<td >


	<h2>First step:</h2>
	
	<p><a href="index.php?c=literature&m=add">Add new Literature </a></p>
	<p><a href="index.php?c=authors&m=add">Add new Authors </a></p>
	
	<h2>Second step:</h2>
	
	<p><a href="index.php?c=brainmaps&m=add">Add new Brain Maps </a></p>
	<p><a href="index.php?c=acronyms&m=add">Add new Acronyms </a></p>
	<p><a href="index.php?c=brainsites&m=add">Add new Brain Sites </a></p>
	<p><a href="index.php?c=architecture&m=add">Add new Architecture to a BSite </a></p>
	<p><a href="index.php?c=mapsrelations&m=add">Add new Relation of Brain maps </a></p>
	
	<h2>Third step:</h2>
	<p><a href="index.php?c=methods&m=add">Add new Injection Method </a></p>
	<p><a href="index.php?c=injections&m=add">Add new Injection </a></p>	
	<p><a href="index.php?c=injectionsdata&m=add">Add new Addtional data for Injection </a></p>
	<p><a href="index.php?c=labelingoutcome&m=add">Add new Labeling Outcome</a></p>
	<p><a href="index.php?c=labelledsites&m=add">Add new Labelled Sites </a></p>
	
	<p><a href="index.php?c=injectionsoutcomes">Connect injections and outcomes </a></p>

	</td>
	
	<td>
	
	<h2>Literature:</h2>
	<p><a href="index.php?c=literature&m=search">Find Literature </a></p>
	<p><a href="index.php?c=authors&m=search">Find Author </a></p>
	
	<h2>Mapping data:</h2>	
	<p><a href="index.php?c=brainmaps&m=search">Find Brain Maps </a></p>
	<p><a href="index.php?c=acronyms&m=search">Find Acronym </a></p>
	
	<h2>Expirement data:</h2>
	
	<p><a href="index.php?c=injections&m=search">Find Injection </a></p>
	
	</td>
	
	<td>
	
	
	<p>Special tables</p>
	<p><a href="index.php?c=menueditor">Main menu editor</a></p>
	<p><a href="index.php?c=journal">Actions Journal</a></p>
	<p><a href="index.php?c=codingrules">Coding rules</a></p>
	<p>Additional tables for mapping studies</p>
	<p><a href="index.php?c=abbreviations">Literature Abbr.</a></p>
	<p><a href="index.php?c=parameters">Architecture parametrs </a></p>
	<p>Additional tables for injection studies</p>
	<p><a href="index.php?c=tracers">Injection tracers</a></p>
	<p><a href="index.php?c=injectionsparameters"> Injection parameter </a></p>
	
	
	</td>
	
</tr>
</table>

<?php endif;?>

<?php $this->load->view('footer'); 
<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php  $this->load->view('header');  ?>

<!-- Main page -->

<?php if($action == 'index'):?>

<h1>Welcome to Ferret Brain Database!</h1>

<table>
	
<!-- Main table header -->
	
<tr>
	<td>
	<h2>Data input</h2>
	</td>
	
	<td>
	<h2>Search and edit data</h2>
	</td>
	
	<td>
	<h2> </h2>
	</td>
	
	<td>
	<h2>Additional</h2>
	</td>

	<!-- Manual link -->

	<td>
	<h3><a href="index.php?c=manual&m=index">How to upload data?</a></h3>
</tr>

<!-- Main table content -->
	
<tr>
	<td valign="top">


	<h3>First step:</h3>
	
	<p><a href="index.php?c=literature&m=add">Add new Literature </a></p>
	<p><a href="index.php?c=authors&m=add">Add new Author(s) </a></p>
	
	<h3>Second step:</h3>
	
	<p><a href="index.php?c=brainmaps&m=add">Add new Brain Map(s) </a></p>
	<p><a href="index.php?c=acronyms&m=add">Add new Acronym(s) </a></p>
	<p><a href="index.php?c=brainsites&m=add">Add new Brain Site(s) </a></p>
	<p><a href="index.php?c=architecture&m=add">Add new Architecture to a BSite </a></p>
	<p><a href="index.php?c=mapsrelations&m=add">Add new Relation of BMaps </a></p>
	
	<h3>Third step:</h3>
	<p><a href="index.php?c=methods&m=add">Add new Injection Method(s) </a></p>
	<p><a href="index.php?c=injections&m=add">Add new Injection(s) </a></p>	
	<p><a href="index.php?c=injectionsdata&m=add">Add new Addtional data for Injection </a></p>
	<p><a href="index.php?c=labelingoutcome&m=add">Add new Labeling Outcome(s) </a></p>
	<p><a href="index.php?c=labelledsites&m=add">Add new Labelled Site(s) </a></p>
	<p><a href="index.php?c=injectionsoutcomes">Connect injections and outcomes </a></p>

	</td>
	
	<td valign="top">
	
	<h3>Literature:</h3>
	<p><a href="index.php?c=literature">Show Literature </a></p>
	<p><a href="index.php?c=authors&m=search">Show Authors </a></p>
	
	<h3>Mapping data:</h3>	
	<p><a href="index.php?c=brainmaps&m=search">Show Brain Maps </a></p>
	<p><a href="index.php?c=acronyms&m=search">Show Acronyms </a></p>
	
	<h3>Expirement data:</h3>
	
	<p><a href="index.php?c=injections&m=search">Show Injections </a></p>
	
	</td>
	
	<td>
		
	</td>
		
	<td valign="top">
	
	
	<h3>Special tables</h3>
	<p><a href="index.php?c=menueditor">Main menu editor</a></p>
	<p><a href="index.php?c=journal">Actions Journal</a></p>
	<p><a href="index.php?c=codingrules">Coding rules</a></p>
	<h3>Additional tables for mapping studies</h3>
	<p><a href="index.php?c=abbreviations">Literature Abbr.</a></p>
	<p><a href="index.php?c=parameters">Architecture parametrs </a></p>
	<h3>Additional tables for injection studies</h3>
	<p><a href="index.php?c=tracers">Injection tracers</a></p>
	<p><a href="index.php?c=injectionsparameters"> Injection parameter </a></p>
	
	
	</td>
	
</tr>
</table>

<?php endif;?>

<?php $this->load->view('footer'); 

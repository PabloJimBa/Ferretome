<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<!-- If extraTitle is set, it will be shown. If not, "Ferret Brain DB" will be shown*/ -->

	<?php if(isset($extraTitle)):?>
		<title><?=$extraTitle?></title>
	<?php else:?>
	 	<title>Ferret Brain DB</title>
	<?php endif;?>

	<!-- If extraHeader is set, it will be shown. -->

	<?php if(isset($extraHeader)):?>
		<?=$extraHeader?>
	<?php endif;?>

	<!-- Style sheet used: -->

	<link href="style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/prototype.js"></script>


	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv='expires' content='-1' />
	<meta http-equiv= 'pragma' content='no-cache' />


</head>

<body>

	<!-- Main page header -->

	<div id="header">
	<?php if(!isset($login_token)):?>
		<div id="header_left">
		<h3><a href="index.php?c=welcome"> Main menu</a></h3>
		</div>
		<div id="header_right">

		<a href="index.php?c=workflow&type=input">Input queue <?php if(isset($input_queue_number)):?>(<?=$input_queue_number?>)<?php endif;?></a> &nbsp; | &nbsp; 
		<a href="index.php?c=workflow&type=proofreading">Proofreading queue <?php if(isset($proof_queue_number)):?>(<?=$proof_queue_number?>)<?php endif;?></a>  &nbsp; | &nbsp; 
		<strong>Ferret Brain Collation DB</strong>  &nbsp; | &nbsp; 
		<a href="index.php?c=login&m=signout"> Exit</a>
		</div>

		<!-- Log in page header -->

	<?php else:?>

		<div id="header_left">
		<h3>Ferret DB login page</h3>
		</div>

		<!-- End of log in page header -->

	<?php endif;?>

	</div>

	<br clear="all">

	<table id="main_contaner">
	<tr>
	<?php if(!isset($login_token)):?>
		<td valign="top" >
		<div id="outer_left">

	<!-- Side menu -->

	<?php if(isset($leftMenu)):?>

		<nav>
				<ul>
					<li><a href="#">Literature</a>
					<div>
	 					<ul>
							<li><a href="index.php?c=literature">Literature</a></li>
							<li><a href="index.php?c=authors">Authors</a></li>
							<li><a href="index.php?c=abbreviations">Journals/Books/Etc.</a></li>
						</ul>
					</div>
					<li><a href="#">Mapping</a>
	 				<div>
	 					<ul>
							<li><a href="index.php?c=brainmaps">Brain maps</a></li>
							<li><a href="index.php?c=brainsites">Brain sites</a></li>
							<li><a href="index.php?c=acronyms">Acronyms</a></li>
							<li><a href="index.php?c=architecture">Architecture of BSite</a></li>
							<li><a href="index.php?c=mapsrelations">Relations of BSites</a></li>
						</ul>
					</div>
	 				</li>
					<li><a href="#">Experiment</a>
					<div>
	 					<ul>
							<li><a href="index.php?c=injections">Injections</a></li>
							<li><a href="index.php?c=methods">Methods of Injection</a></li>
							<li><a href="index.php?c=tracers">Tracers</a></li>
							<li><a href="index.php?c=injectionsdata">Data for Injection</a></li>
							<li><a href="index.php?c=injectionsparameters">Data Parameters</a></li>
							<li><a href="index.php?c=labelingoutcome">Labeling Outcomes</a></li>
							<li><a href="index.php?c=labelledsites">Labelled Sites</a></li>
							<li><a href="index.php?c=injectionsoutcomes&m=add">Injection-Outcome Relations</a></li>
						</ul>
					</div>
					<li><a href="#">Special</a>
					<div>
	 					<ul>
							<li><a href="index.php?c=journal">Actions Journal</a></li>
							<li><a href="index.php?c=codingrules">Coding Rules</a></li>
						</ul>
					</div>
				</ul>
		</nav>


	
	<!--
		<?php foreach ($leftMenu->result() as $lmenu):?>
					
			<?php if($lmenu->item_type == '0'):?>
			<p><strong><?=$lmenu->item_caption?></strong></p>
			<?php endif;?>
						
			<?php if($lmenu->item_type == '1'):?>
			<p><a href="<?=$lmenu->item_link?>"><?=$lmenu->item_caption?></a></p>
			<?php endif;?>
					
					
		<?php endforeach;?> 
	-->

	<?php endif;?>
	
	</div>

		</td>
	<?php endif;?>
	
		<td valign="top">

	<div id="outer_right">

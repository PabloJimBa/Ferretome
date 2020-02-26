<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

/*If extraTitle is set, it will be shown. If not, "Ferret Brain DB" will be shown*/
	
<?php if(isset($extraTitle)):?>
	<title><?=$extraTitle?></title>
<?php else:?>
 	<title>Ferret Brain DB</title>
<?php endif;?>

/*If extraHeader is set, it will be shown.*/
	
<?php if(isset($extraHeader)):?>
 	<?=$extraHeader?>
 <?php endif;?>

/* Style sheet used: /ferret/js/prototype.js */
	
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/prototype.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />

</head>
<body>

/*Main page header*/
	
<div id="header">
<?php if(!isset($login_token)):?>
	
	/*Left header*/
	
	<div id="header_left">
	<h3><a href="index.php?c=literature&m=search"> Main menu</a></h3>
	</div>
	
	/*Right header*/
	
	<div id="header_right">
	<a href="index.php?c=workflow&type=input">Input queue <?php if(isset($input_queue_number)):?>(<?=$input_queue_number?>)<?php endif;?></a> &nbsp; | &nbsp; 
	<a href="index.php?c=workflow&type=proofreading">Proofreading queue <?php if(isset($proof_queue_number)):?>(<?=$proof_queue_number?>)<?php endif;?></a>  &nbsp; | &nbsp; 
	<strong>Ferret Brain Collation DB</strong>  &nbsp; | &nbsp; 
	<a href="index.php?c=login&m=signout"> Exit</a>
	</div>
	
/*Log in page header*/
	
<?php else:?>

	<div id="header_left">
	<h3>Ferret DB login page</h3>
</div>


/*End of log in page header*/
	
<?php endif;?>

</div>
	
<br clear="all">

<table id="main_contaner">
<tr>
<?php if(!isset($login_token)):?>
	<td valign="top" >
	<div id="outer_left">
	
/*Side menu from main page*/
	
<?php if(isset($leftMenu)):?>

	<?php foreach ($leftMenu->result() as $lmenu):?>
					
		/*Side menu headers*/
	
		<?php if($lmenu->item_type == '0'):?>
			<p><strong><?=$lmenu->item_caption?></strong></p>
				
		/*Side menu links (options)*/
	
		<?php else($lmenu->item_type == '1'):?>
			<p><a href="<?=$lmenu->item_link?>"><?=$lmenu->item_caption?></a></p>
		<?php endif;?>
					
					
	<?php endforeach;?>

 
<?php endif;?>
	
</div>

	</td>
<?php endif;?>
	
	<td valign="top">

<div id="outer_right">

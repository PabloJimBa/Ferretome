<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!DOCTYPE html>

<html>

<head>

<?php if(!isset($extraTitle)):?>
 
 <title>Ferret Brain DB</title>

 <?php else:?>

 <title><?=$extraTitle?></title>
<?php endif;?>

<?php if(isset($extraHeader)):?>
 <?=$extraHeader?>
 <?php endif;?>

<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/prototype.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>
<body>

<div id="header">

<div id="header_left">
<h3><a href="index.php">&nbsp;&nbsp;<img src="ferretome.png" width='185' height='120' alt="Ferretome"></a></h3>
</div>

<div id="header_right">


<?php if(!isset($header_page)):?>
<p>

<a href="index.php?c=welcome">HOME</a> &nbsp; | &nbsp;
<a href="index.php?c=news">NEWS</a> &nbsp; | &nbsp;
<a href="index.php?c=literature">LITERATURE</a> &nbsp; | &nbsp;
<a href="index.php?c=connectivity">CONNECTIVITY</a> &nbsp; | &nbsp;
<a href="index.php?c=pages&p=contacts">CONTACTS </a> &nbsp; | &nbsp;
<a href="index.php?c=pages&p=manual">MANUAL</a> &nbsp; | &nbsp;

<?php else:?>
<?=$header_page?>
<?php endif;?>



<?php if(isset($logintoken)):?>
<a href="index.php?c=pages&p=admin_page">ADMIN</a> &nbsp;|&nbsp; 
<a href="index.php?c=login&m=signout">LOGOUT</a>

<?php else: ?>

<a href="index.php?c=login">LOGIN</a>
<?php endif;?>
</p>
</div>

</div>



<br clear="all">
<div id="outer">
<div id="main_contaner">

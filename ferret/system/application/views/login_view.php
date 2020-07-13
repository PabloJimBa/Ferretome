<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<!-- Load the header -->

<?php $this->load->view('header.php'); ?>

<!-- Main page -->

<?php if ($action =='index'): ?>

<?php if (isset($index_message)): ?>        
<p><font color="Red"><?= $index_message ?></font></p>
<?php endif; ?>

<!-- Log in table -->

<div id="login" align="center">
<form action="index.php?c=login&m=signin" method="post">
<table>
<tr><td><b>Email address</b></td><td><input type="text" id="name" name="name" value="" size="26" maxlength="255"/></td></tr>
<tr><td><b>Password</b></td><td><input type="password" id="pass" name="pass" value="" size="26" maxlength="255"/></td></tr>
<tr><td></td><td><input type="submit" value="Signin"></td></tr>
</table>
</form>
</div>
<?php endif; ?>

<!-- Load the footer -->

<?php $this->load->view('footer.php'); ?>

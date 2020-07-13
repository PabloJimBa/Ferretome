<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>


<?php if(isset($index_message)):?>
  <p><?=$index_message?></p>
<?php endif;?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> <!-- Back button -->

	<h1>Architecture input</h1>

	<h2><a href="index.php?c=architecture&m=add">Add new Architecture of Brain sites </a> &nbsp; | &nbsp; <a href="index.php?c=parameters&m=add">Add new Architecture parameters </a></h2>
	<a href="index.php?c=parameters&m=show">Show all Architecture parameters


<?php endif;?>


<!-- Add -->

<?php if($action == 'add'):?>

	<p align="right"><a href="index.php?c=parameters">Back</a> <!-- Back button -->

  <h1>New Architecture parameter</h1>

  <p><a href="index.php?c=parameters&m=show">Show all </a></p>

  <!-- Form -->

  <form method="post" id="frm" name="frm" action="index.php?c=parameters&m=insert">

  <table border="0" cellpadding="3" cellspacing="1">


  <?php foreach($fields as $field): ?>

    <?php if (($field->primary_key == 1) OR ($field->name == 'parameters_type')) continue; ?>

      <tr>
	    <td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
	    <?php if ($field->type == 'blob'): ?>
	      <td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ></textarea></td>
	    <?php else : ?>
	      <td><input class="input" name="<?php echo $field->name; ?>" value="" size="30" /></td>
	    <?php endif; ?>
	
      </tr>
  <?php endforeach; ?>


  <tr>
	  <td>
	  Parameter type
	  </td>
	  <td>
		  <?php echo form_dropdown('parameters_type', $types_options, '1');?>
	  </td>
  </tr>

  </table>

  <input type="submit" class="submit" value="Insert" />

  </form>

<?php endif;?>


<!-- Show -->

<?php if($action == 'show'):?>

	<p align="right"><a href="index.php?c=parameters">Back</a> <!-- Back button -->

  <h1>All Architecture parameters</h1>

  <p><a href="index.php?c=parameters&m=add">Add new Architecture parameters </a></p>

  <table border="0" cellpadding="3" cellspacing="1">
  <?php foreach($block_data->result() as $bdata): ?>
  <tr>
	  <td><?=$bdata->parameters_name?></td>	
	  <td><a href="index.php?c=parameters&m=edit&id=<?=$bdata->parameters_id?>">edit</a> &nbsp; | &nbsp; <a href="index.php?c=parameters&m=confirm&id=<?=$bdata->parameters_id?>">delete</a></td>
  </tr>
  <?php endforeach; ?>
  </table>
<?php endif;?>


<!-- Edit -->

<?php if($action == 'edit'):?>

	<p align="right"><a href="index.php?c=parameters">Back</a> <!-- Back button -->

  <h1>Edit Architecture parameter</h1>

  <!-- Form -->

  <form method="post" id="frm" name="frm" action="index.php?c=parameters&m=update&id=<?=$block_data->parameters_id?>">

  <table border="0" cellpadding="3" cellspacing="1">


  <?php foreach($fields as $field): ?>

  <?php if (($field->primary_key == 1) OR ($field->name == 'parameters_type')) continue; ?>

  <tr>
	  <td><?php $fname = explode("_", $field->name); foreach ($fname as $fn) { echo ucfirst($fn." "); }; echo ' '.$field->default; ?></td>
	
	  <?php if ($field->type == 'blob'): ?>
	  <td><textarea class="textarea" name="<?php echo $field->name; ?>" cols="30" rows="10" ><?php $f=$field->name; echo form_prep($block_data->$f); ?></textarea></td>
	  <?php else : ?>
	  <td><input class="input" name="<?php echo $field->name; ?>" value="<?php $f=$field->name; echo form_prep($block_data->$f); ?>" size="30" /></td>
	  <?php endif; ?>
	
  </tr>
  <?php endforeach; ?>


  <tr>
	  <td>
	  Parameter type
	  </td>
	  <td>
		  <?php echo form_dropdown('parameters_type', $types_options, $block_data->parameters_type);?>
	  </td>
  </tr>


  </table>

  <input type="submit" class="submit" value="Update" />

  </form>

<?php endif;?>


<!-- Load the footer -->

<?php $this->load->view('footer');





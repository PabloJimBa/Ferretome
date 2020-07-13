<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>



<?php if($action == 'index'):?>

<div id="current_job">
<p>Your current job:</p>

<div id="current_job_data">

<?php if(isset($current_job)):?>

<?php $local_data = array(); $local_data['output_data'] =$current_job; $local_data['fields_data'] = $current_job_fields; $this->load->view('standart_record_view',$local_data);?>

<?php else: ?>

<p> No jobs, select one from list below</p>

<?php endif;?>


</div>

</div>

<div id="all_jobs">

<p>Showed jobs: <?=$show_section[$show_section_index]?> </p>

<?php if(isset($job_data)):?>

<?php $local_data = array(); $local_data['output_data'] =$job_data; $local_data['fields_data'] = $fields; $this->load->view('standart_table_view',$local_data);?>

<?php else: ?>
<p> No jobs</p>
<?php endif;?>


</div>

<div id="workflow_stats">

<p>Overall progress </p>

<?php if(isset($workflow_data)):?>

<?php $local_data = array(); $local_data['output_data'] =$workflow_data; $local_data['fields_data'] = $workflow_fields; $this->load->view('standart_table_view',$local_data);?>

<?php else: ?>
<p> No progress</p>
<?php endif;?>


</div>


<?php endif;?>

<?php $this->load->view('footer');?> 
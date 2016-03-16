<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>

<?php foreach ($files_data->result() as $file):?>		

	<a href="upload/<?=$file->file_name?>"><img src="upload/<?=$file->file_name?>" title="<?=$file->real_name?>" width="150" height="150"></a><br/>	
						
<?php endforeach;?>	

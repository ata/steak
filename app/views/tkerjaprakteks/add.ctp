<div class="tkerjaprakteks form grid_12 alpha " id="content">
	<div class="box">
		<h2 class="section_name"><span class="section_name_span"><?php __('Tambah Kerja Praktek');?></span></h2>
<div class="tkerjaprakteks form">
<?php echo $form->create('Tkerjapraktek', array('type'=>'file'));?>
	<fieldset>
 		
	<?php
		
		if(isset($error)){
			echo "<p>$error</p>";			
		}
		echo "<div class='input text'>";
		echo $form->label("NIM");
		if(isset($nim)){
			echo $form->text("NIM",array("value"=>$nim,"readonly"=>true));
		}
		else{
			echo $form->select('NIM',$tmahasiswas);
		}
		echo "</div>";
		echo $form->input('topik');
		echo $form->input('lokasi');
		echo "<div class='input text'>";
		echo $form->label("Pembimbing 1");
		echo $form->select('pembimbing1',$tdosens1);
		echo "</div>";
		echo "<div class='input text'>";
		echo $form->label("Pembimbing 2");
		echo $form->select('pembimbing2',$tdosens2);
		echo "</div>";
		//echo $form->input('pembimbing1');
		//echo $form->input('pembimbing2');
		echo $form->input('file_kp', array('type'=>'file'));
		echo $form->input('mulai',array('label'=>'Tanggal Mulai','type'=>'text', 'class'=>'w8em format-y-m-d divider-dash'));
		echo $form->input('berakhir',array('label'=>'Tanggal Akhir','type'=>'text', 'class'=>'w8em format-y-m-d divider-dash'));
	?>
	</fieldset>
	
<?php echo $form->end('Submit');?>
</div>
<div class="grid_4 omega" id="sidebar">

</div>
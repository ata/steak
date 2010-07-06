<h2>Cetak KSM</h2>

<?php echo $form->create('Filter', array('url'=>'/frs/registrasi',"id"=>"IdFilter"))?>
<?php echo $form->input('FAKULTAS', array("id"=>"FAKULTAS","type"=>"select","options"=>$tfakultases,'empty'=>'-pilih-'))?>
<?php echo $form->input('PROGRAM_STUDI', array("type"=>"select","id"=>"PROGRAM_STUDI","options"=>$tprograms,'empty'=>'-pilih-'));?>
<?php echo $ajax->observeForm('IdFilter', array ("url"=>'/frs/getjurusan','update'=>'daftar_jurusan'))?>

<div id="daftar_jurusan">
<?php 
		echo $form->input('JURUSAN', array("type"=>"select","options"=>$tjurusans,'empty'=>'-pilih-'));	
?>
</div>
<?php echo $ajax->submit('Filter',array('url'=>'/form_studis/get_ksm','update'=>'ksm_mahasiswa'))?>
</form>

<div id="ksm_mahasiswa">
</div>

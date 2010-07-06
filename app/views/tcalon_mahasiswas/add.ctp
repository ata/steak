<div class="tmahasiswas form grid_16" id="content" >
	<div class="box">

		<h2 class="section_name"><span class="section_name_span"><?php __('Penerimaan Calon Mahasiswa Baru');?></span></h2>
		<?php echo $form->create('TcalonMahasiswa',array('class'=>'plain', "type"=>"file"));?>
			<fieldset> Pribadi
			<?php
				echo "<div class='input text required'>";
				echo "<span id='NO_REGISTRASI'>";
				echo $form->input('NO_REGISTRASI', array('type'=>'text', 'label'=>'NO REGISTRASI', 'div'=>false));
				echo "</span>";
				echo $ajax->submit('Generate',array('url'=>'../tmahasiswas/getnim','update'=>'NO_REGISTRASI', 'div'=>FALSE));
				echo "</div>";
				echo $form->input('NAMA', array('label'=>'Nama'));
				echo $form->input('ALAMAT', array('label'=>'Alamat'));
				echo $form->input('JENIS_KELAMIN',array('label'=>'Jenis Kelamin','options' => array('L'=>'L','P'=>'P')));
				echo $form->input('AGAMA',array('label'=>'Agama','options' => $tagamas));
				echo $form->input('TGL_LAHIR',array('label'=>'Tanggal Lahir','type'=>'text', 'class'=>'w8em format-y-m-d divider-dash'));
				echo $form->input('TELEPON', array('label'=>'No Telepon'));
				echo $form->input('PEKERJAAN', array('label'=>'Pekerjaan'));
				echo $form->input('KOTA', array('label'=>'Kota'));
				echo $form->input('KODEPOS', array('label'=>'Kode Pos'));

			?>
			</fieldset>
			<hr class="separator" />
			<fieldset>Pokok
			<?php
				echo "<br>";
				//echo $form->input('TTAHUN_AJARAN_ID', array("type"=>"select","options"=>$ttahunAjarans,'empty'=>'--Pilih Tahun--','label'=>'Angkatan'));
				//echo $form->input('TFAKULTAS_ID', array("type"=>"select","options"=>$tfakultases,'empty'=>'--Pilih Fakultas--','label'=>'Fakultas'));
				
				echo $form->label('Pilihan satu : ');
				echo $form->input('TJURUSAN_ID', array("type"=>"select","options"=>$tjurusans,'empty'=>'--Pilih Jurusan--','label'=>'Jurusan'));
				echo $form->input('TPROGRAM_ID', array("type"=>"select","options"=>$jenjang_studi,'empty'=>'--Pilih Jenjang Studi--','label'=>'Jenjang Studi'));
				
				echo $form->label('Pilihan dua : ');
				echo $form->input('TJURUSAN_ID2', array("type"=>"select","options"=>$tjurusans,'empty'=>'--Pilih Jurusan--','label'=>'Jurusan'));
				echo $form->input('TPROGRAM_ID2', array("type"=>"select","options"=>$jenjang_studi,'empty'=>'--Pilih Jenjang Studi--','label'=>'Jenjang Studi'));
				
			?>
			</fieldset>
			<hr class="separator" />
			<fieldset> SMU
			<?php
				echo $form->input('NAMA_SMU', array('label'=>'Nama SMU '));
				echo $form->input('JURUSAN_SMU', array('label'=>'Jurusan SMU ',"type"=>"select",'empty'=>'--Pilih Jurusan--',"options"=>array("SMA_A1"=>"SMA A1","SMA_A2"=>"SMA A2","SMA_A3"=>"SMA A3","SMA_A4"=>"SMA A4","SMUIPA"=>"SMA IPA","SMA_IPS"=>"SMA IPS")));
				echo $form->input('THN_LULUS', array('label'=>'Tahun Lulus'));
				echo $form->input('nem', array('label'=>'Nem'));

			?>
			</fieldset>
			<hr class="separator" />
			<fieldset> Orang Tua
			<?php
				echo $form->input('NAMA_ORTU', array('label'=>'Nama'));
				echo $form->input('ALAMAT_ORTU', array('label'=>'Alamat'));
				echo $form->input('KOTA_ORTU', array('label'=>'Kota'));
				echo $form->input('KODEPOS_ORTU', array('label'=>'Kode Pos'));
				echo $form->input('TELEPON_ORTU', array('label'=>'Telepon'));
				echo $form->input('PEKERJAAN_ORTU', array('label'=>'Pekerjaan'));
				echo $form->input('INSTANSI', array('label'=>'Instansi'));

			?>
			</fieldset>
			<hr class="separator" />
			<fieldset> Pendaftaran
			<?php
				echo $form->input('TGL_DAFTAR',array('label'=>'Tanggal','type'=>'text', 'class'=>'w8em format-y-m-d divider-dash'));
				echo $form->input("Uang_Pendaftaran",array('type'=>'checkbox','value'=>FALSE,'label'=>'Uang Pendaftaran','checked'=>FALSE));
				echo $form->input("Uang_Seleksi",array('type'=>'checkbox','value'=>FALSE,'label'=>'Uang Seleksi','checked'=>FALSE));
				echo $form->input('kenal_stmik', array('label'=>'Kenal STMIK dari','options'=>array("SURAT KE RUMAH"=>"SURAT KE RUMAH","SPANDUK DIJALAN"=>"SPANDUK DIJALAN","RADIO"=>"RADIO","TELEVISI"=>"TELEVISI","TEMAN"=>"TEMAN","POSTER DI SEKOLAH"=>"POSTER DI SEKOLAH","TELEPON"=>"TELEPON","LEWAT KAMPUS STMIK"=>"LEWAT KAMPUS STMIK","LAIN-LAIN"=>"LAIN-LAIN")));
				echo $form->input('SUMBANGAN', array('label'=>'Sumbangan'));
				echo $form->input('PETUGAS', array('label'=>'Petugas'));
				
			?>
			</fieldset>
			<hr class="separator" />
			<fieldset> Test Masuk
			<?php
				echo $form->input('ruang_test', array('label'=>'Ruang'));
				echo $form->input('tanggal_test',array('label'=>'Tanggal','type'=>'text', 'class'=>'w8em format-y-m-d divider-dash'));
				echo $form->input('nilai_matematika', array('label'=>'Nilai Matematika'));
				echo $form->input('nilai_kemampuan', array('label'=>'Nilai Kemampuan'));
				echo $form->input('nilai_bahasa', array('label'=>'Nilai Bahasa'));
				//echo $form->input('nilai_rata2', array('label'=>'Nilai Rata - rata'));
				
			?>
			</fieldset>
			<hr class="separator" />
						<script type="text/javascript">
				function tampil($form){
					$form.target = "upload_target";
					$form.action = "<?php echo $html->url("/tmahasiswas/upload");?>";
					$form.submit();
					$form.target ="";
					$form.action = "<?php echo $html->url("/tmahasiswas/add");?>";

				}
			</script>
		<?php echo $form->end('Simpan');?>
	</div>
</div>
<!--<div class="actions">-->
<!--	<ul>-->
<!--		<li><?php echo $html->link(__('Lihat Daftar Mahasiswa', true), array('action'=>'index'));?></li>-->
<!--	</ul>-->
<!--</div>-->

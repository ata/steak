<?php $jenkel = array('L'=>'Laki-laki', 'P'=>'Perempuan');?>
<?php $paginator->options(array("url"=>$params));?>

<div class="tmahasiswas grid_12 alpha " id="content">
	<div class="box">
		<h2 class="section_name"><span class="section_name_span"><?php __('Data Mahasiswa');?></span></h2>
		<?php echo $form->create('Filter', array('url'=>'/tcalon_mahasiswas/index',"id"=>"IdFilter", 'class'=>'filter'))?>
			<table class="filter">
				<tr>
					<td>
						<?php echo $form->input('NO_REGISTRASI', array('label'=>'No REGISTRASI', 'div'=>'filter', 'fieldset'=>false))?>
					</td>
					<td>
						<?php echo $form->input('NAMA', array('label'=>'Nama', 'div'=>'filter', 'fieldset'=>false))?>
					</td>
					<td>
						<?php echo $form->input('TJURUSAN_ID', array('label'=>'Jurusan', 'div'=>'filter', 'fieldset'=>false,'options'=>$tjurusans,'empty'=>'-pilih-', 'class'=>'select'))?>
					</td>
					<td>
						<?php echo $form->input('TPROGRAM_ID', array("type"=>"select"/*,"id"=>"Jenjang Studi"*/,"options"=>$jenjang_studi,'empty'=>'-pilih-',"label"=>"Jenjang Studi", 'div'=>'filter', 'fieldset'=>false, 'class'=>'select'));?>
					</td>
					<td>
						<?php echo $form->input('gelombang_id', array("type"=>"select","options"=>$gelombangId, "label"=>"Gelombang", 'div'=>'filter', 'fieldset'=>false, 'class'=>'select'));?>
					</td>
				</tr>
			</table>
			<?php echo $form->submit('Filter') ?>
		</form>

		<table cellpadding="0" cellspacing="0" class="Design">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th><?php echo $paginator->sort('NO REG','NO_REGISTRASI');?></th>
					<th><?php echo $paginator->sort('Nama','NAMA');?></th>
					<th><?php echo $paginator->sort('Tanggal Lahir','TGL_LAHIR');?></th>
					<th><?php echo $paginator->sort('Jurusan yang dipilih','JURUSAN');?></th>
					<th><?php echo $paginator->sort('Nilai Rata2','nilai_rata2');?></th>
					<th class="actions"><?php __('Aksi');?></th>
				</tr>
			</thead>
			<tbody>
				<?php

				foreach ($tmahasiswas as $tmahasiswa): ?>
				<tr>
					<td>
						<?php echo $html->image($tmahasiswa['TcalonMahasiswa']['JENIS_KELAMIN'].'.png', array()); ?>
					</td>
					<td>
						<?php echo $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']; ?>
					</td>

					<td>
						<?php echo $tmahasiswa['TcalonMahasiswa']['NAMA']; ?>
					</td>
					<td>
						<?php echo $tmahasiswa['TcalonMahasiswa']['TGL_LAHIR']; ?>
					</td>

					<td>
						<?php
						//pr($jenjang_studi);
						//if($jenjang_studi[21]==$tmahasiswa['Tprogram']['value']){
						//	echo $jenjang_studi[21];
						//}
						echo $tmahasiswa['Tprogram']['value'] ."-".$tmahasiswa['Tjurusan']['namaJurusan'];
						echo "<br>";
						echo $tmahasiswa['Tprogram2']['value'] ."-".$tmahasiswa['Tjurusan2']['namaJurusan'];
						//echo $tmahasiswa['Tprogram']['value'] ."-".$tmahasiswa['Tjurusan']['namaJurusan'];
							//	echo "<br>";
							//	echo $tmahasiswa['Tprogram2']['value'] ."-".$tmahasiswa['Tjurusan2']['namaJurusan'];
						?>
					</td>
					<td>
						<?php echo $tmahasiswa['TcalonMahasiswa']['nilai_rata2']; ?>
					</td>
					<td class="actions">
						<?php echo $html->link($html->image('page_16.png'), array('action'=>'view', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']), array('title'=>'Lihat data lengkap'),false,false); ?>
						<?php echo $html->link($html->image('pencil_16.png'), array('action'=>'edit', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']), array('title'=>'edit'),false,false); ?>
						<?php echo $html->link($html->image('del_16.png'), array('action'=>'delete', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']), array('title'=>'hapus'), sprintf(__('Are you sure you want to delete # %s?', true), $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']),false); ?>
						<?php echo $html->link($html->image('ubahxxx.gif'), array('action'=>'edit_nilai', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']), array('title'=>'Ubah Nilai Test'),false,false); ?>

						<?php echo $html->link($html->image('table_48.png'), array('action'=>'kelengkapan', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']), array('title'=>'kelengkapan Pendaftaran'),false,false); ?>
				

						<?php

			  if($tmahasiswa['TcalonMahasiswa']['status']=="0"){
				echo $html->link(__('Tidak Di terima', true), array('action'=>'tidak_diterima', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']));
			} else {
				echo $html->link(__('Di terima', true), array('action'=>'diterima', $tmahasiswa['TcalonMahasiswa']['NO_REGISTRASI']));
			}
						  ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>

		<div class="pagination">
			<div class="paging">
				<?php echo $paginator->prev('&laquo; '.__('Sebelumnya', true), array('escape'=>false, 'class'=>'prev'), null, array('class'=>'disabled_prev'));?>
				<?php echo $paginator->numbers(array('separator'=>''));?>
				<?php echo $paginator->next(__('Selanjutnya', true).' &raquo;', array('escape'=>false, 'class'=>'next'), null, array('class'=>'disabled_next'));?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<div class="grid_4 omega" id="sidebar">
	<ul class="special sidebox">
		<li><?php echo $html->link($html->image('add_16.png'). __('Tambah Calon Mahasiswa ', true), array('action'=>'add'), array('class'=>'tombol'), null, false); ?></li>
	</ul>
</div>

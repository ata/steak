<div class="tsilabusMatakuliahs view">
<h2><?php  __('Silabus Matakuliah');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('KODE MK'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['KD_KULIAH']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nama Kuliah'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['NAMA_KULIAH']; ?>
			&nbsp;
		</dd>
		
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('SKS'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['SKS']; ?> sks
			&nbsp;
		</dd>
		
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Konsentrasi'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['KONSENTRASI']; ?> 
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Deskripsi'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['DESKRIPSI']; ?> sks
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tujuan Umum'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['tujuan_umum']; ?>
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tujuan Khusus'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['tujuan_khusus']; ?>
			&nbsp;
		</dd>
                
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lingkup bahasan'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['lingkup_bahasan']; ?>
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Literatur'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['lingkup_bahasan']; ?>
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Aturan kuliah'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['aturan_kuliah']; ?>
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Penilaian'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tsilabusMatakuliah['Tmatakuliah']['penilaian']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div>
    <table cellpadding="0" cellspacing="0" class="Design">
        <thead>
        <tr>
                <th>Mgg</th>
                <th>Topik</th>
                <th>Deskripsi</th>
        </tr>
        </thead>
            <tbody>
                <?php foreach($tjadwalmgg as $data_):?>
                <tr>
                    <td><?php echo $data_['TrencanaKuliahMingguan']['MINGGU_KE'] ?></td>
                    <td><?php echo $data_['TrencanaKuliahMingguan']['TOPIK'] ?></td>
                    <td><?php echo $data_['TrencanaKuliahMingguan']['DESKRIPSI'] ?></td>
                <?php endforeach;?>
            </tbody>
    </table>
</div>
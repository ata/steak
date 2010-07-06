<div class="tkerjaPrakteks view grid_12 alpha " id="content">
<div class="box">
		<h2 class="section_name"><span class="section_name_span"><?php __('Kerja Praktek');?></span></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('NIM'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['NIM']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Topik'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['topik']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lokasi'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['lokasi']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pembimbing1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tdosen1']['NAMA_DOSEN']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pembimbing2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tdosen2']['NAMA_DOSEN']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($html->image('Download.gif'), array('action'=>'downloadfile', $tkerjapraktek['Tkerjapraktek']['NIM']), array('title'=>'Download '.$tkerjapraktek['Tkerjapraktek']['filename']),false,false);echo " ". $html->link($tkerjapraktek['Tkerjapraktek']['filename'], array('action'=>'downloadfile', $tkerjapraktek['Tkerjapraktek']['NIM']), array('title'=>'Download '.$tkerjapraktek['Tkerjapraktek']['filename']),false,false); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mulai'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['mulai']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Berakhir'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['berakhir']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tkerjapraktek['Tkerjapraktek']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Kerja Praktek', true), array('action'=>'edit', $tkerjapraktek['Tkerjapraktek']['NIM'])); ?> </li>
		<li><?php echo $html->link(__('Hapus Kerjapraktek', true), array('action'=>'delete', $tkerjapraktek['Tkerjapraktek']['NIM']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tkerjapraktek['Tkerjapraktek']['NIM'])); ?> </li>
		<li><?php echo $html->link(__('Daftar Kerja Praktek', true), array('action'=>'index')); ?> </li>
		<li><?php //echo $html->link(__('Tambah Baru', true), array('action'=>'add')); ?> </li>
	</ul>
</div>

<table class="Design">
</thead>
<tr>
<td>NIM</td>
<td>Nama</td>
<td>Keterangan</td>
</tr>
</thead>
<tbody>

<?

$i = 0;
foreach($pertemuans as $pertemuan) :
$i = $i + 1;
?>
   	<tr>
   		<td><?php echo $pertemuan['Presence']['nim']; ?></td>
   		<td><?php echo $pertemuan['Tmahasiswa']['NAMA']; ?></td>
   		<td><?php echo $pertemuan['Presence']['keterangan']; ?></td>
   		<td>
        <td>
        <?php

        echo $form->hidden('id',array('name'=>'data[id]['.$i.']','value'=>$pertemuan['Presence']['id']));
        echo $form->input('keterangan',array('name'=>'data[keterangan]['.$i.']','label'=>'','type'=>'select','options'=>array('m'=>'Masuk','i'=>'Ijin','a'=>'Tanpa Keterangan')));
        ?>
        </tr>
        <?php 
        endforeach;
        ?>
</tbody>
<table>
<?
//echo $form->input('pertemuan_id',array('label'=>'Pertemuan','type'=>'select','options'=>$data_pertemuans));

echo $form->input('pertemuan_id', array("name"=>"data[Presence][pertemuan_id]","label"=>"Pertemuan","type"=>"select","id"=>"pertemuan_id","options"=>$data_pertemuans,'empty'=>'-pilih-'));
echo $ajax -> observeField('pertemuan_id', array ("url"=>'/presences/getpertemuan','update'=>'pertemuans'));
?>


<?
$i=0;
/*foreach($formstudis as $formstudi){
    if(!empty($formstudi['Tmahasiswa']['NIM'])){
    echo '<tr><td>'.$formstudi['Tmahasiswa']['NIM'].'</td><td>'.$formstudi['Tmahasiswa']['NAMA'].'</td><td>
        ';?>
        <?
        echo $form->hidden('nim',array('name'=>'data[NIM]['.$i.']','value'=>$formstudi['Tmahasiswa']['NIM']));
        echo $form->input('presence',array('name'=>'data[keterangan]['.$i.']','label'=>'','type'=>'select','options'=>array('m'=>'Masuk','i'=>'Ijin','a'=>'Tanpa Keterangan')));
        $i++;
    
    echo ' </td></tr>';
    }
}
*/?>

<!--</table>-->
<?php
class TtugasAkhir extends AppModel {

	var $name = 'TtugasAkhir';
	var $primaryKey = 'NIM';
	
var $belongsTo = array(
		'Tmahasiswa' => array(
			'className' => 'Tmahasiswa',
			'foreignKey' => 'NIM',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tdosen1' => array(
			'className' => 'Tdosen',
			'foreignKey' => 'pembimbing1',
			'conditions' => '',
			'fields' => array('NAMA_DOSEN','NIP_DOSEN'),
			'order' => ''
		),
		'Tdosen2' => array(
			'className' => 'Tdosen',
			'foreignKey' => 'pembimbing2',
			'conditions' => '',
			'fields' => array('NAMA_DOSEN','NIP_DOSEN'),
			'order' => ''
		)
	);
}
?>
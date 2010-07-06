<?php
class TcalonMahasiswa extends AppModel {

	var $name = 'TcalonMahasiswa';
	var $primaryKey = 'NO_REGISTRASI';
	var $validate = array(

		'NO_REGISTRASI' => array('notempty'),
		'NAMA' => array('notempty'),
		'AGAMA' => array('notempty'),
		'JENIS_KELAMIN' => array('notempty'),
		'TGL_LAHIR' => array('notempty'),
		'TGL_DAFTAR' => array('notempty'),
		'TJURUSAN_ID' => array('notempty'),
		'NAMA_SMU' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array (
		'FormStudi' => array (
			'className' => 'FormStudi',
			'foreignKey' => 'NIM',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Presence' => array (
			'className' => 'Presence',
			'foreignKey' => 'nim',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TstatusPembayaran' => array (
			'className' => 'TstatusPembayaran',
			'foreignKey' => 'NIM',
			'dependent' => '',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PmbNilai' => array (
			'className' => 'PmbNilai',
			'foreignKey' => 'nomor_registrasi',
			'dependent' => '',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array (
		'Tagama' => array (
			'className' => 'Tagama',
			'foreignKey' => 'AGAMA',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tfakultase' => array (
			'className' => 'Tfakultase',
			'foreignKey' => 'TFAKULTAS_ID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tprogram' => array (
			'className' => 'Tprogram',
			'foreignKey' => 'TPROGRAM_ID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tjurusan' => array (
			'className' => 'Tjurusan',
			'foreignKey' => 'TJURUSAN_ID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tprogram2' => array (
			'className' => 'Tprogram',
			'foreignKey' => 'TPROGRAM_ID2',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tjurusan2' => array (
			'className' => 'Tjurusan',
			'foreignKey' => 'TJURUSAN_ID2',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'Tdosen' => array (
			'className' => 'Tdosen',
			'foreignKey' => 'NIP_WALI',
			'conditions' => '',
			'fields' => array('NAMA_DOSEN','NIP_DOSEN'),
			'order' => ''
		),

		'TtahunAjaran' => array (
			'className' => 'TtahunAjaran',
			'foreignKey' => 'TTAHUN_AJARAN_ID',

			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'Tkelase' => array (
			'className' => 'Tkelase',
			'foreignKey' => 'KELAS',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	'GelombangPendaftaran' => array (
			'className' => 'GelombangPendaftaran',
			'foreignKey' => 'gelombang_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),


	);

	var $hasAndBelongsToMany = array(
		'Tperlengkapan' => array(
			'className' => 'Tperlengkapan',
			'joinTable' => 'tperlengkapans_tcalon_mahasiswas',
			'foreignKey' => 'tcalon_mahasiswa_id',
			'associationForeignKey' => 'tperlengkapan_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	/*function beforeSave(){
		if(empty($this->data['Tmahasiswa']['tanggal_masuk'])){
			$this->data['Tmahasiswa']['tanggal_masuk'] = NULL;
		}
		if(empty($this->data['Tmahasiswa']['tanggal_lulus'])){
			$this->data['Tmahasiswa']['tanggal_lulus'] = NULL;
		}
		return true;
	}*/

    function getAllWithNilai($gelombang_id, $ruang, $noreg){
        $conditions = array('gelombang_id' => $gelombang_id);
        if($ruang){
            $conditions[] = "ruang_test LIKE '%$ruang%' ";
        }
        if($noreg){
            $conditions[] = "NO_REGISTRASI LIKE '%$noreg%' ";
        }

        $this->recursive = -1;
        $listMahasiswa = $this->find('all', array('conditions' => $conditions));

        foreach($listMahasiswa as $key => $mhs) {
            $sql = "
                SELECT JenisNilaiPendaftaran.id, PmbNilai.*
                FROM jenis_nilai_pendaftarans JenisNilaiPendaftaran
                LEFT JOIN (
                    SELECT *
                    FROM pmb_nilai
                    WHERE nomor_registrasi =  ?
                )PmbNilai ON ( JenisNilaiPendaftaran.id = PmbNilai.tes_id )
                WHERE JenisNilaiPendaftaran.gelombang_pendaftaran_id = ?
                ORDER BY JenisNilaiPendaftaran.id
            ";
            $nilai = $this->query($sql, array($mhs['TcalonMahasiswa']['NO_REGISTRASI'], $mhs['TcalonMahasiswa']['gelombang_id']));
            $listMahasiswa[$key]['Nilai'] = $nilai;
        }

        return $listMahasiswa;
    }

    function getWithNilai($noreg){
        $this->recursive = -1;
        $mahasiswa = $this->read(null, $noreg);

        $sql = "
            SELECT JenisNilaiPendaftaran.id, JenisNilaiPendaftaran.name, PmbNilai.id, PmbNilai.nilai
            FROM jenis_nilai_pendaftarans JenisNilaiPendaftaran
            LEFT JOIN (
                SELECT *
                FROM pmb_nilai
                WHERE nomor_registrasi =  ?
            )PmbNilai ON ( JenisNilaiPendaftaran.id = PmbNilai.tes_id )
            WHERE JenisNilaiPendaftaran.gelombang_pendaftaran_id = ?
            ORDER BY JenisNilaiPendaftaran.id
        ";
        $nilai = $this->query($sql, array($noreg, $mahasiswa['TcalonMahasiswa']['gelombang_id']));
        $mahasiswa['Nilai'] = $nilai;

        return $mahasiswa;
    }
}
?>

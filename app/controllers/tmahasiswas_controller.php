<?php
class TmahasiswasController extends AppController { 

	var $name = 'Tmahasiswas';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $primaryKey = 'NIM';


	function index() {
		$this->loadModel('Tmahasiswa');
		if(!empty($this->data)){
			$url = array("action"=>"index");
			foreach($this->data['Filter'] as $key => $value){
				$url[$key] = $value;
			}
			$this->redirect($url);
		}
		$this->loadModel('T2calonMahasiswa');
		$this->T2calonMahasiswa->recursive = 0;
		if(!empty($this->params['named'])) {
            $conditions = array();
            foreach($this->params['named'] as $key => $value) {
                if($key!="page"&&$key!="sort"&&$key!="direction" && !empty($value)) {
                    $conditions["Tmahasiswa.$key LIKE"] = "%".trim($value)."%";
                }
            }
            $this->paginate = array_merge($this->paginate, array(
				'conditions' => $conditions,
			));

			$this->data['Filter'] = $this->params['named'];
        }
        
		$ttahunAjarans = $this->T2calonMahasiswa->TtahunAjaran->find('list');
        $tfakultases = $this->T2calonMahasiswa->Tfakultase->find('list');
        $tprograms = $this->T2calonMahasiswa->Tprogram->find('list');
        $tjurusans = $this->T2calonMahasiswa->Tjurusan->find('list');;
        $this->loadModel('Refdetil');
		$status_aktif = $this->Refdetil->generateList($code = '05');
		$status_masuk = $this->Refdetil->generateList($code = '06');
		$jenjang_studi = $this->Refdetil->generateList($code = '04');
		$this->set('status_aktif',$status_aktif);
		$this->set('status_masuk',$status_masuk);
		$this->set('jenjang_studi',$jenjang_studi);
		$this->set(compact('ttahunAjarans','tfakultases', 'tprograms', 'tjurusans'));
		$this->set('tmahasiswas', $this->paginate('Tmahasiswa'));
		//pr($this->paginate);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tmahasiswa.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tmahasiswa', $this->Tmahasiswa->read(null, $id));
	}

	function add() {
		$ambil_jurusan = explode("-",$this->data['T2calonMahasiswa']['ambil_jurusan']);
		/*pr($ambil_jurusan);
die();*/
		if (!empty($this->data)) {
			//pr($this->data);exit;
			$this->loadModel('T2calonMahasiswa');
			$this->data['T2calonMahasiswa']['NIM'] = $this->data['Tmahasiswa']['NIM'];
			$this->data['T2calonMahasiswa']['NO_TEST'] = $this->data['T2calonMahasiswa']['NO_REGISTRASI'];
				$this->data['T2calonMahasiswa']['TJURUSAN_ID'] = $ambil_jurusan[1];
					$this->data['T2calonMahasiswa']['TPROGRAM_ID'] = $ambil_jurusan[0];
			if ($this->T2calonMahasiswa->save($this->data['T2calonMahasiswa'])) {
				$this->loadModel('User');
//                $this->User->create();
//				$this->User->save(array(
//					'USERNAME' => $this->data['Tmahasiswa']['NIM'],
//					'ENABLED_USER' => 0,
//					'TYPE'	=> 'MAHASISWA'
//				));
//
//				move_uploaded_file($this->data['Tmahasiswa']['file_foto']['tmp_name'],"files/".$this->Tmahasiswa->getInsertID());
//				$this->data['Tmahasiswa']["PHOTO"] = "files/".$this->Tmahasiswa->getInsertID();
//				$this->Tmahasiswa->saveField("PHOTO","files/".$this->Tmahasiswa->getInsertID());
//                $this->Tmahasiswa->saveField('USER_ID',$this->User->id);
				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}else{
			$this->loadModel('Option');
			$option = $this->Option->find("first");
			$this->data["Tmahasiswa"]['TTAHUN_AJARAN_ID'] = $option['Option']['ttahun_ajaran_id'];
		}
		$this->loadModel('Tmahasiswa');
		$ttahunAjarans = $this->Tmahasiswa->TtahunAjaran->find('list');
		$tagamas = $this->Tmahasiswa->Tagama->find('list');
		$tfakultases = $this->Tmahasiswa->Tfakultase->find('list');
		$tprograms = $this->Tmahasiswa->Tprogram->find('list');
		$tjurusans = $this->Tmahasiswa->Tjurusan->find('list');
		//$tpropinsis = $this->Tmahasiswa->Tpropinsi->find('list');
		//$tkabupatens = $this->Tmahasiswa->Tkabupaten->find('list');
		$tdosens = $this->Tmahasiswa->Tdosen->find('list');
		$tkelases = $this->Tmahasiswa->Tkelase->find('list');
		$this->loadModel('Refdetil');
		$status_aktif = $this->Refdetil->generateList($code = '05');
		$status_masuk = $this->Refdetil->generateList($code = '06');
		$jenjang_studi = $this->Refdetil->generateList($code = '04');
		$this->set('status_aktif',$status_aktif);
		$this->set('status_masuk',$status_masuk);
		$this->set('jenjang_studi',$jenjang_studi);
		$this->set(compact('tagamas', 'tfakultases', 'tprograms','tjurusans','tpropinsis','tkabupatens','tdosens','ttahunAjarans','tkelases','status_aktif'));
	}

	function edit($id = null) {
	
		$this->loadModel('T2calonMahasiswa');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tmahasiswa', true));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
				if ($this->T2calonMahasiswa->save($this->data['T2calonMahasiswa'])) {
				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->T2calonMahasiswa->read(null, $id);
			//pr($this->data);
		}
		$tagamas = $this->Tmahasiswa->Tagama->find('list');
		$tfakultases = $this->Tmahasiswa->Tfakultase->find('list');
		$tprograms = $this->Tmahasiswa->Tprogram->find('list');
		$tjurusans = $this->Tmahasiswa->Tjurusan->find('list');
		$tdosens = $this->Tmahasiswa->Tdosen->find('list');
		$ttahunAjarans = $this->Tmahasiswa->TtahunAjaran->find('list');
		$tkelases = $this->Tmahasiswa->Tkelase->find('list');
		$this->loadModel('Refdetil');
		$status_aktif = $this->Refdetil->generateList($code = '05');
		$status_masuk = $this->Refdetil->generateList($code = '06');
		$jenjang_studi = $this->Refdetil->generateList($code = '04');
		$this->set('status_aktif',$status_aktif);
		$this->set('status_masuk',$status_masuk);
		$this->set('jenjang_studi',$jenjang_studi);
		$this->set(compact('tagamas', 'tfakultases', 'tprograms','tjurusans','tpropinsis','tkabupatens','tdosens','ttahunAjarans','tkelases'));
	}

	function delete($id = null) {
		$this->loadModel('Tmahasiswa');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tmahasiswa', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tmahasiswa->del($id)) {
			$this->Session->setFlash(__('Tmahasiswa deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function getkabupaten() {
		$this->loadModel('Tmahasiswa');
		$this->layout="ajax";
		$tkabupatens = $this->Tmahasiswa->Tkabupaten->find('list', array ('conditions'=>array('Tkabupaten.KD_PROP'=>$this->data['Tmahasiswa']['KD_PROP_ALAMAT'])));
		$this->set(compact('tkabupatens'));

	}

	function getkabupatenasal() {
		$this->loadModel('Tmahasiswa');
		$this->layout="ajax";
		$tkabupatens = $this->Tmahasiswa->Tkabupaten->find('list', array ('conditions'=>array('Tkabupaten.KD_PROP'=>$this->data['Tmahasiswa']['KD_PROP_ASAL'])));
		$this->set(compact('tkabupatens'));

	}

	function getkabupatenlahir() {
		$this->loadModel('Tmahasiswa');
		$this->layout="ajax";
		$tkabupatens = $this->Tmahasiswa->Tkabupaten->find('list', array ('conditions'=>array('Tkabupaten.KD_PROP'=>$this->data['Tmahasiswa']['KD_PROP_LAHIR'])));
		$this->set(compact('tkabupatens'));

	}

	function upload(){
		$session = $this->Session;
		$this->layout = 'ajax';
		$filename = $this->data['Tmahasiswa']['file_foto']['name'];
		$this->set("filename",$filename);
		if(move_uploaded_file($this->data['Tmahasiswa']['file_foto']['tmp_name'],WWW_ROOT.'files/'.$filename)){
		}
		else{
		}
	}

	function ajax_upload(){
		$this->layout = 'ajax';
		Configure::write('debug', 0);
		$filename = $_FILES['file']['name'];
		echo $_FILES['file']['tmp_name'];
		if (move_uploaded_file($_FILES['file']['tmp_name'], WWW_ROOT .'files/'.$filename)) {
			echo $filename;
		}
	}

	function getnim(){
		$this->loadModel('Tmahasiswa');
		$this->loadModel('TcalonMahasiswa');
		$this->loadModel('TtahunAjaran');
		$this->layout = 'ajax';
		$this->loadModel('GelombangPendaftaran');
		$this->loadModel('Configuration');
		$gelombangId = $this->Configuration->getValue('gelombangPendaftaranId');

		$kode = $this->GelombangPendaftaran->query("SELECT c.*, a.nomor FROM ttahun_ajarans c, gelombang_pendaftarans a, options b where a.ttahun_ajaran_id = b.ttahun_ajaran_id and c.id = b.ttahun_ajaran_id");
		$kodeAng = $kode['0']['c']['kodeAngkatan'];
		$id_thn = $kode['0']['a']['nomor'];
		$t = $kode['0']['c']['nama'];
		
		$mhs = $this->TcalonMahasiswa->find('first', array( 'order' => 'TcalonMahasiswa.NO_REGISTRASI DESC'));
		$last_reg = $mhs['TcalonMahasiswa']['NO_REGISTRASI'];
		$start = strrpos($last_reg, $kodeAng);
		$no_urut = substr($last_reg, $start+3);
		$xnim = $no_urut + 1;
		
		$noUrut = (int) substr($last_reg, 4, 6);
		$noUrut++;
 
		//$newID = $kodeAng."".$id_thn.sprintf("%02s", $noUrut);
		
		
		$countkodeAng = strlen($kodeAng);
		$countid_thn = strlen($id_thn);
		//$countjur = strlen($jur);
		$countxnim = strlen($noUrut);
		if($countkodeAng == 2){
			$kodeAng = $kodeAng;
		}else if($countkodeAng == 1){
			$kodeAng = '0'.$kodeAng;
		}

		if($countid_thn == 2){
			$id_thn = $id_thn;
		}else if($countid_thn = 1){
			$id_thn = '0'. $id_thn;
		}
		
		if($countxnim == 3){
			$noUrut = $noUrut;
		}else if($countxnim == 2){
			$noUrut = '0'.$noUrut;
		}else if($countxnim == 1){
			$noUrut = '00'.$noUrut;
		}

		$reg = $kodeAng.$id_thn.$xnim;
		$this->set('reg', $reg);
	}

	function getjurusan() {
		$this->layout="ajax";
		$this->loadModel('Tjurusan');
		$tjurusans = $this->Tjurusan->find('list', array ('conditions'=>array('Tjurusan.programStudi'=>$this->data['Filter']['TPROGRAM_ID'],'Tjurusan.fakultas'=>$this->data['Filter']['TFAKULTAS_ID'])));
		$this->set(compact('tjurusans'));
	}
	function getregistrasi() {
		$this->loadModel('TcalonMahasiswa');
		$this->loadModel('GelombangPendaftaran');
		$this->loadModel('TtahunAjaran');
		$this->layout = 'ajax';
		
		//pr($this->GelombangPendaftaran);
		$this->loadModel('GelombangPendaftaran');
		$kode = $this->GelombangPendaftaran->query("SELECT c.* FROM ttahun_ajarans c, gelombang_pendaftarans a, options b where a.ttahun_ajaran_id = b.ttahun_ajaran_id and c.id = b.ttahun_ajaran_id");
		pr($kode);
		
		$kodeAng = $kode['0']['c']['kodeAngkatan'];
		$id_thn = $kode['0']['c']['id'];
		$t = $kode['0']['c']['nama'];
		
		
		$prog=$this->data['T2calonMahasiswa']['TPROGRAM_ID'];
		$fak=$this->data['TcalonMahasiswa']['TFAKULTAS_ID'];
		$jur=$this->data['T2calonMahasiswa']['TJURUSAN_ID'];
		$thn=$this->data['TcalonMahasiswa']['TTAHUN_AJARAN_ID'];
		$tahuns = $this->TcalonMahasiswa->TtahunAjaran->find('first', array('conditions' => array('TtahunAjaran.id' => $thn)));
		$tahun = $tahuns['TtahunAjaran']['kodeAngkatan'];
		
		//$mhs = $this->TcalonMahasiswa->find('first', array('conditions' => array('TcalonMahasiswa.TJURUSAN_ID' => $jur, 'TcalonMahasiswa.TPROGRAM_ID' => $prog) ,'order' => 'Tmahasiswa.NIM DESC'));
		//pr($this->data);
		$mhs = $this->TcalonMahasiswa->find('last');
		//pr($mhs);
		$last_reg = $mhs['T2calonMahasiswa']['NO_REGISTRASI'];
		$start = strrpos($lastnim, $kodeAng);
		$no_urut = substr($lastnim, $start+2);
		$xnim = $no_urut + 1;
		$countkodeAng = strlen($kodeAng);
		$countid_thn = strlen($id_thn);
		$countjur = strlen($jur);
		$countxnim = strlen($xnim);
		if($countkodeAng == 2){
			$kodeAng = $kodeAng;
		}else if($countkodeAng == 1){
			$kodeAng = '0'.$kodeAng;
		}

		if($countid_thn == 2){
			$id_thn = $id_thn;
		}else if($countid_thn = 1){
			$id_thn = '0'. $id_thn;
		}

		if($countjur == 2 ){
		$jur = $jur;
		}else if($countjur == 1){
			$jur = '0'. $jur;
		}

		if($countxnim == 3){
			$snim = $xnim;
		}else if($countxnim == 2){
			$snim = '0'.$xnim;
		}else if($countxnim == 1){
			$snim = '00'.$xnim;
		}

		$reg = $kodeAng.$id_thn.$snim;
		$this->set('no_registrasi', $reg);
	}



}
?>

<?php
class TcalonMahasiswasController extends AppController { 

	var $name = 'TcalonMahasiswas';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $primaryKey = 'NIM';

	function index() {
		
		if(!empty($this->data)){
			$url = array("action"=>"index");
			foreach($this->data['Filter'] as $key => $value){
				$url[$key] = $value;
			}
			$this->redirect($url);
		}
		$this->loadModel('TcalonMahasiswa');
		$this->TcalonMahasiswa->recursive = 0;
		
		if(!empty($this->params['named'])) {
            $conditions = array();
            foreach($this->params['named'] as $key => $value) {
                if($key!="page"&&$key!="sort"&&$key!="direction" && !empty($value)) {
                    $conditions["TcalonMahasiswa.$key LIKE"] = "%".trim($value)."%";
                }
            }
            $this->paginate = array_merge($this->paginate, array(
				'conditions' => $conditions,
			));

			$this->data['Filter'] = $this->params['named'];
        }
		$ttahunAjarans = $this->TcalonMahasiswa->TtahunAjaran->find('list');
        $tfakultases = $this->TcalonMahasiswa->Tfakultase->find('list');
        $tprograms = $this->TcalonMahasiswa->Tprogram->find('list');
        $tjurusans = $this->TcalonMahasiswa->Tjurusan->find('list');;
        $this->loadModel('Refdetil');
		$status_aktif = $this->Refdetil->generateList($code = '05');
		$status_masuk = $this->Refdetil->generateList($code = '06');
		$jenjang_studi = $this->Refdetil->generateList($code = '04');
		$this->loadModel("Configuration");
		$gelombangId = $this->Configuration->getValue('gelombangPendaftaranId');
		$gelombangs = ClassRegistry::init('GelombangPendaftaran')->getList();

		$gelombang_pendaftaran = $this->TcalonMahasiswa->GelombangPendaftaran->find('list');
		//pr($gelombang_pendaftaran);
		$this->loadModel('T2calonMahasiswa');
		
		$prog_fix = $this->T2calonMahasiswa->Tprogram->find('list');
		$jur_fix = $this->T2calonMahasiswa->Tjurusan->find('list');
		
		//pr($this->paginate('TcalonMahasiswa'));
		
		$this->set('status_aktif',$status_aktif);
		$this->set('status_masuk',$status_masuk);
		$this->set('jenjang_studi',$jenjang_studi);
		$this->set('gelombangId',$gelombang_pendaftaran);
		$this->set('jur_fix',$jur_fix);
		$this->set('prog_fix',$prog_fix);
		$this->set(compact('ttahunAjarans','tfakultases', 'tprograms', 'tjurusans','prog_fix','jur_fix'));
		$this->set('tmahasiswas', $this->paginate('TcalonMahasiswa'));
		
		
		//pr($this->paginate);
	}

function diterima($id = null) {
	$this->loadModel('TcalonMahasiswa');
		$this->TcalonMahasiswa->read(null, $id);
		$this->TcalonMahasiswa->saveField('status', 0);
		header('Location:' . $_SERVER['HTTP_REFERER']);

	}
	function tidak_diterima($id = null) {
		$this->loadModel('TcalonMahasiswa');
		$this->TcalonMahasiswa->read(null, $id);
		$this->TcalonMahasiswa->saveField('status', 1);
		header('Location:' . $_SERVER['HTTP_REFERER']);
	}
	
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tmahasiswa.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tmahasiswa', $this->TcalonMahasiswa->read(null, $id));
	}

	function kelengkapan($NO_REGISTRASI = null) {
		$this->loadModel('TperlengkapansTcalonMahasiswa');
		
		//pr($this->TperlengkapansTcalonMahasiswa);
		if (!empty($this->data)) {
			pr($this->data);exit;
			if ($this->TcalonMahasiswa->save($this->data)) {
				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
				
			}
		}else{
			
		
		}
		
		$this->data = $this->TcalonMahasiswa->read(null, $NO_REGISTRASI);
		
		$this->loadModel('TcalonMahasiswa');
		$tperlengkapans = $this->TcalonMahasiswa->Tperlengkapan->find('list');
		$this->set(compact('tperlengkapans'));
		$this->loadModel('Tperlengkapan');
		$perlengkapan = $this->Tperlengkapan->find('all');
		$this->set('NO_REGISTRASI', $NO_REGISTRASI);
		$this->set('perlengkapan', $perlengkapan);
	}


	function add() {
		
		$this->loadModel("Configuration");
		$gelombangId = $this->Configuration->getValue('gelombangPendaftaranId');
		if (!empty($this->data)) {
			//pr($this->data);exit();
			$this->loadModel('TcalonMahasiswa');
			
			$this->data['TcalonMahasiswa']['gelombang_id'] = $gelombangId;
			if ($this->TcalonMahasiswa->save($this->data['TcalonMahasiswa'])) {
//				$this->loadModel('User');
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
				$rata = $this->data['TcalonMahasiswa']['nilai_matematika'] + $this->data['TcalonMahasiswa']['nilai_kemampuan']
						+ $this->data['TcalonMahasiswa']['nilai_bahasa'];
						$rata2 = $rata / 3;
				$this->TcalonMahasiswa->saveField('nilai_rata2', $rata2);   
				//$this->TcalonMahasiswa->saveField('GELOMBANG_ID', $gelombangId);
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
		$this->loadModel('TcalonMahasiswa');
		$ttahunAjarans = $this->TcalonMahasiswa->TtahunAjaran->find('list');
		$tagamas = $this->TcalonMahasiswa->Tagama->find('list');
		$tfakultases = $this->TcalonMahasiswa->Tfakultase->find('list');
		$tprograms = $this->TcalonMahasiswa->Tprogram->find('list');
		$tjurusans = $this->TcalonMahasiswa->Tjurusan->find('list');
		//$tpropinsis = $this->TcalonMahasiswa->Tpropinsi->find('list');
		//$tkabupatens = $this->TcalonMahasiswa->Tkabupaten->find('list');
		$tdosens = $this->TcalonMahasiswa->Tdosen->find('list');
		$tkelases = $this->TcalonMahasiswa->Tkelase->find('list');
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
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tmahasiswa', true));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
			$this->loadModel('TcalonMahasiswa');
			//$this->Tmahasiswa->create();
			if ($this->TcalonMahasiswa->save($this->data)) {
			/*	$filename = $this->data['TcalonMahasiswa']['file_foto']['name'];
				move_uploaded_file(WWW_ROOT.'files/'.$filename,"files/".$id);

				$this->data['Tmahasiswa']["PHOTO"] = "files/".$id;
				$this->Tmahasiswa->saveField("PHOTO","files/".$filename);*/
				
				$rata = $this->data['TcalonMahasiswa']['nilai_matematika'] + $this->data['TcalonMahasiswa']['nilai_kemampuan']
						+ $this->data['TcalonMahasiswa']['nilai_bahasa'];
				$rata2 = $rata / 3;
				$this->TcalonMahasiswa->saveField('nilai_rata2', $rata2);   

				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TcalonMahasiswa->read(null, $id);
		}
		$tagamas = $this->TcalonMahasiswa->Tagama->find('list');
		$tfakultases = $this->TcalonMahasiswa->Tfakultase->find('list');
		$tprograms = $this->TcalonMahasiswa->Tprogram->find('list');
		$tjurusans = $this->TcalonMahasiswa->Tjurusan->find('list');
		//$tpropinsis = $this->TcalonMahasiswa->Tpropinsi->find('list');
		//$tkabupatens = $this->TcalonMahasiswa->Tkabupaten->find('list');
		$tdosens = $this->TcalonMahasiswa->Tdosen->find('list');
		$ttahunAjarans = $this->TcalonMahasiswa->TtahunAjaran->find('list');
		$tkelases = $this->TcalonMahasiswa->Tkelase->find('list');
		$this->loadModel('Refdetil');
		$status_aktif = $this->Refdetil->generateList($code = '05');
		$status_masuk = $this->Refdetil->generateList($code = '06');
		$jenjang_studi = $this->Refdetil->generateList($code = '04');
		$this->set('status_aktif',$status_aktif);
		$this->set('status_masuk',$status_masuk);
		$this->set('jenjang_studi',$jenjang_studi);
		$this->set(compact('tagamas', 'tfakultases', 'tprograms','tjurusans','tpropinsis','tkabupatens','tdosens','ttahunAjarans','tkelases'));
	}

	
function edit_nilai($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tmahasiswa', true));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
			$this->loadModel('TcalonMahasiswa');
			//$this->Tmahasiswa->create();
			if ($this->TcalonMahasiswa->save($this->data)) {
			/*	$filename = $this->data['TcalonMahasiswa']['file_foto']['name'];
				move_uploaded_file(WWW_ROOT.'files/'.$filename,"files/".$id);

				$this->data['Tmahasiswa']["PHOTO"] = "files/".$id;
				$this->Tmahasiswa->saveField("PHOTO","files/".$filename);*/
				$rata = $this->data['TcalonMahasiswa']['nilai_matematika'] + $this->data['TcalonMahasiswa']['nilai_kemampuan']
						+ $this->data['TcalonMahasiswa']['nilai_bahasa'];
					$rata2 = $rata / 3;
				$this->TcalonMahasiswa->saveField('nilai_rata2', $rata2);   

				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TcalonMahasiswa->read(null, $id);
		}
}
	function delete($id = null) {
		$this->loadModel('TcalonMahasiswa');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tmahasiswa', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TcalonMahasiswa->del($id)) {
			$this->Session->setFlash(__('Tmahasiswa deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function cari_no_test($no=null){
		
		
		if(!empty($this->data)){
			$url = array (
				"action" => "cari_no_test",
				$this->data['Filter']["NO_REGISTRASI"]
			);
			$this->redirect($url);
		}
	if($no){
			
			$this->loadModel('TcalonMahasiswa');
			$this->loadModel("T2calonMahasiswa");
				$payments = $this->TcalonMahasiswa->find("all",array("conditions"=>array("TcalonMahasiswa.NO_REGISTRASI"=>$no,"TcalonMahasiswa.status"=>"1")));
				$cek_reg = $this->T2calonMahasiswa->find("all",array("conditions"=>array("T2calonMahasiswa.NO_TEST"=>$no)));
				if(empty($payments)){
					$this->set("error","No.Test tidak ada atau tidak diterima dalam Penerimaan");
				}
				$this->set("payments",$payments);
				
				if(!empty($cek_reg)){
					$this->set("error2","No Registrasi ini sudah melakukan Daftar Ulang");
					
				}
				//$this->loadModel("T2calonMahasiswa");
				//$cek_nim = $this->T2calonMahasiswa->find("first",array("conditions"=>array("T2calonMahasiswa.NIM"=>)))
				
			}
			else{
				$this->set("error","Calon Mahasiswa dengan No Test : $no tidak ditemukan.");
			}
			$this->data["TcalonMahasiswa"]["NO_REGISTRASI"] = $no;
			$this->set("no",$no);
			$this->loadModel('Refdetil');
			$tprograms = $this->TcalonMahasiswa->Tprogram->find('list');
			$tjurusans = $this->TcalonMahasiswa->Tjurusan->find('list');
			$jenjang_studi = $this->Refdetil->generateList($code = '04');
			$this->set('jenjang_studi',$jenjang_studi);
			$this->set(compact('tjurusans'));
		
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
		$this->loadModel('TcalonMahasiswa');
		$this->loadModel('T2calonMahasiswa');
		$this->loadModel('TtahunAjaran');
		$this->loadModel('Option');
		$this->layout = 'ajax';
		//$tahun_berjalan = $this->Option->find('list');
		//$thn = $this->Option['ttahun_ajaran_id'];
		$ambil_jurusan = explode("-",$this->data['T2calonMahasiswa']['ambil_jurusan']);
		$this->loadModel('Configuration');
		//pr($this->data['T2calonMahasiswa']['ambil_jurusan']);
		$gelombangId = $this->Configuration->getValue('gelombangPendaftaranId');
		$prog=$ambil_jurusan[0];
		
		$jur=$ambil_jurusan[1];
		$this->loadModel('T2calonMahasiswa');
		//$mhs = $this->T2calonMahasiswa->find('first', array('order' => 'T2calonMahasiswa.NIM DESC'));
		$mhs = $this->T2calonMahasiswa->find('first', array('conditions' => array('T2calonMahasiswa.TJURUSAN_ID' => $jur, 'T2calonMahasiswa.TPROGRAM_ID' => $prog) ,'order' => 'T2calonMahasiswa.NIM DESC'));
		//pr($this->data);
		//pr($mhs);
		$lastnim = $mhs['T2calonMahasiswa']['NIM'];
		//$start = strrpos($lastnim, $tahun);
		//$no_urut = substr($lastnim, $start+2);
		
		$noUrut = (int) substr($lastnim, 4, 6);
		$noUrut++;
 		
		//$xnim = $no_urut + 1;
		$countprog = strlen($prog);
		//$countfak = strlen($fak);
		$countjur = strlen($jur);
		$countxnim = strlen($noUrut);
		if($countprog == 2){
			$prog = $prog;
		}else if($countprog == 1){
			$prog = '0'.$prog;
		}

			if($countjur == 2 ){
		$jur = $jur;
		}else if($countjur == 1){
			$jur = '0'. $jur;
		}

		if($countxnim == 3){
			$snim = $noUrut;
		}else if($countxnim == 2){
			$snim = '0'.$noUrut;
		}else if($countxnim == 1){
			$snim = '00'.$noUrut;
		}

		$nim = $prog.$jur.$snim;
		$this->set('nim', $nim);
	}

	
}
?>

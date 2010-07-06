<?php
class T2calonMahasiswasController extends AppController {

	var $name = 'T2calonMahasiswas';
	var $helpers = array('Html', 'Form', 'Ajax', 'Javascript');
	var $primaryKey = 'NIM';

	function index() {
		
		if(!empty($this->data)){
			$url = array("action"=>"../tmahasiswas/index");
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
		$this->set('status_aktif',$status_aktif);
		$this->set('status_masuk',$status_masuk);
		$this->set('jenjang_studi',$jenjang_studi);
		$this->set(compact('ttahunAjarans','tfakultases', 'tprograms', 'tjurusans'));
		$this->set('tmahasiswas', $this->paginate('TcalonMahasiswa'));
		//pr($this->paginate);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tmahasiswa.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tmahasiswa', $this->TcalonMahasiswa->read(null, $id));
	}

	function add() {
		
		if (!empty($this->data)) {
			//pr($this->data);exit();
			$this->loadModel('T2calonMahasiswa');
			$this->data['T2calonMahasiswa']['NIM'] = $this->data['Tmahasiswa']['NIM'];
			if ($this->T2calonMahasiswa->save($this->data['T2calonMahasiswa'])) {
				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'../tmahasiswas/index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}else{
			$this->loadModel('Option');
			$option = $this->Option->find("first");
			$this->data["Tmahasiswa"]['TTAHUN_AJARAN_ID'] = $option['Option']['ttahun_ajaran_id'];
		}
		$this->loadModel('T2calonMahasiswa');
		$ttahunAjarans = $this->T2calonMahasiswa->TtahunAjaran->find('list');
		$tagamas = $this->T2calonMahasiswa->Tagama->find('list');
		$tfakultases = $this->T2calonMahasiswa->Tfakultase->find('list');
		$tprograms = $this->T2calonMahasiswa->Tprogram->find('list');
		$tjurusans = $this->T2calonMahasiswa->Tjurusan->find('list');
		//$tpropinsis = $this->T2calonMahasiswa->Tpropinsi->find('list');
		//$tkabupatens = $this->T2calonMahasiswa->Tkabupaten->find('list');
		$tdosens = $this->T2calonMahasiswa->Tdosen->find('list');
		$tkelases = $this->T2calonMahasiswa->Tkelase->find('list');
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
			$this->loadModel('T2calonMahasiswa');
			//pr($this->data);exit;
	
			if ($this->T2calonMahasiswa->save($this->data['T2calonMahasiswa'])) {
				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'../tmahasiswas/index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}
			if (empty($this->data)) {
			$this->data = $this->T2calonMahasiswa->read(null, $id);
		}
		$tagamas = $this->T2calonMahasiswa->Tagama->find('list');
		$tfakultases = $this->T2calonMahasiswa->Tfakultase->find('list');
		$tprograms = $this->T2calonMahasiswa->Tprogram->find('list');
		$tjurusans = $this->T2calonMahasiswa->Tjurusan->find('list');
		//$tpropinsis = $this->T2calonMahasiswa->Tpropinsi->find('list');
		//$tkabupatens = $this->T2calonMahasiswa->Tkabupaten->find('list');
		$tdosens = $this->T2calonMahasiswa->Tdosen->find('list');
		$ttahunAjarans = $this->T2calonMahasiswa->TtahunAjaran->find('list');
		$tkelases = $this->T2calonMahasiswa->Tkelase->find('list');
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
			$this->loadModel('T2calonMahasiswa');
			//$this->Tmahasiswa->create();
			if ($this->T2calonMahasiswa->save($this->data)) {
			/*	$filename = $this->data['T2calonMahasiswa']['file_foto']['name'];
				move_uploaded_file(WWW_ROOT.'files/'.$filename,"files/".$id);

				$this->data['Tmahasiswa']["PHOTO"] = "files/".$id;
				$this->Tmahasiswa->saveField("PHOTO","files/".$filename);*/
				$rata = $this->data['T2calonMahasiswa']['nilai_matematika'] + $this->data['T2calonMahasiswa']['nilai_kemampuan']
						+ $this->data['T2calonMahasiswa']['nilai_bahasa'];
					$rata2 = $rata / 3;
				$this->T2calonMahasiswa->saveField('nilai_rata2', $rata2);   

				$this->Session->setFlash(__('The Tmahasiswa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tmahasiswa could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->T2calonMahasiswa->read(null, $id);
		}
}
	function delete($id = null) {
		$this->loadModel('T2calonMahasiswa');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tmahasiswa', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->T2calonMahasiswa->del($id)) {
			$this->Session->setFlash(__('Tmahasiswa deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function cari_no_test($no=null){
		if(!empty($this->data)){
			$url = array (
				"action" => "cari_no_test",
				$this->data['Filter']["NO_TEST"]
			);
			$this->redirect($url);
		}
	if($no){
			
			$this->loadModel('T2calonMahasiswa');
				$payments = $this->T2calonMahasiswa->find("all",array("conditions"=>array("T2calonMahasiswa.NO_TEST"=>$no)));
				if(empty($payments)){
					$this->set("error","No.Test tidak ada");
				}
				$this->set("payments",$payments);
				//$this->loadModel("T2calonMahasiswa");
				//$cek_nim = $this->T2calonMahasiswa->find("first",array("conditions"=>array("T2calonMahasiswa.NIM"=>)))
				
			}
			else{
				$this->set("error","Calon Mahasiswa dengan No Test : $no tidak ditemukan.");
			}
			$this->data["T2calonMahasiswa"]["NO_TEST"] = $no;
			$this->set("no",$no);
			$this->loadModel('Refdetil');
			$tprograms = $this->T2calonMahasiswa->Tprogram->find('list');
			$tjurusans = $this->T2calonMahasiswa->Tjurusan->find('list');
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
		$this->loadModel('T2calonMahasiswa');
		$this->loadModel('TtahunAjaran');
		$this->layout = 'ajax';
		$prog=$this->data['T2calonMahasiswa']['TPROGRAM_ID'];
		$fak=$this->data['T2calonMahasiswa']['TFAKULTAS_ID'];
		$jur=$this->data['T2calonMahasiswa']['TJURUSAN_ID'];
		$thn=$this->data['T2calonMahasiswa']['TTAHUN_AJARAN_ID'];
		$tahuns = $this->T2calonMahasiswa->TtahunAjaran->find('first', array('conditions' => array('TtahunAjaran.id' => $thn)));
		$tahun = $tahuns['TtahunAjaran']['kodeAngkatan'];
		$mhs = $this->T2calonMahasiswa->find('first', array('conditions' => array('T2calonMahasiswa.TJURUSAN_ID' => $jur, 'T2calonMahasiswa.TPROGRAM_ID' => $prog) ,'order' => 'Tmahasiswa.NIM DESC'));
		//pr($this->data);
		//pr($mhs);
		$lastnim = $mhs['T2calonMahasiswa']['NIM'];
		$start = strrpos($lastnim, $tahun);
		$no_urut = substr($lastnim, $start+2);
		$xnim = $no_urut + 1;
		$countprog = strlen($prog);
		$countfak = strlen($fak);
		$countjur = strlen($jur);
		$countxnim = strlen($xnim);
		if($countprog == 2){
			$prog = $prog;
		}else if($countprog == 1){
			$prog = '0'.$prog;
		}

		if($countfak == 2){
			$fak = $fak;
		}else if($countfak = 1){
			$fak = '0'. $fak;
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

		$nim = $prog.$jur.$snim;
		$this->set('nim', $nim);
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
		$mhs = $this->TcalonMahasiswa->find('all');
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

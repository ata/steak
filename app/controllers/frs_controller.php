<?php
class FrsController extends AppController {

	var $name = 'Frs';
	var $uses = array (
		'Tkelase',
		'Tmatakuliah',
		'Tmahasiswa',
		'Tjurusan',
		'FormStudi',
		'KartuStudi',
		'Option'
	);
	var $helpers = array (
		'Html',
		'Form',
		'Ajax',
		'Fpdf','Ksm'
	);

	function registrasi() {
		$matakuls = $this->Tmatakuliah->find('all', array (
			'conditions' => array (
				'IS_BUKA' => '1'
			)
		));
		$this->set('matkuls', $matakuls);

		$params = null;
		$params2 = null;

		if (isset ($this->data['Filter'])) {
			$url = array (
				'action' => 'registrasi'
			);
			foreach ($this->data['Filter'] as $key => $value) {
				$url[$key] = $value;
			}
			$this->redirect($url);

		}
		if (!empty ($this->params['named'])) {
			$conditions = array ();
			foreach ($this->params['named'] as $key => $value) {
				if (!empty ($value)) {
					$conditions['Tmatakuliah.$key LIKE'] = '%' . trim($value) . '%';
				}
			}

			$this->paginate = array (
				'conditions' => $conditions
			);
			$this->data['Filter'] = $this->params['named'];
			$params = array (
				'conditions' => array (
					'fakultas' => $this->params['named']['FAKULTAS'],
					'programStudi' => $this->params['named']['PROGRAM_STUDI']
				)
			);
		}

		$tfakultases = $this->Tmatakuliah->Tfakultase->find('list');
		//$tprograms = $this->Tmatakuliah->Tprogram->find('list');
		$this->loadModel('Refdetil');
		$tprograms = $this->Refdetil->generateList($code = '04');
		$tjurusans = null; //$this->Tmatakuliah->Tjurusan->find('list');

		if (($tfakultases != '') || ($tprograms != '')) {
			$this->set('lblforeignkey', 'Jurusan');

		}
		$this->set(compact('tfakultases', 'tprograms', 'tjurusans'));
	}

	function index() {
		$auth = $this->Session->read('Auth');
		$option = $this->Option->find('first');
		$nim = $auth['User']['USERNAME'];
		$this->Tmahasiswa->recursive = 1;
		$pembayaran = array('TstatusPembayaran.tahun_ajaran'=> $option['Option']['ttahun_ajaran_id'],
				'TstatusPembayaran.semester'=>$option['Option']['tsemester_id']);
		$this->Tmahasiswa->hasMany['TstatusPembayaran']['conditions'] = $pembayaran;
		$mahasiswa = $this->Tmahasiswa->find('first',array('conditions'=>array('NIM'=>$nim)));
		$this->set('tmahasiswa', $mahasiswa);
		$this->KartuStudi->recursive = 3;

		$conditions = array (
			'FormStudi.NIM' => $nim,
			'FormStudi.tsemester_id' => $option['Option']['tsemester_id'],
			'FormStudi.ttahun_ajaran_id' => $option['Option']['ttahun_ajaran_id']
		);

		$kartuStudis = $this->KartuStudi->find('all', array (
			'conditions' => $conditions
		));
		//pr($kartuStudis);
		$this->set('kartuStudis', $kartuStudis);
		$this->Tmatakuliah->recursive = 0;

	}

	function simpanFrs() {
		$this->layout = 'ajax';
		//pr($this->data);

		$FormStudi = array ();

		if (!empty ($this->data)) {
			//	pr($this->data);
			$this->Tmatakuliah->create();
			$auth = $this->Session->read('Auth');
			$option = $this->Option->find('first');
			$nim = $auth['User']['USERNAME'];

			$conditions = array (
				'FormStudi.NIM' => $nim,
				'FormStudi.tsemester_id' => $option['Option']['tsemester_id'],
				'FormStudi.ttahun_ajaran_id' => $option['Option']['ttahun_ajaran_id']
			);
			$FormStudi = $this->FormStudi->find('first',array('conditions'=>$conditions));

			if (empty ($FormStudi['FormStudi'])) {

				$FormStudi['FormStudi']['NIM'] = $nim;

				$FormStudi['FormStudi']['tsemester_id'] = $option['Option']['tsemester_id'];
				$FormStudi['FormStudi']['ttahun_ajaran_id'] = $option['Option']['ttahun_ajaran_id'];

				$this->FormStudi->save($FormStudi);
				$FormStudi_id = $this->FormStudi->getInsertId();
			} else {
				$FormStudi_id = $FormStudi['FormStudi']['id'];
			}

			//$this->KartuStudi->deleteAll(array('FormStudi.id'=>$FormStudi_id));

			foreach ($this->data as $kelas) {
				//pr($kelas);
				if (!empty ($kelas['check'])) {
					$KartuStudi = array ();
					$KartuStudi['id'] = null;
					$KartuStudi['form_studi_id'] = $FormStudi_id;
					//pr($kelas['KartuStudi']['kelas_id']);
					$KartuStudi['kelas_id'] = $kelas['kelas'];

					$this->KartuStudi->save($KartuStudi);
				}
				//}

				//$this->Session->setFlash(__('FRS has been saved', true));

			}
			$this->redirect(array (
				'action' => 'index'
			));
		}
	}

	function hapus() {
		$this->layout = 'ajax';
		//pr($this->data);
		$formStudi_id = $this->data['formid'];
		foreach ($this->data['krs'] as $kelas) {
			if (!empty ($kelas['check'])) {

				$this->KartuStudi->del($kelas['kelas']);
			}

		}

		//echo 'id form studi : $formStudi_id';
		$this->KartuStudi->recursive = 3;
		$kartuStudis = $this->KartuStudi->find('all', array (
			'conditions' => array (
				'form_studi_id' => $formStudi_id
			)
		));
		//pr($kartuStudis);
		$this->set('kartuStudis', $kartuStudis);
		$this->viewPath = 'elements' . DS . 'frs';
		$this->render('list');
	}
	function kartustudi() {
		$auth = $this->Session->read('Auth');
		$nim = $auth['User']['USERNAME'];
		$this->Tmahasiswa->recursive = 0;
		$mahasiswa = $this->Tmahasiswa->findByNim($nim);
		$this->set('frs', $mahasiswa['Tfr']);
	}

	function viewkartustudi($id = null) {

	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Tmatakuliah', true), array (
				'action' => 'index'
			));
		}
		$this->set('tmatakuliah', $this->Tmatakuliah->read(null, $id));
	}

	function ambil_matkul($id = null) {
		$this->matkul->read(null, $id);
		//$this->matkul->saveField('IS_BUKA', 0);
		header('Location:' . $_SERVER['HTTP_REFERER']);
	}

	function getmatkul() {
		$this->layout = 'ajax';
		if(!empty($this->data['JURUSAN'])){
			$mahasiswa = $this->Session->read('Auth');
			$option = $this->Option->find('first');

			$this->FormStudi->recursive = 1;
			$fr = $this->FormStudi->find('first',array(
				'conditions'=>array('FormStudi.NIM'=>$mahasiswa['User']['USERNAME'],'FormStudi.ttahun_ajaran_id'=>$option['Option']['ttahun_ajaran_id'],'tsemester_id'=>$option['Option']['tsemester_id']),
				'fields'=>array('FormStudi.*')
			));
			$telahdiambil = array();
			if(!empty($fr['KartuStudi'])){
				foreach($fr['KartuStudi'] as $row){
					$telahdiambil[] = $row['kelas_id'];
				}
			}
			$this->Tkelase->recursive = 0;
			$matkultelahdiambil = $this->Tkelase->find('all',array('conditions'=>array('Tkelase.ID'=>$telahdiambil),'fields'=>array('KD_KULIAH')));
			$kdkuliahtelahdiambil = array();
			if(!empty($matkultelahdiambil)){
				foreach($matkultelahdiambil as $row){
					$kdkuliahtelahdiambil[] = $row['Tkelase']['KD_KULIAH'];
				}
			}

			//pr($this->data);
			$option = $this->Option->find('first');
			$this->Tmatakuliah->recursive = 1;

			$this->Tmatakuliah->hasMany['Tkelase']['conditions'] = array (
				'Tkelase.TSEMESTER_ID' => $option['Option']['tsemester_id'],
				'Tkelase.TTAHUN_AJARAN_ID' => $option['Option']['ttahun_ajaran_id']
			);
			$matkuls = $this->Tmatakuliah->find('all', array (
				'conditions' => array (
					'Tmatakuliah.IS_BUKA' => 1,
					'Tmatakuliah.program_studi_id' => $this->data['Filter']['program_studi_id'],
					'Tmatakuliah.FAKULTAS' => $this->data['Filter']['FAKULTAS'],
					'Tmatakuliah.JURUSAN' => $this->data['JURUSAN'],
					'NOT'=>array('Tmatakuliah.KD_KULIAH'=>$kdkuliahtelahdiambil)
				)
			));

			$this->set(compact('matkuls'));
		}
	}
	function getjurusan() {
		$this->layout = 'ajax';
		$tjurusans = $this->Tjurusan->find('list', array (
			'conditions' => array (
				'Tjurusan.program_studi_id' => $this->data['Filter']['program_studi_id'],
				'Tjurusan.fakultas' => $this->data['Filter']['FAKULTAS']
			)
		));
		$this->set(compact('tjurusans'));
	}

	function pdf() {
		$this->layout = 'pdf'; //this will use the pdf.thtml layout
		$this->KartuStudi->recursive = 3;
		//$this->KartuStudi->Tkelase->recursive = 2;
		$auth = $this->Session->read('Auth');
		$option = $this->Option->find('first');
		$nim = $auth['User']['USERNAME'];
		$mahasiswa = $this->Tmahasiswa->findByNim($nim);
		$conditions = array (
			'FormStudi.NIM' => $nim,
			'FormStudi.tsemester_id' => $option['Option']['tsemester_id'],
			'FormStudi.ttahun_ajaran_id' => $option['Option']['ttahun_ajaran_id']
		);

		$kartuStudis = $this->KartuStudi->find('all', array (
			'conditions' => $conditions
		));
		$this->set('kartuStudis', $kartuStudis);
		$this->set('mahasiswa', $mahasiswa);
		$this->render();
	}
}
?>

<?php
class FormStudisController extends AppController {

	var $name = 'FormStudis';
	var $uses = array("FormStudi","Tmatakuliah","Option");

	var $helpers = array('Html', 'Form','Ajax');

	function index() {
		$this->FormStudi->recursive = 0;
		$this->set('formStudis', $this->paginate());
		


	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid FormStudi.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('formStudi', $this->FormStudi->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->FormStudi->create();
			if ($this->FormStudi->save($this->data)) {
				$this->Session->setFlash(__('The FormStudi has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The FormStudi could not be saved. Please, try again.', true));
			}
		}
		$ttahunAjarans = $this->FormStudi->TtahunAjaran->find('list');
		$tsemesters = $this->FormStudi->Tsemester->find('list');
		$this->set(compact('ttahunAjarans', 'tsemesters'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid FormStudi', true));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
			if ($this->FormStudi->save($this->data)) {
				$this->Session->setFlash(__('The FormStudi has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The FormStudi could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->FormStudi->read(null, $id);
		}
		$ttahunAjarans = $this->FormStudi->TtahunAjaran->find('list');
		$tsemesters = $this->FormStudi->Tsemester->find('list');
		$this->set(compact('ttahunAjarans','tsemesters'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for FormStudi', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->FormStudi->del($id)) {
			$this->Session->setFlash(__('FormStudi deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	function cetakKSM() {

		$tfakultases = $this->Tmatakuliah->Tfakultase->find('list');
		$tprograms = $this->Tmatakuliah->Tprogram->find('list');
		$tjurusans = null; //$this->Tmatakuliah->Tjurusan->find('list');


		$this->set(compact('tfakultases', 'tprograms', 'tjurusans'));
	}
	function get_ksm() {
		$this->layout="ajax";
		$option = $this->Option->find('first');

		$conditions = array (
			"Tmahasiswa.JURUSAN"=>$this->data["JURUSAN"],
			"FormStudi.tsemester_id" => $option['Option']['tsemester_id'],
			"FormStudi.ttahun_ajaran_id" => $option['Option']['ttahun_ajaran_id']
		);
		$FormStudi = $this->FormStudi->find("all",array("conditions"=>$conditions));

		$this->set('formStudis', $this->paginate());
		$this->render();
	}
	function cetak($id) {
		$this->layout="ajax";
		$this->FormStudi->create();
		$fs = $this->FormStudi->findById($id);
		$fs['FormStudi']["status_ksm"] = 1;

		$this->FormStudi->save($fs);

		$this->render();
	}
}
?>
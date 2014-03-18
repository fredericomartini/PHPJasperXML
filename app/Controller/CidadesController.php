<?php
App::uses('AppController', 'Controller');
/**
 * Cidades Controller
 *
 * @property Cidade $Cidade
 * @property PaginatorComponent $Paginator
 */
class CidadesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cidade->recursive = 0;
		$this->set('cidades', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cidade->exists($id)) {
			throw new NotFoundException(__('Invalid cidade'));
		}
		$options = array('conditions' => array('Cidade.' . $this->Cidade->primaryKey => $id));
		$this->set('cidade', $this->Cidade->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cidade->create();
			if ($this->Cidade->save($this->request->data)) {
				return $this->flash(__('The cidade has been saved.'), array('action' => 'index'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cidade->exists($id)) {
			throw new NotFoundException(__('Invalid cidade'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cidade->save($this->request->data)) {
				return $this->flash(__('The cidade has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('Cidade.' . $this->Cidade->primaryKey => $id));
			$this->request->data = $this->Cidade->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cidade->id = $id;
		if (!$this->Cidade->exists()) {
			throw new NotFoundException(__('Invalid cidade'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cidade->delete()) {
			return $this->flash(__('The cidade has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The cidade could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}}

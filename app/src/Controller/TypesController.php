<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Types Controller
 *
 * @property \App\Model\Table\TypesTable $Types
 *
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->authorizedFlow();
        $types = $this->paginate($this->Types);
        $this->set(compact('types'));
    }

    /**
     * View method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $this->Authorization->skipAuthorization();
        // $this->authorizedFlow();
        $type = $this->Types->get($id, ['contain' => []]);
        $this->Authorization->authorize($type);
        $this->set('type', $type);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->Authorization->skipAuthorization();
        // $this->authorizedFlow();
        $type = $this->Types->newEmptyEntity();$this->Authorization->authorize($type);
        $this->Authorization->authorize($type);
        dump($this->request->getData());
        
        if ($this->request->is('post')) {
            $type = $this->Types->patchEntity($type, $this->request->getData());
            dump('llegamos aqui');  
            dump($this->Types->save($type));
            die();          

            if ($this->Types->save($type)) {
                dump('lo guardamos');
                die();
                $this->Flash->success(__('The type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            dump('no lo logramos');
            die();
            $this->Flash->error(__('The type could not be saved. Please, try again.'));
        }
        dump('No era guardar');
        // die();
        $this->set(compact('type'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->authorizedFlow();
        $type = $this->Types->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $type = $this->Types->patchEntity($type, $this->request->getData());
            if ($this->Types->save($type)) {
                $this->Flash->success(__('The type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type could not be saved. Please, try again.'));
        }
        $this->set(compact('type'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->authorizedFlow();
        $this->request->allowMethod(['post', 'delete']);
        $type = $this->Types->get($id);
        if ($this->Types->delete($type)) {
            $this->Flash->success(__('The type has been deleted.'));
        } else {
            $this->Flash->error(__('The type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function isAuthorized() {
        return $_SESSION['Auth']['is_admin'];
    }

    public function redirectToRoot() {
        return $this->redirect([
            'controller' => 'items',
            'action' => 'index'
        ]);
    }

    public function authorizedFlow() {
        if($this->isAuthorized()){
            return true;
        } else {
            $this->redirectToRoot();
        }
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Vendor Controller
 *
 * @property \App\Model\Table\VendorTable $Vendor
 *
 * @method \App\Model\Entity\Vendor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $vendor = $this->paginate($this->Vendor);

        $this->set(compact('vendor'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor = $this->Vendor->get($id, [
            'contain' => ['Items'],
        ]);

        $this->set('vendor', $vendor);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendor = $this->Vendor->newEmptyEntity();
        if ($this->request->is('post')) {
            $vendor = $this->Vendor->patchEntity($vendor, $this->request->getData());
            if ($this->Vendor->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vendor = $this->Vendor->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendor->patchEntity($vendor, $this->request->getData());
            if ($this->Vendor->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendor->get($id);
        if ($this->Vendor->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        if($this->isAdmin()){
            $this->set('isAdmin', true);
            $this->paginate = [
                'contain' => ['Tags', 'vendors', 'types']];
        } else {
            $this->set('isAdmin', false);
            $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
            $vendors = $this->paginate($this->Items->find('all')->where(['Items.user_id =' => $user_id]));
        }
        $items = $this->paginate($this->Items);
        $this->set(compact('items'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Tags', 'vendors', 'types'],
        ]);
        $this->Authorization->authorize($item);
        $this->set('item', $item);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        $this->Authorization->authorize($item);
        $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            $item->user_id = $user_id;
            $file = $this->request->getData('file');
            $ext =  substr(strtolower(strrchr($file->getClientMediaType(), '/')), 1); //get the extension
            // dump($ext);
            // die();
            $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
            //only process if the extension is valid
            if(in_array($ext, $arr_ext))
            {
                    //do the actual uploading of the file. First arg is the tmp name, second arg is 
                    //where we are putting it
                    move_uploaded_file($file->getClientFilename(), WWW_ROOT . 'img/uploads/' . 'productPhoto');

                    //prepare the filename for database entry
                    $item->photo = 'product_' + $item->serial_number;
            }


            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // dump($this->validationErrors); die();
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        // $tags = $this->Items->Tags->find('list', ['limit' => 200]);
        $vendors = $this->Items->vendors->find('list', ['limit' => 200])->where(['Vendors.user_id =' => $user_id]);
        $types = $this->Items->types->find('list', ['limit' => 200]);
        $this->set(compact('item', 'tags', 'vendors', 'types'));
        $this->set(compact('item', 'vendors', 'types'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($item);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $tags = $this->Items->Tags->find('list', ['limit' => 200]);
        $vendors = $this->Items->vendors->find('list', ['limit' => 200]);
        $types = $this->Items->types->find('list', ['limit' => 200]);
        $this->set(compact('item', 'tags', 'vendors', 'types'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        $this->Authorization->authorize($item);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAdmin() {
        return $this->request->getAttribute('identity')->getOriginalData()->isAdmin;
    }

    public function redirectToRoot() {
        return $this->redirect([
            'controller' => 'vendors',
            'action' => 'index'
        ]);
    }

    public function authorizedFlow() {
        if($this->isAdmin()){
            $this->redirectToRoot();
        } else {
            return true;
        }
    }
}

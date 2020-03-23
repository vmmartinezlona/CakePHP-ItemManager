<?php
declare(strict_types=1);

namespace App\Controller;

class VendorsController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();
        if($this->isAdmin()) {
            $this->set('isAdmin', true);
            $vendors = $this->paginate($this->Vendors);
        } else {    
            $this->set('isAdmin', false);
            $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
            $vendors = $this->paginate($this->Vendors->find('all')->where(['Vendors.user_id =' => $user_id]));
        }     
        $this->set(compact('vendors'));   
    }

    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, ['contain' => []]);
        $this->Authorization->authorize($vendor);
        $this->set('vendor', $vendor);
    }

    public function add()
    {
        // $this->Authorization->skipAuthorization();
        // $this->authorizedFlow();
        $vendor = $this->Vendors->newEmptyEntity();
        $this->Authorization->authorize($vendor);
        if ($this->request->is('post')) {
            $this->saveVendor();
        }
        $this->set(compact('vendor'));
    }

    private function saveVendor()
    {
        $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
        $vendor->user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
        $filename = $this->uploadImage($this->request);
        if($filename) {
            $vendor->logo = $filename;
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        } else {
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }       
    }

    public function edit($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($vendor);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData(), [
                'accessibleFields' => ['user_id' => false]
            ]);
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
        }
        $this->set(compact('vendor'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendors->get($id);
        $this->Authorization->authorize($vendor);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
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

    private function uploadImage($request) 
    {
        $file = $request->getData('file');
        $ext =  substr(strtolower(strrchr($file->getClientMediaType(), '/')), 1);
        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($ext, $arr_ext)) {
            $filename = $this->getRandomString() . '.' . $ext;
            $file->moveTo(WWW_ROOT . 'img/uploads/vendors/' . $filename);
            return $filename;
        }
        return false;
    }

    public function getRandomString() {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))), 1, 10);
    }
}

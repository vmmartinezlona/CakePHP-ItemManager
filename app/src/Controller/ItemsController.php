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
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->paginate = ['contain' => ['Tags', 'vendors', 'types']];
        if ($this->isAdmin()) {
            $items = $this->paginate($this->Items);
        } else {
            $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
            $items = $this->paginate($this->Items->find('all')->where(['Items.user_id =' => $user_id]));
        }
        dump($items);
        $this->set(compact('items'));
    }

    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Tags', 'vendors', 'types'],
        ]);
        $this->Authorization->authorize($item);
        $this->set('item', $item);
    }

    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        $this->Authorization->authorize($item);
        $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;

        if ($this->request->is('post')) {
            $this->saveItem();
        }

        $item->user_id = $user_id;
        $tags = $this->Items->Tags->find('list', ['limit' => 200]);
        $vendors = $this->Items->vendors->find('list', ['limit' => 200])->where(['Vendors.user_id =' => $user_id]);
        $types = $this->Items->types->find('list', ['limit' => 200]);

        // Set tags to the view context
        // $this->set('tags', $tags);
        $this->set(compact('item', 'tags', 'vendors', 'types'));
        $this->set(compact('item', 'vendors', 'types'));
    }

    public function saveItem() {
        $item = $this->Items->patchEntity($item, $this->request->getData());
        $item->user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
        $filename = $this->uploadImage($this->request);
        if ($filename) {
            $item->photo = $filename;
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));            
        }
        else {
            $this->Flash->error(__('The item photo could not be saved. Please, try again.'));
        }  
    }


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

    public function tags(...$tags)
    {
        $this->Authorization->skipAuthorization();
        $items = $this->Items->find('tagged', [
            'tags' => $tags
        ]);

        $this->set(compact('items', 'tags'));
    }

    public function dashboard() 
    {
        $this->Authorization->skipAuthorization();
        $items = $this->Items->find('all');
        $count = $this->getItemsCount($items);
        $this->set('itemsCount', $count);
        $this->set('averagePrice', $this->getItemsAveragePrice($items, $count));
        $this->set('itemsPercent', $this->getTypePercentages($count));
        $this->set('lastItems', $this->getLastItems(3));
    }

    public function getItemsCount($items) 
    {
        return $items->count();
    }

    public function getItemsAveragePrice($items, $count)
    {
        $res = $items->select(['total_sum' =>$items->func()->sum('price')])->first();
        $total = $res->total_sum;
        return $total / $count;
    }

    public function getTypePercentages($count)
    {
        $types = $this->Items->Types->find('all', ['recursive'=>-1]);
        foreach ($types as $key=>$type) {
            $query = $this->Items->find('all', [
                'conditions' => ['type_id =' => $type['type_id']]]
            );
            $result[$type['name']] = $this->getPercentage($query->count(), $count);
        }
        return $result;
    }

    public function getPercentage($count, $total)
    {
        return $count * 100 / $total;
    }

    public function getLastItems($limit)
    {
        return $this->Items->find('all', [
            'limit' => $limit,
            'order' => 'Items.created_date DESC'
        ]);
    }




    public function getItems() {
        $item = $this->Items->get($id, [
            'contain' => ['Tags', 'vendors', 'types']
        ]);
    }


    public function isAdmin() {
        $isAdmin = $this->request->getAttribute('identity')->getOriginalData()->isAdmin;
        $this->set('isAdmin', $isAdmin);
        return $isAdmin;
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
            $file->moveTo(WWW_ROOT . 'img/uploads/items/' . $filename);
            return $filename;
        }
        return false;
    }

    public function getRandomString() {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))), 1, 10);
    }
}

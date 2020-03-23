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
        
        $newestItems = $this->getLastItems(3);
        $itemsColors = $this->getColorList();
        $items = $this->getIndexItems($this->request, $itemsColors);
        $this->set(compact('items', 'newestItems', 'itemsColors'));
    }

    private function getColorList()
    {
        if ($this->isAdmin()) {
            $query = $this->Items->find('all', ['fields' => ['Items.color']]);
        } else {
            $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
            $query = $this->Items->find('all', ['fields' => ['Items.color']])->where(['Items.user_id =' => $user_id]);
        }
        $colors = ['All'];
        foreach($query->distinct()->toArray() as $key => $value) {
            array_push($colors, $value->color);
        }
        return $colors;
    }

    private function getIndexItems($request, $itemsColors) 
    {
        $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
        $searchString = $this->builSearchString($request, $itemsColors);
        if ($searchString) {
            if ($this->isAdmin()) {
                $items = $this->paginate($this->Items->find('all', ['conditions' => $searchString]));
            } else {
                $items = $this->paginate($this->Items->find('all', ['conditions' => $searchString])
                    ->where(['Items.user_id =' => $user_id]));
            }
        } else {
            if ($this->isAdmin()) {
                $items = $this->paginate($this->Items->find('all'));
            } else {
                $items = $this->paginate($this->Items->find('all')
                    ->where(['Items.user_id =' => $user_id]));
            }
        }
        return $items;
    }

    private function builSearchString($request, $itemsColors) 
    {
        if ($request->getData('clear')) {
            $this->clearForm();
            return false;
        }
        $this->fillForm($request);
        $conditions = [];
        if ($request->getData('searchName')) {
            $conditions['Items.name LIKE'] = '%' . $request->getData('searchName') . '%';
        }
        if ($request->getData('searchPrice')) {
            $conditions['Items.price ='] = $request->getData('searchPrice');
        }
        if ($request->getData('searchColor') != 0 ) {
            $conditions['Items.color ='] = $itemsColors[$request->getData('searchColor')];
        }
        return $conditions;
    }

    private function fillForm($request) {
        $this->set('searchName', $request->getData('searchName'));
        $this->set('searchPrice', $request->getData('searchPrice'));
        $this->set('searchColor', $request->getData('searchColor'));
    }

    private function clearForm() {
        $this->set('searchName', '');
        $this->set('searchPrice', '');
        $this->set('searchColor', 0);
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
            $this->saveItem($item);
        }
        $tags = $this->Items->Tags->find('list', ['limit' => 200]);
        $vendors = $this->Items->vendors->find('list', ['limit' => 200])->where(['Vendors.user_id =' => $user_id]);
        $types = $this->Items->types->find('list', ['limit' => 200]);

        $this->set(compact('item', 'tags', 'vendors', 'types'));
    }

    private function saveItem($item) {
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


    private function getItemsCount($items) 
    {
        return $items->count();
    }

    private function getItemsAveragePrice($items, $count)
    {
        $res = $items->select(['total_sum' =>$items->func()->sum('price')])->first();
        $total = $res->total_sum;
        return $total / $count;
    }

    private function getTypePercentages($count)
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

    private function getPercentage($count, $total)
    {
        return $count * 100 / $total;
    }

    private function getLastItems($limit)
    {
        if ($this->isAdmin()) {
            return $this->Items->find('all', [
                'limit' => $limit,
                'order' => 'Items.created_date DESC']);
        } else {
            $user_id = $this->request->getAttribute('identity')->getOriginalData()->user_id;
            return $this->Items->find('all', [
                'limit' => $limit,
                'order' => 'Items.created_date DESC'
                ])->where(['Items.user_id =' => $user_id]);
        }
    }

    private function isAdmin() {
        $isAdmin = $this->request->getAttribute('identity')->getOriginalData()->isAdmin;
        $this->set('isAdmin', $isAdmin);
        return $isAdmin;
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

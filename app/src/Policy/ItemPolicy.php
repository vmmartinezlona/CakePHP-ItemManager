<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Item;
use Authorization\IdentityInterface;

/**
 * Item policy
 */
class ItemPolicy
{
    public function canAdd(IdentityInterface $user, Item $item)
    {
        return !$this->isAdmin($user);
    }

    public function canEdit(IdentityInterface $user, Item $item)
    {
        return $this->isAuthorized($user, $item);
    }

    public function canDelete(IdentityInterface $user, Item $item)
    {
        return $this->isAuthorized($user, $item);
    }

    public function canView(IdentityInterface $user, Item $item)
    {
        return $this->isAuthorized($user, $item);
    }


    protected function isAdmin(IdentityInterface $user) {
        return $user->getOriginalData()->isAdmin;
    }

    protected function isAuthorized(IdentityInterface $user, Item $item)
    {
        $user_id = $user->getOriginalData()->user_id;

        return ($item->user_id === $user_id) || $this->isAdmin($user);
    }
}

<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Type;
use Authorization\IdentityInterface;

/**
 * Type policy
 */
class TypePolicy
{
    public function canAdd(IdentityInterface $user, Type $item)
    {
        return $this->isAdmin($user) ? true : false;
    }

    public function canEdit(IdentityInterface $user, Type $item)
    {
        return $this->isAuthorized($user, $item);
    }

    public function canDelete(IdentityInterface $user, Type $item)
    {
        return $this->isAuthorized($user, $item);
    }

    public function canView(IdentityInterface $user, Type $item)
    {
        return $this->isAuthorized($user, $item);
    }


    protected function isAdmin(IdentityInterface $user) {
        return $user->getOriginalData()->is_admin;
    }

    protected function isAuthorized(IdentityInterface $user, Type $item)
    {
        $user_id = $user->getOriginalData()->user_id;
        return ($item->user_id === $user_id) || $this->isAdmin($user);
    }
}

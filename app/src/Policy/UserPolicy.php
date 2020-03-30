<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UserPolicy
{

    public function canAdd(IdentityInterface $user, User $resource)
    {
        return $this->isAuthorized($user);
    }

    public function canEdit(IdentityInterface $user, User $resource)
    {
        return $this->isAuthorized($user);
    }

    public function canDelete(IdentityInterface $user, User $resource)
    {
        return $this->isAuthorized($user);
    }

    public function canView(IdentityInterface $user, User $resource)
    {
        return $this->isAuthorized($user);
    }


    protected function isAuthorized(IdentityInterface $user)
    {
        return $user->getOriginalData()->is_admin;
    }
}

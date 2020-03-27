<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Tag;
use Authorization\IdentityInterface;

/**
 * Vendor policy
 */
class VendorPolicy
{
    public function canAdd(IdentityInterface $user, Vendor $vendor)
    {
        return $this->isAdmin($user);
    }

    public function canEdit(IdentityInterface $user, Vendor $vendor)
    {
        return $this->isAdmin($user);
    }

    public function canDelete(IdentityInterface $user, Vendor $vendor)
    {
        return $this->isAdmin($user);
    }

    public function canView(IdentityInterface $user, Vendor $vendors)
    {
        return $this->isAdmin($user);
    }


    protected function isAdmin(IdentityInterface $user) {
        return $user->getOriginalData()->isAdmin;
    }
}

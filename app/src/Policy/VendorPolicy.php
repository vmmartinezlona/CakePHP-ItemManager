<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Vendor;
use Authorization\IdentityInterface;

/**
 * Vendor policy
 */
class VendorPolicy
{
    public function canAdd(IdentityInterface $user, Vendor $vendor)
    {
        return !$this->isAdmin($user);
    }

    public function canEdit(IdentityInterface $user, Vendor $vendor)
    {
        return $this->isAuthorized($user, $vendor);
    }

    public function canDelete(IdentityInterface $user, Vendor $vendor)
    {
        return $this->isAuthorized($user, $vendor);
    }

    public function canView(IdentityInterface $user, Vendor $vendors)
    {
        return $this->isAuthorized($user, $vendors);
    }


    protected function isAdmin(IdentityInterface $user) {
        return $user->getOriginalData()->is_admin;
    }

    protected function isAuthorized(IdentityInterface $user, Vendor $vendor)
    {
        $isAdmin = $user->getOriginalData()->is_admin;
        $user_id = $user->getIdentifier();
        return ($vendor->user_id === $user_id) || $this->isAdmin($user);
    }
}

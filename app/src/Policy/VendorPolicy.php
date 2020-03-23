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
        return $user->getOriginalData()->isAdmin;
    }

    protected function isAuthorized(IdentityInterface $user, Vendor $vendors)
    {
        $isAdmin = $user->getOriginalData()->isAdmin;
        return ($vendors->user_id === $user_id) || $this->isAdmin($user);
    }
}

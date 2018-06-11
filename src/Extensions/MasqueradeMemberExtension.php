<?php

namespace DHensby\Masquerade\Extensions;

use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;

/**
 * Class MasqueradeMemberExtension
 * @package DHensby\Masquerade\Extensions
 *
 * The masquerade decorator for Member objects
 */
class MasqueradeMemberExtension extends DataExtension
{
    /**
     * @param null $member
     * @return bool|int
     */
    public function canMasquerade($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }
        elseif (is_numeric($member)) {
            $member = Member::get()->byID($member);
        }
        if ($member && $member->ID == $this->getOwner()->ID) {
            return false;
        }
        return Permission::check('ADMIN', 'any', $member);
    }

    /**
     * @return Object
     */
    public function masquerade()
    {
        $session = Controller::curr()->getRequest()->getSession();
        // don't use $member->logIn() because it triggers tracking and breaks remember me tokens, etc.
        $sessionData = $session->getAll();
        $session->clearAll();
        $session->set("loggedInAs", $this->getOwner()->ID);
        $session->set('Masquerade.Old', $sessionData);
        return $this->getOwner();
    }
}

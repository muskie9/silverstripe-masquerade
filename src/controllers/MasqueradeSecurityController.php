<?php

namespace DHensby\Masquerade\Controllers;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Security\Authenticator;
use SilverStripe\Security\Security;

/**
 * Class MasqueradeSecurityController
 * @package DHensby\Masquerade\Controllers
 */
class MasqueradeSecurityController extends Security
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'logout',
    ];

    /**
     * @param null $request
     * @param int $service
     * @return \SilverStripe\Control\HTTPResponse|string|void
     */
    public function logout($request = null, $service = Authenticator::LOGOUT)
    {
        $session = Injector::inst()->get(HTTPRequest::class)->getSession();
        if ($session->get('Masquerade.Old.loggedInAs')) {
            $oldSession = $session->get('Masquerade.Old');
            $session->clearAll();
            foreach ($oldSession as $name => $val) {
                $session->set($name, $val);
            }
            /*if ($redirect && (!$this->getResponse()->isFinished())) {
                $this->redirectBack();
            }*/
        } else {
            parent::logout($request, $service);
        }
    }
}

<?php

namespace DHensby\Masquerade\Tests;

use DHensby\Masquerade\Controllers\MasqueradeSecurityController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Security;

/**
 * Class MasqueradeSecurityControllerTest
 * @package DHensby\Masquerade\Tests
 */
class MasqueradeSecurityControllerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'MasqueradeMemberTest.yml';

    /**
     *
     */
    public function testLogout()
    {
        $session = Injector::inst()->get(HTTPRequest::class)->getSession();

        $this->logInWithPermission('ADMIN');
        $admin = Security::getCurrentUser();
        $member = $this->objFromFixture('Member', 'user');

        $member->masquerade();

        $this->assertEquals($member->ID, $session->get('loggedInAs'));
        $sc = new MasqueradeSecurityController();
        //$sc->init();
        $sc->logout(false);

        $this->assertEquals($admin->ID, $session->get('loggedInAs'));

    }
}

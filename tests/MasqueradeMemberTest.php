<?php

namespace DHensby\Masquerade\Tests;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class MasqueradeMemberTest
 * @package DHensby\Masquerade\Tests
 */
class MasqueradeMemberTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'MasqueradeMemberTest.yml';

    /**
     *
     */
    public function testCanMasquerade()
    {
        $this->logInWithPermission('ADMIN');
        $admin = Security::getCurrentUser();
        $member = $this->objFromFixture(Member::class, 'user');

        //added function correctly
        $this->assertTrue($member->hasMethod('canMasquerade'));

        // admin can masquerade as another
        $this->assertTrue($member->canMasquerade());

        //admin can't masquerade as themselves
        $this->assertFalse($admin->canMasquerade());

        $admin->logOut();

        // no logged in user can't masquerade
        $this->assertFalse($member->canMasquerade());

        //admin can masquerade
        $this->assertTrue($member->canMasquerade($admin));

        // member cannot masquerade as themeselves
        $this->assertFalse($member->canMasquerade($member));

        $member->logIn();
        // member can't masquerade as themselves
        $this->assertFalse($member->canMasquerade());

        // member can't masquerade as an admin
        $this->assertFalse($admin->canMasquerade());
    }

    /**
     *
     */
    public function testMasquerade()
    {
        $session = Injector::inst()->get(HTTPRequest::class)->getSession;

        $this->logInWithPermission('ADMIN');
        $admin = Security::getCurrentUser();
        $member = $this->objFromFixture(Member::class, 'user');

        $this->assertEquals($admin->ID, $session->get('loggedInAs'));

        $member->masquerade();

        $this->assertEquals($member->ID, $session->get('loggedInAs'));
        $this->assertEquals($admin->ID, $session->get('Masquerade.Old.loggedInAs'));
    }
}

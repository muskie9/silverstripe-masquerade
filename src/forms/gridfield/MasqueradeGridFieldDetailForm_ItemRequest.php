<?php

namespace DHensby\Masquerade\Forms\GridField;

use SilverStripe\Control\Director;
use SilverStripe\Forms\GridField\GridFieldDetailForm_ItemRequest;
use SilverStripe\Security\Security;

/**
 * Class MasqueradeGridFieldDetailForm_ItemRequest
 * @package DHensby\Masquerade\Forms\GridField
 */
class MasqueradeGridFieldDetailForm_ItemRequest extends GridFieldDetailForm_ItemRequest
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'masquerade',
    ];

    /**
     *
     */
    public function masquerade()
    {
        $member = $this->hasMethod('getRecord') ? $this->getRecord() : $this->record;
        if (!$member->hasMethod('canMasquerade') || !$member->hasMethod('masquerade') || !$member->canMasquerade()) {
            Security::permissionFailure($this->getController());
            return;
        }
        $member->masquerade();
        $this->getController()->redirect(Director::absoluteBaseURL());
    }
}

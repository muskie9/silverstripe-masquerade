<?php

namespace DHensby\Masquerade\Extensions;

use DHensby\Masquerade\Forms\GridField\GridFieldMasqueradeButton;
use DHensby\Masquerade\Forms\GridField\MasqueradeGridFieldDetailForm_ItemRequest;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\GridField\GridFieldDetailForm;

/**
 * Class MasqueradeSecurityAdminExtension
 * @package DHensby\Masquerade\Extensions
 */
class MasqueradeSecurityAdminExtension extends Extension
{
    /**
     * @param $form
     */
    public function updateEditForm($form)
    {
        $gridField = $form->Fields()->dataFieldByName('Members');

        $gridField->getConfig()
            ->addComponent(
                new GridFieldMasqueradeButton()
            )
            ->getComponentByType(GridFieldDetailForm::class)
            ->setItemRequestClass(MasqueradeGridFieldDetailForm_ItemRequest::class);
    }
}

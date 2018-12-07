<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\GridField\GridFieldDetailForm;

class MasqueradeSecurityAdminExtension extends DataExtension  {

    public function updateEditForm($form)
    {
        $gridField = $form->Fields()->dataFieldByName('Members');

        $gridField->getConfig()
            ->addComponent(
                new GridFieldMasqueradeButton()
            )
            ->getComponentByType(GridFieldDetailForm::class)
            ->setItemRequestClass(MasqueradeGridFieldDetailForm_ItemRequest::class)
        ;
    }

}

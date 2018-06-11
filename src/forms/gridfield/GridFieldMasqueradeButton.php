<?php

namespace DHensby\Masquerade\Forms\GridField;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\View\ArrayData;

/**
 * Class GridFieldMasqueradeButton
 * @package DHensby\Masquerade\Forms\GridField
 */
class GridFieldMasqueradeButton implements GridField_ColumnProvider
{
    /**
     * @param GridField $gridField
     * @param array $columns
     */
    public function augmentColumns($gridField, &$columns)
    {
        if (!in_array('Actions', $columns)) {
            $columns[] = 'Actions';
        }
    }

    /**
     * Return any special attributes that will be used for FormField::create_tag()
     *
     * @param GridField $gridField
     * @param DataObject $record
     * @param string $columnName
     * @return array
     */
    public function getColumnAttributes($gridField, $record, $columnName)
    {
        return ['class' => 'grid-field__col-compact'];
    }

    /**
     * Add the title
     *
     * @param GridField $gridField
     * @param string $columnName
     * @return array
     */
    public function getColumnMetadata($gridField, $columnName)
    {
        if ($columnName == 'Actions') {
            return ['title' => ''];
        }
    }

    /**
     * Which columns are handled by this component
     *
     * @param GridField $gridField
     * @return array
     */
    public function getColumnsHandled($gridField)
    {
        return ['Actions'];
    }

    /**
     * Which GridField actions are this component handling.
     *
     * @return array
     */
    public function getActions()
    {
        return ['masquerade'];
    }

    /**
     * @param GridField $gridField
     * @param DataObject $record
     * @param string $columnName
     *
     * @return string - the HTML for the column
     */
    public function getColumnContent($gridField, $record, $columnName)
    {
        if (!$record instanceof Member || !$record->canMasquerade()) {
            return;
        }
        // No permission checks, handled through GridFieldDetailForm,
        // which can make the form readonly if no edit permissions are available.

        $data = ArrayData::create([
            'Link' => Controller::join_links($gridField->Link('item'), $record->ID, 'masquerade'),
        ]);

        return $data->renderWith('GridFieldMasqueradeButton');
    }
}

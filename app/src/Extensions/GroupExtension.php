<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
// use SilverStripe\Forms\TextAreaField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldExtensions;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use Silverstripe\Forms\GridField\GridFieldComponent;

class GroupExtension extends DataExtension
{

    private static $db = [

    ];

    private static $has_one = [

    ];

    private static $has_many = [

    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName("ParentID");
        // $fields->removeByName("Permissions");
    }
}

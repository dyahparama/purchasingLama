<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextAreaField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\RequiredFields;
use Silverstripe\Security\Permission;

class Satuan extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(5)',
        'Nama' => 'Varchar(15)',
    ];
    private static $indexes = [
        'Kode' => [
            'type' => 'unique',
            'columns' => ['Kode',]
        ],
    ];
    // private static $has_many = [
    //     'Regionals' => Regional::class,
    // ];

    // private static $owns = [
    // 	'logo'
    // ];

    private static $searchable_fields = [
        'Kode',
        'Nama'
    ];

    private static $field_labels = [
        'Kode' => 'Kode Satuan',
        'Nama' => 'Satuan',
    ];

    private static $summary_fields = [
        'Kode',
        'Nama',
    ];

    public function getCMSValidator()
    {
        return new RequiredFields(array("Nama", "Kode"));
    }

    public function onBeforeWrite()
    {
        if (!$this->ID) {
            $obj = Satuan::get()
                ->filter([
                    'Kode' => $this->Kode,
                ])->Count();
            if (!empty($obj)) {
                throw new ValidationException("Kode must be unique");
            }
        }
        parent::onBeforeWrite();
    }

    public function getCMSFields()
    {
        $fields = new FieldList();
        $fields->add(new TabSet("Root"));

        $fields->addFieldsToTab("Root.Main", new TextField("Kode", "Kode Satuan"));
        $fields->addFieldsToTab("Root.Main", new TextField("Nama", "Nama"));

        return $fields;
    }

    function canView($member = null) {
        // return true;
        return Permission::check('Satuan_Read');
    }

    function canEdit($member = null) {
        // return true;
        return Permission::check('Satuan_Update');
    }

    function canDelete($member = null) {
        // return true;
        return Permission::check('Satuan_Delete');
    }

    function canCreate($member = null, $context = []) {
        // return true;
        return Permission::check('Satuan_Create');
    }
}

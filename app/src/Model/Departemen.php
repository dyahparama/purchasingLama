<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use Silverstripe\Security\Permission;

class Departemen extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(10)',
        'Nama' => 'Varchar(50)',
    ];
    private static $indexes = [
        'Kode' => [
            'type' => 'unique',
            'columns' => ['Kode',],
        ],
    ];

    // private static $belongs_many_many = [
    //     "Pegawais" => Pegawai::class,
    // ];
    // private static $has_one = [
    //     'logo' => Image::class,
    // ];
    // private static $has_many = [
    //     'Moduls' => ModulData::class,
    // ];

    // private static $owns = [
    // 	'logo'
    // ];

    private static $searchable_fields = [
        'Kode',
        'Nama'
    ];

    private static $field_labels = [
        'Kode' => 'Kode Departemen',
        'Nama' => 'Departemen'
    ];

    private static $summary_fields = [
        'Kode',
        'Nama'
    ];
    public function onBeforeWrite()
    {
        if (!$this->ID) {
            $obj = Departemen::get()
                ->filter([
                    'Kode' => $this->Kode,
                ])->Count();
            if (!empty($obj)) {
                throw new ValidationException("Kode must be unique");
            }
        }
        parent::onBeforeWrite();
    }

    function canView($member = null) {
        // return true;
        return Permission::check('Departemen_Read');
    }

    function canEdit($member = null) {
        // return true;
        return Permission::check('Departemen_Update');
    }

    function canDelete($member = null) {
        // return true;
        return Permission::check('Departemen_Delete');
    }

    function canCreate($member = null, $context = []) {
        // return true;
        return Permission::check('Departemen_Create');
    }
}

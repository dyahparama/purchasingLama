<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use Silverstripe\Security\Permission;

class Jabatan extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(5)',
        'Nama' => 'Varchar(50)',
    ];
    private static $indexes = [
        'Kode' => [
            'type' => 'unique',
            'columns' => ['Kode',],
        ],
    ];
    private static $has_many = [
        'Pegawais' => PegawaiPerJabatan::class,
    ];
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
        'Kode' => 'Kode',
        'Nama' => 'Jenis'
    ];

    private static $summary_fields = [
        'Kode',
        'Nama'
    ];
    public function onBeforeWrite()
    {
        if (!$this->ID) {
            $obj = Jabatan::get()
                ->filter([
                    'Kode' => $this->Kode,
                ])->Count();
            if (!empty($obj)) {
                throw new ValidationException("Kode must be unique");
            }
        }
        parent::onBeforeWrite();
    }

    // function canView($member = null) {
    //     // return true;
    //     return Permission::check('Jabatan_Read');
    // }

    // function canEdit($member = null) {
    //     // return true;
    //     return Permission::check('Jabatan_Update');
    // }

    // function canDelete($member = null) {
    //     // return true;
    //     return Permission::check('Jabatan_Delete');
    // }

    // function canCreate($member = null, $context = []) {
    //     // return true;
    //     return Permission::check('Jabatan_Create');
    // }
}

<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;

class Jabatan extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(5)',
        'Nama' => 'Varchar(15)',
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
}

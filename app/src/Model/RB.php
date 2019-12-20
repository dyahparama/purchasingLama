<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;

class RB extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(10)',
        'Tgl' => 'Date',
        'Total'=> 'Double'
    ];
    private static $indexes = [
        'Kode' => [
            'type' => 'unique',
            'columns' => ['Kode',],
        ],
    ];
    private static $has_one = [
        'DraftRB' => DraftRB::class,
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

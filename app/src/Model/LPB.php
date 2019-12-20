<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;

class LPB extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(25)',
        'Tgl' => 'Date',
    ];
    private static $indexes = [
        'Kode' =>[
            'type' => 'unique',
            'columns' => ['Kode',]
        ],
    ];
    private static $has_one = [
        'PO' => PO::class,
    ];

    private static $has_many = [
        'Detail' => LPBDetail::class,
    ];

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->ID) {
            $this->Kode = AddOn::createKode("LPB", "LPB");
        }
    }
    // private static $has_many = [
    //     'Regionals' => Regional::class,
    // ];

    // private static $owns = [
	// 	'logo'
    // ];
}

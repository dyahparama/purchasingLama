<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
class PO extends DataObject
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
        'DraftRB' => DraftRB::class,
        'RB'=> RB::class,
        'ForwardTo'=> User::class,
        'ApproveTo'=> User::class,
        'Supplier' => Supplier::class,
        'Status' => StatusPermintaanBarang::class
    ];

    private static $has_many = [
        'Detail' => PODetail::class,
        'Termin' => POTerminDetail::class,
    ];
    // private static $has_many = [
    //     'Regionals' => Regional::class,
    // ];

    // private static $owns = [
	// 	'logo'
    // ];
}

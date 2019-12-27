<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Assets\File;


class DetailRBPerSupplier extends DataObject
{
    private static $db = [
        'NamaSupplier' => 'Varchar(255)',
        'KodeSupplier' => 'Varchar(50)',
        'Jumlah' => 'Double',
        'Harga' => 'Double',
        'Total' => 'Double',
        'Keterangan' => 'Text',
        'IsPo' => 'Boolean'
    ];

    private static $has_one = [
        'DraftRBDetail' => DraftRBDetail::class,
        'RB' => RB::class,
        'Supplier' => Supplier::class
    ];

    private static $has_many = [
        'DetailLPB' => LPBDetail::class
    ];
}

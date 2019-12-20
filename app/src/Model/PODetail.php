<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Assets\File;

class PODetail extends DataObject
{
    private static $db = [
        'NamaBarang' => 'Varchar(255)',
        'Jumlah' => 'Double',
        'Satuan' => 'Double',
        'Harga' => 'Double',
        'Diskon' => 'Double',
        'DiskonRP' => 'Double',
        'Total' => 'Double',
    ];

    private static $has_one = [
        'PO' => PO::class,
        'Jenis' => JenisBarang::class,
        'Satuan' => Satuan::class,
        'DetailPerSupplier' => DetailRBPerSupplier::class
    ];

}

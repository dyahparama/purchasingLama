<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Assets\File;

class LPBDetail extends DataObject
{
    private static $db = [
        'NamaBarang' => 'Varchar(255)',
        'Jumlah' => 'Double',
        'JumlahTerima' => 'Double',
        'Satuan' => 'Double',
        'Harga' => 'Double',
        'Diskon' => 'Double',
        'DiskonRP' => 'Double',
        'Total' => 'Double',
    ];

    private static $has_one = [
        'LPB' => LPB::class,
        'Jenis' => JenisBarang::class,
        'Satuan' => Satuan::class,
        'DetailPO' => PODetail::class,
        'DetailPerSupplier' => DetailRBPerSupplier::class
    ];

}

<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Assets\File;



class Penawaran extends File
{
    private static $has_one = [
        'DraftRBDetail' => DraftRBDetail::class
    ];
}

class DraftRBDetail extends DataObject
{
    private static $db = [
        'Deskripsi' => 'Varchar(255)',
        'Jumlah' => 'Double',
        'Supplier'=>'Varchar(255)',
        'Spesifikasi'=>'Varchar(100)',
        'KodeInventaris'=>'Varchar(50)',
        'NamaBarang' => 'Varchar(50)'
    ];

    private static $has_one = [
        'DraftRB' => DraftRB::class,
        'Satuan' => Satuan::class,
        'Jenis' => JenisBarang::class
    ];

    private static $has_many = [
        'Penawaran' => Penawaran::class,
        'DetailRBPerSupplier' => DetailRBPerSupplier::class
    ];

}

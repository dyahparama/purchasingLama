<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Assets\File;



class PenawaranSupplier extends File
{
    private static $has_one = [
        'PenawaranSupplierDetail' => PenawaranSupplierDetail::class
    ];
}

class PenawaranSupplierDetail extends DataObject
{
    private static $db = [
       
    ];

    private static $has_one = [
        'Supplier' => Supplier::class,
        'RB' => RB::class
    ];

    private static $has_many = [
        'Penawaran' => PenawaranSupplier::class
    ];
}

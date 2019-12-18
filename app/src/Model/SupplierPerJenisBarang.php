<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\ValidationException;
class SupplierPerJenisBarang extends DataObject
{
    private static $db = [
        'Nama' => 'Varchar(100)'
    ];
    private static $has_one = [
        'Supplier' => Supplier::class,
        'JenisBarang' => JenisBarang::class,
        'Satuan' => Satuan::class
    ];
}

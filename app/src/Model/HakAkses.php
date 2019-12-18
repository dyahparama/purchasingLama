<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
class HakAkses extends DataObject
{
    private static $db = [
        'Nama' => 'Varchar(50)',
    ];
    private static $belongs_many_many = [
        "User" => User::class,
    ];
    
    private static $searchable_fields = [
        'Nama',
     ];
  
     private static $summary_fields = [
        'Nama',
     ];
}

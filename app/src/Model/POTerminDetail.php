<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Assets\File;

class POTerminDetail extends DataObject
{
    private static $db = [
        'Tanggal' => 'Date',
        'Jenis' => 'Varchar(255)',
        'Keterangan' => 'Text',
        'Jumlah' => 'Double'
    ];

    private static $has_one = [
        'PO' => PO::class,
    ];

}

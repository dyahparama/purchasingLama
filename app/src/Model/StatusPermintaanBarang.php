<?php

use SilverStripe\ORM\DataObject;

class StatusPermintaanBarang extends DataObject {
    private static $db = [
        'Kode' => 'Int',
        'Status' => 'Varchar(250)',
        'Keterangan' => 'Varchar(250)',
        'Urutan' => 'Int'
    ];
}

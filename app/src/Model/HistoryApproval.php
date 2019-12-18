<?php

use SilverStripe\ORM\DataObject;

class HistoryApproval extends DataObject {
    private static $db = [
        'Note' => 'Text',
    ];

    private static $has_one = [
        'Status' => StatusPermintaanBarang::class,
        'DraftRB' => DraftRB::class,
        'ApprovedBy' => User::class,
    ];
}

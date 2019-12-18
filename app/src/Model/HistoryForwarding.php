<?php

use SilverStripe\ORM\DataObject;

class HistoryForwarding extends DataObject {
    private static $db = [
        'Note' => 'Text',
    ];

    private static $has_one = [
        'DraftRB' => DraftRB::class,
        'ForwardTo' => User::class,
        'ForwardForm' => User::class
    ];
}

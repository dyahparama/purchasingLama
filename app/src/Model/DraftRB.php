<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
class DraftRB extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(25)',
        'Tgl' => 'Date',
        'Jenis'=>'Enum(array("Event","Non Event"), "Non Event")',
        'Deadline'=>'Date',
        'Alasan'=>'Text',
        'Respond'=>'Enum(array("Reject","Approve","Forward"), "Forward")',
        'Notes'=>'Text',
        'NomorProyek'=>'Varchar(50)',
        'TglSubmit'=>'Date'
    ];
    private static $indexes = [
        'Kode' =>[
            'type' => 'unique', 
            'columns' => ['Kode',]
        ],
    ];
    private static $has_one = [
        'Pemohon' => User::class,
        'ForwardTo'=> User::class,
        'ApproveTo'=> User::class,
        'AssistenApproveTo'=> User::class,
        'PegawaiPerJabatan' => PegawaiPerJabatan::class,
        'Status' => StatusPermintaanBarang::class
    ];

    private static $has_many = [
        'Detail' => DraftRBDetail::class,
    ];
    private static $belongs_to = [
        'RB' => RB::class,
    ];
    // private static $has_many = [
    //     'Regionals' => Regional::class,
    // ];

    // private static $owns = [
	// 	'logo'
    // ];
}

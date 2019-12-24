<?php
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;

class LPB extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(25)',
        'Tgl' => 'Date',
        'Note' => 'Text'
    ];
    private static $indexes = [
        'Kode' =>[
            'type' => 'unique',
            'columns' => ['Kode',]
        ],
    ];
    private static $has_one = [
        'PO' => PO::class,
    ];

    private static $has_many = [
        'Detail' => LPBDetail::class,
    ];

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->ID) {
            $this->Kode = AddOn::createKode("LPB", "LPB");
        }
    }
    // private static $has_many = [
    //     'Regionals' => Regional::class,
    // ];

    // private static $owns = [
	// 	'logo'
    // ];

    public static function Getdetail($ID) {
        $detailnya = LPBDetail::get()->where('LPBID = ' . $ID);
        $temp = array();
        $asu = new ArrayList();
        foreach ($detailnya as $key) {
            if ($key->NamaBarang != '') {
                $temp['NamaBarang'] = $key->NamaBarang;
                $temp['Jumlah'] = $key->Jumlah;
                $temp['JumlahTerima'] = $key->JumlahTerima;
                $temp['view_linknya'] = 'lpb/view/' . $ID;
                $temp['view_link'] = 'lpb/ApprovePage/' . $key->LPB()->PO()->ID;
                $asu->push($temp);
            }
        }
        return $asu;
    }
}

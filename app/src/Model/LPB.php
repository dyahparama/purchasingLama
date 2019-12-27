<?php
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\DB;

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
                $temp['Jumlah'] = self::countLPB1($key->DetailPerSupplierID);
                $temp['JumlahTerima'] = self::countLPB2($key->DetailPerSupplierID);
                $temp['view_linknya'] = 'lpb/view/' . $ID;
                $temp['view_link'] = 'lpb/ApprovePage/' . $key->LPB()->PO()->ID;
                $asu->push($temp);
            }
        }
        return $asu;
    }

    public static function countLPB1($id) {
        $jumlah1 = DB::query("SELECT SUM(Jumlah) FROM detailrbpersupplier WHERE ID = {$id}")->value();

        if (!$jumlah1) {
            $jumlah1 = 0;
        }

        return $jumlah1;
    }
    public static function countLPB2($id)
    {
        $jumlah2 = DB::query("SELECT SUM(JumlahTerima) FROM lpbdetail WHERE DetailPerSupplierID = {$id}")->value();

        if (!$jumlah2) {
            $jumlah2= 0;
        }

        return $jumlah2;
    }
}

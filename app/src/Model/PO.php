<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
class PO extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(25)',
        'Tgl' => 'Date',
        'Total' => 'Double',
        'NamaSupplier' => 'Varchar(50)',
    ];
    private static $indexes = [
        'Kode' =>[
            'type' => 'unique',
            'columns' => ['Kode',]
        ],
    ];
    private static $has_one = [
        'DraftRB' => DraftRB::class,
        'RB'=> RB::class,
        'ForwardTo'=> User::class,
        'ApproveTo'=> User::class,
        'Supplier' => Supplier::class,
        'Status' => StatusPermintaanBarang::class
    ];

    private static $has_many = [
        'Detail' => PODetail::class,
        'Termin' => POTerminDetail::class,
    ];

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->ID) {
            $this->Kode = AddOn::createKode("PO", "PO");
        }
    }

    public static function GetPO($ID)
    {
        $detailnya = PODetail::get()->where('POID = '.$ID);
        $tes = AddOn::groupBySum($detailnya, "NamaSupplier", array("Total"), array("NamaSupplier", "Kode", "Total"));
        $temp = array();
        $asu = new ArrayList();;
        foreach ($tes as $key) {
            $temp['NamaSupplier'] = $key['NamaSupplier'];
            $temp['Kode'] = $key['Kode'];
            $temp['Total'] = $key['Total'];
            $temp['view_link'] = 'po/ApprovePage/'.$ID."/".$key['NamaSupplier'];
            $asu->push($temp);
        }
        return $asu;
    }
    // private static $has_many = [
    //     'Regionals' => Regional::class,
    // ];

    // private static $owns = [
	// 	'logo'
    // ];
}

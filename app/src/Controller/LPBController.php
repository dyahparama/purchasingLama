<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;


class LPBController extends PageController
{
    private static $allowed_actions = [
        'getDetailBarang'
    ];

    public function index(HTTPRequest $request)
    {
        Requirements::themedCSS('custom');
        if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != "") {
            $id = $_REQUEST['id'];
            $data = array(
                "RB" => DraftRB::get()->byID($id),
                "DetailRB" => DraftRBDetail::get()->where("DraftRBID = {$id}"),
                "Supplier" => Supplier::get(),
                "mgeJS" => "lpb"
            );
            return $this->customise($data)
                ->renderWith(array(
                    'LPBPage', 'Page',
                ));
        }
    }

    public function getDetailBarang()
    {
        if (
            isset($_REQUEST['nama_supplier']) &&  $_REQUEST['nama_supplier'] != ""
            && isset($_REQUEST['id_po']) &&  $_REQUEST['id_po'] != ""
        )
        {
            $data = DraftRBDetail::get()->where("DraftRBID = 1");
            $arr = array();
            foreach ($data as $val) {
                $arr[] = array(
                    'ID' => $val->ID,
                    'JenisBarang' => $val->Jenis()->Nama,
                    'NamaBarang' => "tes",
                    'JumlahBarang' => $val->Jumlah,
                    'Satuan' => $val->Satuan()->Nama,
                    'Harga' => "100",
                    'Diskon' => '10',
                    'DiskonRP' => '100',
                    'Subtotal' => '1000',
                );
            }
            return json_encode($arr);
        }
    }
}

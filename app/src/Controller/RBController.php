<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;


class RBController extends PageController
{
    private static $allowed_actions = [
        'doSubmitRB',
        'getKodeSupplier'
    ];

    public function index(HTTPRequest $request)
    {
        // var_dump(json_encode(AddOn::getOneField(Supplier::get(), "Nama")));die;
        Requirements::themedCSS('custom');
        if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != "") {
            $id = $_REQUEST['id'];
            $data = array(
                "SupplierList" => json_encode(AddOn::getOneField(Supplier::get(), "Nama")),
                "RB" => RB::get()->byID($id),
                "DraftRB" => RB::get()->byID($id)->DraftRB(),
                // "DetailRB" => DraftRBDetail::get()->where("DraftRBID = {}"),
                "DetailRB" => RB::get()->byID($id)->DraftRB()->Detail(),
                "mgeJS" =>"rb"
            );
            return $this->customise($data)
                ->renderWith(array(
                    'RBPage', 'Page',
                ));
        }
    }

    public function doSubmitRB() {
        $namaSupplier = $_REQUEST['nama_supplier'];
        foreach($namaSupplier as $val) {
            foreach($val as $val2) {
                echo $val2."<br>";
            }
            echo "Tes<br>";
        }
    }

    public function getKodeSupplier() {
        if (isset($_REQUEST['nama']) && $_REQUEST['nama'] != "") {
            $nama = $_REQUEST['nama'];
            $kode = "";
            $supplier = Supplier::get()->where("Nama LIKE '{$nama}'");
            if ($supplier) {
                $kode = $supplier->first()->Kode;
            }
            return $kode;
        }
    }
}

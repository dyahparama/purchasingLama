<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;


class POController extends PageController
{
    private static $allowed_actions = [
        "doPostPO", "getDetailRB"
    ];

    public function index(HTTPRequest $request) {
        Requirements::themedCSS('custom');
        $data = array(
            "RB" => DraftRB::get(),
            "Supplier" => Supplier::get(),
            "JenisBarang" => JenisBarang::get(),
            "Satuan" => Satuan::get(),
            "mgeJS" =>"po"
        );
        return $this->customise($data)
                ->renderWith(array(
                    'POPage', 'Page',
                ));
    }

    public function doPostPO() {
        foreach ($_REQUEST['diskon'] as $val) {
            var_dump($val);
        }
    }

    public function getDetailRB() {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
            $id = $_REQUEST['id'];
            $data = DraftRBDetail::get()->where("DraftRBID = {$id}");
            return json_encode(AddOn::groupBySum($data, "JenisID", array("Jumlah"), array("Jenis.Nama")));
        }
    }
}

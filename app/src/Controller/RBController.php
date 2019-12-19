<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;


class RBController extends PageController
{
    public function index(HTTPRequest $request)
    {
        // var_dump(json_encode(AddOn::getOneField(Supplier::get(), "Nama")));die;
        Requirements::themedCSS('custom');
        if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != "") {
            $id = $_REQUEST['id'];
            $data = array(
                "SupplierList" => json_encode(AddOn::getOneField(Supplier::get(), "Nama")),
                "RB" => DraftRB::get()->byID($id),
                "DetailRB" => DraftRBDetail::get()->where("DraftRBID = 1"),
                "mgeJS" =>"rb"
            );
            return $this->customise($data)
                ->renderWith(array(
                    'RBPage', 'Page',
                ));


        }
    }
}

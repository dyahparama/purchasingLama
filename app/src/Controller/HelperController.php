<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;

class HelperController extends PageController
{
    private static $allowed_actions = ['ajaxPusat'];

    public function ajaxPusat() {
        if (isset($_REQUEST['regional']) && $_REQUEST['regional'] != "") {
            $val = StrukturCabang::get()->byID($_REQUEST['regional']);
            return json_encode(array(
                'id' => $val->PusatID,
                'nama' => $val->Pusat()->Nama
            ));
        }
    }
}

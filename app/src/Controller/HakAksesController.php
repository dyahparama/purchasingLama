<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Group;

class HakAksesController extends PageController
{
    private static $allowed_actions = ['getAkses', 'setAkses'];

    public function index(HTTPRequest $request) {
        // var_dump(AccessCode::$akses);die;
        $arrAkses = new ArrayList();

        foreach (AccessCode::$akses as $key2 => $val2){
            $tempArrAkses = new ArrayList();

            foreach($val2['akses'] as $val) {
                $tempArrAkses->push(
                    array(
                        "Label" => $val." ".$val2['label'],
                        "Kode" => $key2."_".$val
                    )
                );
            }

            $arrAkses->push(
                array(
                    "Label" => $val2['label'],
                    "Data" => $tempArrAkses
                )
            );
        }

        $data = [
            "mgeJS" => "hakakses",
            "KodeAkses" => $arrAkses,
            "Grup" => Group::get()
        ];

        return $this->customise($data)
        ->renderWith(array(
            'HakAkses', 'Page',
        ));
    }

    public function getAkses(HTTPRequest $request) {
        if (isset($_REQUEST['group'])) {
            $id = $_REQUEST['group'];
            $permission = Permission::get()->where("GroupID = {$id}");

            $arrPermission = [];

            foreach($permission as $val) {
                $arrPermission[] = $val->Code;
            }

            return json_encode($arrPermission);
        }
    }

    public function setAkses() {

    }
}

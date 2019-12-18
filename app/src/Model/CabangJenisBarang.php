<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;

class CabangJenisBarang extends DataObject
{
    private static $db = [];
    private static $has_one = [
        'Kadep' => User::class,
        'Cabang' => StrukturCabang::class,
        'JenisBarang' => JenisBarang::class,
    ];

    // public function onBeforeWrite()
    // {
    //     parent::onBeforeWrite();
    //     echo "<pre>";
    //     foreach($this->record as $key => $val) {
    //         if ($key->)
    //         var_dump($key);
    //     }
    //     // var_dump($this->record);
    //     die;
    // }


    function getCMSFields()
    {
        $fields = new FieldList();
        $fields->add(new TabSet("Root"));
        $user = User::userList();

        if (strpos($_SERVER['REQUEST_URI'], 'helper-strukturcabang')) {
            $barang = JenisBarang::get();
            foreach ($barang as $val) {
                $dropdownValue = 0;
                if ($this->ID) {
                    $relasiBarang = CabangJenisBarang::get()->where("JenisBarangID = {$val->ID} AND CabangID = {$this->ID}");
                    if ($relasiBarang->count() > 0) {
                        $dropdownValue = $relasiBarang->first()->KadepID;
                    }
                }
                $dropdwonApprover = new DropdownField('Barang_'.$val->ID, 'Approver ' . $val->Nama, $user->map('ID', 'Nama'));
                $dropdwonApprover->setEmptyString("Pilih Approver " . $val->Nama);
                $dropdwonApprover->setValue($dropdownValue);
                $fields->addFieldToTab("Root.Main", $dropdwonApprover);
            }
        }
        return $fields;
    }
}

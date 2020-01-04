<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DB;
use SilverStripe\View\Parsers\HTMLValue;
use Silverstripe\Security\Permission;

class JenisBarang extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(5)',
        'Nama' => 'Varchar(15)',
    ];
    private static $indexes = [
        'Kode' => [
            'type' => 'unique',
            'columns' => ['Kode',],
        ],
    ];

    private static $has_one = [
        'Kadep' => User::class,
        'Approver' => User::class,
    ];

    private static $has_many = [
        'JenisBarang' => SupplierPerJenisBarang::class,
    ];
    // private static $owns = [
    // 	'logo'
    // ];

    private static $searchable_fields = [
        'Kode',
        'Nama',
        'Approver.Pegawai.Nama',
    ];

    private static $field_labels = [
        'Kode' => 'Kode',
        'Nama' => 'Nama Jenis Barang',
        'Kadep.Pegawai.Nama' => 'Kadep Pusat',
        'Approver.Pegawai.Nama' => 'Asisten Purchasing Approver',
        'StatusKadep' => 'Status',
        'settingApproval' => 'Approval'
    ];

    private static $summary_fields = [
        'Kode',
        'Nama',
        'Kadep.Pegawai.Nama',
        'Approver.Pegawai.Nama',
        'StatusKadep',
        'settingApproval'
    ];

    public function statusKadep()
    {
        $value = "Ok";
        $status = 1;
        $data = StrukturCabang::get()->where("Jenis <> 'Lokal'");
        foreach ($data as $val) {
            $data2 = CabangJenisBarang::get()->where("JenisBarangID = {$this->ID} AND CabangID = {$val->ID}")->first();
            if (!$data2 || !$data2->KadepID) {
                $status = 0;
            }
        }

        if ($status == 1) {
            $value = "Ok";
        } else {
            $value = "Setting Belum Lengkap";
        }
        return $value;
    }

    public function settingApproval()
    {
        $html = HTMLValue::create("<a target='_blank' class='no-event' href='admin/edit-approver/JenisBarang/EditForm/field/JenisBarang/item/{$this->ID}/edit'>Setting Kadep Approver</a>");
        return $html;
    }

    public function onBeforeWrite()
    {
        if (!$this->ID) {
            $obj = JenisBarang::get()
                ->filter([
                    'Kode' => $this->Kode,
                ])->Count();
            if (!empty($obj)) {
                throw new ValidationException("Kode must be unique");
            }
        } else {
            if (strpos($_SERVER['REQUEST_URI'], 'edit-approver')) {
                DB::query("DELETE FROM cabangjenisbarang WHERE JenisBarangID = {$this->ID}");
                foreach ($this->record as $key => $val) {
                    if (strpos($key, 'ara')) {
                        if ($val) {
                            $barangID = str_replace('Barang_', '', $key);
                            DB::query("INSERT INTO cabangjenisbarang (KadepID, JenisBarangID, CabangID) VALUES ({$val}, {$this->ID}, {$barangID})");
                        }
                    }
                }
            }
        }
        parent::onBeforeWrite();
    }

    public function getCMSFields()
    {
        $fields = new FieldList();
        $fields->add(new TabSet("Root"));
        $user = User::userList();

        if (strpos($_SERVER['REQUEST_URI'], 'edit-approver')) {
            $barang = StrukturCabang::get()->where("Jenis != 'Lokal'");
            $fields->addFieldToTab("Root.Main", new ReadonlyField("KodeRO", "Kode", $this->Kode));
            $fields->addFieldToTab("Root.Main", new ReadonlyField("NamaRO", "Nama Jenis Barang", $this->Nama));
            foreach ($barang as $val) {
                $dropdownValue = 0;
                if ($this->ID) {
                    $relasiBarang = CabangJenisBarang::get()->where("CabangID = {$val->ID} AND JenisBarangID = {$this->ID}");
                    if ($relasiBarang->count() > 0) {
                        $dropdownValue = $relasiBarang->first()->KadepID;
                    }
                }
                $dropdwonApprover = new DropdownField('Barang_' . $val->ID, 'Approver ' . $val->Nama, $user->map('ID', 'Nama'));
                $dropdwonApprover->setEmptyString("Pilih Approver " . $val->Nama);
                $dropdwonApprover->setValue($dropdownValue);
                $fields->addFieldToTab("Root.Main", $dropdwonApprover);
            }

            //hidden field
            $fields->addFieldToTab("Root.Main", new HiddenField("Kode", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("Nama", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("Jenis", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("KadepID", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("ApproverID", ""));
        } else {
            $fields->addFieldToTab("Root.Main", new TextField('Kode', 'Kode'));
            $fields->addFieldToTab("Root.Main", new TextField('Nama', 'Nama Jenis Barang'));

            $dropdwonKadep = new DropdownField('KadepID', 'Kadep Pusat', $user->map('ID', 'Nama'));
            $dropdwonKadep->setEmptyString("Pilih Kadep Pusat");
            $fields->addFieldToTab("Root.Main", $dropdwonKadep);

            $dropdwonApprover = new DropdownField('ApproverID', 'Asisten Purchasing Kadep Pusat', $user->map('ID', 'Nama'));
            $dropdwonApprover->setEmptyString("Pilih Asisten");
            $fields->addFieldToTab("Root.Main", $dropdwonApprover);
        }

        return $fields;
    }

//     function canView($member = null) {
//         // return true;
//         return Permission::check('JenisBarang_Read');
//     }

//     function canEdit($member = null) {
//         // return true;
//         return Permission::check('JenisBarang_Update');
//     }

//     function canDelete($member = null) {
//         // return true;
//         return Permission::check('JenisBarang_Delete');
//     }

//     function canCreate($member = null, $context = []) {
//         // return true;
//         return Permission::check('JenisBarang_Create');
//     }
// }

<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DB;
use SilverStripe\View\HTML;
use SilverStripe\View\Parsers\HTMLValue;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use Sheadawson\DependentDropdown\Forms\DependentDropdownField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldExtensions;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use Silverstripe\Forms\GridField\GridFieldComponent;
use SilverStripe\Forms\GridField\GridFieldDetailForm;

class StrukturCabang extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(10)',
        'Nama' => 'Varchar(50)',
        'Jenis' => 'Enum(array("Lokal","Regional","Pusat"), "Lokal")'
    ];
    private static $indexes = [
        'Kode' => [
            'type' => 'unique',
            'columns' => ['Kode',],
        ],
    ];
    private static $has_one = [
        'Kacab' => User::class,
        'Approver' => User::class,
        'Regional' => StrukturCabang::class,
        'Pusat' => StrukturCabang::class
    ];

    private static $has_many = [
        'PegawaiPerJabatan' => PegawaiPerJabatan::class,
    ];

    private static $searchable_fields = [
        'Kode',
        'Nama',
        'Jenis',
    ];

    private static $field_labels = [
        'Kode' => 'Kode',
        'Nama' => 'Nama',
        'Jenis' => 'Jenis',
        'Kacab.Pegawai.Nama' => 'Kepala Cabang',
        'Approver.Pegawai.Nama' => 'Purchasing Approver',
        'Regional.Nama' => 'Regional',
        'Pusat.Nama' => 'Pusat',
        'statusKadep' => 'Kadep Regional',
        'settingApproval' => 'Approval'
    ];

    private static $summary_fields = [
        'Kode',
        'Nama',
        'Jenis',
        'Kacab.Pegawai.ID',
        'Approver.Pegawai.Nama',
        'Regional.Nama',
        'Pusat.Nama',
        'statusKadep',
        'settingApproval'
    ];

    public function statusKadep()
    {
        $value = "-";
        if ($this->Jenis != "Lokal") {
            $status = 1;
            $data = JenisBarang::get();
            foreach ($data as $val) {
                $data2 = CabangJenisBarang::get()->where("CabangID = {$this->ID} AND JenisBarangID = {$val->ID}")->first();
                if (!$data2 || !$data2->KadepID) {
                    $status = 0;
                }
            }

            if ($status == 1) {
                $value = "Ok";
            } else {
                $value = "Setting Belum Lengkap";
            }
        }
        return $value;
    }

    public function settingApproval()
    {
        $html = HTMLValue::create("-");
        if ($this->Jenis != "Lokal") {
            $html = HTMLValue::create("<a class='no-event' target='_blank' href='admin/edit-approver/StrukturCabang/EditForm/field/StrukturCabang/item/{$this->ID}/edit'>Setting Kadep Approver</a>");
        }
        return $html;
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();
        if ($this->Jenis == "Regional") {
            DB::query("UPDATE strukturcabang SET RegionalID = {$this->ID} WHERE ID = {$this->ID}");
        }

        if ($this->Jenis == "Pusat") {
            DB::query("UPDATE strukturcabang SET PusatID = {$this->ID}, RegionalID = {$this->ID} WHERE ID = {$this->ID}");
        }
    }

    public function onBeforeWrite()
    {
        if ($this->Jenis == "Lokal") {
            if (!$this->RegionalID) {
                throw new ValidationException("Regional is required");
            } else {
                $this->PusatID = $this->Pusat2ID;
            }
        } else if ($this->Jenis == "Regional") {
            if (!$this->PusatID) {
                throw new ValidationException("Pusat is required");
            }
        }

        if (!$this->ID) {
            $obj = StrukturCabang::get()
                ->filter([
                    'Kode' => $this->Kode,
                ])->Count();
            if (!empty($obj)) {
                throw new ValidationException("Kode must be unique");
            }
        } else {
            if (strpos($_SERVER['REQUEST_URI'], 'edit-approver')) {
                DB::query("DELETE FROM cabangjenisbarang WHERE CabangID = {$this->ID}");
                foreach ($this->record as $key => $val) {
                    if (strpos($key, 'ara')) {
                        if ($val) {
                            $barangID = str_replace('Barang_', '', $key);
                            DB::query("INSERT INTO cabangjenisbarang (KadepID, CabangID, JenisBarangID) VALUES ({$val}, {$this->ID}, {$barangID})");
                        }
                    }
                }
            }
        }
        parent::onBeforeWrite();
    }

    public function getCMSFields()
    {
        $datesSource = function ($val) {
            return StrukturCabang::get()->where("Jenis = 'Pusat'")->map('ID', 'Nama');
        };

        $fields = new FieldList();
        $fields->add(new TabSet("Root"));
        $user = User::userList();

        if (strpos($_SERVER['REQUEST_URI'], 'edit-approver')) {
            $fields->addFieldToTab("Root.Main", new ReadonlyField("KodeRO", "Kode Regional", $this->Kode));
            $fields->addFieldToTab("Root.Main", new ReadonlyField("NamaRO", "Regional", $this->Nama));
            $fields->addFieldToTab("Root.Main", new ReadonlyField("KacabRO", "Kepala Cabang", $this->Kacab()->Pegawai()->Nama));
            $barang = JenisBarang::get();
            foreach ($barang as $val) {
                $dropdownValue = 0;
                if ($this->ID) {
                    $relasiBarang = CabangJenisBarang::get()->where("JenisBarangID = {$val->ID} AND CabangID = {$this->ID}");
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
            $fields->addFieldToTab("Root.Main", new HiddenField("KacabID", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("ApproverID", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("RegionalID", ""));
            $fields->addFieldToTab("Root.Main", new HiddenField("PusatID", ""));
        } else {
            $fields->addFieldToTab("Root.Main", new TextField('Kode', 'Kode'));
            $fields->addFieldToTab("Root.Main", new TextField('Nama', 'Nama'));

            $dropdownJenis = new DropdownField('Jenis', 'Jenis', singleton("StrukturCabang")->dbObject('Jenis')->enumValues());
            $dropdownJenis->setEmptyString("Pilih Jenis");
            $fields->addFieldToTab("Root.Main", $dropdownJenis);

            $dropdwonRegional = new DropdownField('RegionalID', 'Regional ', StrukturCabang::get()->where("Jenis = 'Regional'")->map('ID', 'Nama'));
            $dropdwonRegional->setEmptyString("Pilih Cabang Regional");
            $fields->addFieldToTab(
                "Root.Main",
                Wrapper::create($dropdwonRegional)
                    ->displayIf('Jenis')->isEqualTo('Lokal')
                    ->end()
            );
            // $dropdwonRegional->validateIf('Jenis')->isEqualTo('Lokal');

            // $dropdwonPusat = new DropdownField('PusatID', 'Pusat', StrukturCabang::get()->where("Jenis = 'Pusat'")->map('ID', 'Nama'));
            // $dropdwonPusat->setEmptyString("Pilih Cabang Pusat");
            $fields->addFieldsToTab("Root.Main", new HiddenField("Pusat2ID", "Pusat", $this->PusatID));
            $val = $this->Pusat()->Nama ? $this->Pusat()->Nama : '-';
            $textPusat = new ReadonlyField("PusatNama", 'Pusat', $val);
            $fields->addFieldToTab(
                "Root.Main",
                Wrapper::create($textPusat)
                    ->displayIf('Jenis')->isEqualTo('Lokal')
                    ->end()
            );

            $dropdwonPusat = new DropdownField('PusatID', 'Pusat', StrukturCabang::get()->where("Jenis = 'Pusat'")->map('ID', 'Nama'));
            $dropdwonPusat->setEmptyString("Pilih Cabang Pusat");
            $fields->addFieldToTab(
                "Root.Main",
                Wrapper::create($dropdwonPusat)
                    ->displayIf('Jenis')->isEqualTo('Regional')
                    ->end()
            );

            $dropdwonKecab = new DropdownField('KacabID', 'Kepala Cabang', $user->map('ID', 'Nama'));
            $dropdwonKecab->setEmptyString("Pilih Kepala Cabang");
            $fields->addFieldToTab("Root.Main", $dropdwonKecab);

            $dropdwonApprover = new DropdownField('ApproverID', 'Purchasing Approver', $user->map('ID', 'Nama'));
            $dropdwonApprover->setEmptyString("Pilih Approver");
            $fields->addFieldToTab("Root.Main", $dropdwonApprover);

            if ($this->ID) {
                $grid = new GridField(
                    'BarangGrid',
                    'Struktur Cabang',
                    StrukturCabang::get()->where("PusatID = {$this->ID} OR RegionalID = {$this->ID}"),
                    GridFieldConfig::create()
                        ->addComponent(new GridFieldButtonRow('before'))
                        ->addComponent(new GridFieldToolbarHeader())
                        ->addComponent(new GridFieldTitleHeader())
                        ->addComponent(new GridFieldDataColumns())
                );

                $grid->getConfig()->getComponentByType(GridFieldDataColumns::class)->setDisplayFields(array(
                    'Kode' => 'Kode',
                    'Nama' => 'Nama',
                    'Jenis' => 'Jenis',
                    'Kacab.Pegawai.Nama' => 'Kepala Cabang',
                    'Approver.Pegawai.Nama' => 'Purchasing Approval'
                ));

                $fields->addFieldsToTab("Root.Main", $grid);
            }
        }

        return $fields;
    }

    public function getCMSValidator()
    {
        if (strpos($_SERVER['REQUEST_URI'], 'edit-approver')) {
            return new RequiredFields(array());
        } else {
            return new RequiredFields(array("Kode", "Nama", "Jenis"));
        }
    }
}

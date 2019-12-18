<?php

use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\PasswordField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ReadonlyField;

class User extends DataObject
{
    private static $db = [
        'Email' => 'Varchar(100)',
        'Password' => 'Varchar(255)',
        'Salt' => 'Varchar(255)'
    ];
    private static $many_many = [
        "HakAkses" => HakAkses::class,
    ];
    private static $has_one = [
        'Pegawai' => Pegawai::class,
    ];
    // private static $has_many = [
    //     'Moduls' => ModulData::class,
    // ];

    // private static $owns = [
    // 	'logo'
    // ];

    private static $searchable_fields = [
        'Email'
    ];

    private static $field_labels = [
        'Pegawai.Nama' => 'Nama Pegawai',
        'Email' => 'Email User',
    ];

    private static $summary_fields = [
        'Pegawai.Nama',
        'Email',
    ];
    public function getCMSValidator()
    {
        if (strpos($_SERVER['REQUEST_URI'], 'new'))
            return new RequiredFields(array("PegawaiID", "Email", "Password"));
        else
            return new RequiredFields(array("PegawaiID", "Email"));
    }
    public function onBeforeWrite()
    {
        if ($this->Password != "" || !$this->Password) {
            $auth = new Auth();
            $auth = $auth->encrypt($this->Password);
            $this->Password = $auth["hash"];
            $this->Salt = $auth["salt"];
        }
        parent::onBeforeWrite();
    }
    function getCMSFields()
    {
        $fields = new FieldList();
        $fields->add(new TabSet("Root"));

        $user = Pegawai::get();
        $user = $user->leftJoin("user", "\"pegawai\".\"ID\" <> \"user\".\"ID\"")->where("user.ID <> pegawai.ID");

        if (!$this->ID) {
            $dropdown = new DropdownField('PegawaiID', 'Kepala Cabang', $user->map('ID', 'Nama'));
            $dropdown->setEmptyString("Pilih Pegawai");
        } else
            $dropdown = new ReadonlyField("KacabID", "Kepala Cabang", $this->Pegawai()->Nama);
        $fields->addFieldToTab("Root.Main", $dropdown);

        $fields->addFieldToTab("Root.Main", new EmailField('Email', 'Email'));
        $fields->addFieldToTab("Root.Main", new PasswordField('Password', 'Password'));
        return $fields;
    }

    public static function userList()
    {
        $user = Pegawai::get()->innerJoin("user", "\"pegawai\".\"ID\" = \"user\".\"ID\"");
        return $user;
    }
}

<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ReadonlyField;
// use SilverStripe\Forms\TextAreaField;
use SilverStripe\ORM\DataExtension;
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
use SilverStripe\Security\Member;
use SilverStripe\Core\Config\Config;

class MemberExtension extends DataExtension
{
    private static $adminID = 1;

    private static $db = [

    ];

    private static $has_one = [
        'Pegawai' => Pegawai::class,
        'User' => User::class
    ];

    private static $has_many = [

    ];

    private static $summary_fields = [
        'pegawaiNama' => 'Nama Staff',
        'pegawaiEmail' => 'Email',
    ];

    public function pegawaiNama() {
        if ($this->owner->ID == self::$adminID) {
            return "Administrator";
        } else {
            return $this->owner->Pegawai()->Nama;
        }
    }

    public function pegawaiEmail() {
        return $this->owner->Email;
    }

    public function updateSummaryFields(&$fields) {
        $fields = Config::inst()->get(MemberExtension::class, 'summary_fields');
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (!$this->owner->ID) {
            $user = User::create();
            $user->PegawaiID = $this->owner->PegawaiID;
            $userId = $user->write();

            $this->owner->UserID = $userId;
        }
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName("FirstName");
        $fields->removeByName("Surname");
        $fields->removeByName("Locale");
        $fields->removeByName("FailedLoginCount");
        $fields->removeByName("Permissions");
        $fields->removeByName("PegawaiID");
        $fields->removeByName("UserID");

        $userList = Member::get();
        $user = Pegawai::get();
        $tempArr = [];
        if ($userList->count() > 1) {
            foreach($userList as $val) {
                $tempArr[] = $val->PegawaiID;
            }
            $strArr = implode(', ', $tempArr);
            if ($strArr != "")
                $user = $user->where("ID NOT IN ({$strArr})");
            else
                $user = $user;
        }
        // var_dump();die;
        // $user = User::get()->innerJoin("pegawai", "\"pegawai\".\"ID\" <> \"user\".\"PegawaiID\"");

        if (!$this->owner->ID) {
            $dropdown = new DropdownField('PegawaiID', 'Staff', $user->map('ID', 'Nama'));
            $dropdown->setEmptyString("Pilih Pegawai");
        } else
            $dropdown = new ReadonlyField("TesID", "Staff", $this->owner->Pegawai()->Nama);

        if ($this->owner->ID != self::$adminID)
            $fields->addFieldToTab("Root.Main", $dropdown, 'Email');
    }
}

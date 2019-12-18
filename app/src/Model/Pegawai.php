<?php

use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TextAreaField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TabSet;
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

// 'Boolean': A boolean field (see: DBBoolean).
// 'Currency': A number with 2 decimal points of precision, designed to store currency values (see: DBCurrency).
// 'Date': A date field (see: DBDate).
// 'Decimal': A decimal number (see: DBDecimal).
// 'Enum': An enumeration of a set of strings (see: DBEnum).
// 'HTMLText': A variable-length string of up to 2MB, designed to store HTML (see: DBHTMLText).
// 'HTMLVarchar': A variable-length string of up to 255 characters, designed to store HTML (see: DBHTMLVarchar).
// 'Int': An integer field (see: DBInt).
// 'Percentage': A decimal number between 0 and 1 that represents a percentage (see: DBPercentage).
// 'Datetime': A date / time field (see: DBDatetime).
// 'Text': A variable-length string of up to 2MB, designed to store raw text (see: DBText).
// 'Time': A time field (see: DBTime).
// 'Varchar': A variable-length string of up to 255 characters, designed to store raw text (see: DBVarchar).
class Pegawai extends DataObject
{
    private static $db = [
        'Nama' => 'Varchar(50)',
        'Alamat' => 'Text',
        'TempatLahir' => 'Varchar(50)',
        'TglLahir' => 'Date',
        'NoTelp' => 'Varchar(15)',
        'NoWa' => 'Varchar(15)',
        'NoInduk' => 'Varchar(50)',
        // 'Email' => 'Varchar(50)',
        // 'Penempatan' => 'Enum(array("Lokal","Regional","Pusat"), "Lokal")',
        'IsTPS' => 'Boolean'
    ];

    // private static $many_many = [
    //     'Departemens' => Departemen::class,
    // ];
    private static $has_many = [
        'Jabatans' => PegawaiPerJabatan::class,
    ];
    private static $belongs_to = [
        'User' => User::class,
    ];

    // private static $owns = [
    // 	'logo'
    // ];

    private static $searchable_fields = [
        'Nama',
        'NoInduk',
        'Alamat',
        'NoTelp',
    ];

    private static $field_labels = [
        'Nama' => 'Nama',
        'NoInduk' => 'No. Induk Pegawai',
        'Alamat' => 'Alamat',
        'NoTelp' => 'No. HP',
        'TimTPS' => 'Team TPS'
    ];

    private static $summary_fields = [
        'Nama',
        'NoInduk',
        'Alamat',
        'NoTelp',
        'TimTPS'
    ];

    public function TimTPS() {
        $value = "Tidak";
        if ($this->IsTPS)
            $value = "Ya";
        return $value;
    }

    public function getCMSValidator()
    {
        return new RequiredFields(array("Nama", "NoInduk", "Alamat", "TempatLahir", "TglLahir", "NoTelp", "NoWa"));
    }

    public function getCMSFields()
    {
        $fields = new FieldList();
        $fields->add(new TabSet("Root"));

        $fields->addFieldToTab("Root.Main", new TextField('Nama', 'Nama'));
        $fields->addFieldToTab("Root.Main", new TextField('NoInduk', 'No. Induk Pegawai'));
        $fields->addFieldToTab("Root.Main", new TextAreaField('Alamat', 'Alamat'));
        $fields->addFieldToTab("Root.Main", new TextField('TempatLahir', 'Tempat Lahir'));

        $tgllahir = new DateField('TglLahir', 'Tanggal Lahir');
        $fields->addFieldToTab("Root.Main", $tgllahir);

        $fields->addFieldToTab("Root.Main", new TextField('NoTelp', 'No. HP'));
        $fields->addFieldToTab("Root.Main", new TextField('NoWa', 'No. Whatsapp'));

        $fields->addFieldToTab("Root.Main", new CheckboxField('IsTPS', 'Team TPS'));

        $grid = new GridField(
            'JabatanGrid',
            'Jabatan Pegawai',
            $this->Jabatans(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
        );

        $grid->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
            'JabatanID' => array(
                'title' => 'Jabatan',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new DropdownField($column, '', Jabatan::get()->map('ID', 'Nama'));
                    $dropdown->setEmptyString("Plih Jabatan");
                    return $dropdown;
                }
            ),
            'DepartemenID' => array(
                'title' => 'Departemen',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new DropdownField($column, '', Departemen::get()->map('ID', 'Nama'));
                    $dropdown->setEmptyString("Plih Deparrtemen");
                    return $dropdown;
                }
            ),
            'CabangID' => array(
                'title' => 'Cabang',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new DropdownField($column, '', StrukturCabang::get()->map('ID', 'Nama'));
                    $dropdown->setEmptyString("Plih Cabang");
                    return $dropdown;
                }
            )
        ));

        $fields->addFieldToTab("Root.Main", $grid);

        return $fields;
    }
}

<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextAreaField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Parsers\HTMLValue;
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

class LampiranKontrakFile extends File
{
    private static $has_one = [
        'Supplier' => Supplier::class
    ];
}

class Supplier extends DataObject
{
    private static $db = [
        'Kode' => 'Varchar(100)',
        'Nama' => 'Varchar(100)',
        'Alamat' => 'Varchar(255)',
        'NoTelp' => 'Varchar(15)',
        'NoWa' => 'Varchar(15)',
        'TglExpKontrak' => "Date"
    ];
    // private static $has_many = [
    //     'LampiranKontrak' => LampiranKontrakFile::class,
    // ];

    private static $owns = [
        'LampiranKontrak'
    ];

    private static $searchable_fields = [
        'Nama',
        'Alamat',
        'TglExpKontrak'
    ];

    private static $field_labels = [
        'Nama' => 'Supplier',
        'NoTelp' => 'No. Hp',
        'NoWa' => 'No. Wa',
        'ListLampiran' => 'Lampiran Kontrak',
        'TglExpKontrak.Nice' => 'Tanggal Expired Kontrak',
        // 'LampiranKontrak.FileFilename'=>'Lampiran Kontrak'
    ];

    private static $summary_fields = [
        'Nama',
        'Alamat',
        'NoTelp',
        'NoWa',
        'ListLampiran',
        // 'LampiranKontrak.FileFilename',
        'TglExpKontrak.Nice',
    ];

    private static $has_many = [
        'JenisBarang' => SupplierPerJenisBarang::class,
        'LampiranKontrak' => LampiranKontrakFile::class,
    ];

    public function ListLampiran() {
        $string = "";
        foreach ($this->LampiranKontrak() as $val) {
            $string .= "<a class='no-event' href='".$val->AbsoluteURL."' target='_blank'>".$val->Name."</a><br>";
        }
        $html = HTMLValue::create($string);
        return $html;
    }

    public function getCMSValidator()
    {
        return new RequiredFields(array("Nama", "Alamat", "NoTelp", "NoWa", "LampiranKontrak", "TglExpKontrak"));
    }

    public function getCMSFields()
    {
        $fields = new FieldList();
        $fields->add(new TabSet("Root"));

        $fields->addFieldsToTab("Root.Main", new ReadonlyField("Kode", "Kode", "<Auto Generate>"));
        $fields->addFieldsToTab("Root.Main", new TextField("Nama", "Supplier"));
        $fields->addFieldsToTab("Root.Main", new TextAreaField("Alamat", "Alamat"));
        $fields->addFieldsToTab("Root.Main", new TextField("NoTelp", "No. HP"));
        $fields->addFieldsToTab("Root.Main", new TextField("NoWa", "No. Wa"));
        $fields->addFieldsToTab("Root.Main", new UploadField("LampiranKontrak", "Lampiran Kontra"));

        $tgl = new DateField("TglExpKontrak", "Tanggal Expired Kontrak");
        $tgl->setDatepickerFormat('dd/MM/yyyy');
        // $tgl->setDateFormat('dd/MM/yyyy');
        $fields->addFieldsToTab("Root.Main", $tgl);

        $grid = new GridField(
            'BarangGrid',
            'Detail Barang',
            $this->JenisBarang(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
        );

        $grid->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
            'JenisBarangID' => array(
                'title' => 'Jenis Barang',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new DropdownField($column, '', JenisBarang::get()->map('ID', 'Nama'));
                    $dropdown->setEmptyString("Plih Jenis Barang");
                    return $dropdown;
                }
            ),
            'Nama' => array(
                'title' => 'Nama Barang',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new TextField('Nama', '');
                    return $dropdown;
                }
            ),
            'SatuanID' => array(
                'title' => 'Satuan',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new DropdownField($column, '', Satuan::get()->map('ID', 'Nama'));
                    $dropdown->setEmptyString("Plih Satuan");
                    return $dropdown;
                }
            ),
        ));

        $fields->addFieldsToTab("Root.Main", $grid);

        return $fields;
    }
}

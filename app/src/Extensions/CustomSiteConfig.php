<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
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


class CustomSiteConfig extends DataExtension
{

    private static $db = [
        'sendgrid_apikey'     => 'Text',
        'email_from'        => 'Text',
        'email_from_name'    => 'Text',
        'NominalTPS' => 'Double',
        'NominalPimpinan' => 'Double'
    ];

    private static $has_one = [
        'KepalaPembelian' => User::class,
        'AsistenPembelian' => User::class,
        'KepalaFinance' => User::class,
        'AsistenFinance' => User::class,
        'StafPencarianHarga' => Jabatan::class,
        'DepartemenPencairanHarga' => Departemen::class
    ];

    private static $has_many = [
        'StatusPermintaan' => StatusPermintaanBarang::class
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab(
            "Root.Email",
            new TextField("email_from", "Email From")
        );
        $fields->addFieldToTab(
            "Root.Email",
            new TextField("email_from_name", "Email From Name")
        );
        $fields->addFieldToTab(
            "Root.Email",
            new TextField("sendgrid_apikey", "Sendgrid API KEY")
        );

        $user = User::userList();

        $dropdown = new DropdownField('KepalaPembelianID', 'Kepala Pembelian', $user->map('ID', 'Nama'));
        $dropdown->setEmptyString("Pilih Kepala Pembelian");
        $fields->addFieldToTab("Root.Jabatan Khusus", $dropdown);

        $dropdown = new DropdownField('AsistenPembelianID', 'Asisten Kepala Pembelian', $user->map('ID', 'Nama'));
        $dropdown->setEmptyString("Pilih Asisten Kepala Pembelian");
        $fields->addFieldToTab("Root.Jabatan Khusus", $dropdown);

        $dropdown = new DropdownField('KepalaFinanceID', 'Kepala Finance', $user->map('ID', 'Nama'));
        $dropdown->setEmptyString("Pilih Kepala Finance");
        $fields->addFieldToTab("Root.Jabatan Khusus", $dropdown);

        $dropdown = new DropdownField('AsistenFinanceID', 'Asisten Kepala Finance', $user->map('ID', 'Nama'));
        $dropdown->setEmptyString("Pilih Asisten Kepala Pembelian");
        $fields->addFieldToTab("Root.Jabatan Khusus", $dropdown);

        $dropdown = new DropdownField('StafPencarianHargaID', 'Staff Pencarian Harga dan Vendor', Jabatan::get()->map('ID', 'Nama'));
        $dropdown->setEmptyString("Pilih Jabatan");
        $fields->addFieldToTab("Root.Jabatan Khusus", $dropdown);

        $dropdown = new DropdownField('DepartemenPencairanHargaID', 'Departemen Pencarian Harga dan Vendor', Departemen::get()->map('ID', 'Nama'));
        $dropdown->setEmptyString("Pilih Departemen");
        $fields->addFieldToTab("Root.Jabatan Khusus", $dropdown);

        $text = new TextField("NominalTPS", "Nominal Approval TPS");
        $fields->addFieldsToTab("Root.Approval Khusus", $text);

        $text = new TextField("NominalPimpinan", "Nominal Approval Pimpinan");
        $fields->addFieldsToTab("Root.Approval Khusus", $text);


        $grid = new GridField(
            'BarangGrid',
            'Detail Barang',
            StatusPermintaanBarang::get(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
            // ->addComponent(new GridFieldDeleteAction())
            // ->addComponent(new GridFieldAddNewInlineButton())
        );

        $grid->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
            'Kode' => array(
                'title' => 'Kode',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new TextField('Kode', '');
                    $dropdown->setDisabled(true);
                    return $dropdown;
                }
            ),
            'Status' => array(
                'title' => 'Status',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new TextField('Status', '');
                    return $dropdown;
                }
            ),
            'Keterangan' => array(
                'title' => 'Keterangan',
                'callback' => function ($record, $column, $grid) {
                    $dropdown = new TextField('Keterangan', '');
                    return $dropdown;
                }
            ),
        ));

        $fields->addFieldsToTab("Root.Status Permintaan", $grid);
    }
}

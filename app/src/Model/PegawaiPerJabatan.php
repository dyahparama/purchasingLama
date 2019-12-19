<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ValidationException;
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
class PegawaiPerJabatan extends DataObject
{
    private static $db = [

    ];

    // $kacab = PegawaiPerJabatan::get()->where("DepartemenIDPegawaiID={$pegawaiid}");

    private static $has_one = [
        'Jabatan' => Jabatan::class,
        'Pegawai' => Pegawai::class,
        'Cabang' => StrukturCabang::class,
        'Departemen' => Departemen::class
    ];

    // private static $owns = [
	// 	'logo'
    // ];

    private static $searchable_fields = [
        'Nama',
        'NoInduk',
        'Email',
        'Penempatan'
     ];

     private static $field_labels = [
        'Nama'=>'Nama',
        'NoInduk'=>'No. Induk Pegawai',
        'NoTelp'=>'No. Hp',
     ];

     private static $summary_fields = [
        'Nama',
        'NoInduk',
        'Alamat',
        'NoTelp',
     ];

     public function getPegawaiJabatan()
     {
         return $this->Jabatan->Nama . '/' . $this->Cabang->Nama;  
     }


}

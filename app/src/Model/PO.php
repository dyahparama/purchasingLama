<?php
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

class PO extends DataObject {
	private static $db = [
		'Kode' => 'Varchar(25)',
		'Tgl' => 'Date',
		'Total' => 'Double',
		'NamaSupplier' => 'Varchar(50)',
		'Note' => 'Text',
		'Alamat' => 'Text',
		'Nama' => 'Varchar(50)',
		'Kontak' => 'Varchar(50)',
		'IsClosed' => 'Boolean',
		'SuratJalan' => 'Varchar(50)'
	];
	private static $indexes = [
		'Kode' => [
			'type' => 'unique',
			'columns' => ['Kode'],
		],
	];
	private static $has_one = [
		'DraftRB' => DraftRB::class,
		'RB' => RB::class,
		'ForwardTo' => User::class,
		'ApproveTo' => User::class,
		'Supplier' => Supplier::class,
		'Status' => StatusPermintaanBarang::class,
		'TerimaLPB' => User::class,
	];

	private static $has_many = [
		'Detail' => PODetail::class,
		'Termin' => POTerminDetail::class,
	];

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		if (!$this->ID) {
			$this->Kode = AddOn::createKode("PO", "PO");
		}
	}

	public static function GetPO($ID) {
		$detailnya = PODetail::get()->where('POID = ' . $ID);
		$temp = array();
		$asu = new ArrayList();
		foreach ($detailnya as $key) {
			$temp['NamaBarang'] = $key['NamaBarang'];
			$temp['Jumlah'] = $key['Jumlah'];
			$temp['view_link'] = 'po/ApprovePage/' . $ID . "/" . $key['NamaSupplier'];
			$asu->push($temp);
		}
		return $asu;
	}
	// private static $has_many = [
	//     'Regionals' => Regional::class,
	// ];

	// private static $owns = [
	// 	'logo'
	// ];
}

<?php

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationException;

class RB extends DataObject {
	private static $db = [
		'Kode' => 'Varchar(10)',
		'Tgl' => 'Date',
		'Total' => 'Double',
	];
	private static $indexes = [
		'Kode' => [
			'type' => 'unique',
			'columns' => ['Kode'],
		],
	];
	private static $has_one = [
		'DraftRB' => DraftRB::class,
		'DraftRBOld' => DraftRB::class,
	];

	private static $has_many = [
		'PenawaranSupplier' => PenawaranSupplierDetail::class
	];
	// private static $has_one = [
	//     'logo' => Image::class,
	// ];
	// private static $has_many = [
	//     'Moduls' => ModulData::class,
	// ];

	// private static $owns = [
	// 	'logo'
	// ];

	public function onBeforeWrite() {
		if (!$this->ID) {
			$obj = Jabatan::get()
				->filter([
					'Kode' => $this->Kode,
				])->Count();
			if (!empty($obj)) {
				throw new ValidationException("Kode must be unique");
			}
		}
		parent::onBeforeWrite();
	}
	public static function GetSuplier($ID) {
		$detailnya = DetailRBPerSupplier::get()->where('RBID = ' . $ID);
		$tes = AddOn::groupBySum($detailnya, "NamaSupplier", array("Total"), array("NamaSupplier", "Kode", "Total"));
		$temp = array();
		$asu = new ArrayList();
		foreach ($tes as $key) {
			if ($key['NamaSupplier'] != '') {
				$temp['NamaSupplier'] = $key['NamaSupplier'];
				$temp['Kode'] = $key['Kode'];
				$temp['Total'] = $key['Total'];
				$temp['view_link'] = 'po/ApprovePage/' . $ID . "/" . $key['NamaSupplier'];
				$asu->push($temp);
			}
		}
		return $asu;
	}
}

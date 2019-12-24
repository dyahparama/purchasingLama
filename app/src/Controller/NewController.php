<?php
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\Controller;
	use SilverStripe\Dev\Debug;
	use SilverStripe\ORM\DB;

	class NewController extends PageController
	{
		private static $allowed_actions = [
			'tutup_po'
		];

		public function tutup_po(HTTPRequest $request)
		{
			$id = $request->param('ID');

			// get po and set isClosed=1
			$po = PO::get()->byID($id);
			echo "Kode PO: ".$po->Kode."</br>";
			$po_detail = $po->Detail();
			// $po->IsClosed = 1;
			// $po->write();

			// po detail
			foreach ($po_detail as $po_det) {
				$lpbs = LPB::get()->where("POID={$po->ID}");

	 			$detail_per_supplier_id = $po_det->DetailPerSupplierID;
	 			echo "Detail per supplier id: ".$detail_per_supplier_id."</br>";
	 			// jumlah yg dipesan
				$jumlah_po = DB::query("SELECT SUM(Jumlah) FROM podetail WHERE DetailPerSupplierID={$detail_per_supplier_id}")->value();
	 			// jumlah yg sudah direalisasi
				$jumlah_lpb = DB::query("SELECT SUM(JumlahTerima) FROM lpbdetail WHERE DetailPerSupplierID={$detail_per_supplier_id}")->value();
	 			// jumlah yg tolol
				$jumlah_drb = DB::query("SELECT ID FROM detailrbpersupplier WHERE ID={$detail_per_supplier_id}")->value();

				echo "Jumlah PO: ".$jumlah_po."</br>";
				echo "Jumlah LPB: ".$jumlah_lpb."</br>";
				echo "Jumlah DRB: ".$jumlah_drb."</br>";
	 				
	 			$detailrbpersupplier = DetailRbPerSupplier::get()->byID($detail_per_supplier_id);
	 			// var_dump($detailrbpersupplier->DraftRbDetailID);
	 			$draft_rb_detailid = $detailrbpersupplier->DraftRbDetailID;
	 			echo "Draft rb detailid: ".$draft_rb_detailid."</br>"; 
			}
/*
			if ($lpbs->exists()) {
			 	foreach ($lpbs as $lpb) {
			 		echo "LPB: ".$lpb->Kode."</br>";
			 		$lpb_detail = $lpb->Detail();
			 		foreach ($lpb_detail as $lpb_det) {
			 			$permintaan = DetailRbPerSupplier::get()->byID($lpb_det->DetailPerSupplierID);
			 			$terpenuhi = ($permintaan->Jumlah - $lpb_det->JumlahTerima);
			 			echo "Permintaan: ". $permintaan . "</br>";
			 			echo "Terpenuhi: ". $terpenuhi . "</br>";
			 		}
			 	}
			} 
*/
			// return $id;
			// $po =
		}
	}
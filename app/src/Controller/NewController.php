<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\DB;
use SilverStripe\Assets\File;

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
        // echo "Kode PO: ".$po->Kode."</br>";
        $po_detail = $po->Detail();
        $rbDetailArr = array();

        var_dump("<br>");
        echo "<br>";

        foreach ($po_detail as $po_det) {
            $rbDetail = $po_det->DetailPersupplier()->DraftRBDetailID;
            $rbDetailArr[] = $rbDetail;
        }
        $rbDetailArr = array_unique($rbDetailArr);

        if ($rbDetailArr) {
            // $drafRB = DraftRB::get()->where("Kode LIKE '%DRB%'")->sort("Kode", "DESC")->limit(1);
            //     if ($drafRB->count()) {
            //      $kode = "DRB-" . DraftRBController::GenerateKode($drafRB->first()->Kode);
            //     } else {
            //      $kode = "DRB-00001";
            //     }

            $draftRB2 = DraftRBDetail::get()->byID($rbDetailArr[0])->DraftRB();
            $cek = DraftRB::create();
            $cek->ForwardToID = 0;
            $cek->ApproveToID = 0;
            $cek->AssistenApproveTo = 0;
            $cek->TglSubmit = $draftRB2->TglSubmit;
            $cek->StatusID = 5;
            $cek->Created = date("Y/m/d H:i:s");
            $cek->Kode = AddOn::createKode("DraftRB", "DRB");
            $cek->Notes= $draftRB2->Notes;
            $cek->DraftRBLamaID = $draftRB2->ID;
            $cek->Tgl = $draftRB2->Tgl;
		    $cek->PemohonID = $draftRB2->PemohonID;
		    $cek->JenisID = $draftRB2->JenisID;
		    $cek->Deadline = $draftRB2->Deadline;
		    $cek->Alasan = $draftRB2->Alasan;
		    $cek->NomorProyek = $draftRB2->NomorProyek;
		    $cek->PegawaiPerJabatanID = $draftRB2->PegawaiPerJabatanID;
            $draftRBID = $cek->write();

            $rb = RB::create();
            $rb->Kode = AddOn::createKode("RB", "RB");
            $rb->DraftRBID = $draftRBID;
            $rb->write();

            foreach ($rbDetailArr as $detail) {
                $draftRBDetail = DraftRBDetail::get()->byID($detail);

                $jumlahDetail = $draftRBDetail->Jumlah;

                // echo "Jumlah Detail = " . $jumlahDetail . "<br>";

                $jumlahLPB = 0;
                foreach ($draftRBDetail->DetailRBPerSupplier() as $detailPerSupplier) {
                    foreach ($detailPerSupplier->DetailLPB() as $detailLPB) {
                        $jumlahLPB += $detailLPB->JumlahTerima;
                    }
                }
                // echo "Jumlah LPB = " . $jumlahLPB . "<br>";
                $jumlahAkhir = (float)$jumlahDetail - (float)$jumlahLPB;
                // echo "Jumlah Akhir = " .$draftRBDetail->Deskripsi. "<br>";

                $detail = DraftRBDetail::create();
                $detail->Deskripsi = $draftRBDetail->Deskripsi;
                $detail->Jumlah = $jumlahAkhir;
                $detail->SatuanID = $draftRBDetail->SatuanID;
                $detail->Supplier = $draftRBDetail->Supplier;
                $detail->Spesifikasi = $draftRBDetail->Spesifikasi;
                $detail->KodeInventaris = $draftRBDetail->KodeInvetaris;
                $detail->JenisID = $draftRBDetail->JenisID;
                $detail->DraftRBID = $draftRBDetail->DraftRBID;
                $idDetail = $detail->write();

                foreach ($draftRBDetail->Penawaran() as $gambar) {
                    $gambarObjectOld = File::get()->byID($gambar->ID);

                    $gambarObjectNew = File::create();
                    $gambarObjectNew->ClassName = $gambarObjectOld->ClassName;
                    $gambarObjectNew->Version = $gambarObjectOld->Version;
                    $gambarObjectNew->CanViewType = $gambarObjectOld->CanViewType;
                    $gambarObjectNew->CanEditType = $gambarObjectOld->CanEditType;
                    $gambarObjectNew->Name = $gambarObjectOld->Name;
                    $gambarObjectNew->Title = $gambarObjectOld->Title;
                    $gambarObjectNew->ShowInSearch = $gambarObjectOld->ShowInSearch;
                    $gambarObjectNew->ParentID = $gambarObjectOld->ParentID;
                    $gambarObjectNew->OwnerID = $gambarObjectOld->OwnerID;
                    $gambarObjectNew->FileHash = $gambarObjectOld->FileHash;
                    $gambarObjectNew->FileFilename = $gambarObjectOld->FileFilename;
                    $gambarObjectNew->FileVariant = $gambarObjectOld->FileVariant;
                    $idGambar = $gambarObjectNew->write();

                    DB::query("INSERT INTO penawaran (ID, DraftRBDetailID) VALUES ({$idGambar}, {$idDetail})");
                }


                // foreach(Penawaran::get()->where())
            }
        }
        return $this->redirect(Director::absoluteBaseURL() . "ta");
        // // $po->IsClosed = 1;
        // // $po->write();

        // // po detail
        // foreach ($po_detail as $po_det) {
        //     // $lpbs = LPB::get()->where("POID={$po->ID}");
        //     $detail_per_supplier_id = $po_det->DetailPerSupplierID;
        // 	echo "Detail per supplier id: ".$detail_per_supplier_id."</br>";
        //     $detailrbpersupplier = DetailRbPerSupplier::get()->byID($detail_per_supplier_id);
        // 	// var_dump($detailrbpersupplier->DraftRbDetailID);
        // 	$draft_rb_detailid = $detailrbpersupplier->DraftRBDetailID;
        //      echo "Draft rb detailid: ".$draft_rb_detailid."</br>";

        //      echo "RB id: ".$detailrbpersupplier->RBID."</br>";

        // 	// jumlah yg dipesan
        // 	$jumlah_po = DB::query("SELECT SUM(Jumlah) FROM podetail WHERE DetailPerSupplierID={$detail_per_supplier_id}")->value();
        // 	// jumlah yg sudah direalisasi
        // 	$jumlah_lpb = DB::query("SELECT SUM(JumlahTerima) FROM lpbdetail WHERE DetailPerSupplierID={$detail_per_supplier_id}")->value();
        // 	// jumlah yg tolol
        // 	$jumlah_drb = DB::query("SELECT ID FROM detailrbpersupplier WHERE ID={$detail_per_supplier_id}")->value();

        // 	echo "Jumlah PO: ".$jumlah_po."</br>";
        // 	echo "Jumlah LPB: ".$jumlah_lpb."</br>";
        // 	echo "Jumlah DRB: ".$jumlah_drb."</br>";
        // }
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

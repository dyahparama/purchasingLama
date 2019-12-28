<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Control\Director;
    use SilverStripe\Control\HTTPRequest;
    use Silverstripe\SiteConfig\SiteConfig;
    use SilverStripe\View\Requirements;
    use SilverStripe\ORM\DB;

    class PageController extends ContentController
    {
        // for didin
        // 		ApproveRB(String $note,Object $rb,ID $approver)

        // submitStaffPembelian(String $drb,Boolean $isTPS)

        // forwardDrb(String $note,Object $drb,ID $from,ID $to)

        // rejectDRB(String $note,Object $drb,ID $approver)

        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = ["index"];

        protected function init()
        {
            Requirements::themedCSS('custom');
            parent::init();
            // $this::getStrukturDrb(14);
            // die;
        }
        public static function getBaseURL()
        {
            return Director::absoluteBaseURL();
        }
        public function index(HTTPRequest $request)
        {
            if (!UserController::cekSession()) {
                return $this->redirect(Director::absoluteBaseURL() . "user/login");
            } else {
                $arr_data = array(
                    'Results' => "Zemmy",
                );
                return $this->customise($arr_data)
                    ->renderWith(array(
                        'Page',
                        'Page',
                    ));
            }
        }

        public function dateFormat($param, $separator, $separatorShow)
        {
            $arr = explode("$separator", $param);
            return $arr[2] . "$separatorShow" . $arr[1] . "$separatorShow" . $arr[0];
        }

        public function countLPB($id)
        {
            $jumlah1 = DB::query("SELECT SUM(Jumlah) FROM detailrbpersupplier WHERE ID = {$id}")->value();
            $jumlah2 = DB::query("SELECT SUM(JumlahTerima) FROM lpbdetail WHERE DetailPerSupplierID = {$id}")->value();

            if (!$jumlah1) {
                $jumlah1 = 0;
            }

            if (!$jumlah2) {
                $jumlah2 = 0;
            }

            return $jumlah1 - $jumlah2;
        }

        public function multiply($val1, $val2)
        {
            return (float) $val1 * (float) $val2;
        }

        public static function getNextTarget($drb)
        {
            $cabangLokal = $drb->PegawaiPerJabatan()->Cabang();
            $cabangRegional = $drb->PegawaiPerJabatan()->Cabang()->Regional();
            $status = $drb->Status()->ID;
            $pemohon = $drb->Pemohon()->ID;
            $detail = $drb->Detail()->first();
            $kepalaCabang = $drb->PegawaiPerJabatan()->Cabang()->Kacab()->ID;
            $idCabangRegional = $drb->PegawaiPerJabatan()->Cabang()->Regional()->ID;
            $idCabangPusat = $drb->PegawaiPerJabatan()->Cabang()->Pusat()->ID;
            $idJenis = $detail->Jenis()->ID;
            // var_dump([$idCabangRegional,$idJenis]);
            // var_dump(CabangJenisBarang::get()->where("CabangID = {$idCabangRegional} AND JenisBarangID = {$idJenis}")->first());
            // die;
            //$target = CabangJenisBarang::get()->where("CabangID = {$idCabangRegional} AND JenisBarangID = {$idJenis}")->first()->Kadep()->ID;

            //var_dump($idCabangRegional);
            // var_dump($idJenis);
            // var_dump($idCabangRegional);
            // die;
            switch ($status) {
                case 1:
                    $targetStatus = 2;
                    $target = CabangJenisBarang::get()->where("CabangID = {$idCabangRegional} AND JenisBarangID = {$idJenis}")->first()->Kadep()->ID;
                    $asisten = "0";
                    // var_dump($idCabangRegional);
                    // var_dump($idJenis);
                    //             var_dump($target);
                    // die;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;
                case 2:
                    $targetStatus = 3;
                    $target = $cabangRegional->Kacab()->ID;
                    $asisten = $cabangRegional->Approver()->ID;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;
                case 3:
                    $targetStatus = 4;
                    $jenisBarang = CabangJenisBarang::get()->where("CabangID = {$idCabangPusat} AND JenisBarangID = {$idJenis}")->first()->JenisBarang();
                    $target = $jenisBarang->Kadep()->ID;
                    $asisten = $jenisBarang->Approver()->ID;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;
                case 4:
                    $targetStatus = 5;
                    $target = 0;
                    $asisten = 0;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;

                default:
                    break;
            }
        }

        public static function cekSudahApprove($nextUser, $drb)
        {
            if (in_array($nextUser, ["0", 0])) {
                return false;
            }
            $history = HistoryApproval::get()->where("ApprovedByID = {$nextUser} AND DraftRBID = $drb->ID")->count();
            if (empty($history)) {
                return false;
            }
            return true;
        }

        public static function ApproveDrb($note, $drb, $approver)
        {
            $stop = false;
            while ($stop == false) {
                $target = self::getNextTarget($drb);
                $history = HistoryApproval::create();
                $history->Note = $note;
                $history->ApprovedByID = $approver;
                $history->DraftRBID = $drb->ID;
                $history->StatusID = $target["status"];
                $history->write();
                $drb->StatusID = $target["status"];
                $drb->ApproveToID = $target["user"];
                $drb->ForwardToID = $target["user"];
                $drb->AssistenApproveToID = $target["asisten"];
                $drb->write();
                if ($target['status'] == 5 || $target['status'] == "5") {
                    $RB = RB::get()->sort("Kode", "DESC")->limit(1);
                    if ($RB->count()) {
                        $kode = "RB-" . AddOn::GenerateKode($RB->first()->Kode);
                    } else {
                        $kode = "RB-00001";
                    }
                    $newRB = RB::create();
                    $newRB->Kode = $kode;
                    $newRB->DraftRBID = $drb->ID;
                    $newRB->write();
                    $stop = true;
                }
                if (!self::cekSudahApprove($target["user"], $drb)) {
                    $stop = true;
                }
            }
        }

        public static function forwardDrb($note, $drb, $from, $to)
        {
            $history = HistoryForwarding::create();
            $history->Note = $note;
            $history->ForwardToID = $to;
            $history->DraftRBID = $drb->ID;
            $history->ForwardFormID = $from;
            $history->write();
            $drb->ForwardToID = $to;
            $drb->write();
        }

        public static function rejectDRB($note, $drb, $approver)
        {
            $history = HistoryApproval::create();
            $history->Note = $note;
            $history->ApprovedByID = $approver;
            $history->DraftRBID = $drb->ID;
            $history->StatusID = '13';
            $history->write();
            $drb->StatusID = '13';
            $drb->ApproveToID = '0';
            $drb->ForwardToID = '0';
            $drb->AssistenApproveToID = '0';
            $drb->write();
        }

        static function MoneyFormat($prefix, $value)
        {
            return $prefix . " " . number_format($value, 2, ",", ".");
        }

        static function FormatDate($format, $value)
        {
            return date($format, strtotime($value));
        }

        public static function getJabatanFromStatus($status)
        {
            switch ($status) {
                case 2:
                    return "Kepala Cabang";
                    break;
                case 3:
                    return "Kadep Regional";
                    break;
                case 4:
                    return "Kepala Regional";
                    break;
                case 5:
                    return "Kadep Pusat";
                    break;
                case 6:
                    return "Staff Pembelian";
                    break;
                case 7:
                    return "Tim TPS";
                    break;
                case 8:
                    return "Kepala Pembelian";
                    break;
                case 9:
                    return "Kepala Finance";
                    break;
                default:
                    return "lain-lain";
                    break;
            }
        }

        public function getPosisiTerakhir($draft_rb)
        {
            $history = HistoryApproval::get()->where("DraftRBID={$draft_rb->ID}")->sort("StatusID DESC")->first();
            // foreach ($history as $value) {
            // echo $history->StatusID . "=>" . $history->ApprovedByID."</br>";
            // }

            return $history;
        }

        public static function getTglTerima($HistoryID)
        {
            $history = HistoryApproval::get()->byID($HistoryID);
            // var_dump($history);die();
            if ($history->Status()->ID <= 2) {

                $date = $history->DraftRB()->Created;
                $date = explode(" ", $date);
                $date = $date[0];
                $jam = $date[1];
            } else {
                $status = $history->Status()->ID - 1;
                $cek = HistoryApproval::get()->where("StatusID = {$status} AND DraftRBID = {$history->DraftRB()->ID}");
                if (!$cek->count()) {
                    $status -= 1;
                    $cek = HistoryApproval::get()->where("StatusID = {$status} AND DraftRBID = {$history->DraftRB()->ID}");
                    if (!$cek->count()) {
                        $status -= 1;
                    }
                }
                $date = HistoryApproval::get()->where("StatusID = {$status} AND DraftRBID = {$history->DraftRB()->ID}")->first()->Created;
                $date = explode(" ", $date);
                $date = $date[0];
                $jam = $date[1];
            }
            return $jam . " " . (new self)->dateFormat($date, "-", "/");
        }

        public static function getTglApprove($date)
        {
            $date = explode(" ", $date);
            $date = $date[0];
            $jam = $date[1];
            return $jam . " " . (new self)->dateFormat($date, "-", "/");
        }

        public static function getApprover($drb)
        {
            $canApprove = false;
            $canForward = false;
            $approver = $drb->ApproveTo()->ID;
            $forwardTo = $drb->ForwardTo()->ID;
            //             var_dump($approver);
            //             var_dump($_SESSION['user_id']);
            // die;

            if ($drb->Status()->ID == 1) {
                $assisten = $drb->PegawaiPerJabatan()->Cabang()->Approver()->ID;
                if ($assisten == $_SESSION['user_id']) {
                    $canApprove = true;
                    $canForward = true;
                }
            }
            if ($drb->Status()->ID == 3) {
                $assisten = $drb->PegawaiPerJabatan()->Cabang()->Regional()->Approver()->ID;
                if ($assisten == $_SESSION['user_id']) {
                    $canApprove = true;
                    $canForward = true;
                }
            }
            if ($drb->Status()->ID == 4) {
                $assisten = $drb->Detail()->first()->Jenis()->Approver()->ID;
                if ($assisten == $_SESSION['user_id']) {
                    $canApprove = true;
                    $canForward = true;
                }
            }
            if ($_SESSION['user_id'] == $approver && $_SESSION['user_id'] == $forwardTo) {
                $canApprove = true;
                $canForward = true;
            }
            if ($_SESSION['user_id'] == $forwardTo) {
                $canForward = true;
            }
            return ["canForward" => $canForward, "canApprove" => $canApprove];
        }

        public static function getNextTargetRB($drb)
        {
            $siteconfig = SiteConfig::current_site_config();
            $nominalTPS = $siteconfig->NominalTPS;
            $nominalPimpinan = $siteconfig->NominalPimpinan;
            $kepalaPusat = $drb->PegawaiPerJabatan()->Cabang()->Pusat()->Kacab()->ID;
            $status = $drb->Status()->ID;
            switch ($status) {
                case 6:
                    $targetStatus = 7;
                    $target = $siteconfig->KepalaPembelian()->ID;
                    $asisten = $siteconfig->AsistenPembelian()->ID;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;
                case 7:

                    $targetStatus = 8;
                    $target = $siteconfig->KepalaFinance()->ID;
                    $asisten = $siteconfig->AsistenFinance()->ID;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;
                case 8:
                    $targetStatus = 9;
                    $target = 0;
                    $asisten = 0;
                    return (["user" => $target, "status" => $targetStatus, "asisten" => $asisten]);
                    break;

                default:
                    break;
            }
        }
        public static function cekSudahApproveRB($nextUser, $drb)
        {
            $siteconfig = SiteConfig::current_site_config();
            // $nominalTPS = $siteconfig->NominalTPS;
            $userTps = [];
            $history = [];
            // $kepalaPusat = $drb->PegawaiPerJabatan()->Cabang()->Pusat()->Kacab()->ID;
            // if ($drb->Status()->ID == 6 && $rb->Total >= $nominalTPS) {
            // 	$timTps = Pegawai::get()->where("IsTPS = 1");
            // 	$historyRB = HistoryApproval::get()->where("Status > 6 AND Status < 10");
            // 	foreach ($timTps as $key) {
            // 		$userTps[] = $key->User()->ID;
            // 	}
            // 	foreach ($historyRB as $key) {
            // 		$history[] = $key->ApprovedBy()->ID;
            // 	}
            // 	$irisan = array_intersect($history, $userTps);
            // 	if (count($irisan)) {
            // 		return true;
            // 	}
            // }
            $history = HistoryApproval::get()->where("StatusID > 6 AND StatusID < 10")->where("ApprovedByID = {$nextUser} AND DraftRBID = $drb->ID")->count();
            if (empty($history) || $nextUser == 0 || $nextUser == "0") {
                return false;
            }
            return true;
        }

        public static function ApproveRB($note, $rb, $approver)
        {
            $drb = $rb->DraftRB();
            $stop = false;
            while ($stop == false) {
                $target = self::getNextTargetRB($drb);
                $history = HistoryApproval::create();
                $history->Note = $note;
                $history->ApprovedByID = $approver;
                $history->DraftRBID = $drb->ID;
                $history->StatusID = $target["status"];
                $history->write();
                $drb->StatusID = $target["status"];
                $drb->ApproveToID = $target["user"];
                $drb->ForwardToID = $target["user"];
                $drb->AssistenApproveToID = $target["asisten"];
                $drb->write();
                if (!self::cekSudahApproveRB($target["user"], $drb)) {
                    $stop = true;
                }
            }
        }

        public static function submitStaffPembelian($drb, $isTPS)
        {
            $siteconfig = SiteConfig::current_site_config();
            if ($isTPS) {
                $drb->StatusID = "6";
                $drb->ApproveToID = "0";
                $drb->ForwardToID = "0";
            } else {
                $drb->StatusID = "7";
                $drb->ApproveToID = $siteconfig->KepalaPembelian()->ID;
                $drb->ForwardToID = $siteconfig->KepalaPembelian()->ID;
                $drb->AssistenApproveTo = $siteconfig->AsistenPembelian()->ID;
            }
            $drb->write();
        }

        public function getUsername()
        {
            $user = User::get()->byID($_SESSION['user_id']);
            $name = $user->Pegawai()->Nama;
            return $name;
        }

        public function getStrukturDrb($drb)
        {
            $id = $drb;
            $drb = DraftRB::get()->byID($drb);

            $jenis = DraftRBDetail::get()->where("DraftRBID = {$id}")->first()->Jenis();
            $jenisID = $jenis->ID;
            $jenisNama = $jenis->Nama;
            $kadepPusatNama = $jenis->Kadep()->Pegawai()->Nama;
            $kadepPusatID = $jenis->Kadep()->ID;
            $askadepPusatNama = $jenis->Approver()->Pegawai()->Nama;
            $askadepPusatID = $jenis->Approver()->ID;
            
            $idppc = $drb->PegawaiPerJabatan()->ID;
            $pegawaiPerJabatan = PegawaiPerJabatan::get()->byID($idppc);
            $pemohon = $pegawaiPerJabatan->Pegawai()->Nama;
            $pemohonID = $pegawaiPerJabatan->Pegawai()->User()->ID;
            $cabangLokal = $pegawaiPerJabatan->Cabang();
            $cabangRegion = $pegawaiPerJabatan->Cabang()->Regional();
            $cabangPusat = $pegawaiPerJabatan->Cabang()->Pusat();
            $cabangRegionID = $cabangRegion->ID;
            $kacabLokalID = $cabangLokal->Kacab()->ID;
            $kacabLokalNama = $cabangLokal->Kacab()->Pegawai()->Nama;
            $askacabLokalID = $cabangLokal->Approver()->ID;
            $askacabLokalNama = $cabangLokal->Approver()->Pegawai()->Nama;
            // var_dump([$cabangRegionID,$jenisID]);
            // die;
            $kadepRegion = CabangJenisBarang::get()->where("JenisBarangID = {$jenisID} AND CabangID = {$cabangRegionID}")->first();
            $kadepNama = $kadepRegion->Kadep()->Pegawai()->Nama;
            $kadepID = $kadepRegion->Kadep()->ID;
            
            
            $kacabRegion = $cabangRegion->Kacab();
            $kacabRegionID = $kacabRegion->ID;
            $kacabRegionNama =  $kacabRegion->Pegawai()->Nama;
            $askacabRegionID = $cabangRegion->Approver()->ID;
            $askacabRegionNama = $cabangRegion->Approver()->Pegawai()->Nama;
            //$kadepPusat = Jenis
            //header("Content-Type:Application/json");
            echo "<pre>";
            var_dump([
                "jenisID" => $jenisID,
                "jenisNama" => $jenisNama,
                "kepalaCabangID" => $kacabLokalID,
                "kepalaCabangNama" => $kacabLokalNama,
                "askepalaCabangID" => $askacabLokalID,
                "askepalaCabangNama" => $askacabLokalNama,
                "kadepRegionID" => $kadepID,
                "kadepRegionNama" => $kadepNama,
                "kacabRegionID" => $kacabRegionID,
                "kacabRegionNama" => $kacabRegionNama,
                "askacabRegionID" => $askacabRegionID,
                "askacabRegionNama" => $askacabRegionNama,
                "kadepPusatID" => $kadepPusatID,
                "kadepPusatNama" => $kadepPusatNama,
                "askadepPusatID" => $askadepPusatID,
                "askadepPusatNama" => $askadepPusatNama,
                "pemohonID" => $pemohonID,
                "PemohonNama" => $pemohon
            ]);
            echo "</pre>";
        }

        public function getTotalTask()
        {
            $idnya = $_SESSION['user_id'];
            $shownya = 0;
            $pegawainya = User::get()->byID($idnya);
            $config = SiteConfig::current_site_config();
            $jabatannya = $config->StafPencarianHargaID;
            $kepala = $config->KepalaFinanceID;
            $departemennya = $config->DepartemenPencairanHargaID;
            $jabatanpegawai = [];
            $departemenpegawai = [];
            foreach ($pegawainya->Pegawai()->Jabatans() as $key) {
                $jabatanpegawai[] = $key->JabatanID;
                $departemenpegawai[] = $key->DepartemenID;
            }
            if ((in_array(strtoupper($jabatannya), $jabatanpegawai) && in_array(strtoupper($departemennya), $departemenpegawai)) || $kepala == $pegawainya->ID) {
                $shownya = 1;
            }
            $draftrbnya = DraftRB::get()->where('ForwardToID = ' . $pegawainya->ID);
            $lpbnya = PO::get();
            $rb = RB::get();
            $IsBuat = 0;
            $jumlahrb = 0;
            $jumlahpo = 0;
            $jumlahdraft = 0;
            $jumlahlpb = 0;
            // print_r($rb);
            foreach ($rb as $key) {
                if (in_array(strtoupper($jabatannya), $jabatanpegawai) && in_array(strtoupper($departemennya), $departemenpegawai) && $key->DraftRB()->Status()->ID == 5) {
                    $jumlahrb++;
                } else if ($key->DraftRB()->Status->ID == 6 && $pegawainya->Pegawai()->IsTPS == 1) {
                    $jumlahrb++;
                } else if (($key->DraftRB()->ForwardToID == $pegawainya->ID || $key->DraftRB()->AssistenApproveToID == $pegawainya->ID) && $key->DraftRB()->Status()->ID == 7) {
                    $jumlahrb++;
                } else if (($key->DraftRB()->ForwardToID == $pegawainya->ID || $key->DraftRB()->AssistenApproveToID == $pegawainya->ID) && $key->DraftRB()->Status()->ID == 8) {
                    $jumlahrb++;
                }
                if (($key->DraftRB()->Status()->ID == 9 || $key->DraftRB()->Status()->ID == 10) && $shownya == 1) {
                    $totalview = 0;
                    $totalgenerate = 0;
                    $temp2['isi'] = $key->GetSuplier($key->ID);
                    foreach ($temp2['isi'] as $key100) {
                        if($key100->IsPo == 1){
                            $totalview++;
                        }
                        if($key100->IsPo == 0){
                            $totalgenerate++;
                        }
                    }
                    // echo $totalview." ".$totalgenerate."<br>";
                    if($totalgenerate!=0){
                        $jumlahpo++;
                    }
                }
                // if (($key->DraftRB()->Status()->ID == 9 || $key->DraftRB()->Status()->ID == 10) && $shownya == 1) {
                //     $totalview = 0;
                //     $totalgenerate = 0;
                //     $temp2['isi'] = $key->GetSuplier($key->ID);
                //     foreach ($temp2['isi'] as $key100) {
                //         if ($key100->IsPo == 1) {
                //             $totalview++;
                //         }
                //         if ($key100->IsPo == 0) {
                //             $totalgenerate++;
                //         }
                //     }
                //     // echo $totalview." ".$totalgenerate."<br>";
                //     if ($totalgenerate == 0) {
                //         $jumlahpo++;
                //     }
                // }
            }
            foreach ($draftrbnya as $key) {
                if ($key->Status()->ID <= 5) {
                    $jumlahdraft++;
                }
            }
            foreach ($lpbnya as $key5) {
                if ($key5->DraftRB()->StatusID != 13 && $key5->TerimaLPBID == $pegawainya->ID) {
                    $jumlahlpb++;
                }
            }
            // var_dump(["DRB"=>$jumlahdraft,"RB"=>$jumlahrb,"PO"=>$jumlahpo,"LPB"=>$jumlahlpb]);
            // die;
            $totalnya = $jumlahdraft + $jumlahrb + $jumlahpo + $jumlahlpb;
            return $totalnya;
        }
    }
}

<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Control\Director;
    use SilverStripe\Control\HTTPRequest;
    use SilverStripe\View\Requirements;

    class PageController extends ContentController
    {
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
            switch ($status) {
                case 1:
                    $targetStatus = 2;
                    $target = $kepalaCabang;
                    return (["user" => $target, "status" => $targetStatus]);
                    break;
                case 2:
                    $targetStatus = 3;
                    $target = CabangJenisBarang::get()->where("CabangID = {$idCabangRegional} AND JenisBarangID = {$idJenis}")->first()->KadepID;
                    return (["user" => $target, "status" => $targetStatus]);
                    break;
                case 3:
                    $targetStatus = 4;
                    $target = $cabangRegional->Kacab()->ID;
                    return (["user" => $target, "status" => $targetStatus]);
                    break;
                case 4:
                    $targetStatus = 5;
                    $target = CabangJenisBarang::get()->where("CabangID = {$idCabangPusat} AND JenisBarangID = {$idJenis}")->first()->JenisBarang()->Kadep()->ID;
                    return (["user" => $target, "status" => $targetStatus]);
                    break;
                case 5:
                    $targetStatus = 6;
                    $target = "staf pembelian";
                    return (["user" => $target, "status" => $targetStatus]);
                    break;

                default:
                    break;
            }
        }
        public static function cekSudahApprove($nextUser, $drb)
        {
            if (in_array($nextUser, ["staf pembelian"])) {
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
                $drb->write();
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
            $history->StatusID = '14';
            $history->write();
            $drb->StatusID = '14';
            $drb->write();
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
                    return "Kepala Pembelian";
                    break;
                case 8:
                    return "Tim TPS";
                    break;
                case 9:
                    return "Finance";
                    break;
                case 10:
                    return "Pimpinan";
                    break;
                default:
                    return "lain-lain";
                    break;
            }
        }

        public static function getTglTerima($HistoryID)
        {
            $history= HistoryApproval::get()->byID($HistoryID);
            if ($history->Status()->ID<=2) {
                
                $date =  $history->DraftRB()->TglSubmit;
            }else{
               $status = $history->Status()->ID - 1;
               $date = HistoryApproval::get()->where("StatusID = {$status} AND DraftRBID = {$history->DraftRB()->ID}")->first()->Created;
               $date = explode(" ",$date);
               $date = $date[0];
            }
            return (new self)->dateFormat($date, "-", "/");
        }

        public static function getTglApprove($date)
        {
            $date = explode(" ",$date);
            $date = $date[0];
            return (new self)->dateFormat($date, "-", "/");
        }

        public static function getApprover($drb)
        {
            $canApprove = false;
            $canForward = false;
            $approver=$drb->ApproveTo()->ID;
            $forwardTo=$drb->ForwardTo()->ID;
            // var_dump($approver);
            // die;
            if( $_SESSION['user_id'] == $approver && $_SESSION['user_id'] == $forwardTo ){
                $canApprove = true;
                $canForward = true;
            }
            if ($_SESSION['user_id'] == $forwardTo) {
                $canForward = true;
            }
            return ["canForward"=>$canForward,"canApprove"=>$canApprove];
        }
    }
}

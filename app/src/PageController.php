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
                    $target = "tps";
                    return (["user" => $target, "status" => $targetStatus]);
                    break;
                case 5:
                    $targetStatus = 6;
                    $target = CabangJenisBarang::get()->where("CabangID = {$idCabangPusat} AND JenisBarangID = {$idJenis}")->first()->KadepID;
                    return (["user" => $target, "status" => $targetStatus]);
                    break;
                case 6:
                    $targetStatus = 7;
                    $target = "staf pembelian";
                    return (["user" => $target, "status" => $targetStatus]);
                    break;

                default:
                    break;
            }
        }
        public static function cekSudahApprove($nextUser,$drb)
        {
                $history = HistoryApproval::get()->where("ApprovedByID = {$nextUser} AND DraftRBID = $drb->ID")->count();
                if(empty($history)){
                    return false;
                }
                    return true;
        }

        public static function ApproveDrb($note,$drb,$approver)
        {
            $stop=false;
            while ($stop == false) {
               $target = self::getNextTarget($drb);
               $history = HistoryApproval::create();
                $history->Note = $note;
                $history->ApprovedByID =  $approver;
                $history->DraftRBID = $drb->ID;
                $history->Status = $target["status"];
                $history->write();
                $drb->StatusID = $target["status"];
                $drb->write();
               if (!self::cekSudahApprove($target["user"],$drb)) {
                $stop=true;
               }
            }
        }
    }
}

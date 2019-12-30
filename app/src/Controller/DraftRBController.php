<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;

class DraftRBController extends PageController {
	private static $allowed_actions = [
		"GetKepalaCabang",
		"saveMasterDRB",
		"listRb",
		"saveDetailDRB",
		"saveDetailFile",
		"forwardTo",
		"deleteDetail",
		"updateDetail",
		"loadDraft",
		"ApprovePage",
		"approve",
		"clearData",
	];

	private static $casting = [
		'renderOptionEditDetailJenis' => 'HTMLText',
		'renderOptionEditDetailSatuan' => 'HTMLText',
	];
	public function init() {
		parent::init();
        // $this->getStrukturDrb(22);
        // die;
		if (!UserController::cekSession()) {
			return $this->redirect(Director::absoluteBaseURL() . "user/login");
		}

	}

	public function index(HTTPRequest $request) {
		Requirements::themedCSS('custom');
		if (!UserController::cekSession()) {
			return $this->redirect(Director::absoluteBaseURL() . "user/login");
		} else {
			$kode = false;
			$dateNow = false;
			$Jenis = false;
			$Deadline = false;
			$Alasan = false;
			$Notes = false;
			$NomorProyek = false;
			$pegawaiJabatan = false;
			$kepalaCabang = false;
			$detail = new ArrayList();
			$oldData = new ArrayList();
			$cek = DraftRB::get()->where("PemohonID = '" . $_SESSION['user_id'] . "' AND ForwardToID = 0 AND StatusID = 0")->limit(1);
			if (!empty($cek->count())) {
				$cek = $cek->first();
				$kode = $cek->ID;
				$Jenis = $cek->Jenis;
				$Deadline = $this->dateFormat($cek->Deadline, "-", "/");
				$Alasan = $cek->Alasan;
				$Notes = $cek->Notes;
				$NomorProyek = $cek->NomorProyek;
				$pegawaiJabatan = $cek->PegawaiPerJabatanID;
				$kepalaCabang = PegawaiPerJabatan::get()->byID($pegawaiJabatan);
				$kepalaCabang = $kepalaCabang->Cabang()->Kacab()->Pegawai()->Nama;
				$detail = $cek->Detail();
			} else {
				// $drafRB = DraftRB::get()->sort("ID", "DESC")->limit(1);
				// if ($drafRB->count()) {
				// 	$kode = "DRB-" . $this->GenerateKode($drafRB->first()->Kode);
				// } else {
				// 	$kode = "DRB-00001";
				// }
                $drafRB = DraftRB::create();
                //$draftRB->StatusID=0;
                $kode = $drafRB->write();
			}
            $dateNow = date("d/m/Y");

			$oldData = DraftRB::get()->where("PemohonID = '" . $_SESSION['user_id'] . "' AND ForwardToID <> 0");
			$user = User::get()->byID($_SESSION['user_id']);
			$pemohon = $user->Pegawai()->Nama;
			$jabatan = $user->Pegawai()->Jabatans();
			if (count($detail) != 0) {
				foreach ($detail as $key) {
					$cobajenis = $key->Jenis()->ID;
					break;
				}
				// echo $cobajenis;
				$jenisBrng = JenisBarang::get()->byID($cobajenis);
			} else {
				$jenisBrng = JenisBarang::get();
			}
			$satuan = Satuan::get();
			$data = [
				"PageTitle" => "Draft RB",
				"kode" => $kode,
				"dateNow" => $dateNow,
				"pemohon" => $pemohon,
				"jabatan" => $jabatan,
				"jenisBrng" => $jenisBrng,
				"satuan" => $satuan,
				"jenis" => $Jenis,
				"deadline" => $Deadline,
				"alasan" => $Alasan,
				"note" => $Notes,
				"nomorProyek" => $NomorProyek,
				"pegawaiJabatan" => $pegawaiJabatan,
				"kepalaCabang" => $kepalaCabang,
				"detail" => $detail,
				"oldDraft" => $oldData,
				"mgeJS" => "draft-rb",
				"linkRefresh" => "clear-data",
			];
			return $this->customise($data)
				->renderWith(array(
					'DraftRBPage', 'Page',
				));
			return $this->redirect(Director::absoluteBaseURL());
		}
	}

	public function ApprovePage(HTTPRequest $request) {

		// $drb = DraftRB::get()->first();
		// $get = $this::getNextTarget($drb);
		// var_dump($get);
		// die;
		//===============================================
		$ID = $request->params()["ID"];
		Requirements::themedCSS('custom');
		if (!UserController::cekSession()) {
			return $this->redirect(Director::absoluteBaseURL() . "user/login");
		} else {
			$drb = DraftRB::get()->byID($ID);

		}
		$jabatan = PegawaiPerJabatan::get()->byID($drb->PegawaiPerJabatan()->ID);
		$kepalaCabang = $jabatan->Cabang()->Kacab()->Pegawai()->Nama;
		$jabatanPerCabang = $jabatan->Jabatan()->Nama . "/" . $jabatan->Cabang()->Nama;
		$pegawai = User::get()->where("ID <> {$_SESSION['user_id']}");
		$detail = $drb->Detail();
		$history =  new ArrayList();
		$historyApproval = HistoryApproval::get()->where("DraftRBID = {$drb->ID}");
        $historyForward = HistoryForwarding::get()->where("DraftRBID = {$drb->ID}");
		foreach ($historyApproval as $value) {
			$history->push([
				"Created"=>$this::FormatDate("d/m/Y H:i",$value->Created) ,
				"By"=>$value->ApprovedBy()->Pegawai()->Nama ."[".$this::getJabatanFromStatus($value->Status()->ID)."]",
				"Status"=>$value->Status()->Status,
				"Note"=>$value->Note]);
		}

		foreach ($historyForward as $value) {
			$history->push([
				"Created"=>$this::FormatDate("d/m/Y H:i",$value->Created) ,
				"By"=>$value->ForwardForm()->Pegawai()->Nama ."[Pengirim]",
				"Status"=>"Dikirim ke ".$value->ForwardTo()->Pegawai()->Nama,
				"Note"=>$value->Note]);
		}

		$history=$history->sort("Created","ASC");
		$isCan = $this->getApprover($drb);
        $approver = $drb->ApproveTo()->ID;
		$data = [
			"PageTitle" => "Approval Draft RB",
			"kode" => $drb->Kode,
			"dateNow" => $this->dateFormat($drb->Tgl, "-", "/"),
			"pemohon" => $drb->Pemohon()->Pegawai()->Nama,
			"jabatan" => $jabatanPerCabang,
			"jenis" => $drb->Jenis,
			"deadline" => $drb->Deadline,
			"alasan" => $drb->Alasan,
			"note" => $drb->Notes,
			"nomorProyek" => $drb->NomorProyek,
			"kepalaCabang" => $kepalaCabang,
			"detail" => $detail,
			"pegawai" => $pegawai,
			"status" => $drb->Status()->Status,
			"userNow" => $_SESSION['user_id'],
			"canApprove" => $isCan["canApprove"],
			"canForward" => $isCan["canForward"],
			"history" => $history,
            "ApproveTo" => $approver,
			"mgeJS" => "draft-rb",
		];
		return $this->customise($data)
			->renderWith(array(
				'DraftRBApprovePage', 'Page',
			));
		return $this->redirect(Director::absoluteBaseURL());
	}

	public function GenerateKode($param) {
		$arr = explode("-", $param);
		$count = $arr[1] + 1;
		while (strlen($count) < 5) {
			$count = "0" . $count;
		}
		return $count;
	}

	// public function GetKepalaCabang()
	// {
	//     $id = $_POST["id"];
	//     $kepalaCabang = PegawaiPerJabatan::get()->byID($id);
	//     echo json_encode($kepalaCabang->Cabang()->Kacab()->Pegawai()->Nama);
	// }
	public function saveMasterDRB() {
		$drb = DraftRB::get()->where("ID = '" . $_POST["nomor"] . "'")->limit(1)->first();
		// if (empty($drb->count())) {
		// 	$drb = DraftRB::create();
		// } else {
		// 	$drb = $drb->first();
		// }
		//$drb->Kode = $_POST["nomor"];
		$drb->Tgl = $this->dateFormat($_POST["tgl"], "/", "-");
		$drb->PemohonID = $_SESSION['user_id'];
		$drb->Jenis = $_POST["jenis"];
		$drb->Deadline = $_POST["tgl-butuh"];
		$drb->Alasan = $_POST["alasan"];
		$drb->Notes = $_POST["note"];
		$drb->NomorProyek = $_POST["nomor-proyek"];
		$drb->PegawaiPerJabatanID = $_POST["jabatan-cabang"];
		$drb->TglSubmit = date("Y/m/d");
		$drb->write();
	}

	public function saveDetailDRB() {
		$drb = DraftRB::get()->where("ID = '" . $_POST["nomor"] . "'")->limit(1);
		$drb = $drb->first();

		$detail = DraftRBDetail::create();
		$detail->Deskripsi = $_POST["deskripsi-kebutuhan"];
		$detail->Jumlah = $_POST["jumlah"];
		$detail->SatuanID = $_POST["satuan"];
		$detail->Supplier = $_POST["supplier-lokal"];
		$detail->Spesifikasi = $_POST["spesifikasi"];
		$detail->KodeInventaris = $_POST["kode-inventaris"];
		$detail->JenisID = $_POST["jenis-brg"];
		$detail->DraftRBID = $drb->ID;
		$id = $detail->write();
		echo json_encode($id);
	}

	public function saveDetailFile() {


		$upload = new Upload();
		$file = Penawaran::create();
		$upload->loadIntoFile($_FILES['file'], $file, 'File/');
		$file->DraftRBDetailID = $_POST["id"];
		$file->write();
	}

	public function forwardTo() {

        $drafRB = DraftRB::get()->where("Kode LIKE '%DRB%'")->sort("Kode", "DESC")->limit(1);
                if ($drafRB->count()) {
                 $kode = "DRB-" . $this->GenerateKode($drafRB->first()->Kode);
                } else {
                 $kode = "DRB-00001";
                }
		$cek = DraftRB::get()->byID($_POST["kode"]);
		$Cabang = PegawaiPerJabatan::get()->byID($cek->PegawaiPerJabatan()->ID);
		$kepalaCabang = $Cabang->Cabang()->Kacab()->ID;
        $asisten = $Cabang->Cabang()->Approver()->ID;
		$cek->ForwardToID = $kepalaCabang;
		$cek->ApproveToID = $kepalaCabang;
        $cek->AssistenApproveTo = $asisten;
		$cek->TglSubmit = date("Y/m/d");
		$cek->StatusID = 1;
        $cek->Created = date("Y/m/d H:i:s");
        $cek->Kode = $kode;
        $cek->Notes=$_POST["note"];
		$cek->write();

        if ($cek->ID) {
            echo json_encode(['status' => TRUE]);
        }else{
            echo json_encode(['status' => FALSE]);
        }
	}

	public function deleteDetail() {
		$detail = DraftRBDetail::get()->byID($_POST["id"]);
		$detail->delete();
	}

	public function renderOptionEditDetailJenis($ID, $JenisID) {
		$detail = DraftRBDetail::get()->byID($ID);
		$draftnya = DraftRB::get()->byID($detail->DraftRB()->ID);
		if (count($draftnya->Detail()) > 1) {
			$jenisBrng = JenisBarang::get()->byID($detail->Jenis()->ID);
		} else {
			$jenisBrng = JenisBarang::get();
		}
		$option = "<option>Pilih Jenis Barang</option>";
		foreach ($jenisBrng as $key) {
			if ($JenisID == $key->ID) {

				$option .= "<option selected value='{$key->ID}'>{$key->Nama}</option>";
			} else {
				$option .= "<option value='{$key->ID}'>{$key->Nama}</option>";
			}
		}
		return $option;
	}

	public function renderOptionEditDetailSatuan($ID) {
		$jenisBrng = Satuan::get();
		$option = "<option>Pilih Satuan</option>";
		foreach ($jenisBrng as $key) {
			if ($ID == $key->ID) {
				$option .= "<option selected value='{$key->ID}'>{$key->Kode}</option>";
			} else {
				$option .= "<option value='{$key->ID}'>{$key->Kode}</option>";
			}
		}
		return $option;
	}
	public function updateDetail() {
		$detail = DraftRBDetail::get()->byID($_POST['id']);
		if (isset($_POST["deskripsi-kebutuhan"]) && !empty($_POST["deskripsi-kebutuhan"])) {
			$detail->Deskripsi = $_POST["deskripsi-kebutuhan"];
			# code...
		}
		if (isset($_POST["jumlah"]) && !empty($_POST["jumlah"])) {
			# code...
			$detail->Jumlah = $_POST["jumlah"];

		}
		if (isset($_POST["supplier-lokal"]) && !empty($_POST["supplier-lokal"])) {
			# code...
			$detail->Supplier = $_POST["supplier-lokal"];

		}
		if (isset($_POST["spesifikasi"]) && !empty($_POST["spesifikasi"])) {
			$detail->Spesifikasi = $_POST["spesifikasi"];
			# code...
		}
		if (isset($_POST["kode-inventaris"]) && !empty($_POST["kode-inventaris"])) {
			$detail->KodeInventaris = $_POST["kode-inventaris"];
			# code...
		}
		if (isset($_POST["jenis-brg"]) && !empty($_POST["jenis-brg"])) {
			$detail->JenisID = $_POST["jenis-brg"];
			# code...
		}
		if (isset($_POST["satuan"]) && !empty($_POST["jenis-brg"])) {
			# code...
			$detail->SatuanID = $_POST["satuan"];

		}
		$id = $detail->write();
	}

	public function loadDraft() {
		$drafRB = DraftRB::get()->sort("ID", "DESC")->limit(1);
		$drb = DraftRB::get()->byID($_POST["id"]);
		$cek = DraftRB::get()->byID($_POST["idNow"]);

			$newDrb = $cek;
			foreach ($newDrb->Detail() as $key) {
				$key->delete();
			}
		$newDrb->Tgl = date("d/m/Y");
		$newDrb->PemohonID = $_SESSION['user_id'];
		$newDrb->JenisID = $drb->JenisID;
		$newDrb->Deadline = $drb->Deadline;
		$newDrb->Alasan = $drb->Alasan;
		$newDrb->Notes = $drb->Notes;
		$newDrb->NomorProyek = $drb->NomorProyek;
		$newDrb->PegawaiPerJabatanID = $drb->PegawaiPerJabatanID;

		$id = $newDrb->write();
		foreach ($drb->Detail() as $key) {
			$detail = DraftRBDetail::create();
			$detail->Deskripsi = $key->Deskripsi;
			$detail->Jumlah = $key->Jumlah;
			$detail->SatuanID = $key->SatuanID;
			$detail->Supplier = $key->Supplier;
			$detail->Spesifikasi = $key->Spesifikasi;
			$detail->KodeInventaris = $key->KodeInventaris;
			$detail->JenisID = $key->JenisID;
			$detail->DraftRBID = $id;
			$idDetail = $detail->write();

			// foreach ($key->Penawaran() as $key2) {
			//     DB::query("INSERT INTO penawaran (ID, DraftRBDetailID) VALUES ('{$key2->ID}','{$idDetail}')");
			//     DB::query("INSERT INTO penawaran_live (ID, DraftRBDetailID) VALUES ('{$key2->ID}','{$idDetail}')");
			// }
		}
	}

	public function approve() {
		$drb = DraftRB::get()->where("Kode = '" . $_POST["draft"] . "'")->limit(1)->first();
		switch ($_POST["respond"]) {
		case 'approve':
			self::ApproveDrb($_POST["note"], $drb, $_POST["from"]);
			break;
		case 'reject':
			self::rejectDRB($_POST["note"], $drb, $_POST["from"]);
			break;
		case 'forward':
			self::forwardDrb($_POST["note"], $drb, $_POST["from"], $_POST["forward"]);
			break;
		default:
			break;
		}

        echo json_encode(['status' => TRUE]);
	}
	public function clearData() {
		$drb = DraftRB::get()->where("ID = '" . $_POST["nomor"] . "'")->limit(1);
		if ($drb->count()) {
			$drb = $drb->first();
			$id = $drb->ID;
			$detail = DraftRBDetail::get()->where("DraftRBID = " . $id);
			foreach ($detail as $key) {
				$key->delete();
			}
			$drb->delete();
		}
	}

	// public function historynya($id){
	// 	$history1 = HistoryApproval::get()->where("DraftRBID = {$id}");
	// 	$history2 = HistoryForwading::get()->where("DraftRBID = {$id}")
	// }
}

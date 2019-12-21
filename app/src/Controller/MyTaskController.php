<?php
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

class MyTaskController extends PageController {
	private static $allowed_actions = ['TotalTask'];

	public function index(HTTPRequest $request) {
		if (!UserController::cekSession()) {
			return $this->redirect(Director::absoluteBaseURL() . "user/login");
		} else if (isset($_SESSION['user_id'])) {
			$idnya = $_SESSION['user_id'];
		}
		$show = new ArrayList();
		$show1 = new ArrayList();
		$show2 = new ArrayList();
		$show3 = new ArrayList();
		$temp = array();
		$temp1 = array();
		$temp2 = array();
		$temp3 = array();
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
		Requirements::themedCSS('custom');
		$draftrbnya = DraftRB::get()->where('ForwardToID = ' . $pegawainya->ID);
		$lpbnya = PO::get();
		$rb = RB::get();
		$jumlahrb = 0;
		$jumlahpo = 0;
		$jumlahdraft = 0;
		$jumlahlpb = 0;
		// print_r($rb);
		foreach ($rb as $key) {
			if ($key->DraftRB()->ForwardToID == $pegawainya->ID && $key->DraftRB()->Status()->ID != 11) {
				$temp1['Tgl'] = date('d/m/Y', strtotime($key->Tgl));
				$temp1['Kode'] = $key->Kode;
				$temp1['Deadline'] = date('d/m/Y', strtotime($key->DraftRB()->Deadline));
				$temp1['Atasan'] = $key->DraftRB()->PegawaiPerJabatan()->Jabatan()->Nama . " / " . $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Nama . " / " . $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;
				$temp1['Pemohon'] = $key->DraftRB()->Pemohon()->Pegawai()->Nama;
				$temp1['Jenis'] = $key->DraftRB()->Jenis;
				$detail = DraftRBDetail::get()->where('DraftRBID = ' . $key->DraftRB()->ID)->limit(1);
				foreach ($detail as $key1) {
					$temp1['JenisBarang'] = $key1->Jenis()->Nama;
					$temp1['Deskripsi'] = $key1->Deskripsi;
				}
				$temp1['Status'] = $key->DraftRB()->Status()->Status;
				$temp1['view_link'] = 'rb/ApprovePage/' . $key->ID;
				$show1->push($temp1);
				$jumlahrb++;
			}
			if ($key->DraftRB()->Status()->ID == 11 && $shownya == 1) {
				$temp2['ID'] = $key->ID;
				$temp2['Tgl'] = date('d/m/Y', strtotime($key->Tgl));
				$temp2['Kode'] = $key->Kode;
				$temp2['Deadline'] = date('d/m/Y', strtotime($key->DraftRB()->Deadline));
				$temp2['Atasan'] = $key->DraftRB()->PegawaiPerJabatan()->Jabatan()->Nama . " / " . $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Nama;
				$temp2['Pemohon'] = $key->DraftRB()->Pemohon()->Pegawai()->Nama;
				$temp2['Jenis'] = $key->DraftRB()->Jenis;
				$detail = DraftRBDetail::get()->where('DraftRBID = ' . $key->DraftRB()->ID)->limit(1);
				foreach ($detail as $key1) {
					$temp2['JenisBarang'] = $key1->Jenis()->Nama;
				}
				$detailnya = DetailRBPerSupplier::get()->where('RBID = ' . $key->ID);
				$temp2['isi'] = $key->GetSuplier($key->ID);
				$temp1['view_link'] = 'po/ApprovePage/' . $key->ID;
				$temp2['Status'] = $key->DraftRB()->Status()->Status;
				$show2->push($temp2);
				// echo "<pre>";
				// var_dump($temp2);
				// die;
				$jumlahpo++;
			}
		}
		foreach ($draftrbnya as $key) {
			if ($key->Status()->ID <= 6) {
				$temp['ID'] = $key->ID;
				$temp['Tgl'] = date('d/m/Y', strtotime($key->Tgl));
				$temp['Kode'] = $key->Kode;
				$temp['Deadline'] = date('d/m/Y', strtotime($key->Deadline));
				$temp['Atasan'] = $key->PegawaiPerJabatan()->Jabatan()->Nama . " / " . $key->PegawaiPerJabatan()->Cabang()->Nama . " / " . $key->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;
				$temp['Pemohon'] = $key->Pemohon()->Pegawai()->Nama;
				$temp['Jenis'] = $key->Jenis;
				$detail = DraftRBDetail::get()->where('DraftRBID = ' . $key->ID)->limit(1);
				foreach ($detail as $key1) {
					$temp['JenisBarang'] = $key1->Jenis()->Nama;
					$temp['Deskripsi'] = $key1->Deskripsi;
				}
				$temp['Status'] = $key->Status()->Status;
				$temp['view_link'] = 'draf-rb/ApprovePage/' . $key->ID;
				$temp['delete_link'] = $this->Link() . 'deletereqcost/' . $key->ID;
				$show->push($temp);
				$jumlahdraft++;
			}
		}
		foreach ($lpbnya as $key5) {
			if ($key5->DraftRB()->StatusID != 14 && $shownya == 1) {
				$temp3['ID'] = $key->ID;
				$temp3['KodePO'] = $key5->Kode;
				$temp3['KodeRB'] = $key5->RB()->Kode;
				$temp3['KodeDraftRB'] = $key5->DraftRB()->Kode;
				$temp3['Tgl'] = date('d/m/Y', strtotime($key5->Tgl));
				$temp3['Suplier'] = $key5->NamaSupplier;
				// $temp3['isi'] = $key5->GetPO($key->ID);
				$temp3['view_link'] = 'lpb/ApprovePage/' . $key5->ID;
				$show3->push($temp3);
				$jumlahlpb++;
			}
		}
		// echo "<pre>";
		// var_dump($config);
		// die();
		// $total = $this->TotalTask();
		// echo $pegawainya->ID;
		echo $shownya;
		$data = array(
			"draftrbnya" => $show,
			'shownya' => $shownya,
			'siteParent' => 'My Task',
			'PageTitle' => "My Task",
			'Title' => 'My Task',
			// 'total' => $total,
			'rbnya' => $show1,
			'ponya' => $show2,
			'lpbnya' => $show3,
			"jumlahdraft" => $jumlahdraft,
			'jumlahrb' => $jumlahrb,
			'jumlahpo' => $jumlahpo,
			'jumlahlpb' => $jumlahlpb,
			"mgeJS" => "task-my",
		);
		return $this->customise($data)
			->renderWith(array(
				'MyTask', 'Page',
			));
	}

	public function TotalTask() {
		$idnya = $_SESSION['user_id'];
		$pegawainya = User::get()->byID($idnya)->Pegawai();
		$config = SiteConfig::current_site_config();
		$jabatannya = $config->StafPencarianHargaID;
		$departemennya = $config->DepartemenPencairanHargaID;
		$jabatanpegawai = [];
		$departemenpegawai = [];
		$shownya = 0;
		foreach ($pegawainya->Jabatans() as $key) {
			$jabatanpegawai[] = $key->JabatanID;
			$departemenpegawai[] = $key->DepartemenID;
		}
		if (in_array(strtoupper($jabatannya), $jabatanpegawai) && in_array(strtoupper($departemennya), $departemenpegawai)) {
			$shownya = 1;
		}
		$draftrbnya = DraftRB::get()->where('ForwardToID = ' . $pegawainya->ID);
		$lpbnya = PO::get();
		$rb = RB::get();
		$jumlahrb = 0;
		$jumlahpo = 0;
		$jumlahdraft = 0;
		$jumlahlpb = 0;
		// print_r($rb);
		foreach ($rb as $key) {
			if ($key->DraftRB()->ForwardToID == $pegawainya->ID && $key->DraftRB()->Status()->ID != 11) {
				$jumlahrb++;
			}
			if ($key->DraftRB()->Status()->ID == 11 && $shownya == 1) {
				$jumlahpo++;
			}
		}
		foreach ($draftrbnya as $key) {
			if ($key->Status()->ID <= 6 && $shownya == 1) {
				$jumlahdraft++;
			}
		}
		foreach ($lpbnya as $key5) {
			if ($key5->DraftRB()->StatusID != 14 && $shownya == 1) {
				$jumlahlpb++;
			}
		}
		$totalnya = $jumlahdraft + $jumlahrb + $jumlahpo + $jumlahlpb;
		return $totalnya;
	}
}

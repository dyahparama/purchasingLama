<?php
	use SilverStripe\Assets\Upload;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\DB;


	class RejectedController extends PageController
	{
	    private static $allowed_actions = [
	        "rjme",
	        "rjteam",
    	];

	    public function index(HTTPRequest $request)
	    {
            Requirements::themedCSS('custom');
            if (!UserController::cekSession()) {
	            return $this->redirect(Director::absoluteBaseURL() . "user/login");
	        } else {
	           
	        }
            $data = array(
                "RB" => DraftRB::get()
            );
            return $this->customise($data)
                ->renderWith(array(
                    'MyTask', 'Page',
                ));
	    }

	    public function rjme(HTTPRequest $request)
	    {
	        Requirements::themedCSS('custom');
	        if (!UserController::cekSession()) {
	            return $this->redirect(Director::absoluteBaseURL() . "user/login");
	        } else {
	           $idnya = $_SESSION['user_id'];
	        }		
	        $show = new ArrayList();
	    	$show1 = new ArrayList();
			$temp = array();
	    	$temp1 = array();
	    	$jumlahrb=0;
	    	$jumlahdraft=0;
	    	$pegawainya = User::get()->byID($idnya)->Pegawai();
            Requirements::themedCSS('custom');
            $draftrbnya = DraftRB::get()->where('PemohonID = '.$pegawainya->ID.' AND StatusID = 14');
			$rb = rb::get();
	        foreach ($rb as $key) {
            	if($key->DraftRB()->PemohonID == $pegawainya->ID && $key->DraftRB()->Status()->ID == 14){
            		$temp1['Tgl'] = date('d/m/Y',strtotime($key->Tgl));
            		$temp1['Kode'] = $key->Kode;
            		$temp1['Deadline'] = date('d/m/Y',strtotime($key->DraftRB()->Deadline));
            		$temp1['Atasan'] = $key->DraftRB()->PegawaiPerJabatan()->Jabatan()->Nama ." / ". $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Nama ." / ". $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;
            		$temp1['Pemohon'] = $key->DraftRB()->Pemohon()->Pegawai()->Nama;
	            	$temp1['Jenis'] = $key->DraftRB()->Jenis;
	            	$detail = DraftRBDetail::get()->where('DraftRBID = '.$key->DraftRB()->ID)->limit(1);
	            	foreach ($detail as $key1) {
	            		$temp1['JenisBarang'] = $key1->Jenis()->Nama;
	            		$temp1['Deskripsi'] = $key1->Deskripsi;
	            	}
	            	$temp1['Status'] = $key->DraftRB()->Status()->Status;
	            	$temp1['view_link'] = 'rb/ApprovePage/'.$key->ID;
	            	$show1->push($temp1);
            		$jumlahrb++;
            	}
            }
            foreach ($draftrbnya as $key) {
            	$temp['ID'] = $key->ID;
            	$temp['Tgl'] = date('d/m/Y',strtotime($key->Tgl));
            	$temp['Kode'] = $key->Kode;
            	$temp['Deadline'] = date('d/m/Y',strtotime($key->Deadline));
            	$temp['Atasan'] = $key->PegawaiPerJabatan()->Jabatan()->Nama ." / ". $key->PegawaiPerJabatan()->Cabang()->Nama ." / ". $key->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;
            	$temp['Pemohon'] = $key->Pemohon()->Pegawai()->Nama;
            	$temp['Jenis'] = $key->Jenis;
            	$detail = DraftRBDetail::get()->where('DraftRBID = '.$key->ID)->limit(1);
            	foreach ($detail as $key1) {
            		$temp['JenisBarang'] = $key1->Jenis()->Nama;
            		$temp['Deskripsi'] = $key1->Deskripsi;
            	}
                $temp['Status'] = $key->Status()->Status;
            	$temp['view_link'] = 'draf-rb/ApprovePage/'.$key->ID;
				$temp['delete_link'] = $this->Link().'deletereqcost/'.$key->ID;
            	$show->push($temp);
                $jumlahdraft++;
            }
	        $data = array(
	        	"draftrbnya" => $show,
                'siteParent' => 'Reject',
                'siteChild' => 'Me Reject',
                'PageTitle' => "Reject",
                'Title' => 'Reject',
                'rbnya' => $show1,
				"jumlahdraft" => $jumlahdraft,
                'jumlahrb' => $jumlahrb,
				"mgeJS" =>"task-my"
	        );
	        return $this->customise($data)
	            ->renderWith(array(
	                'RejectedMe', 'Page',
	            ));
	        return $this->redirect(Director::absoluteBaseURL());
	    }

	    public function rjteam(HTTPRequest $request)
	    {
	         Requirements::themedCSS('custom');
	        if (!UserController::cekSession()) {
	            return $this->redirect(Director::absoluteBaseURL() . "user/login");
	        } else {
	           $idnya = $_SESSION['user_id'];
	        }		
	        $show = new ArrayList();
	    	$show1 = new ArrayList();
			$temp = array();
	    	$temp1 = array();
	    	$jumlahrb=0;
	    	$jumlahdraft=0;
	    	$pegawainya = User::get()->byID($idnya)->Pegawai();
	    	$jabatan = PegawaiPerJabatan::get()->
				where("PegawaiID = ".$pegawainya->ID);
			$teams = PegawaiPerJabatan::get()->where("CabangID = " . $jabatan->first()->CabangID . " AND DepartemenID = " . $jabatan->first()->DepartemenID);
			$teams_id = AddOn::groupConcat($teams, 'PegawaiID');
            Requirements::themedCSS('custom');
            $draftrbnya = DraftRB::get()->where('PemohonID IN(' . $teams_id . ') AND StatusID = 14');
			$rb = rb::get();
	        foreach ($rb as $key) {
            	if($key->DraftRB()->PemohonID == $pegawainya->ID && $key->DraftRB()->Status()->ID == 14){
            		$temp1['Tgl'] = date('d/m/Y',strtotime($key->Tgl));
            		$temp1['Kode'] = $key->Kode;
            		$temp1['Deadline'] = date('d/m/Y',strtotime($key->DraftRB()->Deadline));
            		$temp1['Atasan'] = $key->DraftRB()->PegawaiPerJabatan()->Jabatan()->Nama ." / ". $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Nama ." / ". $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;
            		$temp1['Pemohon'] = $key->DraftRB()->Pemohon()->Pegawai()->Nama;
	            	$temp1['Jenis'] = $key->DraftRB()->Jenis;
	            	$detail = DraftRBDetail::get()->where('DraftRBID = '.$key->DraftRB()->ID)->limit(1);
	            	foreach ($detail as $key1) {
	            		$temp1['JenisBarang'] = $key1->Jenis()->Nama;
	            		$temp1['Deskripsi'] = $key1->Deskripsi;
	            	}
	            	$temp1['Status'] = $key->DraftRB()->Status()->Status;
	            	$temp1['view_link'] = 'rb/ApprovePage/'.$key->ID;
	            	$show1->push($temp1);
            		$jumlahrb++;
            	}
            }
            foreach ($draftrbnya as $key) {
            	$temp['ID'] = $key->ID;
            	$temp['Tgl'] = date('d/m/Y',strtotime($key->Tgl));
            	$temp['Kode'] = $key->Kode;
            	$temp['Deadline'] = date('d/m/Y',strtotime($key->Deadline));
            	$temp['Atasan'] = $key->PegawaiPerJabatan()->Jabatan()->Nama ." / ". $key->PegawaiPerJabatan()->Cabang()->Nama ." / ". $key->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;
            	$temp['Pemohon'] = $key->Pemohon()->Pegawai()->Nama;
            	$temp['Jenis'] = $key->Jenis;
            	$detail = DraftRBDetail::get()->where('DraftRBID = '.$key->ID)->limit(1);
            	foreach ($detail as $key1) {
            		$temp['JenisBarang'] = $key1->Jenis()->Nama;
            		$temp['Deskripsi'] = $key1->Deskripsi;
            	}
                $temp['Status'] = $key->Status()->Status;
            	$temp['view_link'] = 'draf-rb/ApprovePage/'.$key->ID;
				$temp['delete_link'] = $this->Link().'deletereqcost/'.$key->ID;
            	$show->push($temp);
                $jumlahdraft++;
            }
	        $data = array(
	        	"draftrbnya" => $show,
                'siteParent' => 'Reject',
                'siteChild' => 'Me Reject',
                'PageTitle' => "Reject",
                'Title' => 'Reject',
                'rbnya' => $show1,
				"jumlahdraft" => $jumlahdraft,
                'jumlahrb' => $jumlahrb,
				"mgeJS" =>"task-my"
	        );
	        return $this->customise($data)
	            ->renderWith(array(
	                'RejectedTeam', 'Page',
	            ));
	        return $this->redirect(Director::absoluteBaseURL());
	    }
	   
	}

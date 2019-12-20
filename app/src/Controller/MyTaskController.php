<?php
	use SilverStripe\Assets\Upload;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\DB;


	class MyTaskController extends PageController
	{
	    private static $allowed_actions = ['TotalTask'];

	    public function index(HTTPRequest $request)
	    {
            if (!UserController::cekSession()) {
                return $this->redirect(Director::absoluteBaseURL() . "user/login");
            }
	    	else if(isset($_SESSION['user_id'])){
	    		$idnya = $_SESSION['user_id'];
	    	}
	    	$show = new ArrayList();
	    	$show1 = new ArrayList();
            $show2 = new ArrayList();
	    	$temp = array();
	    	$temp1 = array();
            $temp2 = array();
	    	$pegawainya = User::get()->byID($idnya)->Pegawai();
            Requirements::themedCSS('custom');
            $draftrbnya = DraftRB::get()->where('ForwardToID = '.$pegawainya->ID);
            $rb = RB::get();
            $jumlahrb=0;
            // print_r($rb);
            foreach ($rb as $key) {
            	if($key->DraftRB()->ForwardToID == $pegawainya->ID && $key->DraftRB()->Status()->ID != 11){
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
	            	$temp1['view_link'] = '../rb/ApprovePage/'.$key->ID;
	            	$show1->push($temp1);
            		$jumlahrb++;
            	}
            	if($key->DraftRB()->Status()->ID == 11){
                    $temp2['Tgl'] = date('d/m/Y',strtotime($key->Tgl));
                    $temp2['Kode'] = $key->Kode;
                    $temp2['Deadline'] = date('d/m/Y',strtotime($key->DraftRB()->Deadline));
                    $temp2['Atasan'] = $key->DraftRB()->PegawaiPerJabatan()->Jabatan()->Nama ." / ". $key->DraftRB()->PegawaiPerJabatan()->Cabang()->Nama;
                    $temp2['Pemohon'] = $key->DraftRB()->Pemohon()->Pegawai()->Nama;
                    $temp2['Jenis'] = $key->DraftRB()->Jenis;
                    $detail = DraftRBDetail::get()->where('DraftRBID = '.$key->DraftRB()->ID)->limit(1);
                    foreach ($detail as $key1) {
                        $temp2['JenisBarang'] = $key1->Jenis()->Nama;
                    }
                    $temp2['Status'] = $key->DraftRB()->Status()->Status;
                    $temp2['view_link'] = '../rb/ApprovePage/'.$key->ID;
                    $show2->push($temp2);
                }
            }
            // echo "<pre>".print_r($show2);
            // // var_dump($show2);
            // die();
            $jumlahdraft = count($draftrbnya);
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
            	$temp['view_link'] = '../draf-rb/ApprovePage/'.$key->ID;
				$temp['delete_link'] = $this->Link().'deletereqcost/'.$key->ID;
            	$show->push($temp);
            }
            $total = $this->TotalTask();
            // echo $pegawainya->ID;
            $data = array(
                "draftrbnya" => $show,
                'total' => $total,
                'rbnya' => $show1,
                'ponya' => $show2,
                "jumlahdraft" => $jumlahdraft,
                'jumlahrb' => $jumlahrb,
                "mgeJS" =>"task-my"
            );
            return $this->customise($data)
                ->renderWith(array(
                    'MyTask', 'Page',
                ));
	    }
	   
        public function TotalTask()
        {
            $idnya = $_SESSION['user_id'];
            $pegawainya = User::get()->byID($idnya)->Pegawai();
            $draftrbnya = DraftRB::get()->where('ForwardToID = '.$pegawainya->ID);
            $rb = RB::get();
            $jumlahrb=0;
            foreach ($rb as $key) {
                if($key->DraftRB()->ForwardToID == $pegawainya->ID){
                    $jumlahrb++;
                }
                else{
                    // echo "tidak";
                }
            }
            $jumlahdraft = count($draftrbnya);
            $totalnya = $jumlahdraft + $jumlahrb;
            return $totalnya;
        }
	}

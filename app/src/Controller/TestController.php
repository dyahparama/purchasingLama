<?php
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\Controller;
	use SilverStripe\Dev\Debug;
	use SilverStripe\ORM\DB;

	class TestController extends PageController
	{
	    private static $allowed_actions = ['getData', 'searchdrb', 'Tes'];

	    public function init()
	    {
	    	parent::init();
	    	if (!isset($_SESSION['user_id'])) {
	    		$_SESSION['error_login'] = "1";
	    		return $this->redirect('user/login');
	    	}
        }

        public function Tes() {
            var_dump(AddOn::createKode("PO", "PO"));
            // echo "Dididn tolol";
        }

	    public function index(HTTPRequest $request)
	    {
			$curStat = $request->param('ID');
			$data = [
	    		'cur_status' => $curStat,
	    		'user' => 'User',
	    		'Columns' => new ArrayList($this->getCustomColumns('drb')),
	    		'mgeJS' => 'list-drb',
				'siteParent'=>"Draft RB",
				'siteChild'=>$curStat,
				'linkNew'=>"draf-rb"
	    	];

	    	return $this->customise($data)
                ->renderWith(array(
                    'ListDRBPage', 'Page',
                ));
	    }

	    function getData(){
	    	$jenis = isset($_REQUEST['jenis']) ? $_REQUEST['jenis'] : '';
	    	$cur_status = isset($_REQUEST['cur_status']) ? $_REQUEST['cur_status'] : 'Me';
	    	$msg = [];
	    	$data = [];

	    	$user_logged_id = $_SESSION['user_id'];
			$user = User::get()->byID($user_logged_id);
			$pegawai = $user->Pegawai();

			$jabatan = PegawaiPerJabatan::get()->
				where("PegawaiID = ".$pegawai->ID);

			// iterate over jabatan
			$temp_teams_perjab = [];
			foreach ($jabatan as $jab) {
				// var_dump($jab);
				$temp_jab_userid = PegawaiPerJabatan::get()->where("JabatanID != " . $jab->ID . " AND CabangID = " . $jab->CabangID . " AND DepartemenID = " . $jab->DepartemenID);
				// $temp_jab_userid = PegawaiPerJabatan::get()->where("(JabatanID != " . $jab->ID . " AND Jabatan <> 0) AND CabangID = " . $jab->CabangID . " AND DepartemenID = " . $jab->DepartemenID);

				$jab = $temp_jab_userid->first()->Departemen()->Nama;
				$cab = $temp_jab_userid->first()->Cabang()->Nama;
				// echo ($jab . '/' . $cab). '</br>';

				$temp_teams_perjab[($jab . '/' . $cab)] =
					 $temp_jab_userid
				;
			}

			// get draft rb master
			$draft_rb = DraftRB::get();

	    	if (!empty($jenis)) {
	    		switch ($jenis) {
	    			case 'kddrb':
		    			$temp = $draft_rb->where("PemohonID = {$pegawai->ID}");

						if ($cur_status == "Teams") {
							$teams = PegawaiPerJabatan::get()->where("CabangID = " . $jabatan->first()->CabangID . " AND DepartemenID = " . $jabatan->first()->DepartemenID);

							$pegawai_id = AddOn::groupConcat($teams, 'Pegawai.User.ID');
							$temp = $draft_rb->where("PemohonID IN ($pegawai_id)");
						}

	    				$data = AddOn::getSpecColumn($temp->toNestedArray(), 'Kode');
	    				break;
	    			case 'cbg':
	    				$data = $jabatan->map('ID', 'PegawaiJabatan')->toArray();
	    				break;
    				case 'pemohon':
    					$temp = [
    						$user->ID => $jabatan->first()->Pegawai->Nama
    					];

    					if($cur_status == 'Teams'){
							$temp_teams = [];
							foreach ($temp_teams_perjab	as $key => $temp_jab) {
								$temp = [];
								// echo $key;
								// var_dump($temp_jab->Pegawai()->Nama);
								foreach ($temp_jab as $jab_inside) {
									$pegawai = $jab_inside->Pegawai();
									$user = User::get()->where("PegawaiID = {$pegawai->ID}")->first();
									$temp[$user->ID] = $pegawai->Nama;
								}

								$temp_teams[$key] = $temp;
							}

							$temp = $temp_teams;

							/*	var_dump($temp_teams);
							Debug::dump($temp_teams);
							die;*/
						}

    					$data = $temp;
	    				break;
    				case 'jbarang':
	    				$data = JenisBarang::get()->map('ID', 'Nama')->toArray();
	    				break;
    				case 'mstatus':
	    				$data = StatusPermintaanBarang::get()->map('ID', 'Status')->toArray();
	    				break;
	    			default:
	    				$data = 'Jenis tidak ada';
	    				break;
	    		}
	    		$msg = [
	    			'status' => TRUE,
	    			'msg' => $data
	    		];
	    	}else{
	    		$msg = [
	    			'status' => FALSE,
	    			'msg' => 'Jenis cannot be empty'
	    		];
	    	}

	    	echo json_encode($msg);
	    }

	    /**
		 * Setting column definition
		 */
		function getCustomColumns($config) {
			$columns = array();

			switch ($config) {
				case 'drb':
					$columns = array(
						array(
							'ColumnTb' => 'Tanggal',
							'ColumnDb' => 'Tgl',
							'Type' => 'Date',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Kode Draft RB',
							'ColumnDb' => 'Kode',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Tgl Deadline',
							'ColumnDb' => 'Deadline',
							'Type' => 'Date',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Jabatan/Cabang/Kepala Cabang',
							'ColumnDb' => 'jcabang',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Pemohon',
							'ColumnDb' => 'pemohon',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Jenis Permintaan',
							'ColumnDb' => 'Jenis',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Jenis Barang',
							'ColumnDb' => 'jbarang',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Deskripsi Kebutuhan',
							'ColumnDb' => 'deskripsi',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Status',
							'ColumnDb' => 'status',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Posisi Terakhir',
							'ColumnDb' => 'ForwardToID',
							'Type' => 'Int',
							'Required' => true
						)
					);
					break;
				default:
					# code...
					break;
			}

			return $columns;
		}

		public function Link($action = null)
		{
		    // Construct link with graceful handling of GET parameters
		    $link = Controller::join_links('list-drb', $action);

		    // Allow Versioned and other extension to update $link by reference.
		    $this->extend('updateLink', $link, $action);

		    return $link;
		}

		function searchdrb() {
		    // ============ filter bawaan datatable
			$pk = 'ID';

			$filter_record = (isset($_REQUEST['filter_record'])) ? $_REQUEST['filter_record'] : '';
	    	$cur_status = isset($_REQUEST['cur_status']) ? $_REQUEST['cur_status'] : 'Me';
			$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
			$length = (isset($_REQUEST['length'])) ? $_REQUEST['length'] : 10;
			$search = (isset($_REQUEST['search']['value'])) ? $_REQUEST['search']['value'] : '';
			$columnsort = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
			$typesort = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'DESC';
			$fieldsort = (isset($_REQUEST['columns'][$columnsort]['data']) && $_REQUEST['columns'][$columnsort]['data']) ? $_REQUEST['columns'][$columnsort]['data'] : 0;
		    // ============ end filter

		    // params
		    $user_logged_id = $_SESSION['user_id'];
			$user = User::get()->byID($user_logged_id);
			$pegawai = $user->Pegawai();

			$jabatan = PegawaiPerJabatan::get()->
				where("PegawaiID = ".$pegawai->ID);

		    // SETTING INI
			$columns = $this->getCustomColumns('drb');
			$params_array = [];
			parse_str($filter_record, $params_array);

			// unset every empty parameters
			if(!empty($params_array['Tgl']))
				$tgl = AddOn::convertDate($params_array['Tgl']);
			if(!empty($params_array['Jenis']))
				$jenis = $params_array['Jenis'];
			if(!empty($params_array['jbarang']))
				$jbarang = $params_array['jbarang'];
			if(!empty($params_array['deskripsi']))
                $deskripsi = $params_array['deskripsi'];
            if(!empty($params_array['Kode']))
				$kode = $params_array['Kode'];

			unset($params_array['Tgl']);
			unset($params_array['Jenis']);
			unset($params_array['jbarang']);
			unset($params_array['deskripsi']);
			unset($params_array['kode']);

			foreach ($params_array as $key => $value) {
				if(empty($params_array[$key]))
					unset($params_array[$key]);
			}

			$result = DraftRB::get()->where("StatusID <> 0");
			$count_all = DraftRB::get()->where("StatusID <> 0");
			switch ($cur_status) {
				case 'Me':
					$result = $result->where("PemohonID = ".$user_logged_id);
					$count_all = $result->where("PemohonID = ".$user_logged_id);
					break;
				case 'Teams':
					// $teams_id = DB::query("SELECT ");
					$teams = PegawaiPerJabatan::get()->where("CabangID = " . $jabatan->first()->CabangID . " AND DepartemenID = " . $jabatan->first()->DepartemenID);

					$teams_id = AddOn::groupConcat($teams, 'Pegawai.User.ID');

					$result = $result->where("PemohonID IN(" . $teams_id . ")");
					$count_all = $result->where("PemohonID IN(" . $teams_id . ")");
					break;
				default:
					# code...
					break;
			}

			// filtering data by user keyword
			// unset($params_array['pegawaipercab']);
			// unset($params_array['deskripsi']);

			$result = $result->filterAny($params_array);
			$count_all = $count_all->filterAny($params_array);

			if (!empty($tgl)) {
				$result = $result->where("Tgl <= '{$tgl}'");
				$count_all->where("Tgl <= '{$tgl}'");
			}
			if (!empty($jenis)) {
				$result = $result->where("Jenis = '{$jenis}'");
				$count_all = $count_all->where("Jenis = '{$jenis}'");
            }
            if (!empty($kode)) {
				$result = $result->where("Kode LIKE '%{$kode}%'");
				$count_all = $count_all->where("Kode LIKE '%{$kode}%'");
			}
			if (!empty($jbarang)) {
				$draft_rb_id = AddOn::groupConcat($result, 'ID');
				if ($draft_rb_id) {
					$sql = "SELECT DISTINCT GROUP_CONCAT(rb.ID) FROM draftrb rb
						LEFT OUTER JOIN draftrbdetail drb ON rb.ID = drb.DraftRBID
						WHERE rb.ID IN({$draft_rb_id}) AND drb.JenisID = {$jbarang}";

					// var_dump($sql);
					$draft_rb_detail = DB::query($sql)->value();
					if ($draft_rb_detail) {
						$result = $result->where("ID IN ({$draft_rb_detail})");
						$count_all = $result->where("ID IN ({$draft_rb_detail})");
					}else{
						$result = $result->where("ID IN (0)");
						$count_all = $result->where("ID IN (0)");
					}
				}else{
					$result = $result->where("ID IN (0)");
					$count_all = $result->where("ID IN (0)");
				}

			}
			if (!empty($deskripsi)) {
				$draft_rb_id = AddOn::groupConcat($result, 'ID');
				if ($draft_rb_id) {
					$sql = "SELECT DISTINCT GROUP_CONCAT(rb.ID) FROM draftrb rb
						LEFT OUTER JOIN draftrbdetail drb ON rb.ID = drb.DraftRBID
						WHERE rb.ID IN({$draft_rb_id}) AND drb.Deskripsi LIKE '%{$deskripsi}%'";

					// var_dump($sql);
					$draft_rb_detail = DB::query($sql)->value();
					if ($draft_rb_detail) {
						$result = $result->where("ID IN ({$draft_rb_detail})");
						$count_all = $result->where("ID IN ({$draft_rb_detail})");
					}else{
						$result = $result->where("ID IN (0)");
						$count_all = $result->where("ID IN (0)");
					}
				}else{
					$result = $result->where("ID IN (0)");
					$count_all = $result->where("ID IN (0)");
				}

			}

			// sorting
			$column_sorted = $columns[$fieldsort]['ColumnDb'];
			$result = $result->sort($column_sorted . ' ' . $typesort);
			if ($column_sorted == "pemohon") {
				$result = $result->sort(['Pemohon.Pegawai.Nama' => $typesort]);
			}
			if ($column_sorted == "jcabang") {
				$result = $result->sort(['PegawaiPerJabatan.Jabatan.Nama' => $typesort]);
			}
			if ($column_sorted == "status") {
				$result = $result->sort(['Status.Status' => $typesort]);
			}
			if ($column_sorted == "ForwardToID") {
				$result = $result->sort(['ForwardTo.Pegawai.Nama' => $typesort]);
			}
			// count all data (by filter otherwise)
			$count_all = $result->count();

			// limit offset
			$result = $result->limit($length, $start);

			$arr = array();
			foreach ($result as $row) {
				$temp = array();

				$idx = 0;

				$id = $row->{$pk};

				foreach ($columns as $col) {
					$drafrb_det = DraftRBDetail::get()->where("DraftRBID = ".$row->ID);

					if ($col['ColumnDb'] == 'jcabang') {
						$jab = $row->PegawaiPerJabatan()->Jabatan()->Nama;
						$cab = $row->PegawaiPerJabatan()->Cabang()->Nama;
						$kacab = $row->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;

						$temp[] = ($jab . "/" .$cab . "/" .$kacab);
					}elseif ($col['ColumnDb'] == 'pemohon') {
						$pemohon = $row->Pemohon()->Pegawai()->Nama;
						$temp[] = $pemohon;
					}elseif ($col['ColumnDb'] == 'jbarang') {
						$temp[] = AddOn::groupConcat($drafrb_det, 'Jenis.Nama');
					}elseif ($col['ColumnDb'] == 'deskripsi') {
						$temp[] = AddOn::groupConcat($drafrb_det, 'Deskripsi');
					}elseif ($col['ColumnDb'] == 'status') {
						$status = $row->Status()->Status;
						$temp[] = $status;
					}elseif ($col['ColumnDb'] == 'ForwardToID') {
						$ForwardTo = $row->ForwardTo()->Pegawai()->Nama;

						// if(!$ForwardTo){
		    //                 $last_pos = $this->getPosisiTerakhir($row);

		    //                 $ForwardTo = StatusPermintaanBarang::get()->byID($last_pos->StatusID + 1)->Status;
		    //             }

						$temp[] = $ForwardTo;
					}elseif($col['Type'] == 'Date')
						$temp[] = date('d-m-Y', strtotime($row->{$col['ColumnDb']}));
					else
						$temp[] = $row->{$col['ColumnDb']};

					$idx++;
				}


				$view_link = Director::absoluteBaseURL().'draf-rb/ApprovePage/'.$id;
				$delete_link = $this->Link().'deletereqcost/'.$id;

				$temp[] = '
				<div class="btn-group">
				  <a href="'.$view_link.'" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
				  <!--<a href="'.$delete_link.'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a>-->
				</div>
				';

				$arr[] = $temp;
			}

			// die;
			$result = array(
				'data' => $arr,
				'column_sort'=> $column_sorted,
				'params_arr' => $params_array,
				'recordsTotal' => $count_all,
				'recordsFiltered' => $count_all,
				'sql' => $result['sql']
			);
			return json_encode($result);
		}


	}

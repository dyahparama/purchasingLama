<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;
use Silverstripe\SiteConfig\SiteConfig;

class RBController extends PageController
{
    private static $allowed_actions = [
        'doSubmitRB',
        'getKodeSupplier',
        'listRBPage',
        'getData',
        'searchRb',
        'ApprovePage',
        'View'
    ];
    public function init() {
        parent::init();
        // $this->getStrukturDrb(22);
        // die;
        if (!UserController::cekSession()) {
            return $this->redirect(Director::absoluteBaseURL() . "user/login");
        }

    }
    public function ApprovePage(HTTPRequest $request)
    {
        if (isset($request->params()["ID"])) {
            $id = $request->params()["ID"];
            $rb = RB::get()->byID($id);
            if ($rb) {
                $mode = 1;
                if ($rb->DraftRB()->StatusID == 5) {
                    $mode = 1;
                }
                else if ($rb->DraftRB()->StatusID == 6 || $rb->DraftRB()->StatusID == 7 || $rb->DraftRB()->StatusID == 8) {
                    $mode = 2;
                }
                else {
                    $mode = 3;
                }

                $historyApproval = HistoryApproval::get()->where("DraftRBID = {$rb->DraftRBID}");
                $historyForward = HistoryForwarding::get()->where("DraftRBID = {$rb->DraftRBID}");

                $history =  new ArrayList();
                foreach ($historyApproval as $value) {
                    $history->push([
                        "Created"=>$this::FormatDate("d/m/Y H:i",$value->Created),
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

                $drb=$rb->DraftRB();
                $approver = $drb->ApproveTo()->ID;
                $data = array(
                    "SupplierList" => json_encode(AddOn::getOneField(Supplier::get(), "Nama")),
                    "RB" => $rb,
                    "DraftRB" => RB::get()->byID($id)->DraftRB(),
                    // "DetailRB" => DraftRBDetail::get()->where("DraftRBID = {}"),
                    "DetailRB" => RB::get()->byID($id)->DraftRB()->Detail(),
                    "penawaran"  => PenawaranSupplierDetail::get()->where("RBID = {$id}"),
                    "mgeJS" => "rb",
                    "SupplierNama" => Supplier::get(),
                    "New" => 1,
                    "mode" => $mode,
                    "history" => $history,
                    "pegawai" => User::get(),
                    "ApproveTo" => $approver,
                );
                return $this->customise($data)
                ->renderWith(array(
                    'RBPage', 'Page',
                ));
            } else {
                return $this->redirect(Director::absoluteBaseURL()."ta");
            }
        } else {
            return $this->redirect(Director::absoluteBaseURL()."ta");
        }
    }

    public function view(HTTPRequest $request) {
        //mode
        //1 = submit
        //2 = approve
        //3 = view
        if (isset($request->params()["ID"])) {
            $id = $request->params()["ID"];
            $rb = RB::get()->byID($id);
            // var_dump(HistoryApproval::get()->where("DraftRBID = {$rb->DraftRBID}"));die();
            if ($rb) {
                $mode = 1;
                if ($rb->DraftRB()->StatusID == 5) {
                    $mode = 1;
                }
                // if ($rb->DraftRB()->StatusID == 6 || $rb->DraftRB()->StatusID == 7) {
                //     $mode = 2;
                // }
                else {
                    $mode = 3;
                }
                $historyApproval = HistoryApproval::get()->where("DraftRBID = {$rb->DraftRBID}");
                $historyForward = HistoryForwarding::get()->where("DraftRBID = {$rb->DraftRBID}");

                $history =  new ArrayList();
                foreach ($historyApproval as $value) {
                    $history->push([
                        "Created"=>$this::FormatDate("H:i d/m/Y",$value->Created) ,
                        "By"=>$value->ApprovedBy()->Pegawai()->Nama ."[".$this::getJabatanFromStatus($value->Status()->ID)."]",
                        "Status"=>$value->Status()->Status,
                        "Note"=>$value->Note]);
                }

                foreach ($historyForward as $value) {
                    $history->push([
                        "Created"=>$this::FormatDate("H:i d/m/Y",$value->Created) ,
                        "By"=>$value->ForwardForm()->Pegawai()->Nama ."[Pengirim]",
                        "Status"=>"Dikirim ke ".$value->ForwardTo()->Pegawai()->Nama,
                        "Note"=>$value->Note]);
                }

                $history=$history->sort("Created","ASC");

                $data = array(
                    "SupplierList" => json_encode(AddOn::getOneField(Supplier::get(), "Nama")),
                    "RB" => $rb,
                    "DraftRB" => RB::get()->byID($id)->DraftRB(),
                    // "DetailRB" => DraftRBDetail::get()->where("DraftRBID = {}"),
                    "penawaran"  => PenawaranSupplierDetail::get()->where("RBID = {$id}"),
                    "DetailRB" => RB::get()->byID($id)->DraftRB()->Detail(),
                    "DetailPenawaran" => RB::get()->byID($id)->PenawaranSupplier(),
                    "mgeJS" => "rb",
                    "mode" => 3
                );
                return $this->customise($data)
                ->renderWith(array(
                    'RBPage', 'Page',
                ));
            } else {
                return $this->redirect(Director::absoluteBaseURL()."rb");
            }
        } else {
            return $this->redirect(Director::absoluteBaseURL()."rb");
        }
    }

    public function doSubmitRB()
    {
        var_dump($_POST);
        die;
        if (isset($_REQUEST['RBID']) && $_REQUEST['RBID'] != "") {
            $submitMode = $_REQUEST['SubmitMode'];
            $rbID = $_REQUEST['RBID'];
            $rb = RB::get()->byID($rbID);
            $detailDraftRB = $rb->DraftRB()->Detail();

            $note = "";
            if (isset($_REQUEST['note']) && $_REQUEST['note'] != "") {
                $note = $_REQUEST['note'];
            }

            $namaSupplier = $_REQUEST['nama_supplier'];
            $kodeSupplier = $_REQUEST['kode_supplier'];
            $jumlah = $_REQUEST['jumlah'];
            $harga = $_REQUEST['harga'];
            $total = AddOn::unformatNumber($_REQUEST['subtotal']);
            $keterangan = $_REQUEST['keterangan'];
            $tglRB = $_REQUEST["tgl-rb"];

            $namaBarang = $_REQUEST['nama_barang'];
            $sepesifikasiBarang = $_REQUEST['spesifikasi_barang'];
            $kodeInvetaris = $_REQUEST['inventaris_barang'];
            $jumlahDisetujui = $_REQUEST['jumlah_disetujui'];

            foreach ($namaBarang as $key => $value) {
                $draftRBDetail = DraftRBDetail::get()->byID($key);
                $draftRBDetail->NamaBarang = $namaBarang[$key];
                $draftRBDetail->JumlahDisetujui = AddOn::unformatNumber($jumlahDisetujui[$key]);
                $draftRBDetail->Spesifikasi = $sepesifikasiBarang[$key];
                $draftRBDetail->KodeInventaris = $kodeInvetaris[$key];
                $draftRBDetail->write();
            }

            $grandTotal = 0;

            $isTPS = false;

            if ($submitMode == 1) {
                $siteconfig = SiteConfig::current_site_config();

                foreach ($namaSupplier as $key => $val) {
                    foreach ($val as $key2 => $val2) {
                        $detailRBPerSupplier = new DetailRBPerSupplier();
                        $detailRBPerSupplier->NamaSupplier = $namaSupplier[$key][$key2];
                        $detailRBPerSupplier->KodeSupplier = $kodeSupplier[$key][$key2];
                        $detailRBPerSupplier->Jumlah = AddOn::unformatNumber($jumlah[$key][$key2]);
                        $detailRBPerSupplier->Harga = AddOn::unformatNumber($harga[$key][$key2]);
                        $detailRBPerSupplier->Total = AddOn::unformatNumber($total[$key][$key2]);
                        $detailRBPerSupplier->Keterangan = $keterangan[$key][$key2];
                        $detailRBPerSupplier->DraftRBDetailID = $key;
                        $detailRBPerSupplier->RBID = $rbID;

                        $detailRBPerSupplier->write();

                        if ($harga[$key][$key2] > (int) $siteconfig->NominalTPS) {
                            $isTPS = true;
                        }

                        $grandTotal += (float) AddOn::unformatNumber($total[$key][$key2]);
                    };
                };

                $rb->Tgl = AddOn::convertDateToDatabase($tglRB);
                $rb->Total = $grandTotal;
                $rb->Note = $note;
                $rb->write();

                $arquivo = array();
                $idTes = $_REQUEST['id_tes'];
                foreach ($idTes as $key => $value) {
                    if (isset($_FILES['penawaran_file_'.$value])) {
                     foreach ($_FILES['penawaran_file_'.$value]['name'] as $file=>$key) {
                        if (!empty($_FILES['penawaran_file_'.$value]["name"][$file])) {
                          $arquivo [$value][$file]["name"] = $_FILES['penawaran_file_'.$value]["name"][$file];
                          $arquivo [$value][$file]["type"] = $_FILES['penawaran_file_'.$value]["type"][$file];
                          $arquivo [$value][$file]["tmp_name"] = $_FILES['penawaran_file_'.$value]["tmp_name"][$file];
                          $arquivo [$value][$file]["error"] = $_FILES['penawaran_file_'.$value]["error"][$file];
                          $arquivo [$value][$file]["size"] = $_FILES['penawaran_file_'.$value]["size"][$file];
                      }
                  }
              }
          }

          $i = 0;
          $supplierList = $_REQUEST['supplier_id_penawaran'];
          foreach ($idTes as $key => $value) {
            $penawaranDetail = new PenawaranSupplierDetail();
            $penawaranDetail->SupplierID = $supplierList[$i];
            $penawaranDetail->RBID = $rbID;
            $penawaranDetail = $penawaranDetail->write();
            if ($arquivo) {
                foreach ($arquivo[$value] as $key2 => $value2) {
                    $upload = new Upload();
                    $file = PenawaranSupplier::create();
                    $upload->loadIntoFile($value2, $file, 'File/');
                    $file->PenawaranSupplierDetailID = $penawaranDetail;
                    $file->write();
                }
            }
            $i += 1;
        }

        PageController::submitStaffPembelian($rb->DraftRB(), $isTPS);
    } else if ($submitMode == 2) {
        $note = $_REQUEST['note'];
        $user_id = $_SESSION['user_id'];
        $respond = $_REQUEST['respond'];

        if ($respond == "approve") {
            PageController::ApproveRB($note, $rb, $user_id);
        } else if ($respond == "reject") {
            PageController::rejectDRB($note, $rb->DraftRB(), $user_id);
        } else if ($respond == "forward") {
            PageController::forwardDrb($note, $rb->DraftRB(), $user_id, $_REQUEST['user_forward']);
        }
    }
    return $this->redirect(Director::absoluteBaseURL()."ta");
}
}

public function index(HTTPRequest $request)
{
    $curStat = "Me";
    $data = [
        'cur_status' => $curStat,
        'user' => 'User',
        'Columns' => new ArrayList($this->getCustomColumns('rb')),
        'mgeJS' => 'list-rb',
        'url' => 'searchcosting',
        'siteParent' => "RB",
        'siteChild' => "RB " . $curStat,
    ];
    return $this->customise($data)
    ->renderWith(array(
        'ListRBPage', 'Page',
    ));
}

public function getCustomColumns($config)
{
    $columns = array();

    switch ($config) {
        case 'rb':
        $columns = array(
            array(
                'ColumnTb' => 'Tanggal',
                'ColumnDb' => 'Tgl',
                'Type' => 'Date',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Kode RB',
                'ColumnDb' => 'Kode',
                'Type' => 'Varchar',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Tgl Deadline',
                'ColumnDb' => 'Deadline',
                'Type' => 'Date',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Jabatan/Cabang/Kepala Cabang',
                'ColumnDb' => 'jcabang',
                'Type' => 'Varchar',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Pemohon',
                'ColumnDb' => 'pemohon',
                'Type' => 'Varchar',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Jenis Permintaan',
                'ColumnDb' => 'Jenis',
                'Type' => 'Varchar',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Jenis Barang',
                'ColumnDb' => 'jbarang',
                'Type' => 'Varchar',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Deskripsi Kebutuhan',
                'ColumnDb' => 'deskripsi',
                'Type' => 'Varchar',
                'Required' => true,
            ),
            array(
                'ColumnTb' => 'Status',
                'ColumnDb' => 'status',
                'Type' => 'Varchar',
                'Required' => true,
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

public function getKodeSupplier()
{
    if (isset($_REQUEST['nama']) && $_REQUEST['nama'] != "") {
        $nama = str_replace('%20', ' ', $_REQUEST['nama']);
        $kode = "";
        // var_dump($nama);
        $supplier = Supplier::get()->where("Nama LIKE '{$nama}'");
        if ($supplier) {
            $kode = $supplier->first()->Kode;
        }
        // var_dump($kode);
        return $kode;
    }
}



function getData()
{
    $jenis = isset($_REQUEST['jenis']) ? $_REQUEST['jenis'] : '';
    $cur_status = isset($_REQUEST['cur_status']) ? $_REQUEST['cur_status'] : 'Me';
    $msg = [];
    $data = [];

    $user_logged_id = $_SESSION['user_id'];
    $pegawai = User::get()->byID($user_logged_id);
    $jabatan = PegawaiPerJabatan::get()->where("PegawaiID = " . $pegawai->PegawaiID);

    if (!empty($jenis)) {
        switch ($jenis) {
            case 'kddrb':
            $data = AddOn::getSpecColumn(RB::get()->toNestedArray(), 'Kode');
            break;
            case 'cbg':
            $data = $jabatan->map('ID', 'PegawaiJabatan')->toArray();
            break;
            case 'pemohon':
            $temp = [
                $pegawai->ID => $jabatan->first()->Pegawai->Nama
            ];

            if ($cur_status == 'Teams') {
                $teams = PegawaiPerJabatan::get()->where("CabangID = " . $jabatan->first()->CabangID . " AND DepartemenID = " . $jabatan->first()->DepartemenID);
                foreach ($teams as $team) {
                    $temp[$team->Pegawai()->ID] = $team->Pegawai()->Nama;
                }
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
    } else {
        $msg = [
            'status' => FALSE,
            'msg' => 'Jenis cannot be empty'
        ];
    }

    echo json_encode($msg);
}

function searchRb()
{
    // echo  "Tolol";
        // ============ filter bawaan datatable
    $pk = 'ID';

    $filter_record = (isset($_REQUEST['filter_record'])) ? $_REQUEST['filter_record'] : '';
    $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
    $length = (isset($_REQUEST['length'])) ? $_REQUEST['length'] : 10;
    $search = (isset($_REQUEST['search']['value'])) ? $_REQUEST['search']['value'] : '';
    $columnsort = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
    $typesort = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'DESC';
    $fieldsort = (isset($_REQUEST['columns'][$columnsort]['data']) && $_REQUEST['columns'][$columnsort]['data']) ? $_REQUEST['columns'][$columnsort]['data'] : 0;
        // ============ end filter
        // SETTING INI
    $columns = $this->getCustomColumns('rb');
    $params_array = [];
    parse_str($filter_record, $params_array);

    $kode = (isset($params_array['kodeRb'])) ? $params_array['kodeRb'] : "";
    $status = (isset($params_array['statusid'])) ? $params_array['statusid'] : "";
    $jenis = (isset($params_array['jenisper'])) ? $params_array['jenisper'] : "";
    $pemohon = (isset($params_array['pemohonid'])) ? $params_array['pemohonid'] : "";
    $tgl = (isset($params_array['tgl'])) ? $params_array['tgl'] : "";
    $deskripsi = (isset($params_array['deskripsi'])) ? $params_array['deskripsi'] : "";
    $jbarang = (isset($params_array['jbarang'])) ? $params_array['jbarang'] : "";


    $result = DraftRB::get()->innerJoin("rb", "\"draftrb\".\"ID\" = \"rb\".\"draftrbID\"");
        // ->limit($length, $start)
        // ->sort($columns[$fieldsort]['ColumnDb'] . ' ' . $typesort);

        // count all data (by filter otherwise)
    if ($kode != "") {
        $result = $result->where("rb.Kode LIKE '%{$kode}%'");
    }
    if ($status != "") {
        $result = $result->where("StatusID = '{$status}'");
    }
    if ($jenis != "") {
        $result = $result->where("Jenis = '{$jenis}'");
    }
    // if ($pemohon != "") {
    //     $result = $result->where("PemohonID = '{$pemohon}'");
    // }
    if ($tgl != "") {
        $tgl = PageController::FormatDate("Y-m-d H:i:s", $tgl);
        $result = $result->where("TglSubmit = '{$pemohon}'");
    }
    if ($deskripsi != "") {
        $result = $result
        ->innerJoin("draftrbdetail", "\"draftrbdetail\".\"DraftRBID\" = \"rb\".\"ID\"")
        ->where("draftrbdetail.Deskripsi LIKE '%{$deskripsi}%'");
    }
    if ($jbarang != "") {
        $result = $result
        ->innerJoin("draftrbdetail", "\"draftrbdetail\".\"DraftRBID\" = \"rb\".\"ID\"")
        ->where("draftrbdetail.JenisID = '{$jbarang}'");
    }


    $column_sorted = $columns[$fieldsort]['ColumnDb'];
			$result = $result->sort($column_sorted . ' ' . $typesort);
			if ($column_sorted == "jcabang") {
				$result = $result->sort(['PegawaiPerJabatan.Jabatan.Nama' => $typesort]);
			}
			if ($column_sorted == "pemohon") {
				$result = $result->sort(['Pemohon.Pegawai.Nama' => $typesort]);
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
            # code...

        $temp = array();

        $idx = 0;

        $rb = RB::get()->where("DraftRBID=".$row->ID)->first();
        $id = $rb->ID;
        // echo "ID: ".$id."</br>";

        foreach ($columns as $col) {

            $drafrb_det = DraftRBDetail::get()->where("DraftRBID = " . $row->ID);

            if ($col['ColumnDb'] == 'jcabang') {
                $jab = $row->PegawaiPerJabatan()->Jabatan()->Nama;
                $cab = $row->PegawaiPerJabatan()->Cabang()->Nama;
                $kacab = $row->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;

                $temp[] = ($jab . "/" . $cab . "/" . $kacab);
            } elseif ($col['ColumnDb'] == 'pemohon') {
                $pemohon = $row->Pemohon()->Pegawai()->Nama;
                $temp[] = $pemohon;
            } elseif ($col['ColumnDb'] == 'jbarang') {
                $temp[] = AddOn::groupConcat($drafrb_det, 'Jenis.Nama');
            } elseif ($col['ColumnDb'] == 'deskripsi') {
                $temp[] = AddOn::groupConcat($drafrb_det, 'Deskripsi');
            } elseif ($col['ColumnDb'] == 'status') {
                $status = $row->Status()->Status;
                $temp[] = $status;
            } elseif ($col['Type'] == 'Date')
            $temp[] = date('d-m-Y', strtotime($row->{$col['ColumnDb']}));
            elseif ($col['ColumnDb'] == 'Kode') {
                $status = $rb->Kode;
                $temp[] = $status;
            } elseif ($col['ColumnDb'] == 'ForwardToID') {
                $ForwardTo = $row->ForwardTo()->Pegawai()->Nama;
                // if(!$ForwardTo){
                //     $last_pos = $this->getPosisiTerakhir($row);

                //     $ForwardTo = StatusPermintaanBarang::get()->byID($last_pos->StatusID + 1)->Status;
                // }

                /*echo $row->ID."</br>";
                echo $last_pos->ApprovedByID."</br>";*/

                // $ForwardTo = User::get()->byID($last_pos->ApprovedByID)->Pegawai()->Nama;
                $temp[] = $ForwardTo;
            }else
            $temp[] = $row->{$col['ColumnDb']};

            $idx++;
        }

        $view_link = Director::absoluteBaseURL().'rb/view/' . $id;
        $delete_link = $this->Link() . 'deletereqcost/' . $id;

        $temp[] = '
        <div class="btn-group">
        <a href="' . $view_link . '" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
        <!--<a href="' . $delete_link . '" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a>-->
        </div>
        ';

        $arr[] = $temp;
    }

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

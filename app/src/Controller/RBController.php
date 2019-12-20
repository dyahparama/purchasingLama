<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;

class RBController extends PageController
{
    private static $allowed_actions = [
        'doSubmitRB',
        'getKodeSupplier',
        'listRBPage',
        'getData',
        'searchRb',
        'ApprovePage'
    ];

    public function ApprovePage(HTTPRequest $request)
    {
        if (isset($request->params()["ID"])) {
            $id = $request->params()["ID"];
            $rb = RB::get()->byID($id);
            if ($rb) {
                $data = array(
                    "SupplierList" => json_encode(AddOn::getOneField(Supplier::get(), "Nama")),
                    "RB" => $rb,
                    "DraftRB" => RB::get()->byID($id)->DraftRB(),
                    // "DetailRB" => DraftRBDetail::get()->where("DraftRBID = {}"),
                    "DetailRB" => RB::get()->byID($id)->DraftRB()->Detail(),
                    "mgeJS" => "rb",
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
        if (isset($_REQUEST['RBID']) && $_REQUEST['RBID'] != "") {
            $rbID = $_REQUEST['RBID'];
            $rb = RB::get()->byID($rbID);
            $detailDraftRB = $rb->DraftRB()->Detail();

            $namaSupplier = $_REQUEST['nama_supplier'];
            $kodeSupplier = $_REQUEST['kode_supplier'];
            $jumlah = $_REQUEST['jumlah'];
            $harga = $_REQUEST['harga'];
            $total = $_REQUEST['subtotal'];
            $keterangan = $_REQUEST['keterangan'];

            $grandTotal = 0;

            foreach ($namaSupplier as $key => $val) {
                foreach ($val as $key2 => $val2) {
                    $detailRBPerSupplier = new DetailRBPerSupplier();
                    $detailRBPerSupplier->NamaSupplier = $namaSupplier[$key][$key2];
                    $detailRBPerSupplier->KodeSupplier = $kodeSupplier[$key][$key2];
                    $detailRBPerSupplier->Jumlah = $jumlah[$key][$key2];
                    $detailRBPerSupplier->Harga = $harga[$key][$key2];
                    $detailRBPerSupplier->Total = $total[$key][$key2];
                    $detailRBPerSupplier->Keterangan = $keterangan[$key][$key2];
                    $detailRBPerSupplier->DraftRBDetailID = $key;
                    $detailRBPerSupplier->RBID = $rbID;

                    $detailRBPerSupplier->write();

                    $grandTotal += (float) $total[$key][$key2];
                };
            };

            $rb->Tgl = AddOn::convertDateToDatabase($_REQUEST['tgl-rb']);
            $rb->Total = $grandTotal;
            $rb->write();
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
            $nama = $_REQUEST['nama'];
            $kode = "";
            $supplier = Supplier::get()->where("Nama LIKE '{$nama}'");
            if ($supplier) {
                $kode = $supplier->first()->Kode;
            }
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
                    $data = AddOn::getSpecColumn(DraftRB::get()->toNestedArray(), 'Kode');
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

        $result = DraftRB::get()->innerJoin("rb", "\"draftrb\".\"ID\" = \"rb\".\"draftrbID\"");
        // ->limit($length, $start)
        // ->sort($columns[$fieldsort]['ColumnDb'] . ' ' . $typesort);

        // count all data (by filter otherwise)
        $count_all = $result->count();

        $arr = array();

        foreach ($result as $row) {
            # code...

            $temp = array();

            $idx = 0;

            $id = $row->RB()->ID;

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
                    $status = $row->RB()->Kode;
                    $temp[] = $status;
                } else
                    $temp[] = $row->{$col['ColumnDb']};

                $idx++;
            }

            $view_link = '/rb/ApprovePage/' . $id;
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
            'params_arr' => $params_array,
            'recordsTotal' => $count_all,
            'recordsFiltered' => $count_all,
            'sql' => $result['sql']
        );
        return json_encode($result);
    }
}

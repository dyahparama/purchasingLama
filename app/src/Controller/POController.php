<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;


class POController extends PageController
{
    private static $allowed_actions = [
        "doPostPO", "getDetailRB",'PoList','getData','searchdrb'
    ];

    public function index(HTTPRequest $request) {
        Requirements::themedCSS('custom');
        // $data = array(
        //     "RB" => DraftRB::get(),
        //     "Supplier" => Supplier::get(),
        //     "JenisBarang" => JenisBarang::get(),
        //     "Satuan" => Satuan::get(),
        //     "mgeJS" =>"po"
        // );
        // return $this->customise($data)
        //         ->renderWith(array(
        //             'POPage', 'Page',
        //         ));
        if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != "") {
            $id = $_REQUEST['id'];
            $nama = $_REQUEST['nama'];
            $detail = DetailRBPerSupplier::get()->byID($id);
            // $supplierID =
            $data = array(
                "RB" => RB::get()->byID($id),
                "Detail" => DetailRBPerSupplier::get()->where("RBID = {$id} AND NamaSupplier = '{$nama}'"),
                "mgeJS" => "po",
                "NamaSupplier" => $nama
            );
            return $this->customise($data)
                ->renderWith(array(
                    'POPage', 'Page',
                ));
        }
    }

    public function doPostPO() {
        foreach ($_REQUEST['diskon'] as $val) {
            var_dump($val);
        }
    }

    public function getDetailRB() {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
            $id = $_REQUEST['id'];
            $data = DraftRBDetail::get()->where("DraftRBID = {$id}");
            return json_encode(AddOn::groupBySum($data, "JenisID", array("Jumlah"), array("Jenis.Nama")));
        }
    }

    public function PoList()
    {
        $curStat = "Me";
            $data = [
                'cur_status' => $curStat,
                'user' => 'User',
                'Columns' => new ArrayList($this->getCustomColumns('drb')),
                'mgeJS' => 'list-rb',
                'url'  => 'searchcosting',
                'siteParent'=>"PO",
                'siteChild'=>$curStat,
                'linkNew'=>"/draf-rb"
            ];

            return $this->customise($data)
                ->renderWith(array(
                    'ListPO', 'Page',
                ));
    }

    function getCustomColumns($config) {
            $columns = array();

            switch ($config) {
                case 'drb':
                    $columns = array(
                        array(
                            'ColumnTb' => 'Kode PO',
                            'ColumnDb' => 'Kode',
                            'Type' => 'Varchar',
                            'Required' => true
                        ),
                        array(
                            'ColumnTb' => 'Kode RB',
                            'ColumnDb' => 'Kode',
                            'Type' => 'Varchar',
                            'Required' => true
                        ),
                        array(
                            'ColumnTb' => 'Kode Draft RB',
                            'ColumnDb' => 'Kode',
                            'Type' => 'Varchar',
                            'Required' => true
                        ),
                        array(
                            'ColumnTb' => 'Tgl PO',
                            'ColumnDb' => 'Tgl',
                            'Type' => 'Date',
                            'Required' => true
                        ),
                        array(
                            'ColumnTb' => 'Tgl Deadline',
                            'ColumnDb' => 'Deadline',
                            'Type' => 'Date',
                            'Required' => true
                        ),
                        array(
                            'ColumnTb' => 'Jabatan/Cabang',
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
                        )
                    );
                    break;
                default:
                    # code...
                    break;
            }

            return $columns;
        }
        function getData(){
            $jenis = isset($_REQUEST['jenis']) ? $_REQUEST['jenis'] : '';
            $cur_status = isset($_REQUEST['cur_status']) ? $_REQUEST['cur_status'] : 'Me';
            $msg = [];
            $data = [];

            $user_logged_id = $_SESSION['user_id'];
            $pegawai = User::get()->byID($user_logged_id);
            $jabatan = PegawaiPerJabatan::get()->
                where("PegawaiID = ".$pegawai->PegawaiID);

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

                        if($cur_status == 'Teams'){
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
            }else{
                $msg = [
                    'status' => FALSE,
                    'msg' => 'Jenis cannot be empty'
                ];
            }

            echo json_encode($msg);
        }

        function searchdrb() {
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
            $columns = $this->getCustomColumns('drb');
            $params_array = [];
            parse_str($filter_record, $params_array);

            $result = DraftRB::get();
                // ->limit($length, $start)
                // ->sort($columns[$fieldsort]['ColumnDb'] . ' ' . $typesort);

            // count all data (by filter otherwise)
            $count_all = DraftRB::get()->count();

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
                    }elseif($col['Type'] == 'Date')
                        $temp[] = date('d-m-Y', strtotime($row->{$col['ColumnDb']}));
                    else
                        $temp[] = $row->{$col['ColumnDb']};

                    $idx++;
                }


                $view_link = $this->Link().'view/'.$id;
                $delete_link = $this->Link().'deletereqcost/'.$id;

                $temp[] = '
                <div class="btn-group">
                  <a href="'.$view_link.'" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
                  <a href="'.$delete_link.'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a>
                </div>
                ';

                $arr[] = $temp;
            }

            // die;
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

<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;
use SilverStripe\Control\Controller;
use Mpdf\Mpdf;


class POController extends PageController
{
    private static $allowed_actions = [
        "doPostPO", "getDetailRB", 'PoList', 'getData', 'searchdrb', 'ApprovePage', 'view','printPO'
    ];

    public function printPO(HTTPRequest $request){
        $id = $request->params()["ID"];
        $PO = PO::get()->byID($id);
        $detailPO = $PO->Detail();
        $termin = $PO->Termin();

        $data=[
            "NamaPerusahaan"=>"Purchase",
            "PO" => $PO,
            "Detail" => $detailPO,
            "Termin"=>$termin
        ];
        echo( $this->customise($data)->renderWith('PrintPDF'));
        // die;
        
        // $mpdf = new Mpdf();
        // $mpdf->WriteHTML($this->customise($data)->renderWith('PrintPDF'));
        // $mpdf->Output();
    }
    public function ApprovePage(HTTPRequest $request)
    {
        if (isset($request->params()["ID"])) {
            $id = $request->params()["ID"];
            $nama = $request->params()['Name'];
            $nama = urldecode($nama);
            // var_dump($nama);
            $rb = RB::get()->byID($id);
            if ($rb) {
                $detail = DetailRBPerSupplier::get()->where("RBID = {$id} AND NamaSupplier = '{$nama}'");

                $total = 0;
                foreach ($detail as $val) {
                    $total += $val->Total;
                }
                // $supplierID =
                $data = array(
                    "RB" => RB::get()->byID($id),
                    "Detail" => $detail,
                    "mgeJS" => "po",
                    "NamaSupplier" => $nama,
                    "Terima" => User::get(),
                    "Total" => $total
                );
                return $this->customise($data)
                    ->renderWith(array(
                        'POPage', 'Page',
                    ));
            } else {
                return $this->redirect(Director::absoluteBaseURL() . "po");
            }
        } else {
            return $this->redirect(Director::absoluteBaseURL() . "po");
        }
    }

    public function view(HTTPRequest $request) {
 if (isset($request->params()["ID"])) {
            $id = $request->params()["ID"];
            // $nama = $request->params()['Name'];
            // $nama = urldecode($nama);
            // var_dump($nama);
            $PO = PO::get()->byID($id);
            $detailPO = $PO->Detail();
            $termin = $PO->Termin();

        $data = array(
            "PO" => $PO,
            "Detail" => $detailPO,
            "Termin"=>$termin
                );
        return $this->customise($data)
                    ->renderWith(array(
                        'POViewPage', 'Page',
                    ));
                     } else {
            return $this->redirect(Director::absoluteBaseURL() . "po");
        }
    }

    public function index(HTTPRequest $request)
    {
        Requirements::themedCSS('custom');
        // $data = array(
        //     "RB" => RB::get(),
        //     "DraftRB" => DraftRB::get(),
        //     "Supplier" => Supplier::get(),
        //     "JenisBarang" => JenisBarang::get(),
        //     "Satuan" => Satuan::get(),
        //     "Terima" => User::get(),
        //     "mgeJS" =>"po"
        // );
        // return $this->customise($data)
        //         ->renderWith(array(
        //             'POPage', 'Page',
        //         ));
        // if (isset($_REQUEST['id']) &&  $_REQUEST['id'] != "") {

        // }
    }

    public function doPostPO()
    {
        if (isset($_REQUEST['tgl-po']) && $_REQUEST['tgl-po'] != "") {
            $note = "";

            if (isset($_REQUEST['note']) && $_REQUEST['note'] != "")
                $note = $_REQUEST['note'];

            $draftRBID = $_REQUEST['DraftRB_ID'];
            $RBID = $_REQUEST['RB_ID'];

            // var_dump($draftRBID);die;

            $tgl = $_REQUEST['tgl-po'];
            $drb = DraftRB::get()->byID($draftRBID);
            // var_dump($_REQUEST['TerimaLPBID']);die;
            $drb->StatusID = 10;
            $drb->write();
            $po = new PO();
            $po->Tgl = AddOn::convertDateToDatabase($tgl);
            $po->Total = $_REQUEST['total-akhir-po'];
            $po->DraftRBID = $draftRBID;
            $po->RBID = $RBID;
            $po->TerimaLPBID = $_REQUEST['TerimaLPBID'];
            $po->NamaSupplier = $_REQUEST['nama-supplier'];
            $po->Alamat = $_REQUEST['alamat'];
            $po->Tgl = AddOn::convertDateToDatabase($tgl);
            $po->Note = $note;
            $po->Nama = $_REQUEST['nama_deliver'];
            $po->Alamat = $_REQUEST['alamat'];
            $po->Kontak = $_REQUEST['kontak'];
            $po->SuratJalan = $_REQUEST['surat_jalan'];
            $idPO = $po->write();

            $jenisBarang = $_REQUEST['jenis_barangid'];
            $namaBarang = $_REQUEST['nama_barang'];
            $jumlah = $_REQUEST['jumlah'];
            $satuan = $_REQUEST['satuanid'];
            $harga = $_REQUEST['harga'];
            $subtotal = $_REQUEST['subtotal'];
            $parentid = $_REQUEST['parentid'];

            foreach ($jenisBarang as $key => $val) {
                $poDetail = new PODetail();

                $poDetail->JenisID = $jenisBarang[$key];
                $poDetail->NamaBarang = $namaBarang[$key];
                $poDetail->Jumlah = $jumlah[$key];
                $poDetail->SatuanID = $satuan[$key];
                $poDetail->Harga = $harga[$key];
                $poDetail->Total = $subtotal[$key];
                $poDetail->POID = $idPO;
                $poDetail->DetailPerSupplierID = $parentid[$key];

                $poDetail->write();

                $detail3 = DetailRBPerSupplier::get()->byID($parentid[$key]);
                $detail3->IsPo = 1;
                $detail3->write();
            }

            $tgl = $_REQUEST['tgl-termin'];
            $jenis = $_REQUEST['jenis-termin'];
            $keterangan = $_REQUEST['keterangan-termin'];
            $total = $_REQUEST['total-termin'];

            foreach ($tgl as $key => $val) {
                $poTermin = new POTerminDetail();

                $poTermin->Tanggal = $tgl[$key];
                $poTermin->Jenis = $jenis[$key];
                $poTermin->Keterangan = $keterangan[$key];
                $poTermin->Jumlah = $total[$key];
                $poTermin->POID = $idPO;

                $poTermin->write();
            }

            return $this->redirect(Director::absoluteBaseURL() . "po/PoList");
        }
    }

    public function getDetailRB()
    {
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
            'mgeJS' => 'po',
            'url'  => 'searchcosting',
            'siteParent' => "PO",
            'siteChild' => $curStat,
            'linkNew' => "/draf-rb"
        ];

        return $this->customise($data)
            ->renderWith(array(
                'ListPO', 'Page',
            ));
    }

    function getCustomColumns($config)
    {
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
                        'ColumnDb' => 'KodeRB',
                        'Type' => 'Varchar',
                        'Required' => true
                    ),
                    array(
                        'ColumnTb' => 'Kode Draft RB',
                        'ColumnDb' => 'KodeDRB',
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
                case 'KodeDRB':
                    $data = AddOn::getSpecColumn(DraftRB::get()->toNestedArray(), 'Kode');
                    break;
                case 'KodeRB':
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

    function searchdrb()
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
        $columns = $this->getCustomColumns('drb');
        $params_array = [];
        parse_str($filter_record, $params_array);

        $result = PO::get();
        // ->limit($length, $start)
        // ->sort($columns[$fieldsort]['ColumnDb'] . ' ' . $typesort);

        // count all data (by filter otherwise)
        $count_all = PO::get()->count();

        $arr = array();
        foreach ($result as $row) {
            if($row->DraftRB()->StatusID !=13){
                $temp = array();

                $idx = 0;

                $id = $row->{$pk};

                foreach ($columns as $col) {
                    $drafrb_det = DraftRBDetail::get()->where("DraftRBID = " . $row->DraftRB()->ID);

                    if ($col['ColumnDb'] == 'jcabang') {
                        $jab = $row->DraftRB()->PegawaiPerJabatan()->Jabatan()->Nama;
                        $cab = $row->DraftRB()->PegawaiPerJabatan()->Cabang()->Nama;
                        $kacab = $row->DraftRB()->PegawaiPerJabatan()->Cabang()->Kacab()->Pegawai()->Nama;

                        $temp[] = ($jab . "/" . $cab . "/" . $kacab);
                    } elseif ($col['ColumnDb'] == 'pemohon') {
                        $pemohon = $row->DraftRB()->Pemohon()->Pegawai()->Nama;
                        $temp[] = $pemohon;
                    } elseif ($col['ColumnDb'] == 'jbarang') {
                        $temp[] = AddOn::groupConcat($drafrb_det, 'Jenis.Nama');
                    } elseif ($col['ColumnDb'] == 'status') {
                        $status = $row->DraftRB()->Status()->Status;
                        $temp[] = $status;
                    } elseif ($col['ColumnDb'] == 'Jenis') {
                        $status = $row->DraftRB()->Jenis;
                        $temp[] = $status;
                    } elseif ($col['ColumnDb'] == 'KodeDRB') {
                        $status = $row->DraftRB()->Kode;
                        $temp[] = $status;
                    } elseif ($col['ColumnDb'] == 'Kode') {
                        $status = $row->Kode;
                        $temp[] = $status;
                    } elseif ($col['ColumnDb'] == 'KodeRB') {
                        $status = $row->RB()->Kode;
                        $temp[] = $status;
                    } elseif ($col['Type'] == 'Date')
                        $temp[] = date('d-m-Y', strtotime($row->{$col['ColumnDb']}));
                    else
                        $temp[] = $row->{$col['ColumnDb']};

                    $idx++;
                }


                $view_link =  'view/' . $id;
                $delete_link = 'deletereqcost/' . $id;

                $temp[] = '
                    <div class="btn-group">
                      <a href="' . $view_link . '" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
                      <a href="' . $delete_link . '" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a>
                    </div>
                    ';

                $arr[] = $temp;
            }
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

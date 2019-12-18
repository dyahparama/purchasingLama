<?php
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\View\Requirements;

	class TestController extends PageController
	{
	    private static $allowed_actions = ['getData'];

	    public function index(HTTPRequest $request)
	    {
            // echo "<pre>";
            // var_dump(ModelData::TableHeader(array('Nama', 'Tes')));die;
	    	$data = [
	    		'user' => 'User',
                'url'  => 'searchcosting',
                'TitleColumn' => ModelData::TableHeader(array('Nama', 'Approver')),
                'Data' => ModelData::TableData(StrukturCabang::get(), array('Nama', 'Approver.Pegawai.Nama'))
	    	];

	    	return $this->customise($data)
                ->renderWith(array(
                    'ListRBPage', 'Page',
                ));
	    }

	    function getData(){
	    	$jenis = isset($_REQUEST['jenis']) ? $_REQUEST['jenis'] : '';
	    	$msg = [];

	    	if (!empty($jenis)) {
	    		switch ($jenis) {
	    			case 'kddrb':
	    				$msg = DraftRB::get()->toNestedArray();
	    				break;
	    			case 'kddrb':
	    				$msg = DraftRB::get()->toNestedArray();
	    				break;
	    			default:
	    				# code...
	    				break;
	    		}
	    	}

	    	return $msg;
	    }

	    /**
		 * Setting column definition
		 */
		function getCustomColumns($config) {
			$columns = array();

			switch ($config) {
				case 'costing':
					$columns = array(
						array(
							'ColumnTb' => 'No. Permintaan Costing',
							'ColumnDb' => 'buktitreqcosting',
							'Type' => 'Number',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Tgl Costing',
							'ColumnDb' => 'tgltreqcosting',
							'Type' => 'Date',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Customer',
							'ColumnDb' => 'nmmcust',
							'Type' => 'Varchar',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Jumlah Produk',
							'ColumnDb' => 'jmlproduk',
							'Type' => 'Number',
							'Required' => true
						),
						array(
							'ColumnTb' => 'Keterangan',
							'ColumnDb' => 'keterangan',
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

		function searchcosting() {
		    // ============ filter bawaan datatable
			$pk = 'idtreqcosting';
			$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
			$length = (isset($_REQUEST['length'])) ? $_REQUEST['length'] : 10;
			$search = (isset($_REQUEST['search']['value'])) ? $_REQUEST['search']['value'] : '';
			$columnsort = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
			$typesort = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'DESC';
			$fieldsort = (isset($_REQUEST['columns'][$columnsort]['data']) && $_REQUEST['columns'][$columnsort]['data']) ? $_REQUEST['columns'][$columnsort]['data'] : 0;
		    // ============ end filter

		    // SETTING INI
			$columns = $this->getCustomColumns('costing');
			// Tampilkan semua data tanpa where

			$result = CostingModel::getcosting($start, $length, $columns[$fieldsort]['ColumnDb'], $typesort);

			$count_all = CostingModel::count_costing();
			// Tampilkan data dengan filter
			if ($search){
				$result = CostingModel::getcosting($start, $length, $columns[$fieldsort]['ColumnDb'], $typesort, $search);
				$count_all = CostingModel::count_costing($search);
			}

			$arr = array();
			foreach ($result['listData'] as $row) {
				$temp = array();

				$idx = 0;
				foreach ($columns as $col) {
					if ($col['Type'] == 'Date'){
						$temp[] = $this->getDateFormat($row->$col['ColumnDb']);
					}
					elseif ($idx == 3)
						$temp[] = $row->$col['ColumnDb']." produk";
					else
						$temp[] = $row->$col['ColumnDb'];

					$idx++;
				}

				$id = $row->$pk;

				$view_link = $this->Link().'viewreqcost/'.$id;
				$edit_link = $this->Link().'editreqcost/'.$id;
				$delete_link = $this->Link().'deletereqcost/'.$id;
/*
				$temp[] = '<a href="'.$view_link.'" style="font-size:80%;" class="text-info"><i class="btn btn-info fa fa-2x fa-eye"></i></a>
				<a href="'.$edit_link.'" style="font-size:80%;" class="text-primary"><i class="btn btn-primary fa fa-2x fa-edit"></i></a>
				<a href="'.$view_link.'?print" target = "_blank" style="font-size:80%;" class="text-info"><i class="btn btn-info fa fa-2x fa-print"></i></a>
				<a href="'.$delete_link.'" style="font-size:80%;" class="text-danger delete"><i class="btn btn-danger fa fa-2x fa-close"></i></a>
				';*/

				if ($row->isapprovedirektur != NULL && $row->isapprovemarketing != NULL) {
					$temp[] = '
					<div class="btn-group">
					  <a href="'.$view_link.'" type="button" class="btn btn-default"><i class="text-info fa fa-eye"></i> View</a>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
					    <li><a href="'.$view_link.'?print" target = "_blank" class="print"><i class="text-info fa fa-print"></i> Print</a></li>
					  </ul>
					</div>
					';
				}else{
					$temp[] = '
					<div class="btn-group">
					  <a href="'.$view_link.'" type="button" class="btn btn-default"><i class="text-info fa fa-eye"></i> View</a>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
					    <li><a href="'.$view_link.'?print" target = "_blank" class="print"><i class="text-info fa fa-print"></i> Print</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="'.$edit_link.'" class="edit"><i class="text-primary fa fa-edit"></i> Edit</a></li>
					    <li><a href="'.$delete_link.'" class="delete"><i class="text-danger fa fa-close"></i> Delete</a></li>
					  </ul>
					</div>
					';
				}

				$arr[] = $temp;
			}
			$result = array(
				'data' => $arr,
				'recordsTotal' => $count_all['count'],
				'recordsFiltered' => $count_all['count'],
				'sql' => $result['sql']
			);
			return json_encode($result);
		}


	}

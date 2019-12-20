<% include ContentHeader %>
<div class="row" data-plugin="matchHeight" data-by-row="true">
	<div class="row">
          <div class="col-xl-12">
            <!-- Example Tabs Inverse -->
            <div class="example-wrap">
              <div class="nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
                <ul class="nav nav-tabs" role="tablist">
                  	<li class="nav-item" role="presentation">
                    	<a class="nav-link active" data-toggle="tab" href="#listdraftrb" aria-controls="listdraftrb" role="tab"><span>Draft RB</span> <span class="badge badge-pill badge-dark">$jumlahdraft</span>
                		</a>
                  	</li>
	                <li class="nav-item" role="presentation">
	                    <a class="nav-link" data-toggle="tab" href="#listrb" aria-controls="listrb" role="tab">
		                  <span>RB</span><span class="badge badge-pill badge-dark">$jumlahrb</span>
		                </a>
	                </li>
	                <li class="nav-item" role="presentation">
                    	<a class="nav-link" data-toggle="tab" href="#listpo" aria-controls="listpo" role="tab"><span>PO</span> <span class="badge badge-pill badge-dark">$jumlahpo</span>
                		</a>
                  	</li>
	                <li class="nav-item" role="presentation">
	                    <a class="nav-link" data-toggle="tab" href="#listlpb" aria-controls="listlpb" role="tab">
		                  <span>LPB</span><span class="badge badge-pill badge-dark">5</span>
		                </a>
	                </li>
                </ul>
                <div class="tab-content p-20" style="width: 100%;">
                  <div class="tab-pane active" id="listdraftrb" role="tabpanel">
                    <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
		              	<thead>
			                <tr>
			                  <th style="vertical-align: middle;">Tanggal</th>
			                  <th style="vertical-align: middle;">Kode Draft RB</th>
			                  <th style="vertical-align: middle;">Tanggal Deadline</th>
			                  <th style="vertical-align: middle;">Jabatan / Cabang / Kepala Cabang</th>
			                  <th style="vertical-align: middle;">Pemohon</th>
			                  <th style="vertical-align: middle;">Jenis Permintaan</th>
			                  <th style="vertical-align: middle;">Jenis Barang</th>
			                  <th style="vertical-align: middle;">Deskripsi Kebutuhan</th>
			                  <th style="vertical-align: middle;">Status</th>
			                  <th style="vertical-align: middle;">Aksi</th>
			                </tr>
		              	</thead>
		              	<tbody>
		              		<% loop $draftrbnya %>
			                <tr>
				                <td>$Tgl</td>
				                <td>$Kode</td>
				                <td>$Deadline</td>
				                <td>$Atasan</td>
				                <td>$Pemohon</td>
				                <td>$Jenis</td>
				                <td>$JenisBarang</td>
				                <td>$Deskripsi</td>
				                <td>$Status</td>
				                <td>
				                  	<div class="btn-group">
									  <a href="$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
								</td>
			                </tr>
			                <% end_loop %>
		              	</tbody>
		            </table>
                  </div>
                  <div class="tab-pane" id="listrb" role="tabpanel">
                   <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
		              	<thead>
			                <tr>
			                  <th style="vertical-align: middle;">Tanggal</th>
			                  <th style="vertical-align: middle;">Kode RB</th>
			                  <th style="vertical-align: middle;">Tanggal Deadline</th>
			                  <th style="vertical-align: middle;">Jabatan/Cabang</th>
			                  <th style="vertical-align: middle;">Pemohon</th>
			                  <th style="vertical-align: middle;">Jenis Permintaan</th>
			                  <th style="vertical-align: middle;">Jenis Barang</th>
			                  <th style="vertical-align: middle;">Deskripsi Kebutuhan</th>
			                  <th style="vertical-align: middle;">Status</th>
			                  <th style="vertical-align: middle;">Aksi</th>
			                </tr>
		              	</thead>
		         		<tbody>
		              		<% loop $rbnya %>
			                <tr>
				                <td>$Tgl</td>
				                <td>$Kode</td>
				                <td>$Deadline</td>
				                <td>$Atasan</td>
				                <td>$Pemohon</td>
				                <td>$Jenis</td>
				                <td>$JenisBarang</td>
				                <td>$Deskripsi</td>
				                <td>$Status</td>
				                <td>
				                  	<div class="btn-group">
									  <a href="$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
								</td>
			                </tr>
			                <% end_loop %>
		              	</tbody>
		            </table>
                  </div>
                  <div class="tab-pane" id="listpo" role="tabpanel">
                	<table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" id="dataTablepo">
		              	<thead>
			                <tr>
			                  <th>No. RB</th>
			                  <th>Requester</th>
			                  <th>Tanggal</th>
			                  <th>Deadline</th>
			                  <th>Jabatan/Cabang</th>
			                  <th>Jenis Permintaan</th>
			                  <th>Jenis Barang</th>
			                  <th>Status</th>
			                  <th>Aksi</th>
			                </tr>
		              	</thead>
		              	<% loop $ponya %>
		              	<tbody>
			                <tr>
				                <td>$Kode</td>
				                <td>$Pemohon</td>
				                <td>$Tgl</td>
				                <td>$Deadline</td>
				                <td>$Atasan</td>
				                <td>$Jenis</td>
				                <td>$JenisBarang</td>
				                <td>$Status</td>
				                <td>
				                  	<div class="btn-group">
									  <a type="button" class="btn btn-default viewpo" shownya='0' idnya="$ID"><i class="text-info fa fa-eye"></i> Lihat Detail</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
				                </td>
			                </tr>
		              	</tbody>
		              	<tbody>
		              		<tr class="showdetail1 no-sort" style="display: none;">
			                	<th></th>
			                	<th>Supplier</th>
			                	<th>Kode Supplier</th>
			                	<th>Total Nilai</th>
			                	<th>Action</th>
			                	<th></th>
			                	<th></th>
			                	<th></th>
			                	<th></th>
			                </tr>
			                <% loop $isi %>
			                <!-- $isi.GetSuplier(ID).debug -->
			                <tr class="showdetail$Up.ID no-sort" style="display: none;">
			                	<td></td>
			                	<td>$NamaSupplier</td>
			                	<td>$Kode</td>
			                	<td>$Total</td>
			                	<td>
			                		<div class="btn-group">
									  <a href="$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
			                	</td>
			                	<td></td>
			                	<td></td>
			                	<td></td>
			                	<td></td>
			                </tr>
			                <% end_loop %>
		              	</tbody>
		              	<% end_loop %>
		            </table>
                  </div>
                  <div class="tab-pane" id="listlpb" role="tabpanel">
                   <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
		              	<thead>
			                <tr>
			                  <th>Kode PO</th>
			                  <th>Kode RB</th>
			                  <th>Kode Draft RB</th>
			                  <th>Tanggal</th>
			                  <th>Supplier</th>
			                  <th>Aksi</th>
			                </tr>
		              	</thead>
		              	<% loop $lpbnya %>
		              	<tbody>
			                <tr>
			                  	<td>$KodePO</td>
			                  	<td>$KodeRB</td>
			                  	<td>$KodeDraftRB</td>
			                  	<td>$Tgl.Format(d/M/Y)</td>
			                  	<td>$Suplier</td>
			                  	<td>
			                		<div class="btn-group">
									  <a type="button" class="btn btn-default viewlpb" shownya='0' idnya="$ID"><i class="text-info fa fa-eye"></i> Lihat Detail</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
			                	</td>
			                </tr>
		              	</tbody>
		              	<tbody>
		              		<tr class="showdetaillpb$ID no-sort" style="display: none;">
			                	<th></th>
			                	<th>Nama Barang</th>
			                	<th>Jumlah Dipesan</th>
			                	<th>Jumlah Diterima</th>
			                	<th colspan="2" style="text-align: center;">Action</th>
			                </tr>
			                <tr class="showdetaillpb$ID no-sort" style="display: none;">
			                	<td></td>
			                	<td>tes</td>
			                	<td>tes</td>
			                	<td>tes</td>
			                	<td colspan="2">
			                		<div class="btn-group">
									  <a href="$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> Buat LPB</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
									<div class="btn-group">
									  <a href="$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View LPB</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
									<div class="btn-group">
									  <a href="$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i>Tutup PO</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
			                	</td>
			                </tr>
		              	</tbody>
		              	<% end_loop %>
		            </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Example Tabs Inverse -->
          </div>
    </div>

</div>

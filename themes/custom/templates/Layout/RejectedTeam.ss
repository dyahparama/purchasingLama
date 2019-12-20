<% include ContentHeader %>
<div class="row" data-plugin="matchHeight" data-by-row="true">
	<div class="row">
          <div class="col-xl-12">
            <!-- Example Tabs Inverse -->
            <div class="example-wrap">
              <div class="nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
                <ul class="nav nav-tabs" role="tablist">
                  	<li class="nav-item" role="presentation">
                    	<a class="nav-link active" data-toggle="tab" href="#listdraftrb" aria-controls="listdraftrb" role="tab"><span>Draft RB </span><span class="badge badge-pill badge-dark">$jumlahdraft</span>
                		</a>
                  	</li>
	                <li class="nav-item" role="presentation">
	                    <a class="nav-link" data-toggle="tab" href="#listrb" aria-controls="listrb" role="tab">
		                  <span>RB </span><span class="badge badge-pill badge-dark">$jumlahrb</span>
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
				                	<% if $view_link!='' %>
				                  	<div class="btn-group">
									  <a href="{$BaseHref}$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
									<% end_if %>
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
				                	<% if $view_link!='' %>
				                  	<div class="btn-group">
									  <a href="{$BaseHref}$view_link" type="button" class="btn btn-default view"><i class="text-info fa fa-eye"></i> View</a>
									  <!-- <a href="'$delete_link'" type="button" class="btn btn-danger delete"><i class="text-info fa fa-eye"></i> Delete</a> --> 					 
									</div>
									<% end_if %>
								</td>
			                </tr>
			                <% end_loop %>
		              	</tbody>
		            </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Example Tabs Inverse -->
          </div>
    </div>

</div>

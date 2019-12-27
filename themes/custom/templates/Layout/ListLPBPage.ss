<% include ContentHeader %>
<div class="page-content">
	<%-- panel filter --%>

	<!-- Panel Select 2 -->
    <div class="panel">
      <div id="filterPanel">
        <div class="panel-heading">
          <h3 class="panel-title">
          	Filter
          </h3>
          <div class="panel-actions panel-actions-keep">
            <a class="panel-action icon md-minus" aria-controls="exampleTransparentBody" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
          </div>
        </div>
        <div class="panel-body container-fluid">
          <%-- form filter --%>
          <form autocomplete="off" method="POST" id="form_filter">
          <div class="row row-lg">
            <div class="col-md-6 col-xl-4">
              <!-- Example Basic -->
              <div>
                <p>Kode LPB</p>
                <div class="example">
                	<input type="text" class="form-control" name="kodeLpb" id="kodeLpb" placeholder="Kode LPB">
                </div>
              </div>
              <!-- End Example Basic -->
            </div>

            <div class="col-md-6 col-xl-4">
              <!-- Example Placeholders -->
              <div>
                <p>Kode Po</p>
                <div class="example">
                  <input type="text" class="form-control" name="kodePo" id="kodePo" placeholder="Kode PO">
                </div>
              </div>
              <!-- End Example Placeholders -->
            </div>

            <div class="col-md-6 col-xl-4">
              <!-- Example Minimum Input -->
              <div>
                <p>Kode Rb</p>
                <div class="example">
                  <input type="text" class="form-control" name="kodeRb" id="kodeRb" placeholder="Kode RB">
                </div>
              </div>
              <!-- End Example Minimum Input -->
            </div>

            <div class="col-md-6 col-xl-4">
              <!-- Example Basic -->
              <div>
                <p>Kode Draft RB</p>
                <div class="example">
                  <input type="text" class="form-control" name="kodeDraftRb" id="kodeDraftRb" placeholder="Kode Draft RB">
                </div>
              </div>
              <!-- End Example Basic -->
            </div>

            <div class="col-md-6 col-xl-4">
              <!-- Example Multi Balue -->
              <div>
                <p>Tanggal</p>
                <div class="example">
                  <input class="form-control" id="tgl-draft" name="tgl"
                  data-date-format="dd/mm/yyyy" data-now="{$Now.format('dd/MM/yyyy')}" data-plugin="datepicker"
                  type="text">
                </div>
              </div>
              <!-- End Example Multi Balue -->
            </div>

            <div class="col-md-6 col-xl-4">
              <!-- Example Color -->
              <div>
                <p>Supplier</p>
                <div class="example">
                  <div class="select2-primary">
                    <select class="form-control" id="vendor" name="vendor" data-plugin="select2" data-placeholder="Pilih Supplier" data-allow-clear="true">
                      <option></option>
                    </select>
                  </div>
                </div>

              </div>
              <!-- End Example Color -->
            </div>

            <div class="col-md-6 col-xl-4">
              <!-- Example Color -->
              <div>
                <br>
                <div class="example">
                  <div class="select2-primary" style="text-align: center;">
                    <button type="submit" class="btn btn-raised btn-primary btn-block waves-effect waves-classic">Filter</button>
                  </div>
                </div>

              </div>
              <!-- End Example Color -->
            </div>
          </div>
          <%-- end of filter form --%>
          </form>
        </div>
      </div>

    </div>
    <!-- End Panel Select 2 -->
	<%-- end of panel filter --%>
	<!-- Panel Basic -->
    <div class="panel">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped w-full" id="datatable1">
            <thead>
              <tr>
                <% if $Columns %>
                    <% loop $Columns %>
                      <th data-title="$ColumnTb">$ColumnTb</th>
                    <% end_loop %>
                <% end_if %>
                <th data-title="Action">Action</th>
              </tr>
            </thead>
            <tbody>
              <%-- <tr>
                <td>$336,046</td>
              </tr> --%>
            </tbody>
          </table>
        </div>
      </div>
	<!-- End Panel Basic -->
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-hidden="true"
	aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-simple">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title">Modal Title</h4>
			</div>
			<div class="modal-body">
				<div class="example">
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Jenis Barang :</label>
						<div class="col-md-9">
							<select class="form-control select2-modal" data-plugin="select2">
								<option>Pilih Jenis Barang</option>
								<% loop $jenisBrng %>
								<option value="$ID">{$Nama}</option>
								<% end_loop %>
							</select>
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Deskripsi Kebutuhan :</label>
						<div class="col-md-9">
							<div class="input-group">
								<textarea class="form-control"></textarea>
							</div>
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Jumlah :</label>
						<div class="col-md-9">
							<input class="form-control" type="number" value="0" autocomplete="off">
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Satuan :</label>
						<div class="col-md-9">
							<select class="form-control select2-modal" data-plugin="select2">
								<option>Pilih Satuan</option>
								<% loop $satuan %>
								<option value="$ID">{$Kode}</option>
								<% end_loop %>
							</select>
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Supplier Lokal :</label>
						<div class="col-md-9">
							<input class="form-control" type="text" autocomplete="off">
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Penawaran :</label>
						<div class="col-md-9">

						</div>
					</div>
					<form action="/file-upload" class="dropzone" id="penawaran"></form>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Spesifikasi Barang :</label>
						<div class="col-md-9">
							<input class="form-control" type="text" autocomplete="off">
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Kode Inventaris :</label>
						<div class="col-md-9">
							<input class="form-control" type="text" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Save
					changes</button>
			</div>
		</div>
	</div>
</div>

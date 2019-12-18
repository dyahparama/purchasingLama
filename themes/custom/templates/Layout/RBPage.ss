<% include ContentHeader %>
<div class="page-content">
	<div class="panel">
		<header class="panel-heading">
			<h3 class="panel-title">
				Input Draf Request Barang
			</h3>
		</header>
		<div class="panel-body container-fluid">
			<div class="row row-lg">
				<div class="col-md-12 col-lg-12">
					<!-- Example Horizontal Form -->
					<div class="example-wrap">
						<div class="example">
							<form id="form-drb">
                            <div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Kode RB :</label>
									<div class="col-md-9">
										<input class="form-control" id="nomor" name="nomor" type="text" value="<Auto Generate>" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Kode Draft RB :</label>
									<div class="col-md-9">
										<input class="form-control" id="nomor" name="kode" type="text" value="" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Tanggal :</label>
									<div class="col-md-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="icon md-calendar" aria-hidden="true"></i>
											</span>
											<input class="form-control" id="tgl-draft" name="tgl"
												data-date-format="dd/mm/yyyy" data-now="$dateNow"
												value="<% if $dateNow %>$dateNow<% end_if %>" data-plugin="datepicker"
												type="text">
										</div>
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Pemohon :</label>
									<div class="col-md-9">
										<input class="form-control" id="nomor" name="Pemohon" type="text" value="" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Jabatan :</label>
									<div class="col-md-9">
										<input class="form-control" id="nomor" name="Jabatan" type="text" value="" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Cabang :</label>
									<div class="col-md-9">
										<input class="form-control" id="nomor" name="Cabang" type="text" value="" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Jenis Permintaan :</label>
									<div class="col-md-9">
										<select class="form-control" name="jenis" data-plugin="select2">
											<option>Pilih Event</option>
											<option <% if $jenis=="Event" %>selected<% end_if %> value="Event">Event</>
											<option <% if $jenis=="Non Event" %>selected<% end_if %> value="Non Event">
												Non-Event</option>
										</select>
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Tanggal Dibutuhkan/Deadline:</label>
									<div class="col-md-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="icon md-calendar" aria-hidden="true"></i>
											</span>
											<input class="form-control" value="<% if $deadline %>$deadline<% end_if %>"
												name="tgl-butuh" data-date-format="dd/mm/yyyy" data-plugin="datepicker"
												type="text">
										</div>
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Alasan Permintaan:</label>
									<div class="col-md-9">
										<textarea name="alasan"
											class="form-control"><% if $alasan %>$alasan<% end_if %></textarea>
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">*Nomor Proyek :</label>
									<div class="col-md-9">
										<input class="form-control"
											value="<% if $nomorProyek %>$nomorProyek<% end_if %>" name="nomor-proyek"
											type="text" autocomplete="off">
									</div>
								</div>

								<div class="form-group form-material row">
									<div class="col-md-3">
										<button data-target="#exampleNiftyFadeScale" data-toggle="modal"
											class="btn btn-block btn-primary waves-effect waves-classic" id="add-detail"
											type="button">
											Add Detail Barang
										</button>
									</div>
								</div>
								<div class="example table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Jenis Barang</th>
												<th>Deskripsi Kebutuhan</th>
												<th>Jumlah</th>
												<th>Satuan</th>
												<th>Supplier Lokal</th>
												<th>Penawaran</th>
												<th>Spesifikasi Barang</th>
												<th>Kode Inventaris</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<% loop $detail %>
											<tr>
												<td>$Jenis.Nama</td>
												<td>$Deskripsi</td>
												<td>$Jumlah</td>
												<td>$Satuan.Kode</td>
												<td>$Supplier</td>
												<td><% loop $Penawaran %>
													<a href="{$Link}$FileFileName">$Name</a><% end_loop %></td>
												<td>$Spesifikasi</td>
												<td>$KodeInventaris</td>
												<td>
													<button data-target="#editModal-{$ID}" data-toggle="modal"
														class="btn btn-info btn-xs waves-effect waves-classic modal-select2-show"
														type="button">
														Edit
													</button>
													<button data-target="#deleteModal" data-toggle="modal"
														class="btn btn-danger btn-xs waves-effect waves-classic modal-select2-show"
														type="button">
														Delete
													</button>
												</td>
											</tr>
											<div class="modal fade modal-fade-in-scale-up" id="deleteModal"
												aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog"
												tabindex="-1">
												<div class="modal-dialog modal-sm modal-simple">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close close-modal"
																data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">×</span>
															</button>
															<h4 class="modal-title">Delete Detail</h4>
														</div>
														<div class="modal-body">
															<div class="example">
																<h5>Apakah anda yakin akan menghapus data?</h5>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-primary delete-detail"
																data-id="$ID">Delete</button>
														</div>
													</div>
												</div>
											</div>
											<div class="modal fade modal-fade-in-scale-up" id="editModal-{$ID}"
												aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog"
												tabindex="-1">
												<div class="modal-dialog modal-simple">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close close-modal"
																data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">×</span>
															</button>
															<h4 class="modal-title">Edit Detail</h4>
														</div>
														<div class="modal-body">
															<div class="example">
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Jenis Barang
																		:</label>
																	<div class="col-md-9">
																		<select id="jenis-brg-{$ID}"
																			class="form-control select2-modal"
																			data-plugin="select2">
																			$Top.renderOptionEditDetailJenis($ID)
																		</select>
																	</div>
																</div>
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Deskripsi
																		Kebutuhan :</label>
																	<div class="col-md-9">
																		<div class="input-group">
																			<textarea id="deskripsi-kebutuhan-{$ID}"
																				class="form-control">$Deskripsi</textarea>
																		</div>
																	</div>
																</div>
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Jumlah
																		:</label>
																	<div class="col-md-9">
																		<input id="jumlah-{$ID}" class="form-control"
																			value="$Jumlah" type="number" value="0"
																			autocomplete="off">
																	</div>
																</div>
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Satuan
																		:</label>
																	<div class="col-md-9">
																		<select id="satuan-{$ID}"
																			class="form-control select2-modal"
																			data-plugin="select2">
																			<option>Pilih Satuan</option>
																			$Top.renderOptionEditDetailSatuan($ID)
																		</select>
																	</div>
																</div>
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Supplier
																		Lokal :</label>
																	<div class="col-md-9">
																		<input id="supplier-lokal-{$ID}"
																			value="$Supplier" class="form-control"
																			type="text" autocomplete="off">
																	</div>
																</div>
																<!-- <div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Penawaran :</label>
																	<div class="col-md-9">
																		<form action="draf-rb/saveDetailFile" class="dropzone" id="edit-penawaran"></form>
																	</div>
																</div> -->
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Spesifikasi
																		Barang :</label>
																	<div class="col-md-9">
																		<input class="form-control"
																			id="spesifikasi-{$ID}" value="$Spesifikasi"
																			type="text" autocomplete="off">
																	</div>
																</div>
																<div class="form-group form-material row">
																	<label class="col-md-3 col-form-label">Kode
																		Inventaris :</label>
																	<div class="col-md-9">
																		<input class="form-control"
																			id="kode-inventaris-{$ID}"
																			value="$KodeInventaris" type="text"
																			autocomplete="off">
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-primary update-detail"
																data-id="$ID">Save</button>
														</div>
													</div>
												</div>
											</div>
											<% end_loop %>
										</tbody>
									</table>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Note :</label>
									<div class="col-md-9">
										<div class="input-group">
											<textarea class="form-control"
												name="note"><% if $note %>$note<% end_if %></textarea>
										</div>
									</div>
								</div>
								<div class="form-group form-material row">
									<div class="col-md-9">
										<button class="btn btn-primary" id="forwardTo" type="button">
											Submit
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- End Example Horizontal Form -->
				</div>
			</div>
		</div>
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
				<h4 class="modal-title">Tambah Detail</h4>
			</div>
			<div class="modal-body">
				<div class="example">
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Jenis Barang :</label>
						<div class="col-md-9">
							<select id="jenis-brg" class="form-control select2-modal" data-plugin="select2">
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
								<textarea id="deskripsi-kebutuhan" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Jumlah :</label>
						<div class="col-md-9">
							<input id="jumlah" class="form-control" type="number" value="0" autocomplete="off">
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Satuan :</label>
						<div class="col-md-9">
							<select id="satuan" class="form-control select2-modal" data-plugin="select2">
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
							<input id="supplier-lokal" class="form-control" type="text" autocomplete="off">
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Penawaran :</label>
						<div class="col-md-9">
							<form action="draf-rb/saveDetailFile" class="dropzone" id="penawaran"></form>
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Spesifikasi Barang :</label>
						<div class="col-md-9">
							<input class="form-control" id="spesifikasi" type="text" autocomplete="off">
						</div>
					</div>
					<div class="form-group form-material row">
						<label class="col-md-3 col-form-label">Kode Inventaris :</label>
						<div class="col-md-9">
							<input class="form-control" id="kode-inventaris" type="text" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="save-detail" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>

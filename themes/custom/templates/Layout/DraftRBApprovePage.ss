<% include ContentHeader %>
<div class="page-content">
	<div class="panel">
		<header class="panel-heading">
			<h3 class="panel-title">
				Draf Request Barang
			</h3>
		</header>
		<div class="panel-body container-fluid">
			<div class="row row-lg">
				<div class="col-md-12 col-lg-12">
					<!-- Example Horizontal Form -->
					<div class="example-wrap">
						<div class="example">
							<form id="form-drb">
								<input class="form-control d-none" id="user-now" type="text" value="$userNow"
											readonly autocomplete="off">
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Nomor Draft RB :</label>
									<div class="col-md-3">
										<input class="form-control" id="nomor" name="nomor" type="text" value="{$kode}"
											readonly autocomplete="off">
									</div>
									<label class="col-md-3 col-form-label">Status Permintaan :</label>
									<div class="col-md-3">
										<input class="form-control" id="nomor" name="nomor" type="text" value="$status"
											readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Tanggal :</label>
									<div class="col-md-9">
										<input class="form-control" name="pemohon" type="text" value="$dateNow" readonly
											autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Pemohon :</label>
									<div class="col-md-9">
										<input class="form-control" name="pemohon" type="text" value="$pemohon" readonly
											autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Jabatan/Cabang :</label>
									<div class="col-md-9">
										<input class="form-control" name="pemohon" type="text" value="$jabatan" readonly
											autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Nama Atasan :</label>
									<div class="col-md-9">
										<input id="kepala-cabang" value="$kepalaCabang" class="form-control" type="text"
											readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Jenis Permintaan :</label>
									<div class="col-md-9">
										<input class="form-control" name="pemohon" type="text" value="$jenis" readonly
											autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Tanggal Dibutuhkan/Deadline:</label>
									<div class="col-md-9">
										<input class="form-control" name="pemohon" type="text" value="$deadline"
											readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Alasan Permintaan:</label>
									<div class="col-md-9">
										<textarea readonly name="alasan" class="form-control">$alasan</textarea>
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Nomor Proyek :</label>
									<div class="col-md-9">
										<input readonly class="form-control" value="$nomorProyek" name="nomor-proyek"
											type="text" autocomplete="off">
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Note Pemohon :</label>
									<div class="col-md-9">
										<div class="input-group">
											<textarea readonly class="form-control"
												name="note"><% if $note %>$note<% end_if %></textarea>
										</div>
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
												</td>
											</tr>
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
											<textarea id="note-approver" class="form-control"
												name="note"></textarea>
										</div>
									</div>
								</div>
								<div class="form-group form-material row">
									<label class="col-md-3 col-form-label">Respond :</label>
									<div class="col-md-4">
										<div class="radio-custom radio-primary">
											<input type="radio" id="RadioApprove" name="respond" value="approve">
											<label for="RadioApprove">Approve</label>
										</div>
										<div class="radio-custom radio-primary">
											<input type="radio" id="RadioReject" name="respond" value="reject">
											<label for="RadioReject">Reject</label>
										</div>
										<div class="radio-custom radio-primary">
											<input type="radio" id="RadioForward" name="respond" checked="" value="forward">
											<label for="RadioForward">Forward</label>
										</div>
									</div>
									<div class="col-md-5" id="forward-to">
										<label class="col-md-3 col-form-label">Forward To :</label>
										<div class="col-md-9">
											<select id="select-forward-to" class="form-control" name="jabatan-cabang"
												data-plugin="select2">
												<option>Pilih Pegawai</option>
												<% loop $pegawai %>
												<option value="$ID">
													$Pegawai.Nama</option>
												<% end_loop %>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group form-material row">
									<div class="col-md-9">
										<button class="btn btn-primary" id="approve-forwardTo" type="button">
											Submit
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- End Example Horizontal Form -->
				</div>
				<div class="col-md-12 col-lg-12">
					<h5>History Approval</h5>
				</div>
				<div class="col-md-12 col-lg-12">
					<div class="example table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Jabatan</th>
									<th>Tanggal Diterima</th>
									<th>Tanggal Approve</th>
									<th>Notes</th>
								</tr>
							</thead>
							<tbody>
								<% loop $detail %>
								<tr>
									
								</tr>
								<% end_loop %>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

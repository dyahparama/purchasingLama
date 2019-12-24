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
				<% loop $history %>
				<tr>
					<td>
						$ApprovedBy.Pegawai.Nama
					</td>
					<td>
						$Top.getJabatanFromStatus($Status.ID)		
					</td>
					<td>
						$Top.getTglTerima($ID)
					</td>
					<td>
						$Top.getTglApprove($Created)
					</td>
					<td>
						$Note
					</td>
				</tr>
				<% end_loop %>
			</tbody>
		</table>
	</div>
</div>
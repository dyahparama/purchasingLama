<div class="col-md-12 col-lg-12">
	<h5>History Approval</h5>
</div>
<div class="col-md-12 col-lg-12">
	<div class="example table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
                    <th>Tanggal</th>
					<th>Nama [Jabatan]</th>
					<th>Status</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody>
				<% loop $history %>
				<tr>
					<td>
						$Created
					</td>
					<td>
						$By
					</td>
					<td>
						$Status
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

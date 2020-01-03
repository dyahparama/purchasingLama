<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Document</title>
        <style>
            .color {
                color: red;
            }
            .table {
                border: 1px solid black;
            }
            tr td {
                border: 1px solid black;
            }
            .text-center {
                text-align: center;
            }
            .width100 {
                width: 100%;
            }
            .width25 {
                width: 25%;
            }
        </style>
    </head>
    <body>
        <h3 class="text-center">Approved Draf RB by ($From)</h3>
        <p class="text-center">Draf RB anda dengan kode Draf RB $DRB.Kode</p>
		<p class="text-center">Telah di Approve oleh $From <% if $DRB.Status.ID == 5 %> dan sedang di proses menjadi RB<% end_if %>
		</p>
		<% with $DRB %>
		<p>Berikut Data Draf RB $Kode: </p>
		<p>Pemohon: {$Pemohon.Pegawai.Nama}</p>
		<p>Jabatan/Cabang: {$PegawaiPerJabatan.Jabatan.Nama}/$PegawaiPerJabatan.Cabang.Nama</p>
		<p>Jenis Permintaan: $Jenis</p>
		<p>Tanggal: $Top.FormatDate('d/m/Y',$Tgl)</p>
		<p>Tanggal Deadline: $Top.FormatDate('d/m/Y',$Deadline)</p>
		<% end_with %>
		<br>
		<p>Rincian Request Barang</p>

		<table border="1">
			<thead>
				<tr>
					<th>Jenis Barang</th>
					<th>Deskrips Kebutuhan</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Spesifikasi Barang</th>
				</tr>
			</thead>
			<tbody>
				<% loop $DRB.Detail %>
					<tr>
						<td>$Jenis.Nama</td>
						<td>$Deskripsi</td>
						<td>$Jumlah</td>
						<td>$Satuan.Nama</td>
						<td>$Spesifikasi</td>
					</tr>
				<% end_loop %>
			</tbody>
		</table>
	</body>
	<br>
	<p class="text-center">Klik link berikut untuk melihat Draf RB yang perlu Anda Approved</p>
	<p class="text-center"><a href="$Link">Klik disini</a></p>
</html>

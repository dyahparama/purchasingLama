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
        <h3 class="text-center">Generate Your PO</h3>
        <p class="text-center">RB dengan Kode $PO.RB.Kode telah dibuatkan PO oleh Staff Finance</p>
		</p>
		<% with $PO %>
		<p>Berikut Data PO $Kode untuk RB $RB.Kode: </p>
		<p>Kode RB: {$RB.Kode}</p>
		<p>Kode Draf RB: {$RB.DraftRB.Kode}</p>
		<p>Tanggal: $Top.FormatDate('d/m/Y',$Tgl)</p>
		<p>Supplier: $NamaSupplier</p>
		<% end_with %>
		<br>
		<p>Rincian Request Barang</p>

		<table border="1">
			<thead>
				<tr>
					<th>Jenis Barang</th>
					<th>Nama Barang</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Harga</th>
				</tr>
			</thead>
			<tbody>
				<% loop $PO.Detail %>
					<tr>
						<td>$Jenis.Nama</td>
						<td>$NamaBarang</td>
						<td>$Jumlah</td>
						<td>$Satuan.Nama</td>
						<td>$Top.MoneyFormat('',$Harga)</td>
					</tr>
				<% end_loop %>
			</tbody>
		</table>
	</body>
	<br>
	<p class="text-center">Klik link berikut untuk melihat Draf RB yang perlu Anda Approved</p>
	<p class="text-center"><a href="$Link">Klik disini</a></p>
</html>

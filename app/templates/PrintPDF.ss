
<style>
	.color{
		color: red;
	}
	.table{
		border: 1px solid black;
	}
	tr td{
		border: 1px solid black;
	}
	.text-center{
		text-align: center;
	}
	.width100{
		width: 100%;
	}
	.width25{
		width: 25%;
	}
</style>
<table class="table width100">
	<tr>
		<td colspan="4" class="text-center">
			<h4>Purchase Order</h4>
		</td>
	</tr>
	<tr class="width100">
		<td class="text-center" colspan="4">
			$NamaPerusahaan
		</td>
	</tr>
	<tr>
		<td class="text-center" colspan="4">
			{$PO.Alamat}, {$PO.Kontak}
		</td>
	</tr>
	<tr>
		<td class="text-center width25">
			Kepada Yth
		</td>
		<td class="text-center width25">
			$PO.Nama
		</td>
		<td class="text-center width25">
			Tgl Pemesanan
		</td>
		<td class="text-center width25">
			$PO.Tgl	
		</td>
	</tr>
	<tr>
		<td class="text-center width25">
			
		</td>
		<td class="text-center width25">

		</td>
		<td class="text-center width25">
			No Pesanan
		</td>
		<td class="text-center width25">
			$PO.Kode
		</td>
	</tr>
</table>
<br>
<table class="table width100">
	<thead>
		<tr>
			<th>RBB</th>
			<th>KDD</th>
			<th>Jumlah</th>
			<th>Satuan</th>
			<th>Nama Barang</th>
			<th>Harga Satuan</th>
			<th>Jumlah (Rp)</th>
			<th>Ket</th>
		</tr>
	</thead>
	<tbody>
		<% loop $Detail %>
			<tr>
				<td>$PO.RB.Kode</td>
				<td>$DetailPerSupplier.DraftRBDetail.KodeInventaris</td>
				<td>$Jumlah</td>
				<td>$Satuan.Nama</td>
				<td>$NamaBarang</td>
				<td>$Harga</td>
				<td>$Total</td>
				<td>-</td>
			</tr>
		<% end_loop %>
		<tr>
			<td colspan="6">Jumlah</td>
			<td>$PO.Total</td>
			<td></td>
		</tr>
	</tbody>
</table>
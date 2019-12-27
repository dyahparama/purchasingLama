<style>
	.color {
		color: red;
	}

	.table {
		border: 1px solid black;
	}

	.text-center {
		text-align: center;
	}

	.text-left {
		text-align: left;
	}

	.text-right {
		text-align: right;
	}

	.text-bold {
		font-weight: bold;
	}

	.width100 {
		width: 100%;
	}

	.width25 {
		width: 25%;
	}

	.heigth-200 {
		height: 200px;
	}

	.text-bottom {
		vertical-align: bottom;
	}

	.text-top {
		vertical-align: top;
	}
	.no-border {
		border: 1px solid white;
	}
	td,th{
		font-size: 12px;
	}
</style>
<table class="width100">
	<tr>
		<td colspan="4" class="text-center">
			<h4>Purchase Order</h4>
		</td>
	</tr>
	<tr class="width100">
		<td class="text-center" colspan="4">
			$SiteConfig.Perusahaan
		</td>
	</tr>
	<tr>
		<td class="text-center" colspan="4">
			{$SiteConfig.Alamat}, {$SiteConfig.Telp}, {$SiteConfig.Fax}
		</td>
	</tr>
	<tr class="table">
		<td class="text-center width25 text-bold">
			Kepada Yth :
		</td>
		<td class="text-center width25 text-bold">
			$PO.Nama
		</td>
		<td class="text-center width25 text-bold">
			Tgl Pemesanan :
		</td>
		<td class="text-center width25 text-bold">
			$Top.FormatDate('d/m/Y',$PO.Tgl)
		</td>
	</tr>
	<tr>
		<td class="text-center width25">

		</td>
		<td class="text-center width25">

		</td>
		<td class="text-center width25 text-bold">
			No Pesanan
		</td>
		<td class="text-center width25 text-bold">
			$PO.Kode
		</td>
	</tr>
</table>
<br>
<table border="1" class="width100">
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
			<td class="text-right">$Jumlah</td>
			<td>$Satuan.Nama</td>
			<td>$NamaBarang</td>
			<td class="text-right">$Top.MoneyFormat('',$Harga)</td>
			<td class="text-right">$Top.MoneyFormat('',$Total)</td>
			<td>$DetailPerSupplier.Keterangan</td>
		</tr>
		<% end_loop %>
		<tr>
			<td class="text-right" colspan="6">Total :</td>
			<td class="text-right" colspan="2">$Top.MoneyFormat('',$PO.Total)</td>
		</tr>
		<tr>
			<td colspan="3" class="text-bold">Harap Barang Tersebut dikirim ke : </td>
			<td colspan="5">{$PO.Alamat}</td>
		</tr>
		<tr>
			<td colspan="3">Estimasi Kedatangan Barang : </td>
			<td colspan="5"></td>
		</tr>
		<tr class="no-border">
			<td colspan="4" class="text-center no-border text-bold">Suppliers : $PO.NamaSupplier</td>
			<td colspan="4" class="text-center no-border text-bold">Pemesan : $SiteConfig.Perusahaan</td>
		</tr>
		<tr>
			<td colspan="3" width="25%" height="100px" class="text-center text-bottom no-border">(...................)
			</td>
			<td colspan="2" width="25%" class="text-center text-bottom no-border">(...................)</td>
			<td colspan="3" width="25%" class="text-center text-bottom no-border">(...................)</td>
		</tr>
	</tbody>
</table>

<% if $IsTermin %>
<table border="1" class="table width100">
	<thead>
		<tr>
			<th colspan="4">Termin</th>
		</tr>
		<tr>
			<th>Tanggal</th>
			<th>Jenis</th>
			<th>Keterangan</th>
			<th>Jumlah(RP)</th>
		</tr>
	</thead>
	<tbody>
		<% loop $Termin %>
		<tr>
			<td>$Top.FormatDate('d/m/Y',$Tanggal)</td>
			<td>$Jenis</td>
			<td>$Keterangan</td>
			<td class="text-right">$Top.MoneyFormat('',$Jumlah)</td>
		</tr>
		<% end_loop %>
		<tr>
			<td class="text-right" colspan="3">Total :</td>
			<td class="text-right">$MoneyFormat('',$TotalTermin)</td>
		</tr>
	</tbody>
</table>
<% end_if %>

<table class="table width100">
	<thead>
		<tr>
			<th class="text-left">Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>1. Harap <span class="text-bold">PO dilampirkan pada waktu tukar Tanda Terima (TT) hari selasa</span>. distempel nama toko dan tanda tangan supplier</td>
		</tr>
		<tr>
			<td>2. Harap <span class="text-bold">Mencantumkan nomor rekening pada nota / invoice</span> pada saat penukaran Tanda Terima (TT)</td>
		</tr>
		<tr>
			<td>3. Pengiriman barang pada jam kerja <span class="text-bold">(Selasa-Jum'at pk 9.30-16.00 dan Sabtu pk 9.30-14.00), minggu & senin LIBUR</span></td>
		</tr>
	</tbody>
</table>
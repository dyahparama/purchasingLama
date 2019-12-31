<% include ContentHeader %>
<div class="page-content">
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">
                LPB
            </h3>
        </header>
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12 col-lg-12">
                    <!-- Example Horizontal Form -->
                    <div class="example-wrap">
                        <div class="example">
                            <form action="{$BaseHref}/lpb/doPostLPB" id="form-lpb" method="post">
                            <input type="hidden" value="{$PO.ID}" name="POID">
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode LPB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nomor" type="text"
                                            value="$LPB.Kode" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode RB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nomor" type="text"
                                            value="{$LPB.PO.RB.Kode}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode Draft RB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nomor" type="text"
                                            value="{$LPB.PO.DraftRB.Kode}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Tanggal :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="tgl-lpb" type="text"
                                            value="{$LPB.Tgl.Nice}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Supplier :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nomor" type="text"
                                            value="{$LPB.PO.NamaSupplier}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th class="th-detail">Jenis Barang</th>
                                                <th class="th-detail">Nama Barang</th>
                                                <th class="th-detail">Jumlah Barang PO</th>
                                                <th class="th-detail">Jumlah Barang Diterima</th>
                                                <th class="th-detail">Satuan</th>
                                                <th class="th-detail">Harga</th>
                                                <%-- <th class="th-detail">Diskon (%)</th>
                                                <th class="th-detail">Diskon (Rp)</th> --%>
                                                <th class="th-detail">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <% loop $LPB.Detail %>
                                            <tr class="table-row">
                                                <input type="hidden" value="$ID" name="detail_id[]">
                                                <td class="jenis-barang">
                                                    <input name="jenis_barang[]" class="form-control"
                                                        value="$Jenis.Nama" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="nama_barang[]" class="form-control"
                                                        value="$NamaBarang" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="jumlah[]" class="autonumeric form-control jumlah-lpb" readonly
                                                    value="$Jumlah" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="jumlah_diterima[]" class="autonumeric jumlah-diterima-lpb form-control"
                                                        value="$JumlahTerima" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="satuanid[]" value="$SatuanID">
                                                    <input name="satuan[]" class="form-control" readonly
                                                    value="$Satuan.Nama" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="harga[]" class="autonumeric form-control harga-lpb" type="text"
                                                        value="$Harga" readonly autocomplete="off" value="$Harga">
                                                </td>
                                                <td>
                                                    <input name="subtotal[]" class="autonumeric form-control subtotal-lpb" type="text"
                                                        value="$Total" autocomplete="off" readonly>
                                                </td>
                                            </tr>
                                            <% end_loop %>
                                            <!-- <tr id="row-total">
                                                <td colspan="6">Jumlah</td>
                                                <td><input id="total-akhir-lpb" name="total" class="form-control" type="text" value="{$TotalAkhir}"
                                                    autocomplete="off" readonly></td>
                                                <td></td>
                                                <td></td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Keterangan :</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <textarea readonly class="form-control"
                                                name="note">$Note</textarea>
                                        </div>
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

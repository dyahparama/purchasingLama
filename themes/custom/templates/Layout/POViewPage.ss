<% include ContentHeader %>
<div class="page-content">
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">
                Input PO
            </h3>
        </header>
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12 col-lg-12">
                    <!-- Example Horizontal Form -->
                    <div class="example-wrap">
                        <div class="example">
                            <form action="{$BaseHref}po/doPostPo" method="post" id="form-po" novalidate="novalidate">
                            <%-- <form action="/po/doPostPoaaa" id="form-po" method="post" novalidate="novalidate" class="fv-form fv-form-bootstrap4"> --%>
                                <input type="hidden" name="RBID" value="{$RB.ID}">
                                <input type="hidden" name="DraftRB_ID" value="{$RB.DraftRBID}">
                                <input type="hidden" name="RB_ID" value="{$RB.ID}">
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode PO :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nomor" type="text"
                                            value="$PO.Kode" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode RB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="RBID" name="RBID" type="text"
                                            value="$PO.RB.Kode" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode Draft RB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="DraftRBID" name="DraftRBID" type="text"
                                            value="{$PO.DraftRB.Kode}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Tanggal :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="tgl-po" type="text"
                                            value="$PO.Tgl.Nice" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Supplier :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nama-supplier" type="text"
                                            value="{$PO.NamaSupplier}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">User Terima LPB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nama-supplier" type="text"
                                            value="{$PO.TerimaLPB.Pegawai.Nama}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Nama :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" readonly name="nama_deliver" type="text"
                                            value="{$PO.Nama}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Alamat Pengiriman :</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <textarea readonly="" class="form-control"
                                                name="alamat" value="$Alamat">$PO.Alamat</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kontak :</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <textarea readonly class="form-control"
                                                name="kontak">$PO.Kontak</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <%-- <div class="col-md-3">
                                        <button class="btn btn-block btn-primary waves-effect waves-classic"
                                            id="add-detail-po" type="button">
                                            Add Detail Barang
                                        </button>
                                    </div> --%>
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th class="th-detail">Jenis Barang</th>
                                                <th class="th-detail">Nama Barang</th>
                                                <th class="th-detail">Jumlah</th>
                                                <th class="th-detail">Satuan</th>
                                                <th class="th-detail">Harga</th>
                                                <th class="th-detail">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <% loop $Detail %>
                                            <tr class="table-row">
                                                <td class="jenis-barang">
                                                    <input name="jenis_barangid[]" class="form-control" 
                                                        value="$Jenis.Nama" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="nama_barang[]" class="form-control"
                                                        value="$NamaBarang" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="jumlah[]" class="jumlah-po form-control jumlah-po-val" readonly
                                                        value="$Jumlah" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="satuanid[]" class="jumlah-po form-control jumlah-po-val" readonly
                                                        value="$Satuan.Nama" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="harga[]" class="form-control harga-po-val" type="text"
                                                        value="$Harga" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="subtotal[]" class="form-control subtotal-po-val" type="text"
                                                        value="$Total" autocomplete="off" readonly>
                                                </td>
                                            </tr>
                                            <% end_loop %>
                                            <tr id="row-total">
                                                <td colspan="5">Jumlah</td>
                                                <td><input id="total-akhir-po" name="total-akhir-po" class="form-control" type="text" value="{$PO.Total}"
                                                    autocomplete="off" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Note :</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <textarea readonly="" class="form-control"
                                                name="note">$PO.Note</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="example">
                                    <!-- <div class="col-md-3">
                                        <button class="btn btn-block btn-primary waves-effect waves-classic" id="add-detail-termin" type="button">
                                            Add Termin
                                        </button>
                                    </div> -->
                                    <table class="table-striped table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-termin">
                                            <% loop $Termin %>
                                            <tr class="table-row-termin no-1">
                                                <td>
                                                    <input class="form-control" readonly="" id="tgl-termin" name="tgl-termin[]" value="$Tanggal.Nice" type="text">
                                                </td>
                                                <td>
                                                    <input class="form-control" id="tgl-termin" name="tgl-termin[]" value="$Jenis" type="text">
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="keterangan-termin[]">$Keterangan</textarea>
                                                </td>
                                                <td>
                                                    <input name="total-termin[]" class="form-control jumlah-termin required-field" type="number"
                                                        value="$Jumlah" autocomplete="off">
                                                </td>
                                            </tr>
                                             <% end_loop %>
                                        </tbody>
                                        <!-- <tbody>
                                            <tr id="row-total-termin">
                                                <td colspan="3">Jumlah</td>
                                                <td><input id="total-akhir-termin-po" name="total-akhir-termin" class="form-control" type="text" value="0"
                                                    autocomplete="off" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                </div>
                                
                                <!-- <div class="form-group form-material row">
                                    <div class="col-md-9">
                                        <button type="button" id="submit-po" class="btn-primary btn">Submit</button>
                                    </div>
                                </div> -->
                                
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

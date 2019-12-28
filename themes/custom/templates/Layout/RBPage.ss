<% include ContentHeader %>
<div class="page-content">
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">
                Input Request Barang
            </h3>
        </header>
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12 col-lg-12">
                    <!-- Example Horizontal Form -->
                    <div class="example-wrap">
                        <div class="example">
                            <form action="{$BaseHref}rb/doSubmitRB" method="post" id="form-rb" enctype="multipart/form-data">
                                <input type="hidden" value="{$mode}" name="SubmitMode">
                                <input type="hidden" value="{$RB.ID}" name="RBID">
                                <input class="form-control" name="DraftRB_ID" type="hidden"
                                value="{$RB.DraftRBID}" readonly autocomplete="off">
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode RB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="nomor" type="text"
                                        value="{$RB.Kode}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kode Draft RB :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="kode" type="text"
                                        value="{$DraftRB.Kode}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Tanggal :</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="icon md-calendar" aria-hidden="true"></i>
                                            </span>
                                            <% if $DraftRB.Tgl %>
                                            <input class="form-control" id="tgl-draft" name="tgl-rb"
                                            data-date-format="dd/mm/yyyy"
                                            value="$DraftRB.Tgl.format(dd/MM/yyyy)" readonly data-plugin="datepicker"
                                            type="text">
                                            <% else %>
                                            <input class="form-control" id="tgl-draft" name="tgl-rb"
                                            data-date-format="dd/mm/yyyy" data-now="$dateNow"
                                            value="$Now.format(dd/MM/yyyy)" data-plugin="datepicker"
                                            type="text">
                                            <% end_if %>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Pemohon :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="Pemohon" type="text"
                                        value="{$DraftRB.Pemohon.Pegawai.Nama}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Jabatan/Cabang :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="Pemohon" type="text"
                                        value="{$DraftRB.PegawaiPerJabatan.Jabatan.Nama}/{$DraftRB.PegawaiPerJabatan.Cabang.Nama}"
                                        readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Kepala Cabang :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="Pemohon" type="text"
                                        value="{$DraftRB.PegawaiPerJabatan.Cabang.Kacab.Pegawai.Nama}" readonly
                                        autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Jenis Permintaan :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="Pemohon" type="text"
                                        value="{$DraftRB.Jenis}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Tanggal Dibutuhkan :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="Pemohon" type="text"
                                        value="{$DraftRB.Deadline.format('dd/MM/yyyy')}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Alasan Permintaan :</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="nomor" name="Pemohon" type="text"
                                        readonly autocomplete="off">$DraftRB.Alasan</textarea>
                                    </div>
                                </div>
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">Nomor Proyek :</label>
                                    <div class="col-md-9">
                                        <input class="form-control" id="nomor" name="Pemohon" type="text"
                                        value="{$DraftRB.NomorProyek}" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="example table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="th-detail">Jenis Barang</th>
                                                <th class="th-detail">Nama Barang</th>
                                                <th class="th-detail">Jumlah</th>
                                                <th class="th-detail">Jumlah Disetujui</th>
                                                <th class="th-detail">Satuan</th>
                                                <th class="th-detail">Spesifikasi Barang</th>
                                                <th class="th-detail">Supplier Lokal</th>
                                                <th class="th-detail">Penawaran</th>
                                                <th class="th-detail">Kode Inventaris</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <% loop $DetailRB %>
                                            <tr>
                                                <td>
                                                    $Jenis.Nama
                                                </td>
                                                <td>
                                                    <input name="nama_barang[$ID]" class="form-control harga-detail" type="text" value="$NamaBarang" autocomplete="off" <% if $Top.mode != 1 %>readonly<% end_if %>>
                                                </td>
                                                <td>
                                                    $Jumlah
                                                    <!-- <input type="hidden" val="jumlah" class="jumlah_total_{$ID}" <% if $Top.mode != 1 %>readonly<% end_if %>> -->
                                                </td>
                                                <td>
                                                    <input name="jumlah_disetujui[$ID]" class="form-control jumlah_total_{$ID} harga-detail" type="text"
                                                    <% if $JumlahDisetujui %>
                                                    value="$JumlahDisetujui"
                                                    <% else %>
                                                    value="$Jumlah"
                                                    <% end_if %>
                                                    autocomplete="off" <% if $Top.mode != 1 %>readonly<% end_if %>>
                                                <td>
                                                    $Satuan.Nama
                                                </td>
                                                <td>
                                                    <textarea name="spesifikasi_barang[$ID]" class="form-control harga-detail" type="text" autocomplete="off" <% if $Top.mode != 1 %>readonly<% end_if %>>$Spesifikasi</textarea>
                                                </td>
                                                <td>
                                                    $Supplier
                                                </td>
                                                <td>
                                                    <% loop $Penawaran %>
                                                    <a class='no-event' href='$AbsoluteURL'
                                                    target='_blank'>$Name</a><br>
                                                    <% end_loop %>
                                                </td>
                                                <td>
                                                    <input name="inventaris_barang[$ID]" class="form-control harga-detail" type="text" value="$KodeInventaris" autocomplete="off" <% if $Top.mode != 1 %>readonly<% end_if %>>
                                                </td>
                                                <td>
                                                    <button
                                                    class="btn btn-primary waves-effect waves-classic btn-xs btn-info view-detail"
                                                    type="button" data-target="#modal-detail_$ID" data-id="$ID"
                                                    data-toggle="modal">
                                                    View Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <% end_loop %>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group form-material row">
                                <label class="col-md-3 col-form-label">Grand Total :</label>
                                <div class="col-md-9">
                                    <input id="grand-total" class="form-control" id="nomor" name="Pemohon"
                                    type="text" value="$RB.Total" readonly autocomplete="off">
                                </div>
                            </div>
                            <% if $mode == 1 %>
                            <div class="table-responsive">
                                <div class="col-md-3">
                                    <button
                                    class="btn btn-block btn-primary waves-effect waves-classic add-detail-penawaran"
                                    type="button">
                                    Add Detail
                                </button>
                            </div>
                            <% end_if %>
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th class="th-detail">Supplier Langganan</th>
                                        <th class="th-detail">Penawaran</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <% if $Top.mode == 1 %>
                                    <tr class="table-row">
                                        <td class="supplier">
                                            <select id="supplier-nama" class="form-control" name="supplier_id_penawaran[]">
                                                <option value="">Pilih Supplier</option>
                                                <% loop $SupplierNama %>
                                                <option value="$ID">$Nama</option>
                                                <% end_loop %>
                                            </select>
                                        </td>
                                        <input type="hidden" name="id_tes[]" class="id_tes" value="0">
                                        <td class="penawaran-file-td">
                                            <!-- <div id="penawaran-file"></div> -->
                                            <div class="penawaran-file-div">
                                                <button class="btn btn-danger penawaran-file-button btn-xs waves-effect waves-classic modal-select2-show waves-effect waves-classic" type="button" disabled="">
                                                    Delete
                                                </button>
                                                <input class="penawaran-file first-only" type="file" name="penawaran_file_0[]">
                                            </div>
                                        </td>
                                        <td class="td-input-file">
                                            <button class="btn btn-danger delete-detail-penawaran btn-xs waves-effect waves-classic modal-select2-show waves-effect waves-classic" type="button">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <% else %>
                                    <% loop $penawaran %>
                                    <tr class="table-row">
                                        <td class="supplier">
                                            <input class="form-control" type="text"
                                            value="{$Supplier.Nama}" readonly autocomplete="off">
                                        </td>
                                        <input type="hidden" name="id_tes[]" class="id_tes" value="0">
                                        <td class="penawaran-file-td">
                                            <!-- <div id="penawaran-file"></div> -->
                                            <!-- <div class="penawaran-file-div"> -->
                                                <% loop $Penawaran %>
                                                <a href="$AbsoluteURL" target="_blank">$Name</a>
                                                <% end_loop %>
                                                <!-- </div> -->
                                            </td>
                                            <td></td>
                                        </tr>
                                        <% end_loop %>
                                        <% end_if %>
                                    </tbody>
                                </table>
                            </div>
                            <% if $mode == 2 %>
                            <div class="form-group form-material row">
                                <label class="col-md-3 col-form-label">Note :</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea id="note-approver" class="form-control" name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-material row">
                                <label class="col-md-3 col-form-label">Respond :</label>
                                <div class="col-md-4">
                                    <div class="radio-custom radio-primary">
                                        <input type="radio" id="RadioApprove" class="radio-respond" name="respond" value="approve" checked="">
                                        <label for="RadioApprove">Approve</label>
                                    </div>
                                    <div class="radio-custom radio-primary">
                                        <input type="radio" id="RadioReject" class="radio-respond" name="respond" value="reject">
                                        <label for="RadioReject">Reject</label>
                                    </div>
                                    <div class="radio-custom radio-primary">
                                        <input type="radio" id="RadioForward" class="radio-respond" name="respond"
                                        value="forward">
                                        <label for="RadioForward">Forward</label>
                                    </div>
                                </div>
                                <div class="col-md-5" id="forward-to" style="display: none">
                                    <label class="col-md-3 col-form-label">Forward To :</label>
                                    <div class="col-md-9">
                                        <select id="select-forward-to" class="form-control" name="user_forward" data-plugin="select2">
                                            <option value="">Pilih Pegawai</option>
                                            <% loop $pegawai %>
                                            <option <% if $Top.ApproveTo == $Pegawai.User().ID %> selected <% end_if %> value="$Pegawai.User().ID">
                                                $Pegawai.Nama</option>
                                            <% end_loop %>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <% end_if %>
                            <% if $mode != 3 %>
                            <div class="form-group form-material row">
                                <div class="col-md-9">
                                    <button id="submit-master" type="button" class="btn-primary btn">Submit</button>
                                </div>
                            </div>
                            <% end_if %>

                            <% loop $Top.DetailRB %>
                            <div id="modal-detail_$ID" class="modal fade example-modal-lg" aria-hidden="true"
                            aria-labelledby="exampleOptionalLarge" role="dialog" tabindex="-1"
                            data-backdrop="static">
                            <div class="modal-dialog modal-simple modal-lg" style="min-height: 100px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close close-modal"
                                        data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleOptionalLarge">Detail Barang</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                         <% if $Top.mode == 1 %>
                                        <div class="col-md-3">
                                            <button class="btn btn-block btn-primary waves-effect waves-classic add-detail" type="button">
                                            Add Detail
                                        </button>
                                    </div>
                                    <% end_if %>
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th class="th-detail">Supplier</th>
                                                <th class="th-detail">Kode Supplier</th>
                                                <th class="th-detail">Jumlah</th>
                                                <th class="th-detail">Harga Satuan</th>
                                                <th class="th-detail">Subtotal</th>
                                                <th class="th-detail">Keterangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <% if $Top.mode == 1 %>
                                            <tr class="table-row">
                                                <td class="supplier">
                                                    <input type="text"
                                                    class="form-control ttreinde-input typeahead supplier-nama"
                                                    placeholder="Supplier" autocomplete="off"
                                                    spellcheck="false" dir="auto"
                                                    style="position: relative; vertical-align: top; background-color: transparent;"
                                                    name="nama_supplier[$ID][]">
                                                </td>
                                                <td>
                                                    <input name="kode_supplier[$ID][]"
                                                    class="form-control supplier-kode" type="text"
                                                    autocomplete="off" readonly>
                                                </td>
                                                <td>
                                                    <input name="jumlah[$ID][]"
                                                    class="form-control jumlah-detail jumlah-detail-{$ID}" type="number"
                                                    value="0" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="harga[$ID][]"
                                                    class="form-control harga-detail" type="number"
                                                    value="0" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="subtotal[$ID][]"
                                                    class="form-control subtotal-detail" type="text"
                                                    autocomplete="off" readonly>
                                                </td>
                                                <td>
                                                    <textarea name="keterangan[$ID][]"
                                                    class="form-control"></textarea>
                                                </td>
                                                <td>
                                                    <button
                                                    class="btn btn-danger delete-row btn-xs waves-effect waves-classic modal-select2-show waves-effect waves-classic"
                                                    type="button">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                            <% else %>
                                            <% loop $DetailRBPerSupplier %>
                                            <tr class="table-row">
                                                <td class="supplier">
                                                    <input name="nama_supplier[$ID][]"
                                                    class="form-control supplier-kode" type="text"
                                                    autocomplete="off" readonly="" value="$NamaSupplier">
                                                </td>
                                                <td>
                                                    <input name="kode_supplier[$ID][]"
                                                    class="form-control supplier-kode" type="text"
                                                    autocomplete="off" readonly="" value="$KodeSupplier">
                                                </td>
                                                <td>
                                                    <input name="jumlah[$ID][]"
                                                    class="form-control jumlah-detail" type="number"
                                                    autocomplete="off" readonly value="$Jumlah">
                                                </td>
                                                <td>
                                                    <input name="harga[$ID][]"
                                                    class="form-control harga-detail" type="number"
                                                    value="$Harga" readonly autocomplete="off">
                                                </td>
                                                <td>
                                                    <input name="subtotal[$ID][]"
                                                    class="form-control subtotal-detail" value="$Total" type="text"
                                                    autocomplete="off" readonly>
                                                </td>
                                                <td>
                                                    <textarea name="keterangan[$ID][]"
                                                    class="form-control" readonly>$Ketrangan</textarea>
                                                </td>
                                                <td>

                                            </td>
                                        </tr>
                                        <% end_loop %>
                                        <% end_if %>
                                        <!-- <tr class="row-total">
                                            <td colspan="4">Jumlah</td>
                                            <td><input name="total"
                                                class="form-control subtotal-akhir" type="text"
                                                value="0" autocomplete="off" readonly></td>
                                                <td></td>
                                                <td></td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <% if $Top.mode == 1 %>
                                <button type="button" class="btn btn-primary close-modal"
                                data-modal="modal-detail_$ID">Save</button>
                                <% end_if %>
                            </div>
                        </div>
                    </div>
                </div>
                <% end_loop %>
            </form>
        </div>
    </div>
    <!-- End Example Horizontal Form -->
</div>
</div>
<% include HistoryApproval %>
</div>
</div>
</div>
<div id="stored-val" data-val='$SupplierList'></div>

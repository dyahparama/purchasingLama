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
                            <form action="/rb/doSubmitRB" method="post">
                                <input class="form-control" name="RBID" type="hidden"
                                            value="{$RB.ID}" readonly autocomplete="off">
                                <div class="form-group form-material row">
                                    <label class="col-md-3 col-form-label">*Kode RB :</label>
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
                                            <input class="form-control" id="tgl-draft" name="tgl-rb"
                                                data-date-format="dd/mm/yyyy" data-now="$dateNow"
                                                value="<% if $dateNow %>$dateNow<% end_if %>" data-plugin="datepicker"
                                                type="text">
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
                                            value="{$DraftRB.Alasan}" readonly autocomplete="off"></textarea>
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
                                                <th>Jenis Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Spesifikasi Barang</th>
                                                <th>Supplier Lokal</th>
                                                <th>Penawaran</th>
                                                <th>Kode Inventaris</th>
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
                                                    $NamaBarang
                                                </td>
                                                <td>
                                                    $Jumlah
                                                    <input type="hidden" val="jumlah" class="jumlah_total_{$ID}">
                                                </td>
                                                <td>
                                                    $Satuan.Nama
                                                </td>
                                                <td>
                                                    $Spesifikasi
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
                                                    $KodeInventaris
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-primary waves-effect waves-classic btn-xs btn-info"
                                                        type="button" data-target="#modal-detail_$ID"
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
                                            type="text" value="" readonly autocomplete="off">
                                    </div>
                                </div>
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
                                            <input type="radio" id="RadioApprove" name="respond" value="approve">
                                            <label for="RadioApprove">Approve</label>
                                        </div>
                                        <div class="radio-custom radio-primary">
                                            <input type="radio" id="RadioReject" name="respond" value="reject">
                                            <label for="RadioReject">Reject</label>
                                        </div>
                                        <div class="radio-custom radio-primary">
                                            <input type="radio" id="RadioForward" name="respond" checked=""
                                                value="forward">
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
                                        <button type="submit" class="btn-primary btn">Submit</button>
                                    </div>
                                </div>

                                <% loop $DetailRB %>
                                <div id="modal-detail_$ID" class="modal fade example-modal-lg" aria-hidden="true"
                                    aria-labelledby="exampleOptionalLarge" role="dialog" tabindex="-1"
                                    data-backdrop="static">
                                    <div class="modal-dialog modal-simple modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleOptionalLarge">Detail Barang</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <div class="col-md-3">
                                                        <button
                                                            class="btn btn-block btn-primary waves-effect waves-classic add-detail"
                                                            type="button">
                                                            Add Detail
                                                        </button>
                                                    </div>
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
                                                            <tr class="table-row">
                                                                <td class="supplier">
                                                                    <input type="text"
                                                                        class="form-control tt-input typeahead supplier-nama"
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
                                                                        class="form-control jumlah-detail" type="number"
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
                                                            <tr class="row-total">
                                                                <td colspan="4">Jumlah</td>
                                                                <td><input name="total"
                                                                        class="form-control subtotal-akhir" type="text"
                                                                        value="0" autocomplete="off" readonly></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary close-modal"
                                                    data-modal="modal-detail_$ID">Save</button>
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
        </div>
    </div>
</div>
<div id="stored-val" data-val='$SupplierList'></div>

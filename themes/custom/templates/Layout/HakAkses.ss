<% include ContentHeader %>
<div class="page-content">
    <%-- panel filter --%>

    <!-- Panel Select 2 -->

    <!-- End Panel Select 2 -->
    <%-- end of panel filter --%>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <select class="form-control" id="jabcab" name="pegawaipercab" data-plugin="select2"
                        data-placeholder="Pilih Group" data-allow-clear="true">
                        <option disabled selected>Pilih Group</option>
                        <% loop $Grup %>
                            <option value="{$ID}">{$Title}</option>
                        <% end_loop %>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Panel Basic -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h3 class="panel-title">Group</h3>
                </div>
                <div class="panel-body">
                    <% loop $Grup %>
                    <div class="radio-custom radio-primary">
                        <input type="radio" id="group_{$ID}" class="radio-group" name="inputRadios" value="$ID">
                        <label for="group_{$ID}">$Title</label>
                    </div>
                    <% end_loop %>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h3 class="panel-title">Group - Akses</h3>
                </div>
                <div class="panel-body">
                    <div class="dd">
                        <ol class="dd-list">
                            <% loop $KodeAkses %>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">$Label</div>
                                <ol class="dd-list">
                                    <% loop $Data %>
                                    <li class="dd-item" data-id="4">
                                        <div class="checkbox-custom checkbox-primary">
                                            <input type="checkbox" class="checkbox-akses" id="val{$Kode}"
                                                name="{$Kode}">
                                            <label for="inputChecked">$Label</label>
                                        </div>
                                    </li>
                                    <% end_loop %>
                                </ol>
                            </li>
                            <% end_loop %>
                        </ol>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn-primary btn waves-effect waves-classic" id="simpan-akses">Simpan</button>
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
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
                <div class="example">
                    <div class="form-group form-material row">
                        <label class="col-md-3 col-form-label">Jenis Barang :</label>
                        <div class="col-md-9">
                            <select class="form-control select2-modal" data-plugin="select2">
                                <option>Pilih Jenis Barang</option>
                                <% loop $jenisBrng %>
                                <option value="$ID">{$Nama}</option>
                                <% end_loop %>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-material row">
                        <label class="col-md-3 col-form-label">Jumlah :</label>
                        <div class="col-md-9">
                            <input class="form-control" type="number" value="0" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-material row">
                        <label class="col-md-3 col-form-label">Satuan :</label>
                        <div class="col-md-9">
                            <select class="form-control select2-modal" data-plugin="select2">
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
                            <input class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-material row">
                        <label class="col-md-3 col-form-label">Penawaran :</label>
                        <div class="col-md-9">

                        </div>
                    </div>
                    <form action="/file-upload" class="dropzone" id="penawaran"></form>
                    <div class="form-group form-material row">
                        <label class="col-md-3 col-form-label">Spesifikasi Barang :</label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-material row">
                        <label class="col-md-3 col-form-label">Kode Inventaris :</label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-fade-in-scale-up" id="printPO" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
                <div class="example">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Print Tanpa Termin</button>
                <button type="button" class="btn btn-primary">Print Dengan Termin</button>
            </div>
        </div>
    </div>
</div>


<div class="page-content">
  <div class="panel">
    <div class="panel-body container-fluid">
      <!-- <div class="row"> -->
      <!-- <div class="col-lg-3"> -->
        <!-- Page Widget -->
        <!-- <div class="card card-shadow text-center">
          <div class="card-block">
            <a class="avatar avatar-lg" href="javascript:void(0)">
              <img src="../../../global/portraits/5.jpg" alt="...">
            </a>
            <h4 class="profile-user">$pegawai.Nama</h4>
          </div>
        </div> -->
        <!-- End Page Widget -->
      <!-- </div> -->

      <div class="col-lg-12">
        <!-- Panel -->
        <div class="panel">
          <div class="panel-body nav-tabs-animate nav-tabs-horizontal" data-plugin="tabs">
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
              <li class="nav-item" role="presentation"><a class="active nav-link" data-toggle="tab" href="#profile" aria-controls="profile"
                  role="tab">Profile</a></li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane active animation-slide-left" id="profile" role="tabpanel">
                <form id="form-profile">
                  <div class="form-group form-material row">
                    <label class="col-md-3 col-form-label">Nama :</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <input type="hidden" name="ID" name="ID" value="$pegawai.ID">
                        <input type="text" name="Nama" id="Nama" class="form-control" value="$pegawai.Nama">
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-material row">
                    <label class="col-md-3 col-form-label">Alamat :</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <textarea id="Alamat" name="Alamat" class="form-control">$pegawai.Alamat</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-material row">
                    <label class="col-md-3 col-form-label">Tempat Lahir :</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <input type="text" name="TempatLahir" id="TempatLahir" class="form-control" value="$pegawai.TempatLahir">
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-material row">
                    <label class="col-md-3 col-form-label">Tanggal Lahir :</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <input class="form-control" id="TglLahir" name="TglLahir"
                          data-date-format="dd/mm/yyyy"
                          value="$pegawai.TglLahir.format(d/M/Y)" data-plugin="datepicker"
                          type="text">
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-material row">
                    <label class="col-md-3 col-form-label">No Telefon :</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <input  type="number" name="NoTelp" id="NoTelp" class="form-control" value="$pegawai.NoTelp">
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-material row">
                    <label class="col-md-3 col-form-label">No WA :</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <input required type="number" name="NoWa" id="NoWa" class="form-control" value="$pegawai.NoWa">
                      </div>
                    </div>
                  </div>
                  <div style="float: right;">
                    <button type="button" id="save-detail-profile" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Panel -->
      </div>
    </div>
    </div>
  </div>
</div>
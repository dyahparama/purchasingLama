$("#penawaran").dropzone({
    autoProcessQueue: false,
    parallelUploads: 10,
    addRemoveLinks: true,
    // renameFile:function(fileName){
    //   return new Date().getTime();
    // }
});
let baseURL=$("#baseURL").data("url");
$(document).ready(function() {
    let dateNow = $("#tgl-draft").data("now");
    $("#tgl-draft").datepicker({ format: "dd/mm/yy" });

    $("#tgl-draft").datepicker("setDate", dateNow);

    $(".jabatan-cabang").change(function(e) {
        let id = $(this).val();
        $.ajax({
            url: baseURL+"draf-rb/GetKepalaCabang",
            type: "post", //form method
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {},
            success: function(result) {
                $("#kepala-cabang").val(result);
            },
            complete: function(result) {},
            error: function(xhr, Status, err) {}
        });
    });

    $("#add-detail").click(function(e) {
        let drbID = $("#draf-rb-id").data("id");
        let pass = true;
        let data = $("#form-drb").serializeArray();
        data.forEach(element => {
            if ((element.value == "" && element.name != "note") && (element.value == "" &&  element.name != "nomor-proyek")) {
                pass = false;
            }
        });
        data[0].value = drbID;
        console.log(data);
        if (pass) {
            $("#exampleNiftyFadeScale").modal("show");
            $(".select2-container").addClass("z-index-1");
            $(".select2-modal")
                .next()
                .removeClass("z-index-1");
            $(".select2-modal")
                .next()
                .css("width", "100%");
            $.ajax({
                url: baseURL+"draf-rb/saveMasterDRB",
                type: "post", //form method
                data: data,
                dataType: "json",
                beforeSend: function() {},
                success: function(result) {},
                complete: function(result) {},
                error: function(xhr, Status, err) {}
            });
        } else {
            alert("data belum lengkap");
        }
    });
    $(".close-modal").click(function(e) {
        setTimeout(() => {
            $(".select2-container").removeClass("z-index-1");
        }, 500);
    });

    $("#save-detail").click(function(e) {
        let pass = true;
        let data2 = $("#form-modal-add-detail").serializeArray();
        console.log(data2);
        data2.forEach(element => {
            if (element.value == "") {
                pass = false;
            }
        });
        if (pass) {
            let data = {
                "jenis-brg": $("#jenis-brg").val(),
                "deskripsi-kebutuhan": $("#deskripsi-kebutuhan").val(),
                jumlah: $("#jumlah").val(),
                satuan: $("#satuan").val(),
                "supplier-lokal": $("#supplier-lokal").val(),
                spesifikasi: $("#spesifikasi").val(),
                "kode-inventaris": $("#kode-inventaris").val(),
                nomor: $("#draf-rb-id").data("id"),
            };
            let newId;
            $.ajax({
                url: baseURL+"draf-rb/saveDetailDRB",
                type: "post", //form method
                data: data,
                dataType: "json",
                beforeSend: function() {
                    $('#save-detail').attr('disabled',true);
                },
                success: function(result) {
                    newId = result;
                     if ($(".dz-details").length==0) {
                        location.reload();
                    }
                },
                complete: function(result) {
                    Dropzone.forElement("#penawaran").on("sending", function(
                        file,
                        xhr,
                        formData
                    ) {
                        formData.append("id", newId);
                    });
                    Dropzone.forElement("#penawaran").processQueue();

                    
                    Dropzone.forElement("#penawaran").on(
                        "queuecomplete",
                        function(file) {
                            location.reload();
                        }
                    );

                },
                error: function(xhr, Status, err) {}
            });

        } else {
            alert("data belum lengkap");
        }
    });
    $("#forwardTo").click(function(e) {
        var elem = $(this).prop('disabled', true);
        if ($(".data-detail").length) {
            let data = {
                kode: $("#draf-rb-id").data("id"),
                note:$("#note-master").val()
            };
            $.ajax({
                url: baseURL+"draf-rb/forwardTo",
                type: "post", //form method
                data: data,
                dataType: "json",
                beforeSend: function() {},
                success: function(result) {
                        window.location.href = baseURL+"list-drb/index/Me";
                },
                complete: function(result) {
                        window.location.href = baseURL+"list-drb/index/Me";  
                    // window.location.href = baseURL+"list-drb/index/Me";
                    //location.reload();
                },
                error: function(xhr, Status, err) {}
            });
        } else {
            alert("detail belum diisi");
        }
    });
    $(".delete-detail").click(function(e) {
        let id = $(this).data("id");
        $.ajax({
            url: baseURL+"draf-rb/deleteDetail",
            type: "post", //form method
            data: { id },
            dataType: "json",
            beforeSend: function() {},
            success: function(result) {
                location.reload();
            },
            complete: function(result) {
                location.reload();
            },
            error: function(xhr, Status, err) {}
        });
    });

    $(".modal-select2-show").click(function(e) {
        $(".select2-container").addClass("z-index-1");
        $(".select2-modal")
            .next()
            .removeClass("z-index-1");
        $(".select2-modal")
            .next()
            .css("width", "100%");
    });

    $(".update-detail").click(function(e) {
        let id = $(this).data("id");
        let data = {
            "jenis-brg": $("#jenis-brg-" + id).val(),
            "deskripsi-kebutuhan": $("#deskripsi-kebutuhan-" + id).val(),
            jumlah: $("#jumlah-" + id).val(),
            satuan: $("#satuan-" + id).val(),
            "supplier-lokal": $("#supplier-lokal-" + id).val(),
            spesifikasi: $("#spesifikasi-" + id).val(),
            "kode-inventaris": $("#kode-inventaris-" + id).val(),
            id: id
        };
        $.ajax({
            url: baseURL+"draf-rb/updateDetail",
            type: "post", //form method
            data: data,
            dataType: "json",
            beforeSend: function() {},
            success: function(result) {
                location.reload();
            },
            complete: function(result) {
                location.reload();
            },
            error: function(xhr, Status, err) {}
        });
    });
    $("#load-draft").click(function(e) {
        if (!isNaN($("#draft-lama").val())) {
            $.ajax({
                url: baseURL+"draf-rb/loadDraft",
                type: "post", //form method
                data: {
                    id: $("#draft-lama").val(),
                    idNow:$("#draf-rb-id").data("id")
                },
                dataType: "json",
                beforeSend: function() {},
                success: function(result) {
                   location.reload();
                },
                complete: function(result) {
                   location.reload();
                },
                error: function(xhr, Status, err) {}
            });
        }
    });

    $("input[type=radio][name=respond]").change(function() {
        if (this.value == "forward") {
            $("#forward-to").show();
        } else {
            $("#forward-to").hide();
        }
    });

    $("#approve-forwardTo")
        .unbind("click")
        .click(function(e) {
            let data = {
                note: $("#note-approver").val(),
                respond: $("input[name='respond']:checked").val(),
                forward: $("#select-forward-to").val(),
                from: $("#user-now").val(),
                draft: $("#nomor").val()
            };
            
            if (data.respond == 'forward' && data.forward=="") {
                alert("Masukan tujuan Forward To !");
            }else{
                $.ajax({
                    url: baseURL+"draf-rb/approve",
                    type: "post", //form method
                    data: data,
                    dataType: "json",
                    beforeSend: function() {},
                    success: function(result) {
                        alert('Berhasil simpan')
                        window.location.href = baseURL+"ta";
                    },
                    complete: function(result) {
                        window.location.href = baseURL+"ta";
    
                    },
                    error: function(xhr, Status, err) {}
                });
            }
           
        });
        $("#clear-data").click(function (e) { 
            let nomor = $("#draf-rb-id").data("id");
            data = {
                nomor:nomor
            };
            $.ajax({
                url: baseURL+"draf-rb/clearData",
                type: "post", //form method
                data: data,
                dataType: "json",
                beforeSend: function() {},
                success: function(result) {
                    location.reload();
                },
                complete: function(result) {
                    location.reload();
                },
                error: function(xhr, Status, err) {}
            });

        });
});

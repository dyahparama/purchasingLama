<?php

class AccessCode {
    // static $departemenCreate = "Departemen_Create";
    // static $departemenRead = "Departemen_Read";
    // static $departemenUpdate = "Departemen_Update";
    // static $departemenDelete = "Departemen_Delete";

    // static $jabatanCreate = "Jabatan_Create";
    // static $jabatanRead = "Jabatan_Read";
    // static $jabatanUpdate = "Jabatan_Update";
    // static $jabatanDelete = "Jabatan_Delete";

    // static $jenisbarangCreate = "JenisBarang_Create";
    // static $jenisbarangRead = "JenisBarang_Read";
    // static $jenisbarangUpdate = "JenisBarang_Update";
    // static $jenisbarangDelete = "JenisBarang_Delete";

    // static $satuanCreate = "Satuan_Create";
    // static $satuanRead = "Satuan_Read";
    // static $satuanUpdate = "Satuan_Update";
    // static $satuanDelete = "Satuan_Delete";

    // static $staffCreate = "Staff_Create";
    // static $staffRead = "Staff_Read";
    // static $staffUpdate = "Staff_Update";
    // static $staffDelete = "Staff_Delete";

    // static $settingAccess = "Setting_Access";

    // static $aksesArray = [
    //     array(
    //         'Kode' => 'Kode'
    //     )
    // ]

    static $akses = [
        'Departemen' => [
            'label' => 'Departemen',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'Struktur Cabang' => [
            'label' => 'Cabang',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'Jabatan' => [
            'label' => 'Jabatan',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'JenisBarang' => [
            'label' => 'Jenis',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'Satuan' => [
            'label' => 'Satuan',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'Staff' => [
            'label' => 'Staff',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'Satuan' => [
            'label' => 'Satuan',
            'akses' => ['Create', 'Read', 'Update', 'Delete']
        ],
        'Setting' => [
            'label' => 'Setting',
            'akses' => ['Akses']
        ]
    ];
}

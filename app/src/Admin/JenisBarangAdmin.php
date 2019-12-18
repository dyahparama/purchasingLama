<?php
use SilverStripe\Admin\ModelAdmin;

class JenisBarangAdmin extends ModelAdmin 
{

    private static $managed_models = [
        'JenisBarang'
    ];

    private static $url_segment = 'jenis-barang';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Jenis Barang';

    public function getList() 
    {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        // if($this->modelClass == 'StaffModel') {
        //     $list = $list->exclude('Nama', 'Zemmuwa');
        // }

        return $list;
    }
}
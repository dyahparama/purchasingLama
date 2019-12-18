<?php
use SilverStripe\Admin\ModelAdmin;

class StrukturCabangAdmin extends ModelAdmin
{

    private static $managed_models = [
        'StrukturCabang'
    ];

    private static $url_segment = 'struktur-cabang';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Struktur Cabang';

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

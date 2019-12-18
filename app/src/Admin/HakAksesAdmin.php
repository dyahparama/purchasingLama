<?php
use SilverStripe\Admin\ModelAdmin;

class HakAksesAdmin extends ModelAdmin 
{

    private static $managed_models = [
        'HakAkses'
    ];

    private static $url_segment = 'hak-akses';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Hak Akses';

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
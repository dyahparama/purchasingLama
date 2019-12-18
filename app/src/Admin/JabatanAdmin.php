<?php
use SilverStripe\Admin\ModelAdmin;

class JabatanAdmin extends ModelAdmin 
{

    private static $managed_models = [
        'Jabatan'
    ];

    private static $url_segment = 'jabatan';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Jabatan';

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
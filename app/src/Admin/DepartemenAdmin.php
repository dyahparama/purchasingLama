<?php
use SilverStripe\Admin\ModelAdmin;

class DepartemenAdmin extends ModelAdmin 
{

    private static $managed_models = [
        'Departemen'
    ];

    private static $url_segment = 'departemen';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Departemen';

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
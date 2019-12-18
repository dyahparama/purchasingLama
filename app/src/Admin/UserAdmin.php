<?php
use SilverStripe\Admin\ModelAdmin;

class UserAdmin extends ModelAdmin 
{

    private static $managed_models = [
        'User'
    ];

    private static $url_segment = 'user';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'User';

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
<?php
use SilverStripe\Admin\ModelAdmin;

class SupplierAdmin extends ModelAdmin
{

    private static $managed_models = [
        'Supplier'
    ];

    private static $url_segment = 'Supplier';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Supplier';

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

<?php

namespace SilverStripe\Admin;
use SilverStripe\Admin\ModelAdmin;

class EditApproverAdmin extends ModelAdmin
{

    private static $managed_models = [
        'StrukturCabang',
        'JenisBarang'
    ];

    private static $url_segment = 'edit-approver';
    private static $menu_icon_class = 'font-icon-tree';
    private static $menu_title = 'Tes';

    public function getList()
    {
        $list = parent::getList();


        return $list;
    }
}

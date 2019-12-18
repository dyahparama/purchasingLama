<?php
namespace Extensions;
use SilverStripe\Admin\CMSMenu;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridFieldImportButton;
use SilverStripe\Core\Extension;
use SilverStripe\CampaignAdmin\CampaignAdmin;
use SilverStripe\CMS\Controllers\CMSPagesController;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;
use SilverStripe\Reports\ReportAdmin;
use SilverStripe\Admin\SecurityAdmin;
use SilverStripe\VersionedAdmin\ArchiveAdmin;
use SilverStripe\Admin\EditApproverAdmin;

class LeftAndMainExtension extends Extension {
    static $model_importers = array();

     function init()
    {
        CMSMenu::remove_menu_class(CampaignAdmin::class);
        CMSMenu::remove_menu_class(CMSPagesController::class);
        CMSMenu::remove_menu_class(AssetAdmin::class);
        CMSMenu::remove_menu_class(ReportAdmin::class);
        CMSMenu::remove_menu_class(SecurityAdmin::class);
        CMSMenu::remove_menu_class(ArchiveAdmin::class);
        CMSMenu::remove_menu_class(EditApproverAdmin::class);
    }
}









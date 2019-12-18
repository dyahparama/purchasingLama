<?php
namespace Extensions;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class SettingExtension extends DataExtension 
{
    public function updateCMSFields(FieldList $fields){
       $fields->removeByName("Access");
        return $fields;
      }
}
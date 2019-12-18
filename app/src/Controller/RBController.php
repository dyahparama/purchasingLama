<?php

use SilverStripe\Assets\Upload;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DB;


class RBController extends PageController
{
    public function index(HTTPRequest $request) {
        Requirements::themedCSS('custom');
        $data = array("aaa" => "Aaaa");
        return $this->customise($data)
                ->renderWith(array(
                    'RBPage', 'Page',
                ));
    }
}

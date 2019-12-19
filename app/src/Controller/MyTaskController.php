<?php
	use SilverStripe\Assets\Upload;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\DB;


	class MyTaskController extends PageController
	{
	    private static $allowed_actions = ['getData'];

	    public function index(HTTPRequest $request)
	    {
            Requirements::themedCSS('custom');
	            $data = array(
	                "RB" => DraftRB::get()
	            );
	            return $this->customise($data)
	                ->renderWith(array(
	                    'MyTask', 'Page',
	                ));
	    }
	   
	}

<?php
	use SilverStripe\Assets\Upload;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\DB;


	class RejectedController extends PageController
	{
	    private static $allowed_actions = [
	        "rjme",
	        "rjteam",
    	];

	    public function index(HTTPRequest $request)
	    {
            Requirements::themedCSS('custom');
            if (!UserController::cekSession()) {
	            return $this->redirect(Director::absoluteBaseURL() . "user/login");
	        } else {
	           
	        }
            $data = array(
                "RB" => DraftRB::get()
            );
            return $this->customise($data)
                ->renderWith(array(
                    'MyTask', 'Page',
                ));
	    }

	    public function rjme(HTTPRequest $request)
	    {
	        Requirements::themedCSS('custom');
	        if (!UserController::cekSession()) {
	            return $this->redirect(Director::absoluteBaseURL() . "user/login");
	        } else {
	           
	        }
	        $data = [];
	        return $this->customise($data)
	            ->renderWith(array(
	                'RejectedMe', 'Page',
	            ));
	        return $this->redirect(Director::absoluteBaseURL());
	    }

	    public function rjteam(HTTPRequest $request)
	    {
	        Requirements::themedCSS('custom');
	        if (!UserController::cekSession()) {
	            return $this->redirect(Director::absoluteBaseURL() . "user/login");
	        } else {
	           
	        }
	        $data = [];
	        return $this->customise($data)
	            ->renderWith(array(
	                'RejectedTeam', 'Page',
	            ));
	        return $this->redirect(Director::absoluteBaseURL());
	    }
	   
	}

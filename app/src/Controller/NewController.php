<?php
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\Controller;
	use SilverStripe\Dev\Debug;
	use SilverStripe\ORM\DB;

	class NewController extends PageController
	{
		private $has_one = [
			'tutup_po'
		];

		public function tutup_po(HTTPRequest $request)
		{
			$id = $request->param('ID');

			return $id;
			// $po =
		}
	}
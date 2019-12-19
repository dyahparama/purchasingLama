<?php
	use SilverStripe\Assets\Upload;
	use SilverStripe\Control\Director;
	use SilverStripe\Control\HTTPRequest;
	use SilverStripe\ORM\ArrayList;
	use SilverStripe\View\Requirements;
	use SilverStripe\ORM\DB;


	class ProfileController extends PageController
	{
	    private static $allowed_actions = ['SimpanProfil'];

	    public function index(HTTPRequest $request)
	    {
	    	if(isset($_SESSION['user_id'])){
	    		$idnya = $_SESSION['user_id'];
	    	}
	    	$pegawainya = User::get()->byID($idnya)->Pegawai();
            Requirements::themedCSS('custom');
            $data = array(
                "pegawai" => $pegawainya,
                "mgeJS" =>"profile"
            );
            return $this->customise($data)
                ->renderWith(array(
                    'Profile', 'Page',
                ));
	    }

	    public function SimpanProfil()
	    {
	        $pegawai = pegawai::get()->byID($_POST['ID']);
	        $pegawai->Nama = $_POST['Nama'];
	        $pegawai->Alamat = $_POST['Alamat'];
	        $pegawai->TempatLahir = $_POST['TempatLahir'];
	        $pegawai->TglLahir = $this->dateFormat($_POST["TglLahir"], "/", "-");
	        $pegawai->NoTelp = $_POST['NoTelp'];
	        $pegawai->NoWa = $_POST['NoWa'];
	        $pegawai->write();
	        echo json_encode($pegawai->ID);
	    }
	   
	}

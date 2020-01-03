<?php

class HelperController extends PageController
{
    private static $allowed_actions = [
        'ajaxPusat',
        'sendApproveTo',
        'sendApproveFrom',
        'ApprovalRB',
        'EmailApprovedRB',
        'EmailGeneratePO',
        'EmailGenerateYourPO',
        'EmailRejectDRB',
        'EmailRejectedDRB',
        'EmailForwardDRB'
    ];

    public function ajaxPusat()
    {
        if (isset($_REQUEST['regional']) && $_REQUEST['regional'] != "") {
            $val = StrukturCabang::get()->byID($_REQUEST['regional']);
            return json_encode(array(
                'id' => $val->PusatID,
                'nama' => $val->Pusat()->Nama,
            ));
        }
    }
    public function sendApproveTo()
    {
        $ID = 53;
        $DRB = DraftRB::get()->byID($ID);
        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        $data = [
            "DRB" => $DRB,
            "Link" => $this->getBaseURL() . "draf-rb/ApprovePage/" . $ID,
            "Jabatan" => $this->getJabatanFromStatus($DRB->Status()->ID + 1),
        ];
        echo ($this->customise($data)->renderWith('EmailApproveDRB'));
        die;
        $template = ["EmailApproveDRB"];
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function sendApproveFrom()
    {
        $ID = 53;
        $DRB = DraftRB::get()->byID($ID);
        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        $Approver = 10;
        $data = [
            "DRB" => $DRB,
            "Link" => $this->getBaseURL() . "draf-rb/ApprovePage/" . $ID,
            "From" => User::get()->byID($Approver)->Pegawai()->Nama,
        ];
        echo ($this->customise($data)->renderWith('EmailApprovedDRB'));
        die;
        $template = ["EmailApproveDRB"];
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function ApprovalRB()
    {
        $ID = 10;
        $RB = RB::get()->byID($ID);
        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        $Approver = 10;
        $data = [
            "RB" => $RB,
            "Link" => $this->getBaseURL() . "rb/ApprovePage/" . $ID,
            "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            "Jabatan" => $this->getJabatanFromStatus($RB->DraftRB()->Status()->ID + 1),
        ];
        echo ($this->customise($data)->renderWith('EmailApprovalRB'));
        die;
        $template = ["EmailApproveDRB"];
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function EmailApprovedRB()
    {
        $ID = 10;
        $RB = RB::get()->byID($ID);
        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        $Approver = 10;
        $data = [
            "RB" => $RB,
            "Link" => $this->getBaseURL() . "rb/ApprovePage/" . $ID,
            "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            "Jabatan" => $this->getJabatanFromStatus($RB->DraftRB()->Status()->ID + 1),
        ];
        echo ($this->customise($data)->renderWith('EmailApproved-RB'));
        die;
        $template = ["EmailApproveDRB"];
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function EmailGeneratePO()
    {
        $ID = 10;
        $RB = RB::get()->byID($ID);
        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        $Approver = 10;
        $data = [
            "RB" => $RB,
            "Link" => $this->getBaseURL() . "po/ApprovePage/" . $ID,
            "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            "Jabatan" => $this->getJabatanFromStatus($RB->DraftRB()->Status()->ID + 1),
        ];
        echo ($this->customise($data)->renderWith('EmailGeneratePO'));
        die;
        $template = ["EmailApproveDRB"];
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function EmailGenerateYourPO()
    {
        $ID = 10;
        $PO = PO::get()->byID($ID);
        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        $Approver = 10;
        $data = [
            "PO" => $PO,
            "Link" => $this->getBaseURL() . "po/view/" . $ID,
            "From" => User::get()->byID($Approver)->Pegawai()->Nama,
        ];
        echo ($this->customise($data)->renderWith('EmailGenerateYourPO'));
        die;
        $template = ["EmailApproveDRB"];
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function EmailRejectDRB($param2)
    {
        $param = "rb";
        $ID = 10;
        $Approver = 20;
        if ($param == "drb") {
            $DRB = DraftRB::get()->byID($ID);
            $data = [
                "DRB" => $DRB,
                "Link" => $this->getBaseURL() . "draft-rb/ApprovePage/" . $ID,
                "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            ];
            echo ($this->customise($data)->renderWith('EmailRejectDRB'));
            die;
            $template = ["EmailRejectDRB"];
        } else {
            $RB = RB::get()->byID($ID);
            $data = [
                "RB" => $RB,
                "Link" => $this->getBaseURL() . "rb/ApprovePage/" . $ID,
                "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            ];
            echo ($this->customise($data)->renderWith('EmailRejectRB'));
            die;
            $template = ["EmailRejectDRB"];
        }

        $to = "neo.spacians@gmail.com";
        $subject = "urgent";

        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function EmailRejectedDRB()
    {
        $param = "rb";
        $ID = 10;
        $Approver = 20;
        if ($param == "drb") {
            $DRB = DraftRB::get()->byID($ID);
            $data = [
                "DRB" => $DRB,
                "Link" => $this->getBaseURL() . "draft-rb/ApprovePage/" . $ID,
                "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            ];
            echo ($this->customise($data)->renderWith('EmailRejectedDRB'));
            die;
            $template = ["EmailRejectDRB"];
        } else {
            $RB = RB::get()->byID($ID);
            $data = [
                "RB" => $RB,
                "Link" => $this->getBaseURL() . "rb/ApprovePage/" . $ID,
                "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            ];
            echo ($this->customise($data)->renderWith('EmailRejectedRB'));
            die;
            $template = ["EmailRejectDRB"];
        }

        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }

    public function EmailForwardDRB()
    {
        $param = "rb";
        $ID = 10;
        $Approver = 20;
        if ($param == "drb") {
            $DRB = DraftRB::get()->byID($ID);
            $data = [
                "DRB" => $DRB,
                "Link" => $this->getBaseURL() . "draft-rb/ApprovePage/" . $ID,
                "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            ];
            echo ($this->customise($data)->renderWith('EmailForwardDRB'));
            die;
            $template = ["EmailRejectDRB"];
        } else {
            $RB = RB::get()->byID($ID);
            $data = [
                "RB" => $RB,
                "Link" => $this->getBaseURL() . "rb/ApprovePage/" . $ID,
                "From" => User::get()->byID($Approver)->Pegawai()->Nama,
            ];
            echo ($this->customise($data)->renderWith('EmailForwardRB'));
            die;
            $template = ["EmailRejectDRB"];
        }

        $to = "neo.spacians@gmail.com";
        $subject = "urgent";
        AddOn::sendEmailSMTP($to, $subject, $data, $template);
    }
}

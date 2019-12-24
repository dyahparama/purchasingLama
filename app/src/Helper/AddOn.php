<?php

use SilverStripe\Core\Config\Config;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\View\SSViewer;
use SilverStripe\View\ViewableData;
use SilverStripe\Control\Director;

class AddOn
{
    public static function convertDate($date, $format = 'Y-m-d')
    {
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        return $date;
    }
    /**
     * Convert obj to Array
     */
    public static function createKode($model, $prefix)
    {
        $data = $model::get()->last();
        $id = 1;
        if ($data) {
            $id = $data->ID + 1;
        }
        $count = strlen($id);
        $kode = "";
        for ($i = $count; $i < 5; $i++) {
            $kode .= "0";
        }
        $kode = $prefix . "-" . $kode . $id;
        return $kode;
        // while ($count < 5) {
        //     $kode = "0";
        // }
        // $kode = $prefix.$kode.$id;
        // return $kode;
    }

    public static function objToArray($obj, &$arr)
    {
        if (!is_object($obj) && !is_array($obj)) {
            $arr = $obj;
            return $arr;
        }

        foreach ($obj as $key => $value) {
            if (!empty($value)) {
                $arr[$key] = array();
                objToArray($value, $arr[$key]);
            } else {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }

    public static function getSpecColumn($arr = [], $col = '')
    {
        $temp = array_column($arr, $col);
        return $temp;
    }

    public static function convertDateToDatabase($string)
    {
        $arr = explode("/", $string);

        return $arr[2] . "-" . $arr[1] . "-" . $arr[0];
    }

    public static function groupBySum($data, $object, $sum, $display = null)
    {
        $arr = array();
        foreach ($data as $val) {
            $index = $val->$object;
            $arr[$index]['Key'] = $index;
            if ($display) {
                $display = array_merge($sum, $display);
            } else {
                $display = $sum;
            }
            $display = array_unique($display);

            foreach ($display as $val2) {
                if ($val2 != "Key") {
                    if (in_array($val2, $sum)) {
                        if (array_key_exists($val2, $arr[$val->$object])) {
                            $arr[$index][$val2] +=  $val->$val2;
                        } else {
                            $arr[$index][$val2] =  $val->$val2;
                        }
                    } else {
                        if (strpos($val2, '.')) {
                            $strArr = explode('.', $val2);
                            $tempVal = $val;
                            for ($i = 1; $i <= count($strArr); $i++) {
                                if ($i < count($strArr)) {
                                    $tempVal = $tempVal->{$strArr[$i - 1]}();
                                } else {
                                    $tempVal = $tempVal->{$strArr[$i - 1]};
                                }
                            }
                            $arr[$index][str_replace(".", "_", $val2)] = $tempVal;
                        } else {
                            $arr[$index][$val2] = $val->$val2;
                        }
                    }
                }
            }
        }
        return $arr;
    }

    public static function getOneField($data, $column)
    {
        $arr = array();
        foreach ($data as $val) {
            $arr[] = $val->$column;
        }
        return $arr;
    }

    public static function groupConcat($data = [], $colNameRelation = '', $sep = ', ', $isUnique = FALSE)
    {
        $arr = [];
        foreach ($data as $row) {
            // $tolool = $colNameRelation;
            // var_dump($tolool);
            // echo $row->$tolool . "</br>";
            // // var_dump($row->{$colNameRelation});
            // $temp_arr[] = $row->$colNameRelation;
            if (strpos($colNameRelation, '.')) {
                $strArr = explode('.', $colNameRelation);
                $tempVal = $row;
                for ($i = 1; $i <= count($strArr); $i++) {
                    if ($i < count($strArr)) {
                        $tempVal = $tempVal->{$strArr[$i - 1]}();
                    } else {
                        $tempVal = $tempVal->{$strArr[$i - 1]};
                    }
                }
                $arr[] = $tempVal;
            } else {
                $arr[] = $row->$colNameRelation;
            }
        }
        if ($isUnique)
            $arr = array_keys(array_flip($arr));
        
        return implode($sep, $arr);
    }

    public static function convertObjToArray($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    public static function sendEmailSMTP($to, $subject, $arr_data = array(), $arr_template = array(), $cc = "", $bcc = "", $reply_to = "", $attachment = array(), $attachmenturl = array())
    {
        SSViewer::set_themes(Config::inst()->get('SSViewer', 'theme'));

        $siteconfig = SiteConfig::current_site_config();
        $v = new ViewableData();
        $content = $v->renderWith($arr_template, $arr_data);
        $content = $content->value;

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($siteconfig->email_from, $siteconfig->email_from_name);
        $email->setSubject($subject);
        $email->addTo($to, $to);
        $email->addContent(
            "text/html",
            $content
        );

        $sendgrid = new \SendGrid($siteconfig->sendgrid_apikey);
        try {
            $response = $sendgrid->send($email);
            $data = [
                'statuscode' => $response->statusCode(),
                'headers' => $response->headers(),
                'body' => $response->body(),
                'to' => $to,
                'content' => $content,
            ];
        } catch (Exception $e) {
            $data = [
                'to' => $to,
                'content' => $content,
                'message' => $e->getMessage(),
            ];
        }

        return $data;
    }

    public static function mime2ext($mime)
    {
        $mime_map = [
            'video/3gpp2' => '3g2',
            'video/3gp' => '3gp',
            'video/3gpp' => '3gp',
            'application/x-compressed' => '7zip',
            'audio/x-acc' => 'aac',
            'audio/ac3' => 'ac3',
            'application/postscript' => 'ai',
            'audio/x-aiff' => 'aif',
            'audio/aiff' => 'aif',
            'audio/x-au' => 'au',
            'video/x-msvideo' => 'avi',
            'video/msvideo' => 'avi',
            'video/avi' => 'avi',
            'application/x-troff-msvideo' => 'avi',
            'application/macbinary' => 'bin',
            'application/mac-binary' => 'bin',
            'application/x-binary' => 'bin',
            'application/x-macbinary' => 'bin',
            'image/bmp' => 'bmp',
            'image/x-bmp' => 'bmp',
            'image/x-bitmap' => 'bmp',
            'image/x-xbitmap' => 'bmp',
            'image/x-win-bitmap' => 'bmp',
            'image/x-windows-bmp' => 'bmp',
            'image/ms-bmp' => 'bmp',
            'image/x-ms-bmp' => 'bmp',
            'application/bmp' => 'bmp',
            'application/x-bmp' => 'bmp',
            'application/x-win-bitmap' => 'bmp',
            'application/cdr' => 'cdr',
            'application/coreldraw' => 'cdr',
            'application/x-cdr' => 'cdr',
            'application/x-coreldraw' => 'cdr',
            'image/cdr' => 'cdr',
            'image/x-cdr' => 'cdr',
            'zz-application/zz-winassoc-cdr' => 'cdr',
            'application/mac-compactpro' => 'cpt',
            'application/pkix-crl' => 'crl',
            'application/pkcs-crl' => 'crl',
            'application/x-x509-ca-cert' => 'crt',
            'application/pkix-cert' => 'crt',
            'text/css' => 'css',
            'text/x-comma-separated-values' => 'csv',
            'text/comma-separated-values' => 'csv',
            'application/vnd.msexcel' => 'csv',
            'application/x-director' => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/x-dvi' => 'dvi',
            'message/rfc822' => 'eml',
            'application/x-msdownload' => 'exe',
            'video/x-f4v' => 'f4v',
            'audio/x-flac' => 'flac',
            'video/x-flv' => 'flv',
            'image/gif' => 'gif',
            'application/gpg-keys' => 'gpg',
            'application/x-gtar' => 'gtar',
            'application/x-gzip' => 'gzip',
            'application/mac-binhex40' => 'hqx',
            'application/mac-binhex' => 'hqx',
            'application/x-binhex40' => 'hqx',
            'application/x-mac-binhex40' => 'hqx',
            'text/html' => 'html',
            'image/x-icon' => 'ico',
            'image/x-ico' => 'ico',
            'image/vnd.microsoft.icon' => 'ico',
            'text/calendar' => 'ics',
            'application/java-archive' => 'jar',
            'application/x-java-application' => 'jar',
            'application/x-jar' => 'jar',
            'image/jp2' => 'jp2',
            'video/mj2' => 'jp2',
            'image/jpx' => 'jp2',
            'image/jpm' => 'jp2',
            'image/jpeg' => 'jpeg',
            'image/pjpeg' => 'jpeg',
            'application/x-javascript' => 'js',
            'application/json' => 'json',
            'text/json' => 'json',
            'application/vnd.google-earth.kml+xml' => 'kml',
            'application/vnd.google-earth.kmz' => 'kmz',
            'text/x-log' => 'log',
            'audio/x-m4a' => 'm4a',
            'audio/mp4' => 'm4a',
            'application/vnd.mpegurl' => 'm4u',
            'audio/midi' => 'mid',
            'application/vnd.mif' => 'mif',
            'video/quicktime' => 'mov',
            'video/x-sgi-movie' => 'movie',
            'audio/mpeg' => 'mp3',
            'audio/mpg' => 'mp3',
            'audio/mpeg3' => 'mp3',
            'audio/mp3' => 'mp3',
            'video/mp4' => 'mp4',
            'video/mpeg' => 'mpeg',
            'application/oda' => 'oda',
            'audio/ogg' => 'ogg',
            'video/ogg' => 'ogg',
            'application/ogg' => 'ogg',
            'application/x-pkcs10' => 'p10',
            'application/pkcs10' => 'p10',
            'application/x-pkcs12' => 'p12',
            'application/x-pkcs7-signature' => 'p7a',
            'application/pkcs7-mime' => 'p7c',
            'application/x-pkcs7-mime' => 'p7c',
            'application/x-pkcs7-certreqresp' => 'p7r',
            'application/pkcs7-signature' => 'p7s',
            'application/pdf' => 'pdf',
            'application/octet-stream' => 'pdf',
            'application/x-x509-user-cert' => 'pem',
            'application/x-pem-file' => 'pem',
            'application/pgp' => 'pgp',
            'application/x-httpd-php' => 'php',
            'application/php' => 'php',
            'application/x-php' => 'php',
            'text/php' => 'php',
            'text/x-php' => 'php',
            'application/x-httpd-php-source' => 'php',
            'image/png' => 'png',
            'image/x-png' => 'png',
            'application/powerpoint' => 'ppt',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.ms-office' => 'ppt',
            'application/msword' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop' => 'psd',
            'image/vnd.adobe.photoshop' => 'psd',
            'audio/x-realaudio' => 'ra',
            'audio/x-pn-realaudio' => 'ram',
            'application/x-rar' => 'rar',
            'application/rar' => 'rar',
            'application/x-rar-compressed' => 'rar',
            'audio/x-pn-realaudio-plugin' => 'rpm',
            'application/x-pkcs7' => 'rsa',
            'text/rtf' => 'rtf',
            'text/richtext' => 'rtx',
            'video/vnd.rn-realvideo' => 'rv',
            'application/x-stuffit' => 'sit',
            'application/smil' => 'smil',
            'text/srt' => 'srt',
            'image/svg+xml' => 'svg',
            'application/x-shockwave-flash' => 'swf',
            'application/x-tar' => 'tar',
            'application/x-gzip-compressed' => 'tgz',
            'image/tiff' => 'tiff',
            'text/plain' => 'txt',
            'text/x-vcard' => 'vcf',
            'application/videolan' => 'vlc',
            'text/vtt' => 'vtt',
            'audio/x-wav' => 'wav',
            'audio/wave' => 'wav',
            'audio/wav' => 'wav',
            'application/wbxml' => 'wbxml',
            'video/webm' => 'webm',
            'audio/x-ms-wma' => 'wma',
            'application/wmlc' => 'wmlc',
            'video/x-ms-wmv' => 'wmv',
            'video/x-ms-asf' => 'wmv',
            'application/xhtml+xml' => 'xhtml',
            'application/excel' => 'xl',
            'application/msexcel' => 'xls',
            'application/x-msexcel' => 'xls',
            'application/x-ms-excel' => 'xls',
            'application/x-excel' => 'xls',
            'application/x-dos_ms_excel' => 'xls',
            'application/xls' => 'xls',
            'application/x-xls' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-excel' => 'xlsx',
            'application/xml' => 'xml',
            'text/xml' => 'xml',
            'text/xsl' => 'xsl',
            'application/xspf+xml' => 'xspf',
            'application/x-compress' => 'z',
            'application/x-zip' => 'zip',
            'application/zip' => 'zip',
            'application/x-zip-compressed' => 'zip',
            'application/s-compressed' => 'zip',
            'multipart/x-zip' => 'zip',
            'text/x-scriptzsh' => 'zsh',
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
    }
    public static function GenerateKode($param)
    {
        $arr = explode("-", $param);
        $count = $arr[1] + 1;
        while (strlen($count) < 5) {
            $count = "0" . $count;
        }
        return $count;
    }
    public static function getBaseURL()
    {
        return Director::absoluteBaseURL();
    }
}

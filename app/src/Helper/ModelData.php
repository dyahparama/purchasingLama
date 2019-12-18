<?php

use SilverStripe\ORM\ArrayList;

class ModelData
{
    static function TableHeader($column)
    {
        $arr = new ArrayList();
        foreach ($column as $val) {
            $arr->push(array('Title' => $val));
        }
        return $arr;
    }

    static function TableData($data, $column)
    {
        // var_dump($data->first()->{'Approver'}());die;
        $arr = new ArrayList();
        // echo "<pre>";
        foreach ($data as $val) {
            $tempArr = new ArrayList();
            foreach ($column as $val2) {
                if (strpos($val2, '.')) {
                    $strArr = explode('.', $val2);
                    $tempVal = "";
                    for ($i = 1; $i <= count($strArr); $i++) {
                        // var_dump($strArr[$i-1]);
                        if ($i < count($strArr)){
                            $val = $val->{$strArr[$i-1]}();
                        } else {
                            $val = $val->{$strArr[$i-1]};
                        }

                    }
                    $tempArr->push(array('Item' => $val));
                } else {
                    $tempArr->push(array('Item' => $val->$val2));
                }
            }
            $arr->push(array('Items' => $tempArr));
        }
        // die;
        return $arr;
    }
}

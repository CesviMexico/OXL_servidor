<?php

namespace App\MetaFritterVerso;

class TablaFront
{
    public static $json = [];

    function __construct()
    {
    }

    public static function getPropsTable()
    {
        return [
            "pagination" => true,
            "pageSize" => 5,
            "simplepage" => false,
            "positionBottom" => "bottomRight", // bottomLeft |bottomCenter|bottomRight
            "positionTop" => 'none', // topLeft |topCenter |topRight|
            "Title" => 'Title example table dance churro',
            "size" => 'small', //default | middle | small
            "bordered" => true,
            "scrollX" => 1200,
            "scrollY" => 300,
            "IconAvatar" => 'mdi:cog-refresh-outline',
            "tableLayout" => "auto",
        ];
    }

    public static function getColumns($arr)
    {
        for ($i = 0; $i < sizeof($arr); $i++) {
            $objeto = $arr[$i];
            $element_op = "normal";
            switch ($element_op) {
                case "normal":
                    self::createColumn($objeto);
                    break;
                default:
                    break;
            }
        }
        return self::$json;
    }

    static function createColumn($objeto)
    {
        $data = $objeto['data'];
        if(!empty($data['label'])){
            $values = [
                "title" => $data['label'], 
                "dataIndex" => $data['value'], 
                "key" => $data['value']
            ];
        }else{
            $values = [
                "key" => $data['value']
            ];
        }
        
        $values += self::extrasNormal($objeto);
        array_push(self::$json, $values);
    }

    static function extrasNormal($objeto)
    {
        $extra = $objeto['extras'];
        $values = [];
        foreach ($extra as $value) {
            foreach ($value as $key => $subvalue) {
                $values += [$key => $subvalue];
            }     
        }
        return $values;
    }
}

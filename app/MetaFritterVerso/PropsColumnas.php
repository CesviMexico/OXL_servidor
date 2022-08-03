<?php

namespace App\MetaFritterVerso;

class PropsColumnas
{
    /**
     * Titulo de la columna | string
     * @var title
     */
    private $title;
    /**
     * Valor que hace referencia al campo del dataset | string
     * @var dataIndex
     */
    private $dataIndex;
    /**
     * Valor de la columna, hace referencia para renderizados propios | string
     * @var key
     */
    private $key;
    /**
     * Simbolos de monedas [peso => $, dolar => , euro => € ] | string
     * @var tipoMoneda
     */
    private $tipoMoneda;
    /**
     * Activa formato de miles | booleano
     * @var tipoMiles
     */
    private $tipoMiles;
    /**
     * Activa formatos de fecha | booleano
     * @var tipoFecha
     */
    private $tipoFecha;
    /**
     * Activa formatos de fecha y hora | booleano
     * @var tipoFechaTime
     */
    private $tipoFechaTime;
    /**
     * Activar ordenamiento numerico | boolean
     * @var orderNumber
     */
    private $orderNumber;
    /**
     * Activar ordenamiento alfabetico | boolean
     * @var orderString
     */
    private $orderString;
    /**
     * Activar ordenamiento decimal | boolean
     * @var orderDouble
     */
    private $orderDouble;
    /**
     * Activar ordenamiento de fechas | boolean
     * @var orderDate
     */
    private $orderDate;
    /**
     * Activar busqueda en la columna | boolean
     * @var busqueda
     */
    private $busqueda;
    /**
     * Activar filtro de valores de la columna | boolean
     * @var filterSearch
     */
    private $filterSearch;
    /**
     * JSON con los valores a filtrar | JSON  [ { text: '', value: '' } ]  (debe estar activado filterSearch )
     * @var filter
     */
    private $filter;
    /**
     * Activa delimitador de texto en la columna | booleano
     * @var ellipsis
     */
    private $ellipsis;
    /**
     * Activar una accion en la columna| booleano
     * @var actions
     */
    private $actions;
    /**
     * Propiedades de la actions, tamaño de la columna
     * @var width
     */
    private $width;
    /**
     * Propiedades de la actions, titulo de confimación para la acción
     * @var titleMSG
     */
    private $titleMSG;
    /**
     * Propiedades de la actions, icono para mostrar en la columna 
     * Nombre de los iconos => https://icon-sets.iconify.design/
     * @var icon
     */
    private $icon;
    /**
     * Activa un componente de calendario en la columna | boolean 
     * @var datePicker
     */
    private $datePicker;
    /**
     * Propiedad del datapicker, input | string 
     * @var placeholder
     */
    private $placeholder;
    /**
     * Propriedad del datapicker | string  [ DD/MM/YYYY || DD/MM/YYYY HH:mm:ss ]
     * @var format
     */
    private $format;
    /**
     * Propriedad del datapicker | string  [ HH:mm:ss ]
     * @var showTime
     */
    private $showTime;
    /**
     * Activa un componente de input en la columna | boolean 
     * @var Input
     */
    private $Input;
    /**
     * Activa un componente de textarea en la columna | boolean 
     * @var textArea
     */
    private $textArea;
    /**
     * Propiedad del datapicker | number > 38
     * @var height
     */
    private $height;
    /**
     * Activa un componente de select en la columna | boolean 
     * @var Select
     */
    private $Select;
    /**
     * Opciones del select | JSON  [ { text: '', value: '' } ]  (debe estar activado Select ) 
     * @var arrayOption
     */
    private $arrayOption;
    /**
     * Activa un componente de upload en la columna | boolean 
     * @var upload
     */
    private $upload;
    /**
     * Propiedad del upload, titulo de la carga |string
     * @var titleMSGC
     */
    private $titleMSGC;
    /**
     * Propiedad del upload, titulo de la descarga | string
     * @var titleMSGD
     */
    private $titleMSGD;
    /**
     * Propiedad del upload, icono de la carga | string
     * @var iconC
     */
    private $iconC;
    /**
     * Propiedad del upload, icono de la descarga | string
     * @var iconD
     */
    private $iconD;
    /**
     * Propiedad del upload, tipo de archivos aceptados | string
     * @var tipoFile
     */
    private $tipoFile;
    /**
     * Propiedad del upload, activa si acepta archivos multiples | booleano
     * @var multipleFile
     */
    private $multipleFile;
    /**
     * Propiedad del upload, opciones: text, picture or picture-card | string
     * @var listType
     */
    private $listType;
    /**
     * Propiedad del upload, opciones: text, picture or picture-card | string
     * @var align
     */
    private $align;
    /**
     * Propiedad del upload, opciones: text, picture or picture-card | string
     * @var fixed
     */
    private $fixed;
    /**
     * Propiedad del upload, opciones: text, picture or picture-card | string
     * @var responsive
     */
    private $responsive;

    function setTitle($title)
    {
        $this->title = $title;
    }

    public static function getDataBase($label, $value)
    {
        return [
            "label" => $label,
            "value" => $value,
        ];
    }

    public static function getTipoMoneda($tipoMoneda = "$")
    {
        return ["tipoMoneda" => $tipoMoneda];
    }

    public static function getTipoMiles()
    {
        return ["tipoMiles" => true];
    }

    public static function getTipoFecha()
    {
        return ["tipoFecha" => true];
    }

    public static function getTipoFechaTime()
    {
        return ["tipoFechaTime" => true];
    }

    public static function getOrderNumber()
    {
        return ["orderNumber" => true];
    }

    public static function getOrderString()
    {
        return ["orderString" => true];
    }

    public static function getOrderDouble()
    {
        return ["orderDouble" => true];
    }

    public static function getOrderDate()
    {
        return ["orderDate" => true];
    }

    public static function getBusqueda()
    {
        return ["busqueda" => true];
    }
    public static function getAlign($align)
    {
        return ["align" => $align];
    }
    public static function getFixed($fixed)
    {
        return ["fixed" => $fixed];
    }
    public static function getResponsive($responsive = [])
    {
        return ["responsive" => $responsive];
    }

    public static function getFilterSearch($filters)
    {
        $arr = [];
        foreach ($filters as $value) {
            $arr[] = ["text" => $value, "value" => $value];
        }
        return ["filterSearch" => true, "filters" => $arr];
    }

    public static function getEllipsis()
    {
        return ["ellipsis" => true];
    }

    public static function getActions($width = 130, $titleMSG = "", $icon = "")
    {
        return ["actions" => true, "width" => $width . "px", "titleMSG" => $titleMSG, "icon" => $icon,];
    }

    public static function getDataPicker($width = 185, $placeholder = "DD/MM/YYYY", $format = "DD/MM/YYYY", $showTime = "")
    {
        return ["datePicker" => true, "width" => $width . "px", "placeholder" => $placeholder, "format" => $format, "showTime" => $showTime,];
    }

    public static function getInput($placeholder, $width = 150)
    {
        return ["Input" => true, "placeholder" => $placeholder, "width" => $width . "px"];
    }

    public static function getTextArea($placeholder, $width = 150, $height = 45)
    {
        return ["textArea" => true, "placeholder" => $placeholder, "width" => $width . "px", "height" => $height];
    }

    public static function getSelect($arrayOption = [], $placeholder = "Seleccione una opciòn", $width = 150)
    {
        $arr = [];
        foreach ($arrayOption as $value) {
            $arr[] = ["text" => $value, "value" => $value];
        }
        return ["Select" => true, "placeholder" => $placeholder, "width" => $width . "px", "arrayOption" => $arr];
    }

    public static function getUpload($actionUrl, $width = 180, $titleMSGC, $titleMSGD, $tipoFile, $multipleFile = false, $listType = "text", $iconC = "line-md:cloud-upload-outline-loop", $iconD = "line-md:cloud-download-outline-loop")
    {
        return ["upload" => true, "actionUrl" => $actionUrl, "width" => $width . "px", "titleMSGC" => $titleMSGC, "titleMSGD" => $titleMSGD, "iconC" => $iconC, "iconD" => $iconD, "tipoFile" => $tipoFile, "multipleFile" => $multipleFile, "listType" => $listType];
    }
}

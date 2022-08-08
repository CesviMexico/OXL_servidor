<?php

namespace App\MetaFritterVerso;

use App\MetaFritterVerso\PropsColumnas;

class ColumnasFront
{
    public static function columnasTablaDemo()
    {
        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Nombre", "first_name"),
                "extras" => [
                    PropsColumnas::getBusqueda(),
                    PropsColumnas::getOrderString()
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Apellido", "last_name"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Genero", "gender"),
                "extras" => [
                    PropsColumnas::getFilterSearch(["Male", "Female"])
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Pesos", "double"),
                "extras" => [
                    PropsColumnas::getTipoMoneda("€"),
                    PropsColumnas::getOrderNumber()
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha", "fecha"),
                "extras" => [
                    PropsColumnas::getTipoFecha(),
                    PropsColumnas::getOrderDate()
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Corre", "email"),
                "extras" => [
                    PropsColumnas::getEllipsis(),
                    PropsColumnas::getOrderString(),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("FechaTime", "fechaTime"),
                "extras" => [
                    PropsColumnas::getTipoFechaTime(),
                    PropsColumnas::getOrderDate()
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "Borrar"),
                "extras" => [
                    PropsColumnas::getActions(
                        "50px",
                        "¿Esta seguro churro?",
                        "twemoji:clown-face"
                    ),

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "Editar"),
                "extras" => [
                    PropsColumnas::getActions(
                        50,
                        "¿Editar pavone?",
                        "fluent:calendar-edit-16-regular"
                    ),

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "DatePicker"),
                "extras" => [
                    PropsColumnas::getDataPicker(130, "DD/MM/YYYY")

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "DatePicker"),
                "extras" => [
                    PropsColumnas::getDataPicker(185, "DD/MM/YYYY", "DD/MM/YYYY HH:mm:ss", "HH:mm:ss")

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "Input"),
                "extras" => [
                    PropsColumnas::getInput("Escriba aqui")

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "TextArea"),
                "extras" => [
                    PropsColumnas::getTextArea("Escriba aqui")

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "Select"),
                "extras" => [
                    PropsColumnas::getSelect(["option 1", "option 2", "option 3", "option 4", "option 5"])

                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("", "Upload"),
                "extras" => [
                    PropsColumnas::getUpload("https://www.mocky.io/v2/5cc8019d300000980a055e76", 200, "titulo carga", "titulo descarga", ".jpg, .png", false, "text")

                ]
            ],

        ];
        return $arr;
    }
    public static function columnasTablaPorAsignar($perfil = "cesvi")
    {
        $perfiles = [
            "cesvi" =>
            [
                "asignar" => [
                    "data" => PropsColumnas::getDataBase("Asignar", "Modal", true),
                    "extras" => [
                        PropsColumnas::getModales(
                            "Asignar",
                            "Asignar",
                            "asignacion",
                            "text"
                        ),
                    ]
                ]
            ]
        ];

        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Stock", "stock"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("VIN", "vin"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Marca", "marca"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Modelo", "modelo"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Año", "anio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Color", "color"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Tipo de daño", "tipo_danio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "ver más",
                        "ic:round-photo-camera-back",
                        "fotos",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de registro", "fec_registro"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Cancelar", "Cancelar", true),
                "extras" => [
                    PropsColumnas::getActions(
                        5,
                        "¿Cancelar?",
                        "mdi:table-cancel"
                    ),
                ]
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "asignar"
                ]
            ],
        ];

        foreach ($arr as $key => $value) {
            if (array_key_exists("perfil", $value)) {
                $obj_perfil = $value['perfil'];
                $label = $obj_perfil['label'];
                if (array_key_exists($perfil, $perfiles)) {
                    $column = $perfiles[$perfil][$label];
                    $arr[$key] = $column;
                } else {
                    unset($arr[$key]);
                }
            }
        }

        return array_values($arr);
    }
    public static function columnasTablaAsignados($perfil = "cesvi")
    {
        $taller = [
            "data" => PropsColumnas::getDataBase("Taller", "nombre_taller"),
            "extras" => []
        ];
        $cancelar = [
            "data" => PropsColumnas::getDataBase("Cancelar", "Cancelar", true),
            "extras" => [
                PropsColumnas::getActions(
                    5,
                    "¿Cancelar?",
                    "mdi:table-cancel"
                ),
            ]
        ];
        $ingreso =
            [
                "data" => PropsColumnas::getDataBase("Ingreso", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ingreso",
                        "Ingreso",
                        "ingreso",
                        "text"
                    ),
                ]
            ];

        $perfiles = [
            "cesvi" => [
                "cancelar" => $cancelar,
                "taller" => $taller,
                "ingreso" => $ingreso
            ],
            "taller" => [
                "ingreso" => $ingreso
            ],
            "olx" => [
                "taller" => $taller
            ]
        ];

        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Stock", "stock"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("VIN", "vin"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Marca", "marca"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Modelo", "modelo"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Año", "anio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Color", "color"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Tipo de daño", "tipo_danio"),
                "extras" => []
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "taller"
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de asigación", "fec_asignado"),
                "extras" => []
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "ingreso"
                ]
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "cancelar"
                ]
            ]
        ];

        foreach ($arr as $key => $value) {
            if (array_key_exists("perfil", $value)) {
                $obj_perfil = $value['perfil'];
                $label = $obj_perfil['label'];
                if (array_key_exists($perfil, $perfiles)) {
                    $column = $perfiles[$perfil][$label];
                    $arr[$key] = $column;
                } else {
                    unset($arr[$key]);
                }
            }
        }

        return array_values($arr);
    }
    public static function columnasTablaEnTaller($perfil = "cesvi")
    {
        $taller = [
            "data" => PropsColumnas::getDataBase("Taller", "nombre_taller"),
            "extras" => []
        ];
        $cancelar = [
            "data" => PropsColumnas::getDataBase("Cancelar", "Cancelar", true),
            "extras" => [
                PropsColumnas::getActions(
                    5,
                    "¿Cancelar?",
                    "mdi:table-cancel"
                ),
            ]
        ];
        $inspeccion =
            [
                "data" => PropsColumnas::getDataBase("Inspección", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Inspección",
                        "Inspección",
                        "inspeccion",
                        "text"
                    ),
                ]
            ];

        $perfiles = [
            "cesvi" => [
                "cancelar" => $cancelar,
                "taller" => $taller,
                "inspeccion" => $inspeccion
            ],
            "taller" => [
                "inspeccion" => $inspeccion
            ],
            "olx" => [
                "taller" => $taller
            ]
        ];

        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Stock", "stock"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("VIN", "vin"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Marca", "marca"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Modelo", "modelo"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Año", "anio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Color", "color"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Tipo de daño", "tipo_danio"),
                "extras" => []
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "taller"
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de asignación", "fec_asignado"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos Ingreso", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "ver más",
                        "ic:round-photo-camera-back",
                        "fotos_ingreso",
                        "icon"
                    ),
                ]
            ],
            // [
            //     "data" => PropsColumnas::getDataBase("Fecha promesa", ""),
            //     "extras" => []
            // ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "inspeccion"
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Revisión", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Revisión",
                        "count_status",
                        "revision",
                        "field"
                    ),
                ]
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "cancelar"
                ]
            ],

        ];

        foreach ($arr as $key => $value) {
            if (array_key_exists("perfil", $value)) {
                $obj_perfil = $value['perfil'];
                $label = $obj_perfil['label'];
                if (array_key_exists($perfil, $perfiles)) {
                    $column = $perfiles[$perfil][$label];
                    $arr[$key] = $column;
                } else {
                    unset($arr[$key]);
                }
            }
        }

        return array_values($arr);
    }
    public static function columnasTablaTerminados($perfil = "cesvi")
    {
        $taller = [
            "data" => PropsColumnas::getDataBase("Taller", "nombre_taller"),
            "extras" => []
        ];
        $entrega =
            [
                "data" => PropsColumnas::getDataBase("Entrega", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Entrega",
                        "Entrega",
                        "entrega",
                        "text"
                    ),
                ]
            ];

        $perfiles = [
            "cesvi" => [
                "taller" => $taller,
                "entrega" => $entrega
            ],
            "taller" => [
                "entrega" => $entrega
            ],
            "olx" => [
                "taller" => $taller
            ]
        ];

        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Stock", "stock"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("VIN", "vin"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Marca", "marca"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Modelo", "modelo"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Año", "anio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Color", "color"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Tipo de daño", "tipo_danio"),
                "extras" => []
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "taller"
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de ingreso", "fec_ingreso"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos ingreso", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos_ingreso",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha promesa", ""),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha término", "fec_terminado"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Revisión", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Revisión",
                        "count_status",
                        "revision",
                        "field"
                    ),
                ]
            ],
            [
                "perfil" => [
                    "value" => "si",
                    "label" => "entrega"
                ]
            ],

        ];

        foreach ($arr as $key => $value) {
            if (array_key_exists("perfil", $value)) {
                $obj_perfil = $value['perfil'];
                $label = $obj_perfil['label'];
                if (array_key_exists($perfil, $perfiles)) {
                    $column = $perfiles[$perfil][$label];
                    $arr[$key] = $column;
                } else {
                    unset($arr[$key]);
                }
            }
        }

        return array_values($arr);
    }
    
    
    
    public static function columnasTablaInspecciones()
    {
        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Estatus", "estatus"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha", "fec_estatus"),
                "extras" => [
                    PropsColumnas::getTipoFechaTime(),
                    PropsColumnas::getOrderDate()
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Resultado", "result_inspeccion"),
                "extras" => []
            ]

        ];
        return $arr;
    }
    

    public static function columnasTablaEntregados($perfil = "cesvi")
    {

        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Stock", "stock"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("VIN", "vin"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Marca", "marca"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Modelo", "modelo"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Año", "anio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Color", "color"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Tipo de daño", "tipo_danio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Taller", "nombre_taller"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de ingreso", "fec_ingreso"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos ingreso", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos_ingreso",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha promesa", ""),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha término", "fec_terminado"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de entrega", "fec_entrega"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos entrega", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos_entrega",
                        "icon"
                    ),
                ]
            ],
           
            

        ];

        return $arr;
    }

    public static function columnasTablaCancelados($perfil = "cesvi")
    {

        $arr = [
            [
                "data" => PropsColumnas::getDataBase("Stock", "stock"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("VIN", "vin"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Marca", "marca"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Modelo", "modelo"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Año", "anio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Color", "color"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Tipo de daño", "tipo_danio"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Taller", "nombre_taller"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Fotos", "Modal", true),
                "extras" => [
                    PropsColumnas::getModales(
                        "Ver más",
                        "ic:round-photo-camera-back",
                        "fotos",
                        "icon"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de asignación", "fec_asignado"),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("Motivo", ""),
                "extras" => []
            ],
            

        ];

        return $arr;
    }

}

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

    public static function columnasTablaPorAsignar()
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
                "data" => PropsColumnas::getDataBase("", "Fotos"),
                "extras" => [
                    PropsColumnas::getActions(
                        5,
                        "¿Editar pavone?",
                        "ic:round-photo-camera-back"
                    ),
                ]
            ],
            [
                "data" => PropsColumnas::getDataBase("Fecha de registro", ""),
                "extras" => []
            ],
            [
                "data" => PropsColumnas::getDataBase("", "Cancelar"),
                "extras" => [
                    PropsColumnas::getActions(
                        5,
                        "¿Cancelar?",
                        "mdi:table-cancel"
                    ),
                ]
            ],
        ];
        return $arr;
    }
}

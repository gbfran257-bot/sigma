<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $data = $_GET['data'];

    // Decodificar el JSON para formatearlo de manera legible
    $decodedData = json_decode($data, true);

    // Verificar si la decodificación fue exitosa
    if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error al decodificar el JSON.";
    } else {
        // Imprimir el JSON formateado de manera legible
        // echo "Data:\n" . json_encode($decodedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $data = $decodedData;
        
        // Crear el array base para el JSON
        $jsonArray = array(
            "Certificado" => null,
            "CondicionesDePago" => null,
            "Fecha" => null,
            "Folio" => null,
            "FormaPago" => null,
            "LugarExpedicion" => null,
            "MetodoPago" => null,
            "Moneda" => null,
            "NoCertificado" => null,
            "Sello" => null,
            "Serie" => null,
            "SubTotal" => null,
            "TipoDeComprobante" => null,
            "Total" => null,
            "Version" => null,
            "xsi:schemaLocation" => null,
            "Emisor" => array(
                "Nombre" => null,
                "RegimenFiscal" => null,
                "Rfc" => null
            ),
            "Receptor" => array(
                "Nombre" => null,
                "Rfc" => null,
                "UsoCFDI" => null
            ),
            "Conceptos" => array(
                "Concepto" => array(
                    array(
                        "Cantidad" => null,
                        "ClaveProdServ" => null,
                        "ClaveUnidad" => null,
                        "Descripcion" => null,
                        "Importe" => null,
                        "Unidad" => null,
                        "ValorUnitario" => null,
                        "Impuestos" => array(
                            "Traslados" => array(
                                "Traslado" => array(
                                    array(
                                        "Base" => null,
                                        "Importe" => null,
                                        "Impuesto" => null,
                                        "TasaOCuota" => null,
                                        "TipoFactor" => null
                                    )
                                )
                            )
                        )
                    )
                )
            ),
            "Impuestos" => array(
                "TotalImpuestosTrasladados" => null,
                "Traslados" => array(
                    "Traslado" => array(
                        array(
                            "Importe" => null,
                            "Impuesto" => null,
                            "TasaOCuota" => null,
                            "TipoFactor" => null
                        )
                    )
                )
            ),
            "Complemento" => array(
                array(
                    "ImpuestosLocales" => array(
                        "TotaldeRetenciones" => null,
                        "TotaldeTraslados" => null,
                        "version" => null,
                        "TrasladosLocales" => array(
                            array(
                                "ImpLocTrasladado" => null,
                                "Importe" => null,
                                "TasadeTraslado" => null
                            )
                        )
                    ),
                    "TimbreFiscalDigital" => array(
                        "FechaTimbrado" => null,
                        "NoCertificadoSAT" => null,
                        "RfcProvCertif" => null,
                        "SelloCFD" => null,
                        "SelloSAT" => null,
                        "UUID" => null,
                        "Version" => null,
                        "xsi:schemaLocation" => null
                    )
                )
            )
        );
        
        // Rellenar los valores conocidos desde $data
        $jsonArray["Emisor"]["Nombre"] = $data["emisor_nombre"];
        $jsonArray["Emisor"]["RegimenFiscal"] = $data["emisor_regimen"];
        $jsonArray["Emisor"]["Rfc"] = $data["emisor_rfc"];
        $jsonArray["LugarExpedicion"] = $data["emisor_codigo_postal"];

        $jsonArray["Receptor"]["Nombre"] = $data["receptor_nombre"];
        $jsonArray["Receptor"]["Rfc"] = $data["receptor_rfc"];
        $jsonArray["Receptor"]["DomicilioFiscalReceptor"] = $data["receptor_codigo_postal"];
        $jsonArray["Receptor"]["UsoCFDI"] = $data["receptor_uso_cfdi"];
        $jsonArray["Receptor"]["RegimenFiscalReceptor"] = $data["receptor_regimen"];
        
        // Decodificar la cadena JSON en o_items y reemplazar los valores en Conceptos
        $oItems = json_decode($data["o_items"], true);
        if (is_array($oItems)) {
            foreach ($oItems as $oItem) {
                $concepto = array(
                    "Cantidad" => $oItem["Cantidad"],
                    "ClaveProdServ" => $oItem["ClaveProdServ"],
                    "ClaveUnidad" => $oItem["ClaveUnidad"],
                    "Descripcion" => $oItem["concepto_to"],
                    "Importe" => $oItem["precio_vc"],
                    "ValorUnitario" => $oItem["ValorUnitario"],
                    "Impuestos" => array(
                        "Traslados" => array(
                            "Traslado" => array(
                                array(
                                    "Base" => $oItem["precio_vc"],
                                    "Importe" => null, 
                                    "Impuesto" => null, 
                                    "TasaOCuota" => null, 
                                    "TipoFactor" => null 
                                )
                            )
                        )
                    )
                );
        
                $jsonArray["Conceptos"]["Concepto"][] = $concepto;
            }
        }
        
        // Convertir a JSON y mostrar
        $jsonOutput = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // echo $jsonOutput;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://10.0.2.2:8000/api/cfdi/stamp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonOutput,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 2|laravel_sanctum_pd1O5uOqcHH81YpkdOcpYbcossxBR9i2fds2dDRX92fe9dde',
                'Content-Type: application/json'
            ),
        ));
        print(222);
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;


    }


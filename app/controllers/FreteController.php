<?php

class FreteController
{
    public function calcular()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        header("Content-Type: application/json");

        $token = "40F1A19FR3166R41E1RAA08RCB8E6BAC9A7C";

        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($input['cep'])) {
            http_response_code(400);
            echo json_encode([
                "erro" => "Dados inválidos enviados. Certifique-se de enviar o CEP em formato JSON: {'cep': 'seu_cep'}"
            ]);
            return;
        }

        $recipientCEP = preg_replace('/[^0-9]/', '', $input['cep']);

        if (strlen($recipientCEP) !== 8) {
            http_response_code(400);
            echo json_encode(["erro" => "Formato de CEP inválido. Use 8 dígitos numéricos."]);
            return;
        }

        $dados = [
            "SellerCEP" => "01310100", // CEP da loja
            "RecipientCEP" => $recipientCEP,
            "ShipmentInvoiceValue" => 150.00,
            "ShippingItemArray" => [
                [
                    "Height" => 10,
                    "Length" => 25,
                    "Width"  => 20,
                    "Weight" => 1,
                    "Quantity" => 3
                ]
            ]
        ];

        $ch = curl_init("https://api.frenet.com.br/shipping/quote");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Content-Type: application/json",
            "token: $token"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro na comunicação cURL: " . curl_error($ch)]);
        } else {
            if ($httpCode >= 200 && $httpCode < 300) {
                echo $response;
            } else {
                http_response_code($httpCode);
                $errorData = json_decode($response, true);
                $errorMessage = isset($errorData['Message']) ? $errorData['Message'] : $response;
                echo json_encode(["erro" => "Erro da API Frenet (HTTP $httpCode): " . $errorMessage]);
            }
        }

        curl_close($ch);
    }
}

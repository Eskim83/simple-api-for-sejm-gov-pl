<?php

namespace Sejm;

/**
 * Klient do publicznego API Sejmu.
 *
 * Umożliwia wykonywanie zapytań GET do endpointów API Sejm
 * (https://api.sejm.gov.pl/sejm/term10/) z obsługą klucza API oraz błędów HTTP i sieciowych.
 * 
 */
class Client
{
    /**
     * Bazowy adres API Sejm.
     *
     * @var string
     */
    private $baseUrl = 'https://api.sejm.gov.pl/sejm/term10/';

    /**
     * Konstruktor klienta Sejm.
     *
     */
    public function __construct()
    {

    }

    /**
     * Wysyła zapytanie GET do wybranego endpointu Sejm API.
     *
     * @param string $endpoint Nazwa endpointu.
     * @param array $params Parametry zapytania (opcjonalnie).
     * @param string $accept Nagłówek Accept (domyślnie "application/json").
     *
     * @return array Zdekodowana odpowiedź JSON z API.
     *
     * @throws \Exception W przypadku błędu sieciowego lub odpowiedzi innej niż HTTP 200.
     */
    public function request($endpoint='', $params = [], $accept = 'application/json')
    {
        $url = $this->baseUrl . $endpoint;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $headers = [
            'Accept: ' . $accept
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        // Obsługa błędów cURL
        if ($error) {
            throw new \Exception("cURL Error: " . $error . ': ' . $endpoint . '[ ' . print_r($params, true) . " ]");
        }

        $res = json_decode($response, true);

        // Wszystko OK
        if ($httpCode == 200) {
            return $res;
        }

        $msg = match($httpCode) {
            400 => 'Bad Request',
            404 => 'Not Found',
            default => 'Unknown status code',
        };

        throw new \Exception(
            $msg . ': ' . $endpoint . '[ ' . print_r($params, true) . " ]\n\nResponse: " . print_r($res, true),
            $httpCode
        );
    }

}


?>
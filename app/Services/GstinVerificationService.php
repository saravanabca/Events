<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class GstinVerificationService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('CLEARTAX_API_URL');
        $this->apiKey = env('CLEARTAX_API_KEY');
    }

    public function verifyGstin($gstin)
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl . $gstin, [
                'headers' => [
                    'x-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() == 200) {
                return $data;
            } else {
                throw new Exception('GSTIN verification failed');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

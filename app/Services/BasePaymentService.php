<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class BasePaymentService
{
    /**
     * Create a new class instance.
     */
    protected  $base_url;
    protected array $header;
    protected function buildRequest($method, $url,$base_url,$header, $data = null,$type='json'): \Illuminate\Http\JsonResponse
    {
        try {
            $this->header = $header;
            $this->base_url = $base_url;
            $response = Http::withHeaders($this->header)->send($method, $this->base_url . $url, [
                $type => $data
            ]);
            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
            ], $response->status());
        } catch (Exception $e) {
            return response()->json([
                'success' => 'No NO No',
                'status' => 500,
                'message' => $e->getMessage(),
//                'base_url' => $this->base_url,
//                'url' =>  $url,
//                'header' => $this->header,
            ], 500);
        }
    }
}

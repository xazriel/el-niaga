<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class JneService
{
    protected ?string $urlTracking;
    protected ?string $urlAirwaybill;
    protected ?string $urlTariff;
    protected ?string $username;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->urlTracking   = config('jne.url_tracking',   'https://apiv2.jne.co.id:10205');
        $this->urlAirwaybill = config('jne.url_airwaybill', 'https://apiv2.jne.co.id:10206');
        $this->urlTariff     = config('jne.url_tariff',     'https://apiv2.jne.co.id:10205');
        $this->username      = config('jne.username',       'FARHANAS');
        $this->apiKey        = config('jne.api_key',        '');
    }

    // ─── CEK TARIF ────────────────────────────────────────────
    public function getPrice(string $from, string $thru, int $weight): array
    {
        $cacheKey = "jne_price_{$from}_{$thru}_{$weight}";
        Cache::forget($cacheKey);

        $response = Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Accept' => 'application/json'])
            ->post($this->urlTariff . '/tracing/api/pricedev', [
                'username' => $this->username,
                'api_key'  => $this->apiKey,
                'from'     => $from,
                'thru'     => $thru,
                'weight'   => $weight,
            ]);

        Log::info('[JNE] getPrice Request', [
            'url'      => $this->urlTariff . '/tracing/api/pricedev',
            'username' => $this->username,
            'api_key'  => substr($this->apiKey ?? '', 0, 6) . '***',
            'from'     => $from,
            'thru'     => $thru,
            'weight'   => $weight,
        ]);

        Log::info('[JNE] getPrice Response', [
            'http_status' => $response->status(),
            'body'        => $response->body(),
        ]);

        if ($response->failed()) {
            throw new \Exception('JNE API error: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new \Exception($data['error']);
        }

        return $data['price'] ?? [];
    }

    // ─── ALIAS getTariff ──────────────────────────────────────
    public function getTariff(string $destCode, int $weight): array
    {
        $originCode = config('jne.origin_code', 'CGK10000');
        $prices = $this->getPrice($originCode, $destCode, $weight);
        return ['price' => $prices];
    }

    // ─── GENERATE AIRWAYBILL ──────────────────────────────────
    public function generateAirwaybill(array $params): array
    {
        Log::info('[JNE] generateAirwaybill Request', [
            'url'    => $this->urlAirwaybill . '/tracing/api/generatecnote',
            'params' => $params,
        ]);

        $response = Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Accept' => 'application/json'])
            ->post($this->urlAirwaybill . '/tracing/api/generatecnote', array_merge([
                'username' => $this->username,
                'api_key'  => $this->apiKey,
            ], $params));

        Log::info('[JNE] generateAirwaybill Response', [
            'http_status' => $response->status(),
            'body'        => $response->body(),
        ]);

        if ($response->failed()) {
            throw new \Exception('JNE API error: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new \Exception($data['error']);
        }

        return $data['detail'][0] ?? [];
    }

    // ─── ALIAS createAirwaybill ───────────────────────────────
    public function createAirwaybill(array $params): array
    {
        Log::info('[JNE] createAirwaybill Request', [
            'url'    => $this->urlAirwaybill . '/tracing/api/generatecnote',
            'params' => $params,
        ]);

        $response = Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Accept' => 'application/json'])
            ->post($this->urlAirwaybill . '/tracing/api/generatecnote', array_merge([
                'username' => $this->username,
                'api_key'  => $this->apiKey,
            ], $params));

        Log::info('[JNE] createAirwaybill Response', [
            'http_status' => $response->status(),
            'body'        => $response->body(),
        ]);

        if ($response->failed()) {
            throw new \Exception('JNE API error: ' . $response->body());
        }

        return $response->json() ?? [];
    }

    // ─── TRACKING ─────────────────────────────────────────────
    public function trackPackage(string $awb): array
    {
        Log::info('[JNE] trackPackage Request', ['awb' => $awb]);

        $response = Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Accept' => 'application/json'])
            ->post($this->urlTracking . '/tracing/api/list/v1/cnote/' . $awb, [
                'username' => $this->username,
                'api_key'  => $this->apiKey,
            ]);

        Log::info('[JNE] trackPackage Response', [
            'http_status' => $response->status(),
            'body'        => $response->body(),
        ]);

        if ($response->failed()) {
            throw new \Exception('JNE API error: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new \Exception($data['error']);
        }

        return $data;
    }
}
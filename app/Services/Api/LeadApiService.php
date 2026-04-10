<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;

class LeadApiService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
        $this->apiKey = config('services.api.key');
    }

    private function client()
    {
        return Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Accept' => 'application/json',
        ]);
    }

    public function datatable($params)
    {
        return $this->client()
            ->get("{$this->baseUrl}/leads", $params)
            ->json();
    }

    public function store($data)
    {
        return $this->client()
            ->post("{$this->baseUrl}/leads", $data)
            ->json();
    }

    public function update($id, $data)
    {
        return $this->client()
            ->put("{$this->baseUrl}/leads/{$id}", $data)
            ->json();
    }

    public function delete($id)
    {
        return $this->client()
            ->delete("{$this->baseUrl}/leads/{$id}")
            ->json();
    }
}
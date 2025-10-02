<?php
namespace App\ClientsAPI;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientPokeAPI
{
    private const BASE_URL = 'https://pokeapi.co/api/v2/';

    public function __construct(
        private readonly HttpClientInterface $httpClient)
    {
    }

    /**
     * Fetch a Pokémon by name or ID.
     */
    public function pokemon($nameOrId): ?array
    {
        $url = self::BASE_URL . 'pokemon/' . urlencode($nameOrId);
        try {
            $response = $this->httpClient->request('GET', $url);
            if ($response->getStatusCode() !== 200) {
                return null;
            }
            return $response->toArray();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Fetch a move by name or ID.
     */


    /**
     * Fetch a type by name or ID.
     */
    public function types(): ?array
    {
        $url = self::BASE_URL . 'type';
        try {

            $response = $this->httpClient->request('GET', $url);
            if ($response->getStatusCode() !== 200) {
                return null;
            }
            return $response->toArray();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Fetch the stats of a Pokémon by name or ID.
     *
     */
    public function stats($nameOrId): ?array
    {
        $pokemon = $this->pokemon($nameOrId);

        if (!$pokemon || !isset($pokemon['stats'])) {
            return null;
        }

        $stats = [];
        foreach ($pokemon['stats'] as $statEntry) {
            if (isset($statEntry['stat']['name'], $statEntry['base_stat'])) {
                $stats[$statEntry['stat']['name']] = $statEntry['base_stat'];
            }
        }
        return $stats;
    }
    /**
     * Get moves from a given Pokémon type.
     *
     * @param string|int $typeNameOrId
     * @return array|null
     */
    public function getMovesFromType($typeNameOrId): ?array
    {
        $url = self::BASE_URL . 'type/' . $typeNameOrId;
        try {
            $response = $this->httpClient->request('GET', $url);
            if ($response->getStatusCode() !== 200) {
                return null;
            }

            $typeData = $response->toArray();
            if (!isset($typeData['moves'])) {
                return null;
            }

            return $typeData['moves'];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Calculate the catch rate of a Pokémon by name or ID.
     *
     */
    public function catchRate($nameOrId): ?int
    {
        $pokemon = $this->pokemon($nameOrId);

        if (!$pokemon || !isset($pokemon['id'])) {
            return null;
        }

        // Fetch species data to get catch_rate
        $speciesUrl = self::BASE_URL . 'pokemon-species/' . $pokemon['id'];
        try {
            $response = $this->httpClient->request('GET', $speciesUrl);
            if ($response->getStatusCode() !== 200) {
                return null;
            }
            $speciesData = $response->toArray();
            if (isset($speciesData['capture_rate'])) {
                return (int)$speciesData['capture_rate'];
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Fetch a list of Pokémon.
     */
    public function list(int $limit = 50, int $offset = 0): ?array
    {
        $url = self::BASE_URL . 'pokemon?limit=' . $limit . '&offset=' . $offset;
        try {
            $response = $this->httpClient->request('GET', $url);
            if ($response->getStatusCode() !== 200) {
                return null;
            }
            return $response->toArray();
        } catch (\Exception $e) {
            return null;
        }
    }
}

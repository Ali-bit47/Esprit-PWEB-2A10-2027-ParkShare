<?php
class Parking
{
    private ?PDO $db;

    public function __construct(?PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        if (!$this->db) {
            return [
                ['nom' => 'Résidence Les Jardins du Lac', 'adresse' => 'Les Berges du Lac 1', 'distance' => '350 m', 'prix' => '2,5', 'note' => '4,8', 'type' => 'Place couverte'],
                ['nom' => 'Parking entreprise Centre Urbain Nord', 'adresse' => 'Centre Urbain Nord', 'distance' => '1,2 km', 'prix' => '3', 'note' => '4,6', 'type' => 'Gardé'],
                ['nom' => 'Garage privé Ennasr 2', 'adresse' => 'Ennasr 2', 'distance' => '2,4 km', 'prix' => '2', 'note' => '4,9', 'type' => 'Garage fermé']
            ];
        }

        $stmt = $this->db->query('SELECT nom, adresse, prix, note, type FROM parkings');
        return $stmt->fetchAll();
    }

    public function search(string $search): array
    {
        $parkings = $this->getAll();

        if ($search === '') {
            return $parkings;
        }

        $search = mb_strtolower($search, 'UTF-8');
        return array_values(array_filter($parkings, static function (array $parking) use ($search): bool {
            $haystack = mb_strtolower(
                ($parking['nom'] ?? '') . ' ' . ($parking['adresse'] ?? '') . ' ' . ($parking['type'] ?? ''),
                'UTF-8'
            );
            return str_contains($haystack, $search);
        }));
    }
}

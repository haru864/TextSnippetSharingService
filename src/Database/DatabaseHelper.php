<?php

namespace Database;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
    public static function getRandomComputerPart(): array
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT * FROM computer_parts ORDER BY RAND() LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $part = $result->fetch_assoc();
        if (!$part) throw new Exception('Could not find a single part in database');
        return $part;
    }

    public static function getComputerPartById(int $id): array
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT * FROM computer_parts WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $part = $result->fetch_assoc();
        if (!$part) throw new Exception('Could not find a single part in database');
        return $part;
    }

    public static function getComputerPartByType(string $type): array
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = ?");
        $stmt->bind_param('s', $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $parts = $result->fetch_all();
        if (count($parts) === 0) throw new Exception('Could not find any parts in database');
        return $parts;
    }
}

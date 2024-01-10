<?php

namespace Database;

use Database\MySQLWrapper;
use Exception;
use Config\Config;

class DatabaseHelper
{
    public static function insertSnippet(string $hash_value, string $snippet, string $language): void
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("INSERT INTO snippet VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?) ON DUPLICATE KEY UPDATE registered_at = CURRENT_TIMESTAMP, expired_at = ?");
        $current_date_str = date('Y-m-d H:i:s');
        $expired_date_int = strtotime("+10 minutes", strtotime($current_date_str));
        $expired_date_str = date('Y-m-d H:i:s', $expired_date_int);
        $stmt->bind_param('sssss', $hash_value, $snippet, $language, $expired_date_str, $expired_date_str);
        $stmt->execute();
        return;
    }

    public static function getSnippetById(string $id): string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT snippet FROM snippet WHERE id = ? AND expired_at > CURRENT_TIMESTAMP");
        $stmt->bind_param('s', $id,);
        $stmt->execute();
        $result = $stmt->get_result();
        $snippet = $result->fetch_row()[0];
        if (!$snippet) throw new Exception('Could not find any snippet in database');
        return $snippet;
    }
}

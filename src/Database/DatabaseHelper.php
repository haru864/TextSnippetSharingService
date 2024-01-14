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
        $expired_date_int = strtotime("+30 minutes", strtotime($current_date_str));
        $expired_date_str = date('Y-m-d H:i:s', $expired_date_int);
        $stmt->bind_param('sssss', $hash_value, $snippet, $language, $expired_date_str, $expired_date_str);
        $stmt->execute();
        return;
    }

    public static function getSnippetAndLanguageByHashValue(string $hash_value): array
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT snippet, language FROM snippet WHERE hash_value = ? AND expired_at > CURRENT_TIMESTAMP");
        $stmt->bind_param('s', $hash_value,);
        $stmt->execute();
        $result = $stmt->get_result();
        $arr = $result->fetch_row();
        // var_dump($result);
        // var_dump($arr);
        if (!$arr) throw new Exception('Could not find any snippet in database');
        return $arr;
    }

    public static function deleteExpiredSnippets(): void
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("DELETE FROM snippet WHERE expired_at <= CURRENT_TIMESTAMP");
        $stmt->execute();
    }
}

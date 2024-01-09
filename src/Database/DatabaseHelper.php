<?php

namespace Database;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
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

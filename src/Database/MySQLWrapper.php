<?php

namespace Database;

use mysqli;
use Config\Config;

class MySQLWrapper extends mysqli
{
    public function __construct(?string $hostname = 'localhost', ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null, ?string $socket = null)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $username = $username ?? Config::env('DATABASE_USER');
        $password = $password ?? Config::env('DATABASE_USER_PASSWORD');
        $database = $database ?? Config::env('DATABASE_NAME');
        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }

    public function getSnippetById(string $id): string
    {
        $sql = sprintf("SELECT snippet FROM snippet WHERE id = '%s'", $id);
        $snippet = $this->query($sql)->fetch_row()[0];
        return $snippet;
    }
}

CREATE TABLE practice_db.snippet (
    hash_value VARCHAR(64) PRIMARY KEY,
    snippet TEXT NOT NULL,
    language VARCHAR(20) NOT NULL,
    registered_at DATETIME NOT NULL,
    expired_at DATETIME NOT NULL
)
;
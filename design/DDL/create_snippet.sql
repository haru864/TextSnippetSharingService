CREATE TABLE practice_db.snippet (
    url VARCHAR(256) PRIMARY KEY,
    snippet TEXT NOT NULL,
    language VARCHAR(20) NOT NULL,
    submitted_at DATETIME NOT NULL,
    expired_at DATETIME NOT NULL
)
;
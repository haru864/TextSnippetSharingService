CREATE TABLE IF NOT EXISTS `snippet` (
  `hash_value` varchar(64) NOT NULL,
  `snippet` text NOT NULL,
  `language` varchar(20) NOT NULL,
  `registered_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  PRIMARY KEY (`hash_value`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
;

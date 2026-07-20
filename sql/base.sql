-- Table users
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    phone_number VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    last_login DATETIME,
    login_count INTEGER DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);
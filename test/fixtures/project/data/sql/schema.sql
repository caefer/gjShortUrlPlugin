CREATE TABLE gj_short_url (id INTEGER PRIMARY KEY AUTOINCREMENT, source VARCHAR(255), target VARCHAR(255), code INTEGER, begins_at DATE, expires_at DATE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL);
CREATE UNIQUE INDEX source_uniq_idx ON gj_short_url (source ASC);

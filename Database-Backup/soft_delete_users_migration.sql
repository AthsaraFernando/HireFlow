-- Soft-delete support for users table
-- This migration adds metadata columns for account deactivation/auditing.

ALTER TABLE users
    ADD COLUMN deleted_at DATETIME NULL AFTER status,
    ADD COLUMN deleted_by INT NULL AFTER deleted_at,
    ADD COLUMN deleted_email VARCHAR(100) NULL AFTER deleted_by,
    ADD COLUMN delete_reason VARCHAR(255) NULL AFTER deleted_email;

ALTER TABLE users
    ADD INDEX idx_users_deleted_at (deleted_at),
    ADD INDEX idx_users_deleted_by (deleted_by);

ALTER TABLE users
    ADD CONSTRAINT fk_users_deleted_by
    FOREIGN KEY (deleted_by) REFERENCES users(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

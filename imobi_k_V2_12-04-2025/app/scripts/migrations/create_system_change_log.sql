-- Migration: create_system_change_log.sql
-- Creates the system_change_log table expected by the application

CREATE TABLE IF NOT EXISTS system_change_log (
    id bigint PRIMARY KEY,
    logdate timestamp without time zone,
    log_year integer,
    log_month integer,
    log_day integer,
    login varchar(255),
    tablename varchar(255),
    primarykey varchar(100),
    pkvalue varchar(255),
    operation varchar(50),
    columnname varchar(255),
    oldvalue text,
    newvalue text,
    access_ip varchar(45),
    transaction_id varchar(100),
    log_trace text,
    session_id varchar(255),
    class_name varchar(255),
    php_sapi varchar(50)
);

-- Optional: create a sequence and set default for id if you prefer serial behaviour
-- CREATE SEQUENCE IF NOT EXISTS system_change_log_id_seq;
-- ALTER SEQUENCE system_change_log_id_seq OWNED BY system_change_log.id;
-- ALTER TABLE system_change_log ALTER COLUMN id SET DEFAULT nextval('system_change_log_id_seq');

-- Optional indexes
CREATE INDEX IF NOT EXISTS idx_system_change_log_logdate ON system_change_log (logdate);
CREATE INDEX IF NOT EXISTS idx_system_change_log_tablename ON system_change_log (tablename);

-- Migration: create financeiro.nfe
-- Run this SQL in your database (PostgreSQL) to create the table used by app/model/Nfe.php

CREATE SCHEMA IF NOT EXISTS financeiro;

CREATE TABLE IF NOT EXISTS financeiro.nfe (
    idnfe serial PRIMARY KEY,
    idfatura integer NULL,
    chave varchar(44) NULL,
    protocolo varchar(128) NULL,
    status varchar(64) NULL,
    response_json text NULL,
    xml_path varchar(512) NULL,
    pdf_path varchar(512) NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);

-- optional index on chave for fast lookup
CREATE INDEX IF NOT EXISTS idx_financeiro_nfe_chave ON financeiro.nfe (chave);

-- Migration: add NF-e columns to financeiro.faturaresponse
-- Run this SQL in your database (PostgreSQL) to add NF-e support when reusing Faturaresponse

ALTER TABLE financeiro.faturaresponse
ADD COLUMN IF NOT EXISTS nfe_chave varchar(44),
ADD COLUMN IF NOT EXISTS nfe_protocolo varchar(128),
ADD COLUMN IF NOT EXISTS nfe_status varchar(64),
ADD COLUMN IF NOT EXISTS nfe_response_json text,
ADD COLUMN IF NOT EXISTS nfe_xml_path varchar(512),
ADD COLUMN IF NOT EXISTS nfe_pdf_path varchar(512),
ADD COLUMN IF NOT EXISTS nfe_created_at timestamp without time zone DEFAULT now(),
ADD COLUMN IF NOT EXISTS nfe_updated_at timestamp without time zone DEFAULT now();

CREATE INDEX IF NOT EXISTS idx_faturaresponse_nfe_chave ON financeiro.faturaresponse (nfe_chave);

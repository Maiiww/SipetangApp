#!/usr/bin/env bash
cd "$(dirname "$0")"
mysql -h localhost -u root sipetang_db << 'EOSQL'
UPDATE users SET alamat='Kantor Dinas Perikanan Pusat, Subang' WHERE username='staff_tpi';
SELECT nama, alamat FROM users WHERE username='staff_tpi';
EOSQL

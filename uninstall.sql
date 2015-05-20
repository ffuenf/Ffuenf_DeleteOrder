-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'deleteorder/%';
DELETE FROM core_resource WHERE code = 'deleteorder_setup';
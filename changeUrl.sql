UPDATE core_config_data SET value = 'http://www.example.com/' WHERE path LIKE 'web/unsecure/base_url';
UPDATE core_config_data SET value = 'https://www.example.com/' WHERE path LIKE 'web/secure/base_url';

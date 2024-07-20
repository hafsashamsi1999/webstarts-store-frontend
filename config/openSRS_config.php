<?php
// Paths
// Setting default path to the same directory this file is in
if (!defined('DS')) define('DS', "/");
if (!defined('PS')) define('PS', "/");
if (!defined('CRLF')) define('CRLF', "\r\n");


if (!defined('OPENSRSURI')) define('OPENSRSURI', dirname(__FILE__));

/**
* OpenSRS Domain service directories include provisioning, lookup, and dns
*/

if (!defined('OPENSRSDOMAINS')) define('OPENSRSDOMAINS', OPENSRSURI . DS . 'domains');
/**
* OpenSRS trust service directory
*/
if (!defined('OPENSRSTRUST')) define('OPENSRSTRUST', OPENSRSURI . DS . 'trust');

/**
* OpenSRS publishing service directory
*/
if (!defined('OPENSRSPUBLISHING')) define('OPENSRSPUBLISHING', OPENSRSURI . DS . 'publishing');

/**
* OpenSRS email service (OMA) directory
*/
if (!defined('OPENSRSOMA')) define('OPENSRSOMA', OPENSRSURI . DS . 'OMA');

/**
* OpenSRS email service (APP) directory
*/
if (!defined('OPENSRSMAIL')) define('OPENSRSMAIL', OPENSRSURI . DS . 'mail');


if (!defined('OPENSRSFASTLOOKUP')) define('OPENSRSFASTLOOKUP', OPENSRSURI . DS . 'fastlookup');

/**
* OpenSRS reseller username
*/
if (!defined('OSRS_USERNAME')) define('OSRS_USERNAME', 'webstarts');

/**
* OpenSRS reseller private Key. Please generate a key if you do not already have one.
*/
if (!defined('OSRS_KEY')) define('OSRS_KEY', 'c2f04a1f82ac57b01b1b1c446d227d3a12b9a14b106f1d33f931506f6c3f4719e2c90966a024ffe9d2f92298d4ccfeef2576411c23d8a2ec');

/**
* OpenSRS default encryption type => ssl, sslv2, sslv3, tls
*/
if (!defined('CRYPT_TYPE')) define('CRYPT_TYPE', 'ssl');

/**
* OpenSRS domain service API url.
* LIVE => rr-n1-tor.opensrs.net, TEST => horizon.opensrs.net
*/
if (!defined('OSRS_HOST')) define('OSRS_HOST', 'rr-n1-tor.opensrs.net');

/**
* OpenSRS API SSL port
*/
if (!defined('OSRS_SSL_PORT')) define('OSRS_SSL_PORT', '55443');

/**
* OpenSRS protocol. XCP or TPP.
*/
if (!defined('OSRS_PROTOCOL')) define('OSRS_PROTOCOL', 'XCP');

/**
* OpenSRS version
*/
if (!defined('OSRS_VERSION')) define('OSRS_VERSION', 'XML:0.1');

/**
* OpenSRS domain service debug flag
*/
if (!defined('OSRS_DEBUG')) define('OSRS_DEBUG', 0);

/**
* OpenSRS API fastlookup port`
*/
if (!defined('OSRS_FASTLOOKUP_PORT')) define('OSRS_FASTLOOKUP_PORT', '51000');


/**
* OpenSRE Email API (OMA) Specific configurations
* Please change the value CHANGEME to your value
*/

/**
* OMA HOST
* LIVE => https://admin.hostedemail.com, TEST => https://admin.test.hostedemail.com
*/
if (!defined('MAIL_HOST')) define('MAIL_HOST', 'https://admin.b.hostedemail.com');

/**
* Your company level username
*/
if (!defined('MAIL_USERNAME')) define('MAIL_USERNAME', 'admin@webstarts.adm');
//define('MAIL_USERNAME', 'webstarts');

/**
* Your company level password
*/
if (!defined('MAIL_PASSWORD')) define('MAIL_PASSWORD', 'xya9vZ/FXsxA2B');
//define('MAIL_PASSWORD', 'WebStarts~2407');
//define('MAIL_PASSWORD', 'We2bS4ta0rt7s');

/**
* OMA environment LIVE or TEST
*/
if (!defined('MAIL_ENV')) define('MAIL_ENV', 'LIVE');

/**
* OMA Client tool info. i.e. OpenSRS PHP Toolkit
*/
if (!defined('MAIL_CLIENT')) define('MAIL_CLIENT', 'OpenSRS PHP Toolkit');


/**
* APP Email Specific configurations
*
* WARNING: This APP libs will eventually be deprecated and replace by OMA.
*/

/**
* OpenSRS APP HOST
* LIVE => ssl://admin.hostedemail.com, TEST => ssl://admin.test.hostedemail.com
*/
if (!defined('APP_MAIL_HOST')) define('APP_MAIL_HOST', 'ssl://admin.hostedemail.com');

/**
* OpenSRS APP Username
*/
if (!defined('APP_MAIL_USERNAME')) define('APP_MAIL_USERNAME', 'admin');

/**
* OpenSRS APP Password
*/
if (!defined('APP_MAIL_PASSWORD')) define('APP_MAIL_PASSWORD', 'WebStarts~2407');

/**
* OpenSRS APP domain
*/
if (!defined('APP_MAIL_DOMAIN')) define('APP_MAIL_DOMAIN', 'webstarts.adm');

/**
* OpenSRS APP mail port
*/
if (!defined('APP_MAIL_PORT')) define('APP_MAIL_PORT', '4449');

/**
* OpenSRS APP mail portwait
*/
if (!defined('APP_MAIL_PORTWAIT')) define('APP_MAIL_PORTWAIT', '10');

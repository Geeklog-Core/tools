<?php

// this file can't be used on its own
if (stripos($_SERVER['PHP_SELF'], 'config.php') !== false) {
    die('This file cannot be used on its own!');
}
// ******************************
// ******** CONFIGURATION *******
// ******************************

// Version: Geeklog version
// Date: Date of release
// Supported: Is support currently being offered for version (ie can webmasters expect security fixes, etc...)
// Upgrade: Is the alternate upgrade version for the version. For example this could be for security fixes for 
//			an old version like 2.2.1 to 2.2.1sr1 but meanwhile there is a new version Geeklog 2.2.2 that
//			already contains the fixes along with new features

// All releases ordered by version number
$releases = [
    ['version' => '1.4.1',      'date' => '31-Dec-06', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.0',      'date' => '15-Jun-08', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.1',      'date' => '22-Sep-08', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2',      'date' => '08-Feb-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2sr1',   'date' => '30-Mar-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2sr2',   'date' => '04-Apr-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2sr3',   'date' => '13-Apr-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2sr4',   'date' => '18-Apr-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2sr5',   'date' => '30-Jul-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.5.2sr6',   'date' => '09-May-10', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.6.0',      'date' => '19-Jul-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.6.0sr1',   'date' => '30-Jul-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.6.0sr2',   'date' => '30-Aug-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.6.1',      'date' => '22-Nov-09', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.6.1sr1',   'date' => '09-May-10', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.6.1sr2',   'date' => '02-Jan-11', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.7.0',      'date' => '01-Jul-10', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.7.1',      'date' => '31-Oct-10', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.7.1sr1',   'date' => '02-Jan-11', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.7.2',      'date' => '20-Feb-11', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.8.0',      'date' => '12-Jun-11', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.8.1',      'date' => '09-Oct-11', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.8.2',      'date' => '30-Dec-12', 'supported' => false, 'upgrade' => ''],
    ['version' => '1.8.2sr1',   'date' => '19-Feb-13', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.0.0',      'date' => '31-Mar-13', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.1.0',      'date' => '12-Jul-14', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.1.1',      'date' => '09-Dec-15', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.1.2',      'date' => '01-Mar-17', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.1.3',      'date' => '22-Jun-17', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.2.0',      'date' => '26-Jun-18', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.2.1',      'date' => '26-Feb-20', 'supported' => false, 'upgrade' => ''],
    ['version' => '2.2.1sr1',   'date' => '16-Apr-20', 'supported' => false,  'upgrade' => ''],
	['version' => '2.2.2',   	'date' => '27-Sep-22', 'supported' => true,  'upgrade' => '']
];

// Current stable version
$current = $releases[count($releases) - 1]['version']; // Last entry in the $releases array

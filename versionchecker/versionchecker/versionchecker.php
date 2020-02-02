<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Version Checker                                                   |
// +---------------------------------------------------------------------------+
// | versionchecker.php                                                        |
// |                                                                           |
// | Version checker page.                                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Rouslan Placella  - rouslan AT placella DOT com                  |
// |          Kenji ITO         - mystralkk AT gmail DOT com                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

// Include information about releases
require __DIR__ . '/config.php';

// ******************************
// ********** FUNCTIONS *********
// ******************************

/**
 * @param  string  $templateName
 * @param  array   $vars
 * @return string
 */
function render($templateName, array $vars)
{
    static $flags = null;

    // Set up flags for htmlspecialchars
    if ($flags === null) {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $flags = ENT_QUOTES | ENT_HTML5;
        } else {
            $flags = ENT_QUOTES;
        }
    }

    // Fetch temlate file
    $content = @file_get_contents(__DIR__ . '/templates/' . $templateName . '.thtml');

    if ($content === false) {
        return '';
    }

    // Replace placeholders with actual values
    foreach ($vars as $key => $value) {
        $content = str_replace(
            '{' . $key . '}',
            htmlspecialchars($value, $flags, 'utf-8'),
            $content
        );
    }

    return $content;
}

/**
* Prints the header
*
* @return   void
*
*/
function printHeader()
{
    global $LANG_VER;

    echo render('header', [
        'iso639_code'    => $LANG_VER['iso639_code'],
        'version_check'  => $LANG_VER['version_check'],
        'go_to_homepage' => $LANG_VER['go_to_homepage'],
    ]);
}

/**
* Prints a footer with a timeline image
*
* @param  string  $version  Geeklog version number that is being checked
* @param  int     $case     Represents the outcome of the comparison, possible values are:
*                             1 - invalid version number
*                             2 - OK, version up-to-date
*                             3 - upgrade
*                             4 - upgrade - alternative available
*                             5 - obsolete
*                             6 - Development
*                             7 - Not a release, maybe an rc or a beta
* @param  string  $language
*/
function printFooter($version, $case, $language)
{
    global $LANG_VER;

    $case = (int) $case;
    echo render('footer', [
        'case'     => $case,
        'language' => $language,
        'timeline' => $LANG_VER['timeline'],
        'version'  => $version,
    ]);
    die();
}

/**
* Checks if a string could be a valid geeklog version
*
* @param   string  $version  Geeklog version number that is being checked
* @return  bool
*/
function isValidVersion($version = '')
{
    $valid   = true;

    // some minimal parameter filtering ...
    $v = explode('.', $version);
    if ((count($v) !== 3) || !is_numeric($v[0]) || !is_numeric($v[1])) {
        $valid = false;
    } else {
        $v = COM_versionConvert($version);
        $v = explode('.', $v);

        foreach ($v as $key => $value) {
            if (!is_numeric($value)) {
                $valid = false;
                break;
            }
        }
    }

    return $valid;
}

/**
* Common function used to convert a Geeklog version number into
* a version number that can be parsed by PHP's "version_compare()"
*
* @param   string  $version  Geeklog version number
* @return  string            Generic version number that can be correctly handled by PHP
*
*/
function COM_versionConvert($version)
{
    $version = strtolower($version);

    // Check if it's a bugfix release first
    $dash = strpos($version, '-');
    if ($dash !== false) {
        // Sometimes the bugfix part is not placed in the version number
        // according to the documentation and this needs to be accounted for
        $rearrange = true; // Assume incorrect formatting
        $b  = strpos($version, 'b');
        $rc = strpos($version, 'rc');
        $sr = strpos($version, 'sr');
        if ($b && $b<$dash) {
            $pos = $b;
        } else if ($rc && $rc<$dash) {
            $pos = $rc;
        } else if ($sr && $sr<$dash) {
            $pos = $sr;
        } else {
            // Version is correctly formatted
            $rearrange = false;
        }

        // Rearrange the version number, if needed
        if ($rearrange) {
            $ver = substr($version, 0, $pos);
            $cod = substr($version, $pos, $dash-$pos);
            $bug = substr($version, $dash+1);
            $version = $ver . '.' . $bug . $cod;
        } else { // This bugfix release version is correctly formatted
            // So there is an extra number in the version
            $version = str_replace('-', '.', $version);
        }
        $bugfix = '';
    } else {
        // Not a bugfix release, so we add a zero to compensate for the extra number
        $bugfix = '.0';
    }

    // We change the non-numerical part in the "versions" that were passed into the function
    // beta                      -> 1
    // rc                        -> 2
    // hg                        -> ignore
    // stable (e.g: no letters)  -> 3
    // sr                        -> 4
    if (strpos($version, 'b') !== false) {
        $version = str_replace('b', $bugfix . '.1.', $version);
    } else if (strpos($version, 'rc') !== false) {
        $version = str_replace('rc', $bugfix . '.2.', $version);
    } else if (strpos($version, 'sr') !== false) {
        $version = str_replace('sr', $bugfix . '.4.', $version);
    } else { // must be a stable version then...
        // we always ignore the 'hg' bit
        $version = str_replace('hg', '', $version);
        $version .= $bugfix . '.3.0';
    }

    return $version;
}

// ******************************
// ************ MAIN ************
// ******************************

$system_timezone = @date_default_timezone_get();
date_default_timezone_set($system_timezone);

// GET parameter
$version = '';
if (!empty($_GET['version'])) {
    $version = trim(strip_tags($_GET['version']));
}

// Include language file
$language = 'english';
if (!empty($_GET['language'])) {
    $language = preg_replace('/[^0-9a-z_-]/', '', strtolower($_GET['language']));
    $language = str_replace('_utf-8', '', $language);

    if (!is_readable(__DIR__ . '/language/' . $language . '.php')) {
        $language = 'english';
    }
}

include __DIR__ . '/language/' . $language . '.php';

if (!empty($_GET['timeline'])) {
    // Create and return a timeline graph
    $case = trim($_GET['case']);
    if (empty($case) || !is_numeric($case)) {
        $case = 1;
    }

    include __DIR__ . '/graph.php';
    die();
}

// Print the top part of the HTML page
header('Content-Type: text/html; charset=utf-8');
printHeader();

// ************************************
// case 1 - invalid version number
if (!isValidVersion($version)) {
    echo render('case1', [
        'error'           => $LANG_VER['error'],
        'case1_title'     => $LANG_VER['case1_title'],
        'case1_message1'  => $LANG_VER['case1_message1'],
        'case1_message2'  => $LANG_VER['case1_message2'],
        'case1_message3'  => $LANG_VER['case1_message3'],
        'case1_message4'  => $LANG_VER['case1_message4'],
        'download_now'    => $LANG_VER['download_now'],
        'geeklog_current' => sprintf($LANG_VER['geeklog_current'], $current),
        'view_all'        => $LANG_VER['view_all'],
    ]);
    printFooter('', 1, $language);
}

// ************************************
// case 2 - OK, version up-to-date
if ($version == $current) {
    echo render('case2', [
        'ok'                  => $LANG_VER['ok'],
        'case2_title'         => $LANG_VER['case2_title'],
        'case2_message1'      => $LANG_VER['case2_message1'],
        'case2_message2'      => $LANG_VER['case2_message2'],
        'case2_message3'      => $LANG_VER['case2_message3'],
        'view_all'            => $LANG_VER['view_all'],
        'available_downloads' => $LANG_VER['available_downloads'],
    ]);
    printFooter($version, 2, $language);
}

// ************************************
// case 3 - upgrade
// check for $version in $releases
$index = false;
foreach ($releases as $key => $release) {
    if ($version == $release['version']) {
        $index = $key;
        break;
    }
}
if ($index !== false && empty($releases[$index]['upgrade'])) {
    echo render('case3', [
        'warning'                => $LANG_VER['warning'],
        'upgrade_recommendation' => $LANG_VER['upgrade_recommendation'],
        'case3_message1'         => sprintf($LANG_VER['case3_message1'], $version),
        'case3_message2'         => (
            $releases[$index]['supported']
                ? sprintf($LANG_VER['case3_supported'], $current)
                : $LANG_VER['case3_unsupported']
        ),
        'case3_message3'         => $LANG_VER['case3_message3'],
        'recommended_upgrade'    => $LANG_VER['recommended_upgrade'],
        'download_geeklog_ver'   => sprintf($LANG_VER['download_geeklog_ver'], $current),
    ]);
    printFooter($version, 3, $language);
}

// ************************************
// case 4 - upgrade - alternative available
if ($index !== false && !empty($releases[$index]['upgrade'])) {
    echo render('case4', [
        'warning'                => $LANG_VER['warning'],
        'upgrade_recommendation' => $LANG_VER['upgrade_recommendation'],
        'case4_message1'         => sprintf($LANG_VER['case4_message1'], $version),
        'case4_message2'         => sprintf($LANG_VER['case4_message2'], $current),
        'case4_message3'         => sprintf($LANG_VER['case4_message3'], $releases[$index]['upgrade']),
        'case4_message4'         => $LANG_VER['case4_message4'],
        'recommended_upgrade'    => $LANG_VER['recommended_upgrade'],
        'download_geeklog_ver'   => sprintf($LANG_VER['download_geeklog_ver'], $current),
        'alternative_upgrade'    => $LANG_VER['alternative_upgrade'],
        'download_geeklog_alt'   => sprintf($LANG_VER['download_geeklog_ver'], $releases[$index]['upgrade']),
    ]);
    printFooter($version, 4, $language);
}

// ************************************
// case 5 - obsolete
if (version_compare(COM_versionConvert($version), COM_versionConvert($releases[0]['version']), '<')) {
    echo render('case5', [
        'warning'                => $LANG_VER['warning'],
        'upgrade_recommendation' => $LANG_VER['upgrade_recommendation'],
        'case5_message1'         => sprintf($LANG_VER['case5_message1'], $version, $current),
        'case5_message2'         => $LANG_VER['case5_message2'],
        'recommended_upgrade'    => $LANG_VER['recommended_upgrade'],
        'download_geeklog_ver'   => sprintf($LANG_VER['download_geeklog_ver'], $current),
    ]);
    printFooter($version, 5, $language);
}

// ************************************
// case 6 - Development
if (version_compare(COM_versionConvert($version), COM_versionConvert($current), '>')) {
    echo render('case6', [
        'info'                => $LANG_VER['info'],
        'case6_title'         => $LANG_VER['case6_title'],
        'case6_message1'      => $LANG_VER['case6_message1'],
        'current'             => $current,
        'case6_message2'      => sprintf($LANG_VER['case6_message2'], $version),
        'case6_message3'      => $LANG_VER['case6_message3'],
        'case6_message4'      => $LANG_VER['case6_message4'],
        'download_now'        => $LANG_VER['download_now'],
        'geeklog_current'     => sprintf($LANG_VER['geeklog_current'], $current),
        'view_all'            => $LANG_VER['view_all'],
        'available_downloads' => $LANG_VER['available_downloads'],
    ]);
    printFooter($version, 6, $language);
}

// ************************************
// case 7 - Not a release
// if the script did not exit yet, then it's not an official release, maybe an rc or a beta
echo render('case7', [
    'warning'              => $LANG_VER['warning'],
    'case7_message1'       => $LANG_VER['case7_message1'],
    'current'              => $current,
    'case7_message2'       => sprintf($LANG_VER['case7_message2'], $version),
    'case7_message3'       => $LANG_VER['case7_message3'],
    'case7_message4'       => sprintf($LANG_VER['case7_message4'], $current),
    'case7_message5'       => $LANG_VER['case7_message5'],
    'recommended_upgrade'  => $LANG_VER['recommended_upgrade'],
    'download_geeklog_ver' => sprintf($LANG_VER['download_geeklog_ver'], $current),
    'view_all'             => $LANG_VER['view_all'],
    'available_downloads'  => $LANG_VER['available_downloads'],
]);
printFooter($version, 7, $language);

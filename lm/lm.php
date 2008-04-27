#!/usr/local/bin/php -q 
<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | lm.php                                                                    |
// |                                                                           |
// | Update a language file by merging it with english.php                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2008 by the following authors:                         |
// |                                                                           |
// | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
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
//
// $Id: lm.php,v 1.3 2008/04/27 09:48:06 dhaun Exp $

$VERSION = '0.8';

// Prevent PHP from reporting uninitialized variables
error_reporting( E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR );

// name of the language file should be passed on the command line
$langfile = $GLOBALS['argv'][1];
if (empty ($langfile)) {
    echo "lm.php v{$VERSION}\n";
    echo "This is free software; see the source for copying conditions.\n\n";
    echo "Usage: {$GLOBALS['argv'][0]} langfile.php > new-langfile.php\n\n";
    exit;
}

$mb = false;
if (strpos($filename, '_utf-8') !== false) {
    $mb = true;

    if (!function_exists('mb_strpos')) {
        echo "Sorry, this script needs a PHP version that has multibyte support compiled in.\n\n";
        exit;
    } else if (!function_exists('mb_ereg_replace')) {
        echo "Sorry, this script needs a PHP version with the mb_ereg_replace function compiled in.\n\n";
        exit;
    }

    mb_regex_encoding('UTF-8');
    mb_internal_encoding('UTF-8');
}


// list of all variables accessed in the language file
$_DB_mysqldump_path         = '{$_DB_mysqldump_path}';
$_CONF['backup_path']       = '{$_CONF[\'backup_path\']}';
$_CONF['commentspeedlimit'] = '{$_CONF[\'commentspeedlimit\']}';
$_CONF['site_admin_url']    = '{$_CONF[\'site_admin_url\']}';
$_CONF['site_name']         = '{$_CONF[\'site_name\']}';
$_CONF['site_url']          = '{$_CONF[\'site_url\']}';
$_CONF['speedlimit']        = '{$_CONF[\'speedlimit\']}';
$_USER['username']          = '{$_USER[\'username\']}';

$failures                   = '{$failures}';
$from                       = '{$from}';
$fromemail                  = '{$fromemail}';
$qid                        = '{$qid}';
$shortmsg                   = '{$shortmsg}';
$successes                  = '{$successes}';
$topic                      = '{$topic}';
$type                       = '{$type}';

// load the English language file
require_once 'english.php';

// save the english text strings
$ENG01 = $LANG01;
// $LANG02 moved to the Calendar plugin as of Geeklog 1.4.1
$ENG03 = $LANG03;
$ENG04 = $LANG04;
$ENGMY = $LANG_MYACCOUNT;
$ENG05 = $LANG05;
// $LANG06 moved to the Links plugin as of Geeklog 1.4.0
// $LANG07 moved to the Polls plugin as of Geeklog 1.4.0
$ENG08 = $LANG08;
$ENG09 = $LANG09;
$ENG10 = $LANG10;
$ENG11 = $LANG11;
$ENG12 = $LANG12;
// there are no $LANG13-$LANG19
$ENG20 = $LANG20;
$ENG21 = $LANG21;
// $LANG22 moved to the Calendar plugin as of Geeklog 1.4.1
// $LANG23 moved to the Links plugin as of Geeklog 1.4.0
$ENG24 = $LANG24;
// $LANG25 moved to the Polls plugin as of Geeklog 1.4.0
// there is no $LANG26
$ENG27 = $LANG27;
$ENG28 = $LANG28;
$ENG29 = $LANG29;
// $LANG30 moved to the Calendar plugin as of Geeklog 1.4.1
$ENG31 = $LANG31;
$ENG32 = $LANG32;
$ENG33 = $LANG33;

$ENGMS = $MESSAGE;
$ENGAC = $LANG_ACCESS;
$ENGDB = $LANG_DB_BACKUP;
$ENGBT = $LANG_BUTTONS;
$ENG404 = $LANG_404;
$ENGLO = $LANG_LOGIN;
$ENGPD = $LANG_PDF;
$ENGTB = $LANG_TRB;
$ENGDI = $LANG_DIR;
$ENGWN = $LANG_WHATSNEW;
$ENGMO = $LANG_MONTH;
$ENGWK = $LANG_WEEK;
$ENGAD = $LANG_ADMIN;

$ENG_commentcodes = $LANG_commentcodes;
$ENG_commentmodes = $LANG_commentmodes;
$ENG_cookiecodes = $LANG_cookiecodes;
$ENG_dateformats = $LANG_dateformats;
$ENG_featurecodes = $LANG_featurecodes;
$ENG_frontpagecodes = $LANG_frontpagecodes;
$ENG_postmodes = $LANG_postmodes;
$ENG_sortcodes = $LANG_sortcodes;
$ENG_trackbackcodes = $LANG_trackbackcodes;

$ENG_CONFIG = $LANG_CONFIG;
$ENG_configsections['Core'] = $LANG_configsections['Core'];
$ENG_confignames['Core'] = $LANG_confignames['Core'];
$ENG_configsubgroups['Core'] = $LANG_configsubgroups['Core'];
$ENG_configsubgroups['Core'] = $LANG_configsubgroups['Core'];
$ENG_fs['Core'] = $LANG_fs['Core'];
$ENG_configselects['Core'] = $LANG_configselects['Core'];

unset($LANG_MONTH);
unset($LANG_WEEK);

// now load the language file we want to update
require_once $langfile;

// try to rescue translated day and months names

if (!isset ($LANG_WEEK[1]) && isset ($LANG30[1])) {
    $LANG_WEEK = array ();
    for ($i = 1; $i <= 7; $i++) {
        $LANG_WEEK[$i] = $LANG30[$i];
    }
}

if (!isset ($LANG_MONTH[1]) && isset ($LANG30[13])) {
    $LANG_MONTH = array ();
    for ($i = 1; $i <= 12; $i++) {
        $LANG_MONTH[$i] = $LANG30[$i + 12];
    }
}

function separator()
{
    echo "###############################################################################\n";
}

/**
* My mb-save replacement for some(!) string replacements
*
*/
function my_str_replace($s1, $s2, $s3)
{
    global $mb;

    if ($mb) {
        return mb_ereg_replace($s1, $s2, $s3);
    } else {
        return str_replace($s1, $s2, $s3);
    }
}

/**
* My mb-save replacement for some(!) use cases of strpos
*
*/
function my_strpos($s1, $s2)
{
    global $mb;

    if ($mb) {
        return mb_strpos($s1, $s2);
    } else {
        return strpos($s1, $s2);
    }
}

/**
* Replace <br> with '<br . XHTML . >' construct for XHTML compliance
*
*/
function patch_br($txt)
{
    global $mb;

    if ($mb) {
        $fc = mb_substr($txt, 0, 1);
    } else {
        $fc = substr($txt, 0, 1);
    }

    return my_str_replace('<br>',
                          '<br' . $fc . ' . XHTML . ' . $fc . '>', $txt);
}

/**
* Merge two language arrays
*
* This function does all the work. Any missing text strings are copied
* over from english.php. Also does some pretty-printing.
*
*/
function mergeArrays($ENG, $OTHER, $arrayName, $comment = '')
{
    global $mb;

    $numElements = sizeof($ENG);
    $counter = 0;

    if ($comment !== false) {
        separator();
    }
    if (!empty ($comment)) {
        $comments = explode ("\n", $comment);
        foreach ($comments as $c) {
            echo "# $c\n";
        }
    }
    echo "\n\${$arrayName} = array(\n";

    foreach ($ENG as $key => $txt) {
        $counter++;
        if (is_numeric($key)) {
            echo "    $key => ";
        } else {
            echo "    '$key' => ";
        }
        $newtxt = '';
        if (empty($OTHER[$key])) {
            // string does not exist in other language - use English text
            $newtxt = $txt;
        } else {
            if (isset($ENG[$key]) && empty($ENG[$key])) {
                // string is now empty in English language file - remove it
                $newtxt = '';
            } else {
                // string exists in other language - keep it
                $newtxt = $OTHER[$key];
            }
        }

        if (!is_array($newtxt)) {
            $newtxt = my_str_replace("\n", '\n', $newtxt);
        }

        if (is_array($newtxt)) { // mainly for the config selects
            $quotedtext = 'array(';
            foreach ($newtxt as $nkey => $ntxt) {
                $quotedtext .= "'" . my_str_replace("'", "\'", $nkey) . "' => ";
                if ($ntxt === true) {
                    $quotedtext .= 'true';
                } else if ($ntxt === false) {
                    $quotedtext .= 'false';
                } else if (is_numeric($ntxt)) {
                    $quotedtext .= $ntxt;
                } else {
                    $quotedtext .= "'" . my_str_replace("'", "\'", $ntxt) . "'";
                }
                $quotedtext .= ', ';
            }
            if ($mb) {
                $quotedtext = mb_substr($quotedtext, 0, -2);
            } else {
                $quotedtext = substr($quotedtext, 0, -2);
            }
            $quotedtext .= ')';

            // hack for this special case ...
            if ($quotedtext == "array('True' => 1, 'False' => '')") {
                $quotedtext = "array('True' => TRUE, 'False' => FALSE)";
            }

            // ??? $quotedtext = mb_ereg_replace("\n", '\n', $quotedtext);
        } else if (my_strpos ($newtxt, '{$') === false) {
            if (my_strpos ($newtxt, '\n') === false) {
                // text contains neither variables nor line feeds,
                // so enclose it in single quotes
                $newtxt = my_str_replace("'", "\'", $newtxt);
                $quotedtext = "'" . $newtxt . "'";
            } else {
                // text contains line feeds - enclose in double quotes so
                // they can be interpreted
                $newtxt = my_str_replace('"', '\"', $newtxt);
                $quotedtext = '"' . $newtxt . '"';
            }
        } else {
            // text contains variables
            if ($mb) {
                $newtxt = mb_ereg_replace('\$', '\$', $newtxt);
                // backslash attack!
                $newtxt = mb_ereg_replace('\{\\\\\$', '{$', $newtxt);
                $newtxt = mb_ereg_replace('"', '\"', $newtxt);
            } else {
                $newtxt = str_replace('$', '\$', $newtxt);
                $newtxt = str_replace('{\$', '{$', $newtxt);
                $newtxt = str_replace('"', '\"', $newtxt);
            }
            $quotedtext = '"' . $newtxt . '"';
        }

        $quotedtext = patch_br($quotedtext);

        if ($counter != $numElements) {
            $quotedtext .= ',';
        }
        echo "$quotedtext\n";
    }

    if ($comment === false) {
        echo ");\n";
    } else {
        echo ");\n\n";
    }
}

/**
* Read the credits / copyright from the other language file.
* Assumes that it starts and ends with a separator line of # signs.
*
*/
function readCredits($langfile)
{
    $credits = array ();

    $firstcomment = false;

    $fh = fopen ($langfile, 'r');
    if ($fh !== false) {
        while (true) {
            $line = fgets ($fh);
            if ($firstcomment) {
                $credits[] = $line;
                if (strstr ($line, '#####') !== false) {
                    // end of credits reached
                    break;
                }
            } else {
                if (strstr ($line, '#####') !== false) {
                    // start of credits
                    $firstcomment = true;
                    $credits[] = $line;
                }
            }
        }
        fclose ($fh);
    }

    return ($credits);
}


// MAIN

$credits = readCredits ($langfile);

// output starts here ...

echo "<?php\n\n";

foreach ($credits as $c) {
    echo "$c"; // Note: linefeeds are part of the credits
}

echo "\n\$LANG_CHARSET = '$LANG_CHARSET';\n";
if (isset ($LANG_DIRECTION)) {
    echo "\$LANG_DIRECTION = '$LANG_DIRECTION';\n\n";
} else {
    echo "\n";
}

separator();
echo "# Array Format:\n";
echo "# \$LANGXX[YY]:  \$LANG - variable name\n";
echo "#               XX    - file id number\n";
echo "#               YY    - phrase id number\n";
separator();
echo "\n";
separator();
echo "# USER PHRASES - These are file phrases used in end user scripts\n";
separator();
echo "\n";

mergeArrays($ENG01, $LANG01, 'LANG01', 'lib-common.php');
mergeArrays($ENG03, $LANG03, 'LANG03', 'comment.php');
mergeArrays($ENG04, $LANG04, 'LANG04', 'users.php');
mergeArrays($ENGMY,  $LANG_MYACCOUNT, 'LANG_MYACCOUNT', "Customize if need to modify the Tabbed navbar MyAccount panels used.\nArray index key matches preference div id");
mergeArrays($ENG05, $LANG05, 'LANG05', 'index.php');
mergeArrays($ENG08, $LANG08, 'LANG08', 'profiles.php');
mergeArrays($ENG09, $LANG09, 'LANG09', 'search.php');
mergeArrays($ENG10, $LANG10, 'LANG10', 'stats.php');
mergeArrays($ENG11, $LANG11, 'LANG11', 'article.php');
mergeArrays($ENG12, $LANG12, 'LANG12', 'submit.php');

separator();
echo "# ADMIN PHRASES - These are file phrases used in admin scripts\n";
separator();
echo "\n";

mergeArrays($ENG20, $LANG20, 'LANG20', 'admin/auth.inc.php');
mergeArrays($ENG21, $LANG21, 'LANG21', 'admin/block.php');
mergeArrays($ENG24, $LANG24, 'LANG24', 'admin/story.php');
mergeArrays($ENG27, $LANG27, 'LANG27', 'admin/topic.php');
mergeArrays($ENG28, $LANG28, 'LANG28', 'admin/user.php');
mergeArrays($ENG29, $LANG29, 'LANG29', 'admin/moderation.php');
mergeArrays($ENG31, $LANG31, 'LANG31', 'admin/mail.php');
mergeArrays($ENG32, $LANG32, 'LANG32', 'admin/plugins.php');
mergeArrays($ENG33, $LANG33, 'LANG33', 'admin/syndication.php');

mergeArrays($ENGMS,  $MESSAGE, 'MESSAGE', 'confirmation and error messages');
mergeArrays($ENGAC,  $LANG_ACCESS, 'LANG_ACCESS');
mergeArrays($ENGDB,  $LANG_DB_BACKUP, 'LANG_DB_BACKUP', 'admin/database.php');
mergeArrays($ENGBT,  $LANG_BUTTONS, 'LANG_BUTTONS');
mergeArrays($ENG404, $LANG_404, 'LANG_404', '404.php');
mergeArrays($ENGLO,  $LANG_LOGIN, 'LANG_LOGIN', 'login form');
mergeArrays($ENGPD,  $LANG_PDF, 'LANG_PDF', 'pdfgenerator.php');
mergeArrays($ENGTB,  $LANG_TRB, 'LANG_TRB', 'trackback.php');
mergeArrays($ENGDI,  $LANG_DIR, 'LANG_DIR', 'directory.php');
mergeArrays($ENGWN,  $LANG_WHATSNEW, 'LANG_WHATSNEW', "\"What's New\" Time Strings\n\nFor the first two strings, you can use the following placeholders.\nOrder them so it makes sense in your language:\n%i    item, \"Stories\"\n%n    amount, \"2\", \"20\" etc.\n%t    time, \"2\" (weeks)\n%s    scale, \"hrs\", \"weeks\"");
mergeArrays($ENGMO,  $LANG_MONTH, 'LANG_MONTH', 'Month names');
mergeArrays($ENGWK,  $LANG_WEEK, 'LANG_WEEK', 'Weekdays');
mergeArrays($ENGAD,  $LANG_ADMIN, 'LANG_ADMIN', "Admin - Strings\n\nThese are some standard strings used by core functions as well as plugins to\ndisplay administration lists and edit pages");

echo "# Localisation of the texts for the various drop-down menus that are actually\n# stored in the database. If these exist, they override the texts from the\n# database.\n";

mergeArrays($ENG_commentcodes, $LANG_commentcodes, 'LANG_commentcodes', false);
mergeArrays($ENG_commentmodes, $LANG_commentmodes, 'LANG_commentmodes', false);
mergeArrays($ENG_cookiecodes, $LANG_cookiecodes, 'LANG_cookiecodes', false);
mergeArrays($ENG_dateformats, $LANG_dateformats, 'LANG_dateformats', false);
mergeArrays($ENG_featurecodes, $LANG_featurecodes, 'LANG_featurecodes', false);
mergeArrays($ENG_frontpagecodes, $LANG_frontpagecodes, 'LANG_frontpagecodes', false);
mergeArrays($ENG_postmodes, $LANG_postmodes, 'LANG_postmodes', false);
mergeArrays($ENG_sortcodes, $LANG_sortcodes, 'LANG_sortcodes', false);
mergeArrays($ENG_trackbackcodes, $LANG_trackbackcodes, 'LANG_trackbackcodes', false);

echo "\n";
separator();
echo "# Localization of the Admin Configuration UI\n";

mergeArrays($ENG_CONFIG, $LANG_CONFIG, 'LANG_CONFIG', false);
mergeArrays($ENG_configsections['Core'], $LANG_configsections['Core'], "LANG_configsections['Core']", false);
mergeArrays($ENG_confignames['Core'], $LANG_confignames['Core'], "LANG_confignames['Core']", false);
mergeArrays($ENG_configsubgroups['Core'], $LANG_configsubgroups['Core'], "LANG_configsubgroups['Core']", false);
mergeArrays($ENG_fs['Core'], $LANG_fs['Core'], "LANG_fs['Core']", false);
mergeArrays($ENG_configselects['Core'], $LANG_configselects['Core'], "LANG_configselects['Core']", false);

echo "\n?>";

?>

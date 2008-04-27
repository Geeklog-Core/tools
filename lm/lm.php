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
// $Id: lm.php,v 1.5 2008/04/27 20:27:56 dhaun Exp $

$VERSION = '0.9';

// Prevent PHP from reporting uninitialized variables
error_reporting( E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR );

// name of the language file should be passed on the command line
$langfile = $GLOBALS['argv'][1];
if (empty ($langfile)) {
    echo "lm.php v{$VERSION}\n";
    echo "This is free software; see the source for copying conditions.\n\n";
    echo "Usage: {$GLOBALS['argv'][0]} langfile.php [module] > new-langfile.php\n\n";
    exit;
}

$module = '';
if (!empty($GLOBALS['argv'][2])) {
    $module = $GLOBALS['argv'][2];
}

$mb = false;
if (strpos($filename, '_utf-8') !== false) {
    $mb = true;

    if (!function_exists('mb_strpos')) {
        echo "Sorry, this script needs a PHP version that has multibyte support compiled in.\n\n";
        exit;
    } elseif (!function_exists('mb_ereg_replace')) {
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
if (empty($module)) {
    require_once 'language/english.php';
} else {
    require_once 'plugins/' . $module . '/language/english.php';
}

$lastp = strrpos($_SERVER['PHP_SELF'], DIRECTORY_SEPARATOR);
if ($lastp === false) {
    $incpath = '.' . DIRECTORY_SEPARATOR;
} else {
    $incpath = substr($_SERVER['PHP_SELF'], 0, $lastp + 1);
}
$incpath .= 'include' . DIRECTORY_SEPARATOR;

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
* Make <br> and <hr> tags XHTML compliant
*
*/
function makeXHTML($txt)
{
    global $mb;

    if ($mb) {
        $fc = mb_substr($txt, 0, 1);
    } else {
        $fc = substr($txt, 0, 1);
    }

    $txt = my_str_replace('<br>',
                          '<br' . $fc . ' . XHTML . ' . $fc . '>', $txt);
    $txt = my_str_replace('<hr>',
                          '<hr' . $fc . ' . XHTML . ' . $fc . '>', $txt);

    return $txt;
}

function prepareText($newtxt)
{
    global $mb;

    if (my_strpos($newtxt, '{$') === false) {
        if (my_strpos($newtxt, '\n') === false) {
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

    return $quotedtext;
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
                } elseif ($ntxt === false) {
                    $quotedtext .= 'false';
                } elseif (is_numeric($ntxt)) {
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
        } else {
            $quotedtext = prepareText($newtxt);
        }

        $quotedtext = makeXHTML($quotedtext);

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

function mergeString($eng, $other, $name)
{
    global $mb;

    if (empty($other)) {
        $newtxt = $eng;
    } else {
        $newtxt = $other;
    }

    $quotedtext = prepareText($newtxt);
    $quotedtext = makeXHTML($quotedtext);

    echo "\$$name = $quotedtext;\n";
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
                } elseif (strstr($line, '*/') !== false) {
                    // end of credits reached, Spam-X style
                    break;
                }
            } else {
                if (strstr ($line, '#####') !== false) {
                    // start of credits
                    $firstcomment = true;
                    $credits[] = $line;
                } elseif (strstr($line, '/**') !== false) {
                    // start of credits, Spam-X style
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

$credits = readCredits($langfile);

// output starts here ...

echo "<?php\n\n";

foreach ($credits as $c) {
    echo "$c"; // Note: linefeeds are part of the credits
}

// load the module file which does the rest

if (empty($module)) {
    require_once $incpath . 'core.inc';
} else {
    require_once $incpath . $module . '.inc';
}

echo "\n?>";

?>

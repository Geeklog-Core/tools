<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Version Checker                                                   |
// +---------------------------------------------------------------------------+
// | graph.php                                                                 |
// |                                                                           |
// | Graphics library.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Rouslan Placella  - rouslan AT placella DOT com>                 |
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

global $LANG_VER;

// this file can't be used on its own
if (stripos($_SERVER['PHP_SELF'], 'graph.php') !== false) {
    die('This file cannot be used on its own!');
}

// Font path
define('FONT_PATH', __DIR__ . '/fonts/' . $LANG_VER['graph']['font_name']);

// Init images
$im         = imagecreatetruecolor(825, 200); // Working canvas
$arrow      = imagecreatefrompng('img/graph/arrow.png');
$dot1       = imagecreatefrompng('img/graph/dot1.png');
$dot2       = imagecreatefrompng('img/graph/dot2.png');
// Init colours
$white      = imagecolorallocate($im, 255, 255, 255);
$green      = imagecolorallocate($im,   0, 100,   0);
$lightgray  = imagecolorallocate($im, 132, 132, 120);
$shadow     = imagecolorallocate($im, 200, 200, 200);
$gray       = imagecolorallocate($im,  46,  52,  54);
$black      = imagecolorallocate($im,   0,   3,   7);
imagefill($im, 1, 1, $white);
imageantialias($im, true);
imageinterlace($im, true);

// If there is an available alternative upgrade option, I want to know about it now
$upgrade = '';
if ($case == 4) {
    foreach ($releases as $key => $value) {
        if ($value['version'] == $version) {
            $upgrade = $value['upgrade'];
            break;
        }
    }
    $alt_upgrade_exists = false;
    foreach ($releases as $key => $value) {
        if ($value['version'] == $upgrade) {
            $alt_upgrade_exists = true;
            break;
        }
    }
    if (!$alt_upgrade_exists) { // No alternative upgrade found in $releases
        $case = 3; // switching to single upgrade mode
    }
}

// Sort releases by date
$r = $releases;
foreach ($r as $key => $value) {
    $v[] = $value['version'];
    $t[] = strtotime($value['date']);
    $d[] = date($LANG_VER['graph']['datetime_format'], strtotime($value['date']));
    $u[] = $value['upgrade'];
}
array_multisort($t, SORT_DESC, $v, SORT_DESC, $d, $u);
foreach ($t as $key => $value) {
    $r[$key] = array('version' => $v[$key], 'date' => $d[$key], 'upgrade' => $u[$key]);
}

// Initialise position for the timeline
$initpos= 780;
$pos = $initpos;
$path_drawn = false;

// Draw a line
imagefilledrectangle($im, 15, 100, $initpos+20, 103, $green);
imagecopymerge($im, $arrow, $initpos+20, 97, 0, 0, 7, 10, 100);

// Print label for current version
$offset = imagettfbbox(11, 0, FONT_PATH, $LANG_VER['graph']['current']);
$offset = (int)($offset[2] / 2);
imagettftext($im,  11, 0, $pos-$offset+1, 171, $shadow, FONT_PATH, $LANG_VER['graph']['current']);
imagettftext($im,  11, 0, $pos-$offset,   170, $black,  FONT_PATH, $LANG_VER['graph']['current']);
$offset = imagettfbbox(11, 0, FONT_PATH, $LANG_VER['graph']['version']);
$offset = (int)($offset[2] / 2);
imagettftext($im,  11, 0, $pos-$offset+1, 186, $shadow, FONT_PATH, $LANG_VER['graph']['version']);
imagettftext($im,  11, 0, $pos-$offset,   185, $black,  FONT_PATH, $LANG_VER['graph']['version']);

// Create the timeline
$index = 0;
while ($pos > 30) {
    // Print version
    $offset = imagettfbbox(10, 0, FONT_PATH, $r[$index]['version']);
    $offset = (int)($offset[2] / 2);
    imagettftext($im, 10, 0, $pos-$offset, 125, $gray, FONT_PATH, $r[$index]['version']);
    imagettftext($im, 10, 0, $pos-$offset, 125, $gray, FONT_PATH, $r[$index]['version']);
    // Print release date
    $offset = imagettfbbox(8, 0, FONT_PATH, $r[$index]['date']);
    $offset = (int)($offset[2] / 2);
    imagettftext($im,  8, 0, $pos-$offset, 140, $lightgray, FONT_PATH, $r[$index]['date']);
    // Print "Your version"
    if ($version == $r[$index]['version'] && $version != $current) {
        $offset = imagettfbbox(11, 0, FONT_PATH, $LANG_VER['graph']['your']);
        $offset = (int)($offset[2] / 2);
        imagettftext($im,  11, 0, $pos-$offset+1, 171, $shadow, FONT_PATH, $LANG_VER['graph']['your']);
        imagettftext($im,  11, 0, $pos-$offset,   170, $black,  FONT_PATH, $LANG_VER['graph']['your']);
        $offset = imagettfbbox(11, 0, FONT_PATH, $LANG_VER['graph']['version']);
        $offset = (int)($offset[2] / 2);
        imagettftext($im,  11, 0, $pos-$offset+1, 186, $shadow, FONT_PATH, $LANG_VER['graph']['version']);
        imagettftext($im,  11, 0, $pos-$offset,   185, $black,  FONT_PATH, $LANG_VER['graph']['version']);
    }
    // Draw the upgrade path
    if ($version == $r[$index]['version'] && $version != $current && ($case == 3 || $case == 4)) {
        $path_drawn = true;
        if ($case == 4) {
            $y      = 20;
            $offset = 30;
        } else {
            $y      = 60;
            $offset = 15;
        }
        imageline($im, $pos, 100, $pos+$offset, $y, $green);
        imageline($im, $pos+$offset, $y, $initpos+$offset, $y, $green);
        imageline($im, $initpos+$offset, $y, $initpos, 100, $green);
        // Add an arrow
        $arrowpos = (int)(($initpos-$pos)/2)+$pos+13;
        imageline($im, $arrowpos, $y, $arrowpos-4, $y+4, $green);
        imageline($im, $arrowpos, $y, $arrowpos-4, $y-4, $green);
        imageline($im, $arrowpos+1, $y, $arrowpos-3, $y+4, $green);
        imageline($im, $arrowpos+1, $y, $arrowpos-3, $y-4, $green);
        // Print label (prevent clipping)
        $width = imagettfbbox(11, 0, FONT_PATH, $LANG_VER['graph']['recommended_upgrade']);
        if (($pos + $offset + $width[2]) < 824) {
            imagettftext($im, 8, 0, $pos+$offset, $y-8, $black, FONT_PATH, $LANG_VER['graph']['recommended_upgrade']);
        } else {
            imagettftext($im, 8, 0, 824-$width[2], $y-8, $black, FONT_PATH, $LANG_VER['graph']['recommended_upgrade']);
        }
    }
    // Remember co-ordinates for the alternative upgrade path. We will draw that later
    if ($version == $r[$index]['version'] && $version != $current && $case == 4) {
        $alt_path_src = $pos;
    }
    if ($upgrade == $r[$index]['version']) {
        $alt_path_dest = $pos;
    }
    // Draw a dot
    if (strpos($r[$index]['version'], 'sr') !== false) {
        imagecopymerge($im, $dot2, $pos-4, 97, 0, 0, 10, 10, 100);
    } else {
        imagecopymerge($im, $dot1, $pos-4, 97, 0, 0, 10, 10, 100);
    }
    // Update variables for next item
    $index++;
    $pos-=67;
}

// Draw additional paths, if any
if ($case == 4) {
    // Draw the alternative upgrade path
    imageline($im, $alt_path_src+16, 60, $alt_path_dest+15, 60, $lightgray);
    imageline($im, $alt_path_dest+15, 60, $alt_path_dest, 100, $lightgray);
    // Add an arrow
    $arrowpos = (int)(($alt_path_dest-$alt_path_src)/2)+$alt_path_src+13;
    imageline($im, $arrowpos, 60, $arrowpos-4, 64, $lightgray);
    imageline($im, $arrowpos, 60, $arrowpos-4, 56, $lightgray);
    imageline($im, $arrowpos+1, 60, $arrowpos-3, 64, $lightgray);
    imageline($im, $arrowpos+1, 60, $arrowpos-3, 56, $lightgray);
    // Print label
    imagettftext($im, 8, 0, $alt_path_src+25, 52, $gray, FONT_PATH, $LANG_VER['graph']['alternative_upgrade']);
} elseif ($case == 5 || $case == 7 || ($case == 3 && !$path_drawn)) { // Old version or beta
    // Draw an upgrade suggestion
    $y      = 60;
    $offset = 15;
    $pos    = 500;
    imageline($im, $pos+$offset, $y, $initpos+$offset, $y, $green);
    imageline($im, $initpos+$offset, $y, $initpos, 100, $green);
    // Add an arrow
    $arrowpos = (int)(($initpos-$pos)/2)+$pos;
    imageline($im, $arrowpos, $y, $arrowpos-4, $y+4, $green);
    imageline($im, $arrowpos, $y, $arrowpos-4, $y-4, $green);
    imageline($im, $arrowpos+1, $y, $arrowpos-3, $y+4, $green);
    imageline($im, $arrowpos+1, $y, $arrowpos-3, $y-4, $green);
    // Print label
    imagettftext($im, 8, 0, $pos+$offset, $y-8, $black, FONT_PATH, $LANG_VER['graph']['recommended_upgrade']);
}

// Fix the dots
if (strpos($current, 'sr') !== false) {
    imagecopymerge($im, $dot2, $initpos-4, 97, 0, 0, 10, 10, 100);
} else {
    imagecopymerge($im, $dot1, $initpos-4, 97, 0, 0, 10, 10, 100);
}
if ($case == 4) {
    if (strpos($upgrade, 'sr') !== false) {
        imagecopymerge($im, $dot2, $alt_path_dest-4, 97, 0, 0, 10, 10, 100);
    } else {
        imagecopymerge($im, $dot1, $alt_path_dest-4, 97, 0, 0, 10, 10, 100);
    }
}

// Create the final image (adjusted to the correct size)
switch ($case) {
    case 3:
        $final = imagecreatetruecolor(825, 200);
        imagecopy($final, $im, 0, 0, 0, 0, 845, 200);
        break;
    case 4:
        $final = imagecreatetruecolor(825, 240);
        imagefill($final, 1, 1, $white);
        imagecopy($final, $im, 0, 40, 0, 0, 845, 200);
        break;
    case 5:
        $final = imagecreatetruecolor(825, 190);
        imagecopy($final, $im, 0, 0, 0, 10, 845, 190);
        break;
    case 1:
    case 2:
    case 7:
    default:
        $final = imagecreatetruecolor(825, 160);
        imagecopy($final, $im, 0, 0, 0, 40, 845, 160);
        break;
}

// Print image title
imagettftext($final, 12, 0, 15, 26, $black, FONT_PATH, $LANG_VER['graph']['recent_timeline']);

// Output
header('Content-Type: image/png');
imagepng($final);
imagedestroy($final);

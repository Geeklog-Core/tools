<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | File Management Plugin for Geeklog                                        |
// +---------------------------------------------------------------------------+
// | submit-local-file.php                                                     |
// |                                                                           |
// | Helper file to automate Geeklog releases: Add a Geeklog tarball to the    |
// | File Management submission queue.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Blaine Lang       - blaine AT portalparts DOT com                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

require_once '../lib-common.php';
require_once $_CONF['path'] . 'plugins/filemgmt/include/functions.php';
require_once $_CONF['path'] . 'plugins/filemgmt/include/textsanitizer.php';

/**
* Add a file to the submission queue
*
* Most of the code in this function has been lifted from the File Management
* plugin's submit.php
*
*/
function submit_file($submitter, $filename, $title, $desc, $version, $homepage, $cid = 0)
{
    global $_CONF, $_USER,
           $_FM_TABLES, $_FMDOWNLOAD, $filemgmt_FileStore;

    $myts = new MyTextSanitizer; // MyTextSanitizer object

    $name = basename($filename);
    $url = rawurlencode($name);
    $name = $myts->makeTboxData4Save($name);
    $url = $myts->makeTboxData4Save($url);

    if (DB_count($_FM_TABLES['filemgmt_filedetail'], 'url', $name) > 0) {
        COM_errorLog("FM submit_file: file '" . $name . "' already exists in DB");
        return false;
    }

    $title = $myts->makeTboxData4Save($title);
    $homepage = $myts->makeTboxData4Save($homepage);
    $version = $myts->makeTboxData4Save($version);
    $size = sprintf('%u', filesize($filename));
    $description = $myts->makeTareaData4Save($desc);
    //$comments = ($_CONF['comment_code'] == 0) ? 1 : 0;
    $comments = 0; // prefer no comments on Geeklog tarballs
    $date = time();
    $tmpfilename = randomfilename();

    $uploadfilename = basename($filename);
    $pos = strrpos($uploadfilename, '.') + 1;
    $fileExtension = strtolower(substr($uploadfilename, $pos));
    if (array_key_exists($fileExtension, $_FMDOWNLOAD)) {
        if ($_FMDOWNLOAD[$fileExtension] == 'reject') {
            COM_errorLog("FM submit_file: file extension '" . $fileExtension . "' not allowed.");
            return false;
        }
        $fileExtension = $_FMDOWNLOAD[$fileExtension];
        $tmpfilename = $tmpfilename . '.' . $fileExtension;
        $pos = strrpos($url, '.') + 1;
        $url = strtolower(substr($url, 0, $pos)) . $fileExtension;
    } else {
        $tmpfilename = $tmpfilename . '.' . $fileExtension;
    }

    rename($filename, $filemgmt_FileStore . 'tmp/' . $tmpfilename);

    $logourl = '';

    DB_query("INSERT INTO {$_FM_TABLES['filemgmt_filedetail']} (cid, title, url, homepage, version, size, platform, logourl, submitter, status, date, hits, rating, votes, comments) VALUES ('$cid', '$title', '$url', '$homepage', '$version', '$size', '$tmpfilename', '$logourl', '$submitter', 0, '$date', 0, 0, 0, '$comments')");
    $newid = DB_insertId();
    DB_query("INSERT INTO {$_FM_TABLES['filemgmt_filedesc']} (lid, description) VALUES ($newid, '$description')");

    return true;
}


// MAIN
$display = '';
$nightly = $_CONF['path_html'] . 'nightly/';

if (count($_GET) == 3) {
    if (isset($_GET['md5']) && isset($_GET['filename']) && isset($_GET['action'])) {
        if ($_GET['action'] == 'geeklog_release') {
            $filename = COM_sanitizeFilename($_GET['filename'], true);
            if (! empty($filename)) {
                if (substr($filename, 0, strlen('geeklog')) == 'geeklog') {
                    $filename = $nightly . $filename;
                    if (file_exists($filename)) {
                        $md5 = md5_file($filename);
                        if ($md5 == $_GET['md5']) {
                            COM_errorLog("Accepting submission of $filename");
                        } else {
                            unset($filename);
                            unset($md5);
                        }
                    } else {
                        unset($filename);
                    }
                } else {
                    unset($filename);
                }
            }
        }
    }
}

if (empty($filename) || empty($md5)) {
    COM_displayMessageAndAbort(30, '', 403, 'Forbidden');
}

unset($_POST);
$_REQUEST = $_GET;

if (COM_isAnonUser()) {
    $submitter = 2; // yes, the Admin account
} else {
    $submitter = $_USER['uid'];
}

// extract version from file name
$g = basename($filename);
$p = explode('.', $g);
if (count($p) == 5) {
    array_pop($p); // drop .gz
    array_pop($p); // drop .tar
    $g = implode('.', $p);
    $p = explode('-', $g);
    if (count($p) == 2) {
        $version = $p[1];
    }
}

if (! isset($version)) {
    COM_displayMessageAndAbort(30, '', 403, 'Forbidden');
}

$title = 'Geeklog ' . $version;
$desc = "Geeklog $version\n(description goes here)\nmd5 checksum: $md5";
$url = 'http://www.geeklog.net/';

if (! submit_file($submitter, $filename, $title, $desc, $version, $url, 8)) {
    COM_displayMessageAndAbort(30, '', 403, 'Forbidden');
}

$display .= 'Done.';

COM_output($display);

?>

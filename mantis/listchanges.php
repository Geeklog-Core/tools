<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog                                                                   |
// +---------------------------------------------------------------------------+
// | listchanges.php                                                           |
// |                                                                           |
// | Get a list of resolved issues for a given Geeklog version from Mantis.    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2011-2012 by the following authors:                         |
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

error_reporting(E_ALL);

$user = '';
$password = '';
$version = '2.0.0';
$per_page = 25;
$project = 'Geeklog';

// command line handling - user + password are required
$args = getopt("", array('user:', 'password:',
                         'version::', 'per-page::', 'project::'));

if (isset($args['user']) && $args['user'] !== false) {
    $user = $args['user'];
}
if (isset($args['password']) && $args['password'] !== false) {
    $password = $args['password'];
}
if (isset($args['version']) && $args['version'] !== false) {
    $version = $args['version'];
}
if (isset($args['per-page']) && $args['per-page'] !== false) {
    $per_page = (int) $args['per-page'];
}
if (isset($args['project']) && $args['project'] !== false) {
    $project = $args['project'];
}

if (empty($user) || empty($password)) {
    echo "Please specify a username and password.\n";
    exit;
}

require_once 'MantisConnect.php';

$m = new MantisConnect();

$project_id = $m->mc_project_get_id_from_name($user, $password, $project);
$all_issues = array();
for ($i = 1; $i <= 10; $i++) {
    try {
        $all_issues[] = $m->mc_project_get_issues($user, $password, $project_id, $i, $per_page);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        break;
    }
}

$issues = array();
for ($i = 0; $i < count($all_issues); $i++) {
    $issues = array_merge($issues, $all_issues[$i]);
}

for ($i = 0; $i < count($issues); $i++) {
    $obj = $issues[$i];

    $status = $obj->status;
    if ($status->name != 'resolved') {
        //echo "Not resolved: " . $obj->summary . "\n";
        continue;
    }
    if (isset($obj->fixed_in_version)) {
        if ($obj->fixed_in_version != $version) {
            continue;
        }
    } else {
        continue;
    }

    if (! isset($obj->handler)) {
        continue;
    }
    $fixedby = $obj->handler;
    $type = "bug";
    if ($obj->category == "Patches") {
        $type = "patch";
    } elseif ($obj->category == "Feature Requests") {
        $type = "feature request";
    }
/*
    if ($type == "patch") {
        if (count($obj->attachments) > 0) {
            $numa = count($obj->attachments);
            for ($a = 0; $a < $numa; $a++) {
                $att = $obj->attachments[$a];
                //echo "Attachment: " . $att->filename;
                //$ai = $m->mc_issue_attachment_get($user, $password, $att->id);
            }
        }
    }
*/
    $credits = $fixedby->name;
    if (isset($fixedby->real_name) && !empty($fixedby->real_name)) {
        $c = explode(' ', $fixedby->real_name);
        $credits = $c[0];
    }
    $change = sprintf("%s (%s #%07d) [%s]", $obj->summary, $type, $obj->id,
                                            $credits);

    $formatted = wordwrap($change, 78);

    $lines = explode("\n", $formatted);
    $msg = "";
    foreach ($lines as $l) {
        if (empty($msg)) {
            $msg .= "- $l\n";
        } else {
            $msg .= "  $l\n";
        }
    }

    echo $msg;
}

?>

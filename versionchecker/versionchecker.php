<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Geeklog Version Check</title>
  <link rel="stylesheet" type="text/css" href="http://www.geeklog.net/docs/docstyle.css" title="Dev Stylesheet">
</head>

<body>
<p align="left"><a href="http://www.geeklog.net/" title="go to the Geeklog homepage"><img src="http://www.geeklog.net/docs/images/newlogo.gif" alt="" width="243" height="90" border="0"></a></p>
<?php

$current = '1.6.0sr1';
$version = '';
if (isset ($_GET['version'])) {
    $version = strip_tags ($_GET['version']);
}

$upgrade = array (
/*
    '1.3.9'     => '1.3.9sr4',
    '1.3.9sr1'  => '1.3.9sr4',
    '1.3.9sr2'  => '1.3.9sr4',
    '1.3.9sr3'  => '1.3.9sr4',
    '1.3.10'    => '1.3.11sr7-1',
    '1.3.11'    => '1.3.11sr7-1',
    '1.3.11sr1' => '1.3.11sr7-1',
    '1.3.11sr2' => '1.3.11sr7-1',
    '1.3.11sr3' => '1.3.11sr7-1',
    '1.3.11sr4' => '1.3.11sr7-1',
    '1.3.11sr5' => '1.3.11sr7-1',
    '1.3.11sr6' => '1.3.11sr7-1',
    '1.3.11sr7' => '1.3.11sr7-1',
    '1.4.0'     => '1.5.2sr4',
    '1.4.0sr1'  => '1.5.2sr4',
    '1.4.0sr2'  => '1.5.2sr4',
    '1.4.0sr3'  => '1.5.2sr4',
    '1.4.0sr4'  => '1.5.2sr4',
    '1.4.0sr5'  => '1.5.2sr4',
    '1.4.0sr5-1' => '1.5.2sr4',
    '1.4.0sr6'  => '1.5.2sr4',
*/
    '1.4.1'     => '1.6.0sr1',
    '1.5.0'     => '1.6.0sr1',
    '1.5.1'     => '1.6.0sr1',
    '1.5.2'     => '1.5.2sr5',
    '1.5.2sr1'  => '1.5.2sr5',
    '1.5.2sr2'  => '1.5.2sr5',
    '1.5.2sr3'  => '1.5.2sr5',
    '1.5.2sr4'  => '1.5.2sr5',
    '1.5.2sr5'  => '1.6.0sr1',
    '1.6.0'     => '1.6.0sr1'
);

$v = explode ('.', $version);

// some minimal parameter filtering ...
if ((count ($v) != 3) || !is_numeric ($v[0]) || !is_numeric ($v[1])) {
    echo '<p>Version number not recognized.</p></body></html>';
    exit;
}

$v2 = (int) $v[1];

if ($version == $current) {
   echo '<p>Your Geeklog installation is up-to-date.</p>';
} else {
    $version = htmlentities ($version);
    if ($v2 < 4) {
        echo '<h1>Upgrade recommendation</h1>';
        echo '<p>The Geeklog version you are running (' . $version . ') is rather old and not supported any more. In your own interest, we strongly encourage you to upgrade to the current release, ' . $current . ', which is <a href="http://www.geeklog.net/filemgmt/viewcat.php?cid=8" title="go to the Geeklog download section">available for download</a> from the Geeklog homepage.</p>';
    } else {
        if (isset ($upgrade[$version])) {
            if ($upgrade[$version] == $current) {
                echo '<h1>Upgrade recommendation</h1>';
                // echo '<p>The Geeklog version you are running (' . $version . ') is out of date and possibly insecure. Please <a href="http://www.geeklog.net/filemgmt/viewcat.php?cid=8" title="go to the Geeklog download section">update to the current version</a>, ' . $current . ', as soon as possible.</p>';
                echo '<p>The Geeklog version you are running (' . $version . ') is out of date. We recommend <a href="http://www.geeklog.net/filemgmt/viewcat.php?cid=8" title="go to the Geeklog download section">updating to the current version</a>, ' . $current . ', at your earliest convenience.</p>';
            } else {
                echo '<h1>Upgrade recommendation</h1>';
                echo '<p>For the Geeklog version you are running (' . $version . '), there are two upgrade paths available: You can either <a href="http://www.geeklog.net/filemgmt/viewcat.php?cid=8" title="go to the Geeklog download section">upgrade to the most recent version</a> (' . $current . ') or, if you don\'t want to do that just yet, we suggest that you at least <a href="http://www.geeklog.net/filemgmt/viewcat.php?cid=10" title="go to the Geeklog download section">upgrade to version ' . $upgrade[$version] . '</a> as soon as possible.</p>';
            }
        } else {
            echo '<p>The current version of Geeklog is <strong>' . $current . '</strong> but it seems you are running Geeklog ' . $version . '.</p>';
            echo '<p>You are running either an old version of Geeklog <em>or</em> you are running a beta version.  If you are running an older version of Geeklog you are encouraged to <a href="http://www.geeklog.net/filemgmt/viewcat.php?cid=8" title="go to the Geeklog download section">upgrade now</a>.</p>';
        }
    }
}

?>
</body>
</html>

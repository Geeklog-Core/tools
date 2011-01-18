<?php

// Include information about releases
require('config.php');

// ******************************
// ********** FUNCTIONS *********
// ******************************

/**
* Prints the header
*
* @return   void
*
*/
function printHeader()
{
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Geeklog Version Check</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="versionchecker/style.css">
</head>
<body>
<div class="top">
    <a style="position: relative; top: 60px;" href="http://www.geeklog.net/" title="go to the Geeklog homepage">
    <img src="versionchecker/img/speck.gif" width="462" height="150" alt="" border="0"></a>
</div>
<div class="main">
<div class="content">
<table border="0" cellpadding="12" cellspacing="0"><tr><td style="width:48px; vertical-align: top; padding-top: 50px;">
<?php
}

/**
* Prints a footer with a timeline image
*
* @param    string  $version        Geeklog version number that is being checked
* @param    int     $case           Represents the outcome of the comparison, possible values are:
*                                   1 - invalid version number
*                                   2 - OK, version up-to-date
*                                   3 - upgrade
*                                   4 - upgrade - alternative available
*                                   5 - obsolete
*                                   6 - Development
*                                   7 - Not a release, maybe an rc or a beta
* @return   void
*
*/
function printFooter($version='', $case)
{
    echo "</td></tr></table>\n";
    echo "<img alt='Timeline of recent Geeklog releases' class='timeline' src='versionchecker/versionchecker.php?timeline=1&amp;version=" . $version . "&amp;case=" . $case . "'></div></div>";
    echo "<div class=\"bottom\">&nbsp;</div></body></html>";
    die();
}

/**
* Checks if a string could be a valid geeklog version
*
* @param    string  $version        Geeklog version number that is being checked
* @return   bool                    true/false
*
*/
function isValidVersion($version='')
{
    $valid   = true;
    // some minimal parameter filtering ...
    $v = explode ('.', $version);
    if ((count ($v) != 3) || !is_numeric ($v[0]) || !is_numeric ($v[1])) {
        $valid = false;
    } else {
        $v = COM_versionConvert($version);
        $v = explode ('.', $v);
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
* @param    string  $version        Geeklog version number
* @return   string                  Generic version number that can be correctly handled by PHP
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

// GET parameter
$version = '';
if (!empty($_GET['version'])) {
    $version = trim(strip_tags($_GET['version']));
}

if (!empty($_GET['timeline'])) {
    // Create and return a timeline graph
    $case = trim($_GET['case']);
    if (empty($case) || !is_numeric($case)) {
        $case = 1;
    }
    include('graph.php');
    die();
}

printHeader(); // Print the top part of the HTML page

// ************************************
// case 1 - invalid version number
if (!isValidVersion($version)) {
    echo "<img src='versionchecker/img/icons/critical.png' alt='Error!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<h1>Sorry, an ERROR has occured while processing your request.</h1>\n";
    echo "<p>We were unable to recognise the version number of your current Geeklog installation. \n";
    echo "If this problem persists, please visit <a href='http://www.geeklog.net/staticpages/index.php/20011217123134458'>this page</a>\n ";
    echo "to discover how you can get support.<p>We apologise for any inconvenience that this may have caused you.</p>\n";
    echo "</td><td style='width: 237px;'>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=8'>Download Now<br>Geeklog $current </a></div><p>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/index.php'>View All<br>Available Downloads</a></div>\n";
    printFooter('', 1);
}

// ************************************
// case 2 - OK, version up-to-date
if ($version == $current) {
    echo "<img src='versionchecker/img/icons/ok.png' alt='OK!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<h1>Congratulations, your Geeklog installation is up-to-date.</h1>\n";
    echo "<p>At the moment no action is required on your part to keep your installation secure. \n";
    echo "However, we recommend that you make regular use of this version checker to ensure that you are \n";
    echo "aware of any available updates. Alternatively, you may subscribe to the low-volume \n";
    echo "<a href='http://eight.pairlist.net/mailman/listinfo/geeklog-announce'>announcements mailing list</a> to receive information about updates.</p>\n";
    echo "</td><td style='width: 237px;'>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/index.php'>View All<br>Available Downloads</a></div>\n";
    printFooter($version, 2);
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
    echo "<img src='versionchecker/img/icons/warning.png' alt='Warning!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<h1>Upgrade Recommendation</h1>\n";
    echo "<p>The Geeklog version you are running, $version, is out of date";
    if (!$releases[$index]['supported']){
        // Unsupported
        echo " and is no longer supported. In your own interest, we strongly encourage you to upgrade to the current release.\n";
    } else {
        // Supported
        echo ". We recommend upgrading to the current version, $current, at your earliest convenience.\n";
    }
    echo "<p>Click on the button located on the right side of this page to receive the latest version of Geeklog.</p>\n";
    echo "</td><td style='width: 237px;'>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=8'>RECOMMENDED UPGRADE<br>Download Geeklog $current</a></div><p>\n";
    printFooter($version, 3);
}

// ************************************
// case 4 - upgrade - alternative available
if ($index !== false && !empty($releases[$index]['upgrade'])) {
    echo "<img src='versionchecker/img/icons/warning.png' alt='Warning!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<h1>Upgrade recommendation</h1>\n";
    echo "<p>There are two upgrade paths available for the Geeklog version ($version) that you are running.<p>\n";
    echo "The recommended upgrade for your installation is to version $current. \n";
    echo "This upgrade provides bugfixes and will also provide you with some new features.<p>\n";
    echo "Alternatively you may choose to upgrade to version " . $releases[$index]['upgrade'] . ". \n";
    echo "This upgrade resolves important security issues, but will not provide you with any new features.<p>\n";
    echo "We recommend that you perform one of the two available upgrades as soon as possible by clicking on the buttons located on the right side of this page</p>\n";
    echo "</td><td style='width: 237px;'>";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=8'>RECOMMENDED UPGRADE<br>Download Geeklog $current </a></div><p>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=10'>ALTERNATIVE UPGRADE<br>Download Geeklog " . $releases[$index]['upgrade'] . "</a></div>\n";
    printFooter($version, 4);
}

// ************************************
// case 5 - obsolete
if (version_compare(COM_versionConvert($version), COM_versionConvert($releases[0]['version']), '<')) {
    echo "<img src='versionchecker/img/icons/warning.png' alt='Warning!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<h1>Upgrade Recommendation</h1>\n";
    echo "<p>The Geeklog version you are running, $version, is rather old and not supported any more. In your own interest, ";
    echo "we strongly encourage you to upgrade to the current release, $current.<p>";
    echo "<p>Click on the button located on the right side of this page to receive the latest version of Geeklog.</p>\n";
    echo "</td><td style='width: 237px;'>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=8'>RECOMMENDED UPGRADE<br>Download Geeklog $current</a></div><p>";
    printFooter($version, 5);
}

// ************************************
// case 6 - Development
if (version_compare(COM_versionConvert($version), COM_versionConvert($current), '>')) {
    echo "<img src='versionchecker/img/icons/info.png' alt='Info!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<h1>Development version detected</h1>\n";
    echo "<p>The current version of Geeklog is <strong>$current</strong> but it seems you are running Geeklog $version, which looks like a development version.<p>";
    echo "Please note that it is not recommended to use a development version of Geeklog in a production environment as it may ";
    echo " be unstable. You may receive the latest stable version of Geeklog by clicking on the button located on the right side of this page.<p>";
    echo "If you are a Geeklog developer, then you probably already knew all this. So, happy coding!</p>\n";
    echo "</td><td style='width: 237px;'>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=8'>Download Now<br>Geeklog $current </a></div><p>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/index.php'>View All<br>Available Downloads</a></div>";
    printFooter($version, 6);
}

// ************************************
// case 7 - Not a release
// if the script did not exit yet, then it's not an official release, maybe an rc or a beta
    echo "<img src='versionchecker/img/icons/warning.png' alt='Warning!' width='48' height='48'>\n";
    echo "</td><td>\n";
    echo "<p>The current version of Geeklog is <strong>$current</strong> but it seems you are running Geeklog $version.</p>";
    echo "<p>You are not running an official release of Geeklog, in fact it appears to be an old \"Release Candidate\" or \"Beta\" version.";
    echo "<p>We strongly encourage you to upgrade to the current release, $current, as soon as possible.";
    echo "<p>Click on the button located on the right side of this page to receive the latest version of Geeklog.</p>\n";
    echo "</td><td style='width: 237px;'>\n";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/viewcat.php?cid=8'>RECOMMENDED UPGRADE<br>Download Geeklog $current</a></div><p>";
    echo "<div class='button'><a href='http://www.geeklog.net/filemgmt/index.php'>View All<br>Available Downloads</a></div>";
    printFooter($version, 7);

?>

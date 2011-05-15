<?php

// ported over from the 1.4.1 trunk:
function CUSTOM_emailMatches ($email, $domain_list)
{
    $match_found = false;

    if (!empty ($domain_list)) {
        $domains = explode (',', $domain_list);

        // Note: We should already have made sure that $email is a valid address
        $email_domain = substr ($email, strpos ($email, '@') + 1);

        foreach ($domains as $domain) {
            if (preg_match ("#$domain#i", $email_domain)) {
                $match_found = true;
                break;
            }
        }
    }

    return $match_found;
}


/****
*
* Shout box test
*
*
* you need to put this in your database:
*
*	CREATE TABLE `shoutbox` (
*	`id` int(11) NOT NULL auto_increment,
*	`name` text NOT NULL,
*	`message` longtext NOT NULL,
*	`time` text NOT NULL,
*	PRIMARY KEY (`id`)
*	) TYPE=MyISAM;
*
*/

function phpblock_shoutblock()
{
    global $_TABLES,$_USER,$HTTP_COOKIE_VARS,$HTTP_POST_VARS,$PHP_SELF,$REMOTE_ADDR,$LANG01,$_CONF;

    $shout_out = "";

    $wrap_width = 20;
    $max_stories = 5;
    $welcome = "Welcome to shoutbox.<p>";

    $shout_out .= $welcome;
    if($HTTP_POST_VARS["shout_submit"])
    {

        $shout_name=addslashes(COM_checkWords(strip_tags($HTTP_POST_VARS["shout_name"])));
        $shout_message=addslashes(COM_checkWords(strip_tags($HTTP_POST_VARS["shout_message"])));

        $result = DB_query("INSERT INTO shoutbox (name,message,time)"."VALUES (\"$shout_name\", \"$shout_message\",now() )");
    }   

    $count = DB_query("select count(*) as count from shoutbox");
    $A = DB_fetchArray($count);
    $shout_out .= '<b>' . $A['count'] . '</b> shouts already<p>';

    $result = DB_query("select * from shoutbox order by id desc limit $max_stories");
    $nrows  = DB_numrows($result);
    for ($i =1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $shout_out .= '<b>' . $A['name'] . '</b>';
        $thetime = COM_getUserDateTimeFormat($A['time']);
        $shout_time = $thetime[0];
        $shout_out .= '<i> on ' . $shout_time . '</i><br>';
        $shout_out .= wordwrap($A['message'],$wrap_width,"<br>", 1) . '<br><br>';
    }

    $shout_out .= "\n<form name='shoutform' action='$PHP_SELF' method='post'>";
    if (!empty($_USER['uid'])) {
        $shout_out .= '<b>Name: ' . $_USER['username'] . '</b><br>';
        $shout_out .= '<input type="hidden" value="' . $_USER['username'] . '"';
    }
    else
    {
        $shout_out .= '<b>Name: Anonymous</b><br>';
        $shout_out .= '<input type="hidden" value="Anonymous"';
    }
    $shout_out .= ' name="shout_name"><b>Message:</b>';
    $shout_out .= "\n<input type='text' value='Your Message' name='shout_message' size=20 maxlength='100'><br>";
    $shout_out .= "\n<input type='submit' name='shout_submit' value='Shout it!'>";
    $shout_out .= "\n</form>";

    return $shout_out;

}

function phpblock_whos_new()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE;

    // Set the number of new members to show
    $numToShow = 5;

    $result = DB_query("SELECT uid,username,photo FROM {$_TABLES['users']} WHERE status = " . USER_ACCOUNT_ACTIVE . " ORDER BY regdate DESC LIMIT $numToShow");

    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $retval .= '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '" rel="nofollow">' . COM_checkWords ($A['username']) .
 '</a>';
        if (!empty($A['photo']) AND $_CONF['allow_user_photo'] == 1) {
            $retval .= ' <a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '" rel="nofollow"><img src="' . $_CONF['layout_url'] . '/images/smallcamera.' . $_IMAGE_TYPE . '" border="0" alt=""></a>';
        }
        $retval .= '<br>';
    }
    return $retval;
}


function phpblock_themetester()
{
    global $PHP_SELF, $HTTP_USER_AGENT, $HTTP_POST_VARS, $HTTP_GET_VARS, $_TABLES, $_USER, $_CONF, $_THEME_TIMER, $REMOTE_ADDR;
    
    $thememode = $HTTP_GET_VARS['thememode'];

    if ($thememode == 'save') {
        $usetheme = $HTTP_GET_VARS['usetheme'];
    } else {
        $usetheme = $HTTP_POST_VARS['usetheme'];
    }
    if (empty ($usetheme)) {
        if (isset ($HTTP_COOKIE_VARS[$_CONF['cookie_theme']])) {
            $usetheme = $HTTP_COOKIE_VARS[$_CONF['cookie_theme']];
        } else if (!empty ($_USER['theme'])) {
            $usetheme = $_USER['theme'];
	} else {
            $usetheme = $_CONF['theme'];
        }
    }

    if ($_USER['uid'] > 1 AND $thememode == 'save' AND !empty($usetheme)) {
        $newtheme = addslashes (COM_applyFilter ($usetheme));
        DB_query("UPDATE {$_TABLES['users']} SET theme='$newtheme' WHERE uid = {$_USER['uid']}");
        echo COM_refresh($PHP_SELF);
    }

    $themes = COM_getThemes();
    if (count($themes) == 1) {
        return 'Sorry, only one theme installed.';
    }
    usort ($themes, create_function ('$a,$b', 'return strcasecmp($a,$b);'));

     // Browser & Platform Check
    if(@eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}",$HTTP_USER_AGENT,$match) || @eregi("(opera/)([0-9]{1,2}.[0- 9]{1,3}){0,1}",$HTTP_USER_AGENT,$match))
    {
        $BName= "Opera"; $BVersion=$match[2];
    }
    elseif(eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})",$HTTP_USER_AGENT,$match))
    {
        $BName = "MSIE"; $BVersion=$match[2];
    }
    elseif(eregi("(netscape6)/(6.[0-9]{1,3})",$HTTP_USER_AGENT,$match))
    {
        $BName = "Netscape"; $BVersion=$match[2];
    }
    elseif(eregi("mozilla/5",$HTTP_USER_AGENT))
    {
        $BName = "Mozilla"; $BVersion="Unknown";
    }
    elseif(eregi("(mozilla)/([0-9]{1,2}.[0-9]{1,3})",$HTTP_USER_AGENT,$match))
    {
        $BName = "Netscape "; $BVersion=$match[2];
    }
    else
    {
        $BName = "Unknown"; $BVersion="Unknown";
    }

    $retval .= "Try out these Geeklog themes:<br>";

    if ($BName=='MSIE' || $BName=='Opera' || $BName=='Mozilla' || $BName=='Safari') {
        $retval .= '<form action="' . $PHP_SELF . '" method="POST"><select name="usetheme" onchange="this.form.submit()">' . LB;
        $retval .= '<option value="">--</option>' . LB;
        for ($i = 1; $i <= count($themes); $i++) {
            $retval .= '<option value="' . current($themes) . '"';
            if ($usetheme == current($themes)) {
                $retval .= ' selected="selected"';
            } 
            $th = str_replace ('_', ' ', current ($themes));
            if ((strtolower ($th{0}) == $th{0}) && (strtolower ($th{1}) == $th{1})) {
                $th = strtoupper ($th{0}) . substr ($th, 1);
            }
            $retval .= '>' . $th . '</option>' . LB;
            next($themes);
        }
    
        if (($_USER['uid'] > 1) && !empty($usetheme) && ($usetheme != $_USER['theme'])) {
            $args = 'thememode=save&amp;usetheme=' . $usetheme;
            for ($i = 1; $i <= count($HTTP_GET_VARS); $i++) {
                if (key($HTTP_GET_VARS) <> 'thememode' AND key($HTTP_GET_VARS) <> 'usetheme') {
                    $args .= '&amp;' . key($HTTP_GET_VARS) . '=' . urlencode(current($HTTP_GET_VARS));
                }
                next($HTTP_GET_VARS);
            }
            $retval .= '</select></form>' . LB;
            $retval .= '<p>More themes can be found on our <a href="http://demo.geeklog.net/">demo site</a>.</p>';
            $retval .= '<a href="' . $PHP_SELF . '?' . $args . '">save current selection</a>';
        } else {
            $retval .= '</select></form>';
            $retval .= '<p>More themes can be found on our <a href="http://demo.geeklog.net/">demo site</a>.</p>';
        }
    } else {
        $retval .= '<form action="' . $PHP_SELF . '" method="POST"><select name="usetheme">' . LB;
        $retval .= '<option value="">--</option>' . LB;
        for ($i = 1; $i <= count($themes); $i++) {
            $retval .= '<option value="' . current($themes) . '"';
            if ($usetheme == current($themes)) {
                $retval .= ' selected="selected"';
            } 
            $th = str_replace ('_', ' ', current ($themes));
            if ((strtolower ($th{0}) == $th{0}) && (strtolower ($th{1}) == $th{1})) {
                $th = strtoupper ($th{0}) . substr ($th, 1);
            }
            $retval .= '>' . $th . '</option>' . LB;
            next($themes);
        }

        if (($_USER['uid'] > 1) && !empty($usetheme) && ($usetheme != $_USER['theme'])) {
            $args = 'thememode=save&amp;usetheme=' . $usetheme;
            for ($i = 1; $i <= count($HTTP_GET_VARS); $i++) {
                if (key($HTTP_GET_VARS) <> 'thememode' AND key($HTTP_GET_VARS) <> 'usetheme') {
                    $args .= '&amp;' . key($HTTP_GET_VARS) . '=' . urlencode(current($HTTP_GET_VARS));
                }
                next($HTTP_GET_VARS);
            }
            $retval .= '</select><input type="submit" value="go!"></form>' . LB;
            $retval .= '<p>More themes can be found on our <a href="http://demo.geeklog.net/">demo site</a>.</p>';
            $retval .= '<a href="' . $PHP_SELF . '?' . $args . '">save current selection</a>' . LB;
        } else {
            $retval .= '</select><input type="submit" value="go!"></form>' . LB;
            $retval .= '<p>More themes can be found on our <a href="http://demo.geeklog.net/">demo site</a>.</p>';
        }       
    }
       
    return $retval;
}


function phpblock_quickstats() {
   global $_FM_TABLES,$_TABLES, $_CONF;
   $query1 = DB_query("SELECT count(*) as count FROM {$_FM_TABLES['filemgmt_history']} WHERE unix_timestamp(date)  + 86400 > unix_timestamp() ");
   $query2 = DB_query("SELECT count(*) FROM {$_TABLES['userinfo']} WHERE lastlogin + 604800 > unix_timestamp()");
   $query3 = DB_query("SELECT count(*) as count FROM {$_TABLES['gf_topic']} WHERE date  + 86400 > unix_timestamp() ");
   $query4 = DB_query("SELECT count(*) AS downloads,downloads.lid, filedetail.title FROM {$_FM_TABLES['filemgmt_history']} downloads, {$_FM_TABLES['filemgmt_filedetail']} filedetail WHERE filedetail.lid = downloads.lid AND unix_timestamp(downloads.date )  + 86400 > unix_timestamp(  ) GROUP  BY lid ORDER  BY downloads DESC LIMIT 5");
   list($numfiles) = DB_fetchArray($query1);
   list($numusers) = DB_fetchArray($query2);
   list($numposts) = DB_fetchArray($query3);
   $retval .= "<tt>Downloads:&nbsp;</tt><b>$numfiles</b><tt>(24hrs)</tt><br>";
   while ( list ($count,$id, $filename) = DB_fetchArray($query4) ) {
    $retval .= '<tt><a href="' .$_CONF['site_url'] . '/filemgmt/singlefile.php?lid=' . $id . '">'  . substr($filename,0,15) . " ($count)</a></tt><br>";
   }
   $retval .= "<tt>ForumPosts:</tt><b>$numposts</b><tt>(24hrs)</tt><br>";
   $retval .= "<tt>ActiveMembers:</tt><b>$numusers</b><tt>(wk)</tt>";
   $retval .= '<br><center><a href="'.$_CONF['site_url'].'/stats.php">More Stats</a></center>';
   return $retval;

}


/**
* Custom function to retrieve and return a formatted list of blocks
* Can be used when calling COM_siteHeader or COM_SiteFooter

* Example: 
* 1: Setup an array of blocks to display
* 2: Call COM_siteHeader or COM_siteFooter
*
*  $myblocks = array ('site_menu','site_news','poll_block');

* COM_siteHeader( array('COM_showCustomBlocks',$myblocks) ) ;
* COM_siteFooter( true, array('COM_showCustomBlocks',$myblocks));

* @param   array   $showblocks    An array of block names to retrieve and format
* @return  string                 Formated HTML containing site footer and optionally right blocks
*/
function old_custom_showBlocks($showblocks) {
    global $_CONF, $_TABLES;
    $retval = '';
    foreach($showblocks as $block) {
        $sql = "SELECT bid, name,type,title,content,rdfurl,phpblockfn,help FROM {$_TABLES['blocks']} WHERE name='$block'";
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $retval .= COM_formatBlock($A);
        }
    }
    return $retval;
}

function CUSTOM_showBlocks($showblocks)
{
    global $_CONF, $_USER, $_TABLES;
    
    $retval = '';
    if( !isset( $_USER['noboxes'] )) {
        if( !empty( $_USER['uid'] )) {
            $noboxes = DB_getItem( $_TABLES['userindex'], 'noboxes', "uid = {$_USER['uid']}" );
        } else {
            $noboxes = 0;
        }
    } else {
        $noboxes = $_USER['noboxes'];
    }

    foreach($showblocks as $block) {
        $sql = "SELECT bid, name,type,title,content,rdfurl,phpblockfn,help,allow_autotags,onleft FROM {$_TABLES['blocks']} WHERE name='$block'";
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            if ($A['onleft'] == 1) {
                $side = 'left';
            } else {
                $side = 'right';
            }
            $retval .= COM_formatBlock($A,$noboxes, $side);
        }
    }

    return $retval;
}

function CUSTOM_ref2query()
{
    global $_CONF;

    $query = '';
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $ref = $_SERVER['HTTP_REFERER'];
        if (substr($ref, 0, strlen($_CONF['site_url'])) != $_CONF['site_url']) {
            $qpos = strpos($ref, '?');
            if ($qpos !== false) {
                $qref = substr($ref, $qpos + 1);
                $parts = explode('&', $qref);
                foreach ($parts as $part) {
                    if (substr($part, 0, 2) == 'q=') {
                        $q = urldecode(substr($part, 2));
                        if (substr($q, 6) != 'cache:') {
                            $query = $q;
                        }
                        break;
                    }
                }
            }
        }
    }

    return $query;
}

function CUSTOM_templateSetVars($templatename, &$template)
{
    global $_CONF, $LANG09;

    switch ($templatename) {
    case 'header':
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($agent, 'AppleWebKit') !== false) {
            $parts = parse_url($_CONF['site_url']);
            $search_input_type = 'search';
            $search_attributes = 'autosave="' . $parts['host'] . '" results="5"'
                               . ' placeholder="' . $LANG09[10] . '" ';
        } else {
            $search_input_type = 'text';
            $search_attributes = '';
        }
        $template->set_var('my_search_input_type', $search_input_type);
        $template->set_var('my_search_attributes', $search_attributes);
        break;
    }
}

function phpblock_current_versions()
{
    global $_CONF, $_FM_TABLES;

    $output = '<p><a href="' . $_CONF['site_url'] . '/filemgmt/viewcat.php?cid=8"><img src="' . $_CONF['site_url'] . '/images/buttons/download.png" width="134" height="49" border="0" align="center" alt="[Download]"></a><br' . XHTML . ">\n";

    $result = DB_query("SELECT version FROM {$_FM_TABLES['filemgmt_filedetail']} WHERE cid = 8 ORDER BY date DESC LIMIT 2");
    $num_versions = DB_numRows($result);

    $stable = '';
    $alternate = '';

    for ($v = 0; $v < $num_versions; $v++) {
        $A = DB_fetchArray($result);
        $reltype = '';
        if (strpos($A['version'], 'rc') !== false) {
            $reltype = ' title="Release Candidate"';
        } elseif (strpos($A['version'], 'b') !== false) {
            $reltype = ' title="Beta Version"';
        }

        if (empty($reltype) && empty($stable)) {
            $stable .= "Current version: <strong title=\"Recommended Version\">Geeklog {$A['version']}</strong></p>\n";
        } elseif (! empty($reltype)) {
            $alternate .= '<p>Also available:<br' . XHTML . ">\n"
                       .  "<b$reltype>Geeklog " . $A['version'] . "</b></p>\n";
        }
    }

    $output .= $stable . $alternate;

    return $output;
}

?>

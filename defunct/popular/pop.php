<?php

require_once '/usr/www/users/geeklog/lib-common.php';

$_TABLES['topstories'] = $_DB_table_prefix . 'topstories';
$maxstories = 25;

$lines = file ('/usr/home/geeklog/popular/articles.lst');

$counter = array ();
foreach ($lines as $l) {
    $l = trim($l);
    if (!empty ($l)) {
        if (isset ($counter[$l])) {
            $counter[$l]++;
        } else {
            $counter[$l] = 1;
        }
    }
}

arsort ($counter);

DB_query ("TRUNCATE TABLE {$_TABLES['topstories']}");

$stories = 0;
foreach ($counter as $key => $count) {
    DB_save ($_TABLES['topstories'], 'sid,hits', "'$key',$count");
    $stories++;
    if ($stories == $maxstories) {
        break;
    }
}

?>

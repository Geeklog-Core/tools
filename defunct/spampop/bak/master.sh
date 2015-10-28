#!/bin/sh
#
# Create master blacklist of domains using 'pinapplyproxy'
#
# Part of the larger "update.sh" script (see there for details)
#
# written 2005-03-30 by Dirk Haun <dirk AT haun-online DOT de>

master='spampop.txt'
entries=`wc -l current.lst | cut -f1 -d'c' | sed 's/ //g'`
now=`date '+%F %T'`

cat > $master <<HERE
#
#   Pinappleproxy Blacklist Master Copy
#
#   Last update:        $now
#   Number of entries:  $entries
#
#   This is the master copy of the pinappleproxy
#   blacklist.
#
#   You can find out more about this file at:
#    http://www.candygenius.com/pinapplyproxy_spammer
#
HERE

cat current.lst >> $master


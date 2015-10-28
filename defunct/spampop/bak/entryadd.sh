#!/bin/sh
#
# Add a new entry, RDF formatted.
#
# Call like this: ./entryadd.sh <entry> <feed>
#
# Part of the larger "update.sh" script (see there for details)
#
# written 2005-03-30 by Dirk Haun <dirk AT haun-online DOT de>

entry=$1
feed=$2

about='http://www.candygenius.com/pinapplyproxy_spammer'
link='http://www.candygenius.com/pinapplyproxy_spammer'
timestamp=`date +%FT%T%z | cut -c-22 | sed 's/\(.*\)$/\1:00/'`
author='Cindy'

cat >> $feed <<HERE
<item rdf:about="$about">
<title>$entry</title>
<link>$link</link>
<description>$entry...</description>
<content:encoded><![CDATA[[Blacklist additions] <p>$entry</p>
]]></content:encoded>
<dc:subject>Blacklist additions</dc:subject>
<dc:creator>$author</dc:creator>
<dc:date>$timestamp</dc:date>
</item>
HERE


#!/bin/sh
#
# Add an entry to be removed, RDF formatted.
#
# Call like this: ./entryrem.sh <entry> <feed>
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

cat > $feed.tmp <<HERE
<item rdf:about="$about">
<title>$entry</title>
<link>$link</link>
<description>$entry...</description>
<content:encoded><![CDATA[[Blacklist deletions] <p>$entry</p>
]]></content:encoded>
<dc:subject>Blacklist deletions</dc:subject>
<dc:creator>$author</dc:creator>
<dc:date>$timestamp</dc:date>
</item>
HERE

cat $feed >> $feed.tmp
mv $feed.tmp $feed


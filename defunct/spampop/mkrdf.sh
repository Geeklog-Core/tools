#!/bin/sh
#
# Create list of last 100 changes to the 'pinappleproxy'
# master blacklist.
#
# Part of the larger "update.sh" script (see there for details)
#
# written 2005-03-30 by Dirk Haun <dirk AT haun-online DOT de>

feed='spampop-changes.rdf'
channelabout='http://www.candygenius.com/pinapplyproxy_spammer'
channellink='http://www.candygenius.com/flexinode/table/1'
channelauthor='Cindy'

timestamp=`date +%FT%T%z | cut -c-22 | sed 's/\(.*\)$/\1:00/'`

cat > $feed <<HERE
<?xml version="1.0" encoding="utf-8"?>

<rdf:RDF
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns="http://purl.org/rss/1.0/">

<channel rdf:about="$channelabout">
<title>Pinappleproxy Blacklist Changes</title>
<link>$channellink</link>
<description>This feed reflects changes to the master pinappleproxy blacklist</description>
<dc:language>en-us</dc:language>
<dc:creator>$channelauthor</dc:creator>
<dc:date>$timestamp</dc:date>

<items>
<rdf:Seq>
HERE

grep '<title' entries.rdf | sed 's|^.*$|<rdf:li rdf:resource="http://www.candygenius.com/pinapplyproxy_spammer"/>|' >> $feed

cat >> $feed <<HERE
</rdf:Seq>
</items>
</channel>

HERE

cat entries.rdf >> $feed

echo >> $feed
echo '</rdf:RDF>' >> $feed


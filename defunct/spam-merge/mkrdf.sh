#!/bin/sh
#
# Create list of last 100 changes to the 'pinappleproxy'
# master blacklist.
#
# Part of the larger "update.sh" script (see there for details)
#
# written 2005-03-30 by Dirk Haun <dirk AT haun-online DOT de>

feed='spam-merge-changes.rdf'
channelabout='http://www.usemod.com/cgi-bin/mb.pl?SharedAntiSpam'
channellink='http://www.usemod.com/cgi-bin/mb.pl?SharedAntiSpam'
channelauthor='Geeklog'

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
<title>SharedAntiSpam Blacklist Changes</title>
<link>$channellink</link>
<description>This feed reflects changes to the master SharedAntiSpam blacklist</description>
<dc:language>en-us</dc:language>
<dc:creator>$channelauthor</dc:creator>
<dc:date>$timestamp</dc:date>

<items>
<rdf:Seq>
HERE

grep '<title' entries.rdf | sed 's|^.*$|<rdf:li rdf:resource="http://www.usemod.com/cgi-bin/mb.pl?SharedAntiSpam"/>|' >> $feed

cat >> $feed <<HERE
</rdf:Seq>
</items>
</channel>

HERE

cat entries.rdf >> $feed

echo >> $feed
echo '</rdf:RDF>' >> $feed


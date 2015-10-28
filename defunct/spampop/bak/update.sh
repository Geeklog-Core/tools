#!/bin/sh
#
# Update the list of domains using 'pinappleproxy' to spam.
#
# - get raw list from Cindy's site
# - create RDF from the diffs (max. 100 entries)
# - create master list from the raw list
#
# written 2005-03-30 by Dirk Haun <dirk AT haun-online DOT de>

#url='pinappleproxy.html'
url='http://www.candygenius.com/spamvertised_domains_raw.php'
feed='entries.rdf'

cd /usr/home/geeklog/spampop

mv current.lst last.lst
rm -f $feed
rm -f changes.lst

/usr/local/bin/lynx -dump $url | grep '/' | sed 's/ //g' | cut -f1 -d'/' | sort | uniq > current.lst

diff -b -B last.lst current.lst | grep ' ' > changes.lst

if [ -s changes.lst ]; then

  # add new entries
  lines=`grep '>' changes.lst | cut -f2 -d' '`
  for l in $lines; do
    ./entryadd.sh $l $feed
  done

  # remove entries
  lines=`grep '<' changes.lst | cut -f2 -d' '`
  for l in $lines; do
    ./entryrem.sh $l $feed
  done

  # reduce feed to max. 100 entries
  ./cut100.sh

  # create feed
  ./mkrdf.sh

  # create master list
  ./master.sh

  # publish files
  cp spampop.txt /usr/www/users/geeklog/backend/
  cp spampop-changes.rdf /usr/www/users/geeklog/backend/

fi

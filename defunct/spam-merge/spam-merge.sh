#!/usr/local/bin/bash

cd /usr/home/geeklog/spam-merge

cp -p master.txt master.old
/usr/local/bin/python spam-merge.py > /dev/null 2>&1

diff -q master.txt master.old > /dev/null
if [ $? -eq 0 ]; then
  exit
fi

cp -p current.lst last.lst

tr -d '\015' < master.txt | cut -f1 -d'#' | sed 's/ //g' | sort | uniq > current.lst

feed='entries.rdf'

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

  cp -p master.txt /usr/www/users/geeklog/backend/spam-merge.txt
  cp -p spam-merge-changes.rdf /usr/www/users/geeklog/backend/

fi


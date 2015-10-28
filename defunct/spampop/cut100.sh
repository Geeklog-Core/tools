#!/bin/sh

num=`grep '<item rdf' entries.rdf | wc -l | sed 's/ //g'`

if [ $num -gt 100 ]; then

  tail -n1000 entries.rdf > entries.tmp
  mv entries.tmp entries.rdf

fi


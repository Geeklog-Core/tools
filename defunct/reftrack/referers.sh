#!/bin/sh
#
# collect the referers for the last hour
#
# filters out many known sites / URLs since we're only interested
# in _unknown_ sites
#
# written 2005-03-31 by Dirk Haun <dirk AT haun-online DOT de>

cd /usr/home/geeklog/reftrack

hour=`date '+%Y:%H:'`

grep '^www.geeklog.net ' /usr/home/geeklog/www_logs/access_log | grep $hour | grep -v Echr | grep -v ' 403 ' | grep -v ' 410 ' | grep -v ' 412 ' | grep -v AvantGo | grep -v 'Feedster Crawler' | cut -f4 -d'"' | grep -v 'geeklog.net' | grep -v 'geeklog.info' | grep -v '^-$' | grep -v '^$' | grep -v '+++' | grep -v 'about:blank' | grep -v ':2082' | grep -v wikipedia | grep -v google | grep -v yahoo | grep -v overture.com | grep -v dogpile.com | grep -v answerbus | grep -v fantastico | grep -v afterWorkOptions.cgi | grep -v sourceforge.net | grep -v freshmeat | grep -v pigstye.net | grep -v squatty.com | grep -v portalparts.com | grep -v tonybibbs.com | grep -v geeklog.now.pl | grep -v aeonserv.com | grep -v macosxhints.com | grep -v groklaw | grep -v msn.com | grep -v mail.moderntalking.biz | grep -v localhost | grep -v 192.168 | grep -v 127.0.0.1 | grep -v opensourcecms.com | grep -v cmsmatrix | grep -v bloogz.com | grep -v 'teamkarn.net' | grep -v 'Strategic Board Bot' | grep -v strategicboard.com | sort | uniq > referers.log


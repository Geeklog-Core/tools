#!/bin/sh

cd /usr/home/geeklog/popular

LOG8=`date -v-8d +%Y%m%d`
LOG7=`date -v-7d +%Y%m%d`
LOG6=`date -v-6d +%Y%m%d`
LOG5=`date -v-5d +%Y%m%d`
LOG4=`date -v-4d +%Y%m%d`
LOG3=`date -v-3d +%Y%m%d`
LOG2=`date -v-2d +%Y%m%d`
LOG1=`date -v-1d +%Y%m%d`
LOGS=`echo www.$LOG8.gz www.$LOG7.gz www.$LOG6.gz www.$LOG5.gz www.$LOG4.gz www.$LOG3.gz www.$LOG2.gz www.$LOG1.gz`

cd ../www_logs

zcat $LOGS | grep 'GET .article.php' | grep -v Googlebot | grep -v 'Yahoo!' | grep -v msnbot | grep -v almaden | grep -v xmlrpc.php | grep -v ';DECLARE' | grep ' 200 ' | cut -f7 -d' ' | cut -f1 -d'&' | sed 's/\?story=/\//g' | cut -f3 -d'/' | cut -f1 -d'#' | grep -v '<' | grep -v '>' | grep -v 'http:' | sort > ../popular/articles.lst

/usr/local/bin/php /usr/home/geeklog/popular/pop.php


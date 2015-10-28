#!/usr/local/bin/bash
#
# nightly.sh - create nightly tarball for Geeklog
#
# Also see the mkdist.sh script - some pieces have been copied from there.
#
# To be called from a cronjob, hence the use of complete paths in some places.

# do this once:
# mkdir /usr/home/geeklog2/nightly
# cd /usr/home/geeklog2/nightly
# hg clone http://project.geeklog.net/cgi-bin/hgwebdir.cgi/geeklog/ geeklog

cd /usr/home/geeklog2/nightly/geeklog-nightly

rm -f system/lib-custom.php

# update repository
/usr/local/bin/hg -q pull > /dev/null 2>&1
/usr/local/bin/hg -q up > /dev/null 2>&1

# fix names of .dist files
mv db-config.php.dist db-config.php
mv public_html/siteconfig.php.dist public_html/siteconfig.php
mv system/lib-custom.php.dist system/lib-custom.php

# add PEAR classes
cd system/pear
cp /usr/www/users/geeklog2/www/nightly/geeklog-pear.tar.gz .
tar xfz geeklog-pear.tar.gz
rm -f geeklog-pear.tar.gz
cd ../..

# don't ship old upgrade files (from pre-1.3 versions)
rm -f sql/updates/*.sql
rm -f sql/updates/1.2.5-1_to_1.3.NOTES

# PEAR buildpackage files
rm -f plugins/calendar/buildpackage.php
rm -f plugins/links/buildpackage.php
rm -f plugins/polls/buildpackage.php
rm -f plugins/spamx/buildpackage.php
rm -f plugins/staticpages/buildpackage.php
rm -rf system/build

# fix permissions
find . -type f -exec chmod a-x \{\} \;
chmod a+x emailgeeklogstories

# set the default permissions
chmod 775 backups
chmod 775 data
chmod 775 logs
chmod 664 logs/*.log
chmod 775 public_html/backend
chmod 644 public_html/backend/*.rss
chmod 775 public_html/images/articles
chmod 664 public_html/images/articles/*
chmod 775 public_html/images/topics
chmod 664 public_html/images/topics/*
chmod 775 public_html/images/userphotos
chmod 664 public_html/images/userphotos/*

cd ..

tar cf geeklog-nightly.tar '--exclude=\.hg' geeklog-nightly
gzip geeklog-nightly.tar

# rename .dist files back to their names in the repository
mv geeklog-nightly/db-config.php geeklog-nightly/db-config.php.dist
mv geeklog-nightly/public_html/siteconfig.php geeklog-nightly/public_html/siteconfig.php.dist
# leave copy of lib-custom.php for phpDocumentor
cp -p geeklog-nightly/system/lib-custom.php geeklog-nightly/system/lib-custom.php.dist

mv geeklog-nightly.tar.gz /usr/www/users/geeklog2/www/nightly/


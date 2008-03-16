#!/bin/bash
#
# mkdist.sh - make a Geeklog distribution from a local CVS copy
#
# Usage: mkdist.sh new-version old-version [german]
# e.g. ./mkdist.sh 1.3.9rc1 1.3.8-1sr4

if [ -z "$1" ]; then
  echo "Usage: $0 new-version old-version [german]"
  exit
fi

if [ -z "$2" ]; then
  echo "Need another version number ..."
  exit
fi

if [ -z "$3" ]; then
  langv="english"
else
  langv="german"
fi

NEWVERSION="geeklog-$1"
OLDVERSION="geeklog-$2"

cd dist

if [ -d $NEWVERSION ]; then
  rm -rf $NEWVERSION
fi

cp -r -p ../Geeklog-1.x $NEWVERSION
cp -r -p ../pear-1.3/pear/* $NEWVERSION/system/pear/

cd $NEWVERSION

# remove old default themes
rm -rf public_html/layout/Classic
rm -rf public_html/layout/clean
rm -rf public_html/layout/Digital_Monochrome
rm -rf public_html/layout/gameserver
rm -rf public_html/layout/Smooth_Blue
rm -rf public_html/layout/XSilver
rm -rf public_html/layout/Yahoo

# no PDF support for now
rm public_html/pdfgenerator.php
rm -rf public_html/layout/professional/pdfgenerator
rm -rf pdfs

# don't ship MT-Blacklist modules any more
rm -f plugins/spamx/MTBlackList.Examine.class.php
rm -f plugins/spamx/Import.Admin.class.php
# only used by the Import class
rm -rf plugins/spamx/magpierss
# you'd need to set up a honeypot to use it
rm -f plugins/spamx/ProjectHoneyPot.Examine.class.php

# don't ship these language files any more
rm -f language/chinese_big5.php
rm -f language/chinese_gb2312.php

# PEAR buildpackage files
rm -f plugins/calendar/buildpackage.php
rm -f plugins/links/buildpackage.php
rm -f plugins/polls/buildpackage.php
rm -f plugins/spamx/buildpackage.php
rm -f plugins/staticpages/buildpackage.php
rm -rf system/build

# no more config.php, yay!
rm -f config.php config.php.dist

find . -type f -name '.*' -exec rm \{\} \;
find . -name CVS -exec rm -r \{\} \; 2>/dev/null

find . -type f -exec chmod a-x \{\} \;
chmod a+x emailgeeklogstories

# set the default permissions ...
chmod -R 775 backups
chmod -R 775 data
chmod -R 775 logs
# chmod -R 775 pdfs
chmod -R 775 public_html/backend
chmod -R 775 public_html/images/articles
chmod -R 775 public_html/images/topics
chmod -R 775 public_html/images/userphotos

if [ "$langv" = "german" ]; then
  echo "Making German version ..."
  rm -rf public_html/docs
  mv public_html/docs.german public_html/docs
  mv config.php.german config.php
  mv sql/mysql_tableanddata.php.german sql/mysql_tableanddata.php
  mv sql/updates/mysql_1.3.8_to_1.3.9.php.german sql/updates/mysql_1.3.8_to_1.3.9.php
  mv sql/updates/mysql_1.3.9_to_1.3.10.php.german sql/updates/mysql_1.3.9_to_1.3.10.php
  mv public_html/admin/install/success.php.german public_html/admin/install/success.php
else
  echo "Making English version ..."
  rm -rf public_html/docs.german
  rm -f config.php.german
  rm -f sql/mysql_tableanddata.php.german
  rm -f sql/updates/mysql_1.3.8_to_1.3.9.php.german
  rm -f sql/updates/mysql_1.3.9_to_1.3.10.php.german
  rm -f public_html/admin/install/success.php.german
fi

cd ..

diff -b -B --brief --recursive -N $OLDVERSION $NEWVERSION | grep -v 'system.pear' | cut -f 4 -d' ' >changed-files
# diff -b -B --brief --recursive -N $OLDVERSION $NEWVERSION | grep -v layout | grep -v docs | cut -f 4 -d' ' >changed-files
mv changed-files $NEWVERSION/public_html/docs/

if [ -f $NEWVERSION.tar ]; then
  rm $NEWVERSION.tar
fi

tar cf $NEWVERSION.tar $NEWVERSION

if [ -f $NEWVERSION.tar.gz ]; then
  rm $NEWVERSION.tar.gz
fi

gzip $NEWVERSION.tar

md5 $NEWVERSION.tar.gz


#!/bin/bash
#
# mkdist.sh - make a Geeklog distribution from a local Mercurial repository
#
# Usage: mkdist.sh new-version old-version
# e.g. ./mkdist.sh 1.3.9rc1 1.3.8-1sr4 [repository-dir]

if [ -z "$1" ]; then
  echo "Usage: $0 new-version-number old-version-number [repository-dir]"
  exit
fi

if [ -z "$2" ]; then
  echo "Need another version number ..."
  exit
fi

if [ -z "$3" ]; then
  repository="geeklog"
else
  repository="$3"
fi

NEWVERSION="geeklog-$1"
OLDVERSION="geeklog-$2"

echo "Creating $NEWVERSION from $repository"

cd dist

if [ -d $NEWVERSION ]; then
  rm -rf $NEWVERSION
fi

# use tar to create a copy without the .hg directory
cd ../geeklog
tar cf gl-temp.tar '--exclude=\.hg' $repository
mv gl-temp.tar ../dist/
cd ../dist
tar xf gl-temp.tar
rm -f gl-temp.tar
mv $repository $NEWVERSION

cp -r -p ../pear-1.3/pear/* $NEWVERSION/system/pear/
# remove PHP_Compat package
rm -rf $NEWVERSION/system/pear/PHP

cd $NEWVERSION

# don't ship Professional CSS theme yet
rm -rf public_html/layout/professional_css

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

mv db-config.php.dist db-config.php
mv public_html/siteconfig.php.dist public_html/siteconfig.php

# lib-custom.php.dist is the actual lib-custom.php file now ...
mv system/lib-custom.php.dist system/lib-custom.php

find . -type f -name '.*' -exec rm \{\} \;

# if on a Mac, check that we don't have any of those pesky xattributes set
xattr=`which xattr`
if [ -n "$xattr" ]; then
  xa=`xattr -r .`
  if [ -n "$xa" ]; then
    echo "xattr found:"
    echo $xa
    exit
  fi
fi

find . -type f -exec chmod a-x \{\} \;
chmod a+x emailgeeklogstories

# set the default permissions
chmod 775 backups
chmod 775 data
chmod 775 logs
chmod 664 logs/*log
chmod 775 public_html/backend
chmod 644 public_html/backend/*.rss
chmod 775 public_html/images/articles
chmod 664 public_html/images/articles/*
chmod 775 public_html/images/topics
chmod 664 public_html/images/topics/*
chmod 775 public_html/images/userphotos
chmod 664 public_html/images/userphotos/*

cd ..

diff -b -B --brief --recursive -N $OLDVERSION $NEWVERSION | grep -v 'system.pear' | cut -f 4 -d' ' >changed-files
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


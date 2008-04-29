#!/bin/bash
# +---------------------------------------------------------------------------+
# | Geeklog 1.5                                                               |
# +---------------------------------------------------------------------------+
# | uplng.sh                                                                  |
# |                                                                           |
# | Helper script to update the Geeklog language files,                       |
# | using the lm.php script.                                                  |
# +---------------------------------------------------------------------------+
# | Copyright (C) 2004-2008 by the following authors:                         |
# |                                                                           |
# | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
# +---------------------------------------------------------------------------+
# |                                                                           |
# | This program is free software; you can redistribute it and/or             |
# | modify it under the terms of the GNU General Public License               |
# | as published by the Free Software Foundation; either version 2            |
# | of the License, or (at your option) any later version.                    |
# |                                                                           |
# | This program is distributed in the hope that it will be useful,           |
# | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
# | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
# | GNU General Public License for more details.                              |
# |                                                                           |
# | You should have received a copy of the GNU General Public License         |
# | along with this program; if not, write to the Free Software Foundation,   |
# | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
# |                                                                           |
# +---------------------------------------------------------------------------+
#
# $Id: uplng.sh,v 1.8 2008/04/29 18:47:45 dhaun Exp $

# Installation and usage:
# - copy this script into the /path/to/geeklog of a local Geeklog install
#   Note that all *.php files in all of the language directories will be
#   deleted and new language files will be created there
# - adjust paths below
# - cd /path/to/geeklog, run the script

# just a basedir to save some typing ...
basedir=/Users/dirk/darwin

# the /path/to/geeklog of your local copy of the CVS repository
cvspath=$basedir/cvs.geeklog.net/Geeklog-1.x

# target directory - where this script is located aka /path/to/geeklog
destpath=$basedir/work

# path to the lm.php script and the include directory
lm=$basedir/cvs.geeklog.net/tools/lm/lm.php


# you shouldn't need to change anything below ...

function doConvert() { # parameters: "to" "from" "module"

  if [ -z "$3" ]; then
    echo "=== Core ==="

    modpath=$1/language
    langpath=$2/language
  else
    echo "=== $3 ==="

    modpath=$1/plugins/$3/language
    langpath=$2/plugins/$3/language
  fi

  cd $modpath
  rm -f *.php

  cd $langpath
  files=`ls -1 *.php | grep -v english.php | grep -v english_utf-8.php`

  cp english.php $modpath
  cp english_utf-8.php $modpath

  cd $destpath
  for l in $files; do
    echo "$l"
    php $lm $langpath/$l "$3" > $modpath/$l
  done

}

doConvert $destpath $cvspath
doConvert $destpath $cvspath "calendar"
doConvert $destpath $cvspath "links"
doConvert $destpath $cvspath "polls"
doConvert $destpath $cvspath "spamx"
doConvert $destpath $cvspath "staticpages"


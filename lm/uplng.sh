#!/bin/bash
# +---------------------------------------------------------------------------+
# | Geeklog 1.5                                                               |
# +---------------------------------------------------------------------------+
# | uplng.sh                                                                  |
# |                                                                           |
# | Helper script to update the Geeklog language files, using the lm.php and  |
# | mblm.php scripts.                                                         |
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
# $Id: uplng.sh,v 1.3 2008/04/27 09:48:06 dhaun Exp $

# Installation and usage:
# - copy this script into the "language" directory of a local Geeklog install
#   Note that all *.php files in that directory will be removed!
# - adjust paths below
# - cd into the language directory, run the script

# just a basedir to save some typing ...
basedir=/Users/dirk/darwin

# location of the language directory in your local copy of the CVS repository
langpath=$basedir/cvs.geeklog.net/Geeklog-1.x/language

# target language directory - where this script is located
destpath=$basedir/work/language

# paths to the lm.php and mblm.php scripts
lm=$basedir/cvs.geeklog.net/tools/lm/lm.php


# you shouldn't need to change anything below ...

cd $destpath
rm -f *.php

cd $langpath
files=`ls -1 *.php | grep -v english.php`

cp english.php $destpath

cd $destpath
for l in $files; do
  echo "$l"
  php $lm $langpath/$l > $l
done


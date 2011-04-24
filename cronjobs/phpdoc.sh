#!/usr/local/bin/bash
#
# phpdoc.sh - create phpDocumentor documentation from Geeklog's source code
#
# For use from a cronjob - you may want to leave out the "-q &" when calling
# manually.

# where to put the created documentation
OUTPUT=/usr/www/users/geeklog2/www/src

# path to Geeklog source code (e.g. a Mercurial repository)
GL_PATH=/usr/home/geeklog2/nightly/geeklog-nightly

# location of phpDocumentor
PHPDOC_PATH=/usr/home/geeklog2/phpDocumentator

# seems to help when called from a cronjob
export PHP=/usr/local/bin/php

$PHPDOC_PATH/phpdoc -t $OUTPUT -o HTML:Smarty:PHP -d $GL_PATH -i *language/*,system/build/,buildpackage.*,system/pear/,public_html/fckeditor/ -dc Geeklog -dn Geeklog -ti "Geeklog Source Code Documentation" -q &


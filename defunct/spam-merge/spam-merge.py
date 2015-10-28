#!/usr/bin/env python
# -*- coding: iso8859-1 -*-
"""
    This implements merging of some blacklists containing RE patterns targetted against wiki spammers.

    @copyright: 2005 by Thomas Waldmann
    @license: GNU GPL, see COPYING for details
"""

var_dir = '.' # here we keep our variable data

lists = { # those are the remote lists we merge
        "MM": "http://moinmaster.wikiwikiweb.de:8000/BadContent?action=raw",
#        "WM": "http://meta.wikimedia.org/w/index.php?action=raw&title=Spam_blacklist",
        "TW": "http://twiki.org/feeds/_spam_list.txt",
        }

# the antispam standard is located on that page, too:
user_agent = "spam-merge/1.0 (http://www.usemod.com/cgi-bin/mb.pl?SharedAntiSpam)"

update_interval = 600 # if our local list is more than X seconds old: merge the remote lists

debug = True # give some log entries to stderr

import sys, os, re, time
import sets
import socket
import urllib

master_fname = os.path.join(var_dir, "master.txt")

def dprint(s):
    """ print debug msgs to stderr, encode to utf-8 if we get unicode """
    if debug:
        if isinstance(s, unicode):
            s = s.encode('utf-8')
        sys.stderr.write('%s\n' % s)

class UrlOpener(urllib.URLopener):
    version = user_agent # use our own user_agent or we get denied in some wikis

def makedict(src, text, timestamp):
    """ Split text into lines, parse them into regex and comment part,
        add timestamp to comment (if not there).
        return dict {regex: comment}
    """
    comment_re = re.compile(r'(?P<timestamp>\d{4}-\d{2}-\d{2})(:(?P<src>[^:\s]*))?\S*(\s(?P<comment>.*))?') # YYYY-MM-DD:SRC:... spec ?
    lines = text.splitlines()
    redict = {}
    for line in lines:
        d = line.split(' #', 1) # regex, maybe with rest-of-line-comment
        regex = d[0].strip()
        if regex and not regex.startswith('#'): # not a comment or empty line
            if len(d) < 2:
                comment = ''
            else:
                comment = d[1].strip()
            if comment:
                match = comment_re.match(comment) # is there already a date:src in the comment?
                if not match: # nothing there, add date:src
                    comment = "%s:%s %s" % (timestamp, src, comment)
                else: # some stuff is there, parse and reassemble
                    gdict = match.groupdict()
                    _timestamp = gdict['timestamp'] or timestamp
                    _src = gdict['src'] or src
                    _comment = gdict['comment'] or ''
                    comment = "%s:%s %s" % (_timestamp, _src, _comment)
            else:
                comment = "%s:%s" % (timestamp, src) # no comment at all, add date:src
            try:
                re.compile(regex) # try if this is a valid regex
                redict[regex] = comment
            except:
                pass # regex compile crashed, just ignore this one
    return redict

def update_from_remotes(blacklist, timestamp):
    """ update our blacklist from the remote lists from time to time """
    did_update = False
    now = int(time.time())
    try:
        last_update = os.path.getmtime(master_fname)
    except:
        last_update = 0
    if last_update > now: # our file timestamp is in the future
        last_update = 0
    if last_update + update_interval < now:
        # get remote stuff and update our list with it
        for src, list in lists.items():
            try:
                text = UrlOpener().open(list).read()
                did_update = True
            except socket.error, err:
                dprint('socket error when accessing %s: %s' % (list, str(err)))    
                text = ''
            except IOError, err:
                dprint('IOError when accessing %s: %s' % (list, str(err)))    
                text = ''
            newdict = makedict(src, text, timestamp)
	    
            # this is sort of a conditional dict update, it prefers longer comments
            for regex, comment in newdict.items():
                if blacklist.has_key(regex):
                    if len(blacklist[regex]) < len(comment):
                        blacklist[regex] = comment
                else:
                    blacklist[regex] = comment
    return did_update

def main():
    """ Fetch spam patterns from some blacklists and merge them.
        A complete new and sorted list gets printed to stdout.
    """
    # make sure we don't wait forever if some server is down...
    socket.setdefaulttimeout(30)

    # emit content-type header for cgi usage
    sys.stdout.write("Content-Type: text/plain;charset=utf-8\r\n\r\n")
    
    # generate a timestamp of today, iso format
    timestamp = time.strftime("%Y-%m-%d", time.gmtime())
    
    # read in what we already have locally
    try:
        masterf = file(master_fname, "r")
        masterlist = masterf.read()
        masterf.close()
        blacklist = makedict("LOC", masterlist, timestamp)
    except IOError:
        blacklist = {}

    did_update = update_from_remotes(blacklist, timestamp)
    
    # generate the new spam list
    blacklist = blacklist.items() # dict -> list
    blacklist.sort()
    list = ["%s # %s\r\n" % (regex, comment) for regex, comment in blacklist]
    list = '''# %d anti-spam patterns as of %s\r\n%s#EOF\r\n''' % (len(list), timestamp, ''.join(list))
    
    # write new local master copy and also write to stdout for cgi usage
    sys.stdout.write(list)
    if did_update:
        try:
            masterf = file(master_fname, "w")
            masterf.write(list)
            masterf.close()
        except IOError:
            pass

if __name__ == '__main__':
    main()



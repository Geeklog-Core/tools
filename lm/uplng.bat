@echo off

rem +---------------------------------------------------------------------------+
rem | Geeklog 2.1.0                                                             |
rem +---------------------------------------------------------------------------+
rem | uplng.bat                                                                 |
rem |                                                                           |
rem | Helper script to update the Geeklog language files,                       |
rem | using the lm.php script.                                                  |
rem +---------------------------------------------------------------------------+
rem | Copyright (C) 2004-2014 by the following authors:                         |
rem |                                                                           |
rem | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
rem |          Kenji ITO         - mystralkk AT gmail DOT com                   |
rem +---------------------------------------------------------------------------+
rem |                                                                           |
rem | This program is free software; you can redistribute it and/or             |
rem | modify it under the terms of the GNU General Public License               |
rem | as published by the Free Software Foundation; either version 2            |
rem | of the License, or (at your option) any later version.                    |
rem |                                                                           |
rem | This program is distributed in the hope that it will be useful,           |
rem | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
rem | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
rem | GNU General Public License for more details.                              |
rem |                                                                           |
rem | You should have received a copy of the GNU General Public License         |
rem | along with this program; if not, write to the Free Software Foundation,   |
rem | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
rem |                                                                           |
rem +---------------------------------------------------------------------------+

rem Installation and usage:
rem - copy this script into the /path/to/geeklog of a local Geeklog install
rem   Note that all *.php files in all of the language directories will be
rem   updated.
rem - cd /path/to/geeklog, run the script

rem target directory - where this script is located aka /path/to/geeklog

echo Synching language files ...
for /F "usebackq" %%t in (`cd`) do set destpath=%%t

rem path to the lm.php script and the include directory
set lm=%destpath%\lm.php

call :doConvert %destpath%
call :doConvert %destpath% calendar
call :doConvert %destpath% links
call :doConvert %destpath% polls
call :doConvert %destpath% spamx
call :doConvert %destpath% staticpages
call :doConvert %destpath% xmlsitemap
call :doConvert %destpath% install

cd %destpath%
echo Done.
pause
exit /b

:doConvert
rem @param  %1 = path
rem @param  %2 = module

if "%2"=="" (
	echo ===== Core =====
	set langpath=%destpath%\language
) else if  "%2"=="install" (
	echo ===== Install =====
	set langpath=%destpath%\public_html\admin\install\language
) else (
	echo ===== Plugin - %2 =====
	set langpath=%destpath%\plugins\%2\language
)

pushd %langpath%
	for /F "usebackq" %%f in (`dir /A-D /B *.php ^| findstr /V ^english`) do (
		echo %%f
		php.exe -f %lm% %langpath%\%%f %2 > %langpath%\%%f.tmp
		del %langpath%\%%f
		ren %langpath%\%%f.tmp %%f
	)
popd

exit /b

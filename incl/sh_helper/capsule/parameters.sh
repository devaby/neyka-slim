#!/bin/sh

ROOT_PATH=/srv/www

SHELL_LOG=/srv/www

# Second variable supplied like 

CAPSULE_NAME=$2

if [ -z "$1" ]; then

	ROOT_PATH_NEYKA=$ROOT_PATH
	
	$SHELL_LOG=$SHELL_LOG/log/shell.log
	
else

	ROOT_PATH_NEYKA=$ROOT_PATH/$1
	
	SHELL_LOG=$SHELL_LOG/$1/log/shell.log

fi

# Find neyka path

if [ -z "$1" ]; then

	NEYKA_PATH=$ROOT_PATH_NEYKA/library/capsule/$2/

else

	NEYKA_PATH=$ROOT_PATH_NEYKA/library/capsule/$2/

fi

# Date and time

CURRENT_YEAR=`date +%Y`

CURRENT_MONTH=`date +%m` 

CURRENT_DATE=`date +%d` 

CURRENT_TIME="$CURRENT_DATE-$CURRENT_MONTH-$CURRENT_YEAR"
#!/bin/bash

# Include all capsule script helper
source /srv/www/$1/incl/sh_helper/capsule/parameters.sh  
source /srv/www/$1/incl/sh_helper/capsule/logger.sh  

NEYKA_PATH=$1

CAPSULE_NAME=$2

DELETE_PATH=/srv/www/$1/library/capsule/$CAPSULE_NAME/

if [ -d "$DELETE_PATH" ]; then

	rm -R $DELETE_PATH
	
else

	echo "Directory $DELETE_PATH not exist."

	echo "Rewinding action now..."
	
	exit 1

fi
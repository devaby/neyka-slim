#!/bin/sh

# Include all capsule script helper
source /srv/www/$1/incl/sh_helper/capsule/parameters.sh  
source /srv/www/$1/incl/sh_helper/capsule/logger.sh
source /srv/www/$1/incl/sh_helper/capsule/skeleton.sh  

DEFAULT_FILES=($NEYKA_PATH$CAPSULE_NAME.info.php $NEYKA_PATH$CAPSULE_NAME.main.php $NEYKA_PATH$CAPSULE_NAME.ajax.php)

DEFAULT_FOLDER=(mvc js css)

DEFAULT_MVC=(model.php view.php controller.php)

FOLDER_LENGTH=${#DEFAULT_FOLDER[@]}

FILES_LENGTH=${#DEFAULT_FILES[@]}

FOLDER_MVC_LENGTH=${#DEFAULT_MVC[@]}

	if [ -d $NEYKA_PATH ]; then
	
		echo "Capsule $CAPSULE_NAME already exist. Exiting script.";
	        
		exit 1

	else
	
		mkdir -p $NEYKA_PATH
		
		echo "Capsule directory created";
		
		logger $ROOT_PATH_NEYKA "Capsule $CAPSULE_NAME directory::$NEYKA_PATH created"
			
	fi

	for (( i=0; i<FOLDER_LENGTH; i++ ))
	
	do
	  
		CREATION="${DEFAULT_FOLDER[$i]}"
		
		mkdir -p $NEYKA_PATH$CREATION
		
		if [ $CREATION = "mvc" ]; then
		
			for (( t=0; t<FOLDER_MVC_LENGTH; t++ ))

			do
			
			   touch -r > $NEYKA_PATH$CREATION/${DEFAULT_MVC[$t]}
			   
			   if [ $t = 0 ]; then
			   
			   echo "$CAPSULE_MVC_MODEL" >> $NEYKA_PATH$CREATION/${DEFAULT_MVC[$t]}
			   
			   fi
			   
			   if [ $t = 1 ]; then
			   
			   echo "$CAPSULE_MVC_VIEW" >> $NEYKA_PATH$CREATION/${DEFAULT_MVC[$t]}
			   
			   fi
			   
			   if [ $t = 2 ]; then
			   
			   echo "$CAPSULE_MVC_CONTROLLER" >> $NEYKA_PATH$CREATION/${DEFAULT_MVC[$t]}
			   
			   fi
			   			   
			done
		
		fi
		
		if [ $CREATION = "js" ]; then
					
			touch -r > $NEYKA_PATH$CREATION/$CAPSULE_NAME.js
			
			echo "$CAPSULE_JS" >> $NEYKA_PATH$CREATION/$CAPSULE_NAME.js
			   		
		fi
		
		if [ $CREATION = "css" ]; then
					
			touch -r > $NEYKA_PATH$CREATION/$CAPSULE_NAME.css
			
			echo "$CAPSULE_CSS" >> $NEYKA_PATH$CREATION/$CAPSULE_NAME.css
			   		
		fi
					
	done

for (( i=0; i<FILES_LENGTH; i++ ))

do

   touch -r > ${DEFAULT_FILES[$i]}
   
   if [ $i = 0 ]; then
			   
   echo "$CAPSULE_INFO" >> ${DEFAULT_FILES[$i]}
   
   fi
   
   if [ $i = 1 ]; then
			   
   echo "$CAPSULE_MAIN" >> ${DEFAULT_FILES[$i]}
   
   fi
   
   if [ $i = 2 ]; then
			   
   echo "$CAPSULE_AJAX" >> ${DEFAULT_FILES[$i]}
   
   fi
   
done



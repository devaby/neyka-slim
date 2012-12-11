<?php use \framework\user; use \framework\database\oracle\select; use \framework\encryption; use \framework\server; ?>


<div class="container">

<h2  style='text-align:center;'>Pilih Role Anda </h2>
<hr>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

		<?php

		$select = new select("*");

		if (isset($_GET['role'])):

			$rjand  = encryption::urlHashDecodingRinjndael($_GET['emblem'],$_GET['role']);

			if (is_numeric($rjand)):

				$select->tableName   = "CAP_USER_ROLE";

				$select->whereClause = [["CAP_USE_ROL_ID","=",$rjand]];

				$select->execute();

				if (!empty($select->arrayResult)):

					if (
					$select->arrayResult[0]['CAP_USE_ROL_ID'] == 1 || 
					$select->arrayResult[0]['CAP_USE_ROL_ID'] == 2 || 
					$select->arrayResult[0]['CAP_USE_ROL_ID'] == 3):
					
					$role = $GLOBALS['_neyClass']['router']->register($select->arrayResult[0]['CAP_USE_ROL_NAME']);

					server::setAdminSessionMultiRole([$select->arrayResult[0]['CAP_USE_ROL_ID'], $select->arrayResult[0]['CAP_USE_ROL_NAME'], $select->arrayResult[0]['FK_CAP_MEN_ID']]);

					else:
					
					$role = $GLOBALS['_neyClass']['router']->register($select->arrayResult[0]['CAP_USE_ROL_NAME']);
										
					server::setUserSessionMultiRole([$select->arrayResult[0]['CAP_USE_ROL_ID'], $select->arrayResult[0]['CAP_USE_ROL_NAME'], $select->arrayResult[0]['FK_CAP_MEN_ID']]);

					endif;

				endif;
								
			endif;

		endif;

		$user = unserialize($_SESSION['user']);
				
		$idSites = $user->getSiteID();
		
		$idPrivateSites = $user->getPersonalSiteID();
		 
		if (!empty($user)):

			if (count($user->getRole()) > 1):
			
				$domain = $GLOBALS['_neyClass']['sites']->domain();
			
				foreach ($user->getRole() as $key => $value):

					$select->tableName   = "CAP_USER_ROLE";

					$select->whereClause = [["CAP_USE_ROL_ID","=",$value]];

					$select->execute();                   
					
					if (!empty($select->arrayResult)):
											
						if ($value == 1):
													
							$view .= "<div class='row-fluid show-grid' style='margin-bottom:20px;'><div class='span4 center-strap' ></div><div class='span4 center-strap' >";
							    
							$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$select->arrayResult[0]['CAP_USE_ROL_ID']);
							
							$view .= "<a class='btn btn-large btn-block'  style='padding-top:20px; padding-bottom:20px;'  href='index.php?role=".$crypt."&emblem=".$_SESSION['xss']."'>".ucwords(strtolower($select->arrayResult[0]['CAP_USE_ROL_NAME']))."</a>";	
							
							$view .= "</div>";
							
							$view .= "<div class='span4 center-strap' ></div>";
							
							$view .= "</div>";
																			
						elseif ($value == 2):
						
							if($domain == $idSites):
							
								$view .= "<div class='row-fluid show-grid' style='margin-bottom:20px;'><div class='span4 center-strap' ></div><div class='span4 center-strap' >";
								    
								$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$select->arrayResult[0]['CAP_USE_ROL_ID']);
								
								$view .= "<a class='btn btn-large btn-block'  style='padding-top:20px; padding-bottom:20px;'  href='index.php?role=".$crypt."&emblem=".$_SESSION['xss']."'>".ucwords(strtolower($select->arrayResult[0]['CAP_USE_ROL_NAME']))."</a>";	
								
								$view .= "</div>";
								
								$view .= "<div class='span4 center-strap' ></div>";
								
								$view .= "</div>";
							
							endif;
												
						elseif ($value == 3):
						
							if($domain == $idPrivateSites):
							
								$view .= "<div class='row-fluid show-grid' style='margin-bottom:20px;'><div class='span4 center-strap' ></div><div class='span4 center-strap' >";
								    
								$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$select->arrayResult[0]['CAP_USE_ROL_ID']);
								
								$view .= "<a class='btn btn-large btn-block'  style='padding-top:20px; padding-bottom:20px;'  href='index.php?role=".$crypt."&emblem=".$_SESSION['xss']."'>".ucwords(strtolower($select->arrayResult[0]['CAP_USE_ROL_NAME']))."</a>";	
								
								$view .= "</div>";
								
								$view .= "<div class='span4 center-strap' ></div>";
								
								$view .= "</div>";
							
							endif;
						
						else:
						
						$view .= "<div class='row-fluid show-grid' style='margin-bottom:20px;' ><div class='span4 center-strap' ></div><div class='span4 center-strap' >";
								    
						$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$select->arrayResult[0]['CAP_USE_ROL_ID']);
						
						$view .= "<a class='btn btn-large btn-block ' style='padding-top:20px; padding-bottom:20px;' href='index.php?role=".$crypt."&emblem=".$_SESSION['xss']."'>".ucwords(strtolower($select->arrayResult[0]['CAP_USE_ROL_NAME']))."</a>";	
						
						$view .= "</div>";
						
						$view .= "<div class='span4 center-strap' ></div>";
						
						$view .= "</div>";
						
						endif;
						
						/*
						
						if($domain != $idSites):
						
							if (($value != 2 && $value != 3)):
								
							$view .= "<div class='row-fluid show-grid' style='margin-bottom:20px;'><div class='span4 center-strap' ></div><div class='span4 center-strap' >";
								    
							$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$select->arrayResult[0]['CAP_USE_ROL_ID']);
							
							$view .= "<a class='btn btn-large btn-block'  style='padding-top:20px; padding-bottom:20px;'  href='index.php?role=".$crypt."&emblem=".$_SESSION['xss']."'>".ucwords(strtolower($select->arrayResult[0]['CAP_USE_ROL_NAME']))."</a>";	
							
							$view .= "</div>";
							
							$view .= "<div class='span4 center-strap' ></div>";
							
							$view .= "</div>";
							
							endif;
							
						else:
						
						$view .= "<div class='row-fluid show-grid' style='margin-bottom:20px;' ><div class='span4 center-strap' ></div><div class='span4 center-strap' >";
								    
						$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$select->arrayResult[0]['CAP_USE_ROL_ID']);
						
						$view .= "<a class='btn btn-large btn-block ' style='padding-top:20px; padding-bottom:20px;' href='index.php?role=".$crypt."&emblem=".$_SESSION['xss']."'>".ucwords(strtolower($select->arrayResult[0]['CAP_USE_ROL_NAME']))."</a>";	
						
						$view .= "</div>";
						
						$view .= "<div class='span4 center-strap' ></div>";
						
						$view .= "</div>";
								
						endif;
						
						*/
						
					endif;

				endforeach;

			echo $view;

			endif;

		endif;

		?>
        
	</form>

</div>
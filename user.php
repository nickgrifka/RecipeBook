<?php
		include_once('facebook-sdk/facebook.php');
		$config = array('appId' => '629992387024555',
					'secret' => '30b1935a8e7112753788d936747af58a',
					'cookie' => true);
		$facebook = new Facebook($config);
		$user = $facebook->getUser();
?>
<html>
<head>
	
	
</head>
<body>
	<div id="background" style="background:black; width:100%; height:100%; margin:0px">
		<div id="container" style="background:yellow; width:1000px; height:625px; margin:auto; z-index:-10;">
			<div id="header" style="background:green; width:100%; height:35px;">
			</div>
			<div id="banner" style="background-image:url('foodbanner2.jpg'); background-repeat:no-repeat; width:100%; height:300px;
									font-size:30px; font-family:arial; color:white; ">
				
				<?php 
				
					if ($user)
					{
						try
						{
							$loginUrl = $facebook->getLoginUrl();
							$userProfile = $facebook->api('/me', 'GET');
							echo "Hello " . $userProfile['name'] . "!<br/>";	
						}
						catch (FacebookApiException $e)
						{
							echo 'Please <a href="' . $login_url . '">login.</a>';
							error_log($e->getType());
							error_log($e->getMessage());
						}
					}
					else
					{
						echo "You are not logged in!";
					}
				?>
				
			</div>
			<div id="content" style="background:#0F0F0F; width:100%; height:290px; font-family:arial; color:black;
				border-width:2px; border-style:solid; border-color:#242424; ">
				
				<div id="left" style="background:url('http://www.clker.com/cliparts/g/y/g/4/r/h/tan-index-card.svg'); width:53%; height:280px; float:left; margin:5px;">
					<p style="text-align:center; font-size:20px;" >Recipes</p>
					<ul style="height:200px; width:300px; overflow:auto; border-width:3px; border-color:black; border-style:solid; margin-left:auto; margin-right:auto; background:#242424; color:white;">
						<li>Chicken Marsla</li>
						<li>Pocorn</li>
						<li>Recipe 3</li>
						<li>Recipe 4</li>
						<li>Recipe 5</li>
						<li>Jumbalaya</li>
						<li>Recipe 2</li>
						<li>Recipe 3</li>
						<li>fried steak</li>
						<li>Recipe 5</li>
						<li>Recipe 1</li>
						<li>Recipe 2</li>
						<li>clam chowder</li>
						<li>Recipe 4</li>
						<li>Recipe 5</li>
					</ul>
				</div>
				
				<div id="right" style="background:green; width:45%; height:280px; float:right; margin:5px;">
					<p style="text-align:center; font-size:20px;">Quick Search</p>
					<input style="height:25px; width:200px; margin-left:125px; border-width:1px; border-color:black; border-style:solid;" type="text" id="searchbar" placeholder="Recipe Name"/>
				</div>
				
			</div>
		</div>
	</div>
</body>
</html>
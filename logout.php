<?php
	// Setup facebook sdk
	include_once('facebook-sdk/facebook.php');
	$config = array('appId' => '629992387024555',
					'secret' => '30b1935a8e7112753788d936747af58a',
					'cookie' => true);
	$facebook = new Facebook($config);
	$user = $facebook->getUser();
	// Get the logout url and log the user out
	if ($user)
	{
		if (session_id())
		{
			// $params = array( 'next' => 'http://localhost/RecipeBook/grifkarecipebook.html' );
			// $logoutUrl = $facebook->getLogoutUrl($params);
			// session_destroy();
			// header("Location: {$logoutUrl}");
			//header("Location: http://localhost/RecipeBook/grifkarecipebook.html");
			$token = $facebook->getAccessToken();
			$url = 'https://www.facebook.com/logout.php?next=' . 'http://localhost/RecipeBook/grifkarecipebook.html' .
			  '&access_token='.$token;
			session_destroy();
			header('Location: '.$url);
		}
	}
	else
	{
		header("Location: http://localhost/RecipeBook/grifkarecipebook.html");
	}
?>
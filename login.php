<?php
	include_once('facebook-sdk/facebook.php');
	$config = array('appId' => '629992387024555',
					'secret' => '30b1935a8e7112753788d936747af58a',
					'cookie' => true);
	$facebook = new Facebook($config);
	$user = $facebook->getUser();
	if ($user)
	{
		if (session_id())
		{
		}
		else
		{	
			session_start();
		}
		// Get the access token for graph api calls. TODO: make it a session variable 
		$access_token = $facebook->getAccessToken();
		// Get the permissions from the user
		$permissions_list = $facebook->api('/me/permissions', 'GET', array('access_token' => $access_token));
		// Check if the user actually has permissions (could have revoked one or more)
		$permissions_needed = array();
		foreach($permissions_needed as $perm)
		{	
			if (!isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1)
			{
				// redirect back to the permissions page
				$params = array('redirect_uri' => 'http://localhost/RecipeBook/login.php',
						'fbconnect' => 1);
						//'scope' => '');
				$loginUrl = $facebook->getLoginUrl($params);
			}
		}
		// Finally we can start our application and make whatever api calls we want
		header("Location: http://localhost/RecipeBook/user.php");
	}
	else
	{
		// Direct user to login
		$params = array('redirect_uri' => 'http://localhost/RecipeBook/login.php',
						'fbconnect' => 1);
						//'scope' => 'publish_stream, read_stream, offline_access, manage_pages');
		$loginUrl = $facebook->getLoginUrl($params);
		header("Location: {$loginUrl}");
		exit();
	}
?>
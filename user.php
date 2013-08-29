<html>
<head>
<title>GrifkaRecipeBook</title>
	
	<?php
		include_once('facebook-sdk/facebook.php');
		$config = array('appId' => '629992387024555',
					'secret' => '30b1935a8e7112753788d936747af58a',
					'cookie' => true);
		$facebook = new Facebook($config);
		$user = $facebook->getUser();
	?>
	<?php 
				
		$loginUrl = $facebook->getLoginUrl();
		
		if ($user)
		{
			try
			{
				$loginUrl = $facebook->getLoginUrl();
				$userProfile = $facebook->api('/me', 'GET');
				$welcomeMessage = "Hello " . $userProfile['name'] . "!<br/>";
				//echo $welcomeMessage;
				// echo "Hello " . $userProfile['name'] . "!<br/>";	
			}
			catch (FacebookApiException $e)
			{
				echo 'Please <a href="' . $loginUrl . '">login.</a>';
				error_log($e->getType());
				error_log($e->getMessage());
			}
		}
		else
		{
			$welcomeMessage = 'You are not logged in. Please login <a href="http://localhost/RecipeBook/grifkarecipebook.html">here</a>';
			//echo $welcomeMessage;
			// echo 'You are not logged in. Please login <a href="http://localhost/RecipeBook/grifkarecipebook.html">here</a>';
		}
	?>

	<script type="text/javascript">
		var fbUser = <?php echo $user; ?>;
	</script>
	<script src='https://cdn.firebase.com/v0/firebase.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
	
</head>
<body background="oliveGreenBubbles.jpg" bgcolor="green">

	<div id="shadowBlanket" style="position:absolute; left:0px; top:0px; width:100%; height:100%; display:none; opacity:0.2; background:black; z-index:100;">
	</div>
	
	
	<!--------------- Viewable html --------------------->
			
	<!-- <div id="background" style="background:white; width:100%; height:100%; margin:0px"> -->
		<div id="container" style="position:relative; display:block; width:1100; height:625px; margin:auto;">
			
			<div id="banner" style="width:516px; height:100px; position:absolute; top:30px; left:20px; background:white; border-radius:7px;">
				<h1><em>RecipeBook, <?php echo $welcomeMessage?></em></h1>
			</div>
			
			<button style="font-size:16px; position:absolute; left:20px; top: 135px;"><a id="logout_fb" href="http://localhost/RecipeBook/logout.php" >Logout</a></button>
			
			<div id="right" style="background:#242424; width:500px; height:280px; margin:5px; color:white; position:absolute; right:20px; top:18px; border-radius:7px;">
				<p style="text-align:center; font-size:20px;">Quick Search</p>
				<input type="text" id="searchbar" placeholder="Recipe Name"
					style="height:25px; width:300px; margin-left:80px; border-width:1px; border-color:black; border-style:solid; padding-left:10px; font-size:16px;"/>
				
				<!-- Hidden search results dropdown -->
				<table class="recipeLink" id="searchResults" style="width:299px; height:auto; margin-left:81px; background:white; border-collapse:collapse;">
					<!-- this list gets populated with search -->
				</table>
			</div>
				
			<div id="left" style="background:#242424; width:500px; height:280px; margin:5px; color:white; position:absolute; right:20px; bottom:18px; border-radius:7px;">
				<p style="text-align:center; font-size:20px;" >Recipes</p>
				<div style="height:180px; width:300px; overflow:auto; margin-left:auto; margin-right:auto;">
				<table class="recipeLink" id="recipe_list" style="width:280px; border-width:3px; border-color:black; border-style:solid; background:white; color:black;">
					<!-- this list gets populated with firebase -->
				</table>
				</div>
				
				<button id="addRecipe"style="margin-left:10px;">Add Recipe</button>
			</div>
			
			
			<!----------- Hidden popup windows ------------------>
	
			<div id="addRecipeWindow" style="display:none; width:400px; height:auto; background:#86C452; position:absolute; left:320px; top:80px; z-index:110;
											text-align:left; padding:20px;">
				<h2>Add a recipe!</h2>
				
				<input id="recipeNameInput" type="text" placeholder="Name" />
				<br/>
				<div id="ingredient_field">
					<input id="recipeIngredientInput" type="text" placeholder="Ingredient" />
					<button id="add_ingredient">+</button>
				</div>
				<br/>
				<textarea id="recipeDescriptionInput" rows="5" cols="40" placeholder="Description"></textarea>
				
				<button id="saveRecipe">Save Recipe</button>
				<button id="cancelNewRecipe">Cancel</button>
				
			</div>
			
			<div id="showRecipeWindow" style="display:none; width:500px; height:411px; background:#242424; position:absolute; left:-550px; top:170px; z-index:10;
									border-radius:7px; text-align:left; padding:10px;">
									
				<button id="closeShowRecipeWindow" style="float:right;">Close</button>
				<button id="deleteRecipe" style="float:right;">Delete Recipe</button>
			
				<div id="showRecipeContents" style="width:80%; height:auto; background:white; color:black; padding:20px; margin-left:auto; margin-right:auto; margin-top:40px;">

				<h2 id="showRecipeName"></h2>
				<ul id="showRecipeIngredientList">
				</ul>
				<p id="showRecipeDescription"></p>
		
			</div>
			
			
		
		
		</div>
	
		
	<!-- </div> -->
	
	<!-- Scripts        --------------------------------------------------------- -->
	<script src="userfns.js"></script>
	
</body>
</html>
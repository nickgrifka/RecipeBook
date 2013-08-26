<html>
<head>
	
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
<body>

	<!----------- Hidden popup windows ------------------>
	
	<div id="addRecipeWindow" style="display:none; width:400px; heigth:auto; background:orange; position:absolute; left:100px; top:100px; z-index:10;
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
	
	<div id="showRecipeWindow" style="display:none; width:400px; heigth:auto; background:orange; position:absolute; left:100px; top:100px; z-index:10;
									text-align:left; padding:20px;">
		<h2 id="showRecipeName"></h2>
		
		<ul id="showRecipeIngredientList">
		</ul>
		
		<p id="showRecipeDescription"></p>
		
		<button id="closeShowRecipeWindow">Close</button>
		<button id="deleteRecipe" style="float:right;">Delete Recipe</button>
		
	</div>
	
	<!--------------- Viewable html --------------------->
			
	<div id="background" style="background:black; width:100%; height:100%; margin:0px">
		<div id="container" style="background:yellow; width:1000px; height:625px; margin:auto; z-index:-10;">
			<div id="header" style="background:green; width:100%; height:35px;">
			</div>
			<div id="banner" style="background-image:url('foodbanner2.jpg'); background-repeat:no-repeat; width:100%; height:300px;
									font-size:30px; font-family:arial; color:white; ">
									
				<?php
					echo $welcomeMessage;
				?>
				
			</div>
			<div id="content" style="background:#0F0F0F; width:100%; height:290px; font-family:arial; color:black;
				border-width:2px; border-style:solid; border-color:#242424; ">
				
				<div id="left" style="background:url('http://www.clker.com/cliparts/g/y/g/4/r/h/tan-index-card.svg'); width:53%; height:280px; float:left; margin:5px;">
					<p style="text-align:center; font-size:20px;" >Recipes</p>
					<div style="height:180px; width:300px; overflow:auto; margin-left:auto; margin-right:auto;">
					<table class="recipeLink" id="recipe_list" style="width:290px; border-width:3px; border-color:black; border-style:solid; background:#242424; color:white;">
						<!-- this list gets populated with firebase -->
					</table>
					</div>
					
					<button id="addRecipe">Add Recipe</button>
				</div>
				
				<div id="right" style="background:green; width:45%; height:280px; float:right; margin:5px;">
					<p style="text-align:center; font-size:20px;">Quick Search</p>
					<input type="text" id="searchbar" placeholder="Recipe Name"
						style="height:25px; width:300px; margin-left:80px; border-width:1px; border-color:black; border-style:solid; padding-left:10px; font-size:16px;"/>
					
					<!-- Hidden search results dropdown -->
					<table class="recipeLink" id="searchResults" style="width:299px; height:auto; margin-left:81px; background:white; border-collapse:collapse;">
						<!-- this list gets populated with search -->
					</table>
				</div>
				
			</div>	
		</div>
	</div>
	
	<!-- Scripts        --------------------------------------------------------- -->
	<script src="userfns.js"></script>
	
</body>
</html>
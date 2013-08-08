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

	<script type="text/javascript">
		var fbUser = <?php echo $user; ?>;
	</script>
	<script src='https://cdn.firebase.com/v0/firebase.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
	
	
	
</head>
<body>

	<div id="addRecipeWindow" style="display:none; width:400px; heigth:auto; background:orange; position:absolute; left:100px; top:100px; z-index:10;
									text-align:left; padding:20px;">
		<h2>Add a recipe!</h2>
		
		<input id="recipeNameInput" type="text" placeholder="Name" />
		<br/>
		<input id="recipeIngredientInput" type="text" placeholder="Ingredient" />
		<br/>
		<textarea id="recipeDescriptionInput" rows="5" cols="40" placeholder="Description"></textarea>
		
		<button id="saveRecipe">Save Recipe</button>
		
	</div>
			
	<div id="background" style="background:black; width:100%; height:100%; margin:0px">
		<div id="container" style="background:yellow; width:1000px; height:625px; margin:auto; z-index:-10;">
			<div id="header" style="background:green; width:100%; height:35px;">
			</div>
			<div id="banner" style="background-image:url('foodbanner2.jpg'); background-repeat:no-repeat; width:100%; height:300px;
									font-size:30px; font-family:arial; color:white; ">
				
				<?php 
				
					$loginUrl = $facebook->getLoginUrl();
					
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
							echo 'Please <a href="' . $loginUrl . '">login.</a>';
							error_log($e->getType());
							error_log($e->getMessage());
						}
					}
					else
					{
						echo 'You are not logged in. Please login <a href="http://localhost/RecipeBook/grifkarecipebook.html">here</a>';
					}
				?>
				
				
				
			</div>
			<div id="content" style="background:#0F0F0F; width:100%; height:290px; font-family:arial; color:black;
				border-width:2px; border-style:solid; border-color:#242424; ">
				
				<div id="left" style="background:url('http://www.clker.com/cliparts/g/y/g/4/r/h/tan-index-card.svg'); width:53%; height:280px; float:left; margin:5px;">
					<p style="text-align:center; font-size:20px;" >Recipes</p>
					<ul style="height:160px; width:300px; overflow:auto; border-width:3px; border-color:black; border-style:solid; margin-left:auto; margin-right:auto; background:#242424; color:white;">
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
					
					<button id="addRecipe">Add Recipe</button>
				</div>
				
				<div id="right" style="background:green; width:45%; height:280px; float:right; margin:5px;">
					<p style="text-align:center; font-size:20px;">Quick Search</p>
					<input style="height:25px; width:200px; margin-left:125px; border-width:1px; border-color:black; border-style:solid;" type="text" id="searchbar" placeholder="Recipe Name"/>
				</div>
				
			</div>
			
			
			
		</div>
	</div>
	
	<!-- Scripts        --------------------------------------------------------- -->
	<script>
		// Access the users recipes
		var userRecipeRef = new Firebase('https://ngrifka.firebaseIO.com/RecipeBook/users/' + fbUser + '/recipes/');
		
		// make recipe class
		function Recipe(name, ingredients, description)
		{
			this.name = name;
			this.ingredients = ingredients;
			this.description = description;
		}
		
		// all of the users recipes in javascript
		var userRecipeList = new Array();
		
		//test
		
		//fire: update recipe reference
		userRecipeRef.on('value', function(snapshot) {
			// display nice message "no recipes" suggest to add recipe
			if (snapshot == null)
			{
				alert("you have no recipes! add some!");
			}
			else
			{	var recipes = '';
				alert("updating data ref");
				var numchilds = userRecipeRef.numChildren()
				alert("here");
				// userRecipeRef.forEach( function(recipeSnapshot) {
					// alert("iteration");
					// var recipe = recipeSnapshot.value();
					// recipes = recipes + recipe.name;
				// });
				// alert(recipes);
			}
		});
		
		// fire: add recipe
		$('#addRecipe').click( function() {
			// open a new window that has entries to add recipe info
			$('#addRecipeWindow').fadeIn('fast');
			
		});
		
		// fire: save recipe
		$('#saveRecipe').click( function() {
			// create a new recipe object
			var name = $('#recipeNameInput').val();
			var ingredient = $('#recipeIngredientInput').val();
			var description = $('#recipeDescriptionInput').val();
			
			// var recipe = new Recipe(
			
			// save the recipe in the database, the local copy will update itself in real time
			userRecipeRef.push({name:name, ingredient:ingredient, description:description});
			
			// fade out the window
			$('#addRecipeWindow').fadeOut('fast');
		});
		
		// fire: search
		$('#searchbar').keypress( function (e) {
			if (e.keyCode == 13)
			{
				alert("Search fired");
			}
		});
		
		
		// write on fn to load the recipe section from firebase /fbUser/recipes
	  
	</script>
	
</body>
</html>
// Access the users recipes
var userRecipeRef = new Firebase('https://ngrifka.firebaseIO.com/RecipeBook/users/' + fbUser + '/recipes/');
var userRecipeSnapshot;
var currentDisplayedRecipeRef; // gets set once recipe is shown, only accessed when delete is clicked

// make recipe class
function Recipe(name, ingredients, description)
{
	this.name = name;
	this.ingredients = ingredients;
	this.description = description;
}

// all of the users recipes in javascript
// var userRecipeList = new Array();
// array of ingredients for multiple ingredients
var ingredientList = new Array();


// visually update the recipe html list
function updateRecipes(recipeList) {
	alert("recipe length");
	alert(recipeList);
	for (var i = 0; i < recipeList.length(); i++)
	{
		var recipeName = recipeList[i].name;
		$('#recipe_list').prepend('<li>' + recipeName + '</li>');
	}
	alert("Exit update recipes visually");
}

$(document).ready( function() {

	//fire: update recipe reference and javascript recipe list
	userRecipeRef.on('value', function(snapshot) {
		// Update the global recipe snapshot
		userRecipeSnapshot = snapshot;

		// Hold recipes in list of Recipe objects
		var userRecipeList = new Array();
	
		// display nice message "no recipes" suggest to add recipe
		if (snapshot == null)
		{
			alert("you have no recipes! add some!");
		}
		else
		{	
			// declare recipe list here?
			snapshot.forEach( function(recipeSnapshot) {
				var recipe = recipeSnapshot.val();
				var newRecipe = new Recipe(recipe.name, recipe.ingredients, recipe.description);
				userRecipeList.push(newRecipe);
			
			});
		
			// display/update the recipe book div
			// clear the existing list
			$('#recipe_list').html('');
			// add to the empty list
			for (var i = 0; i < userRecipeList.length; i++)
			{
				var recipeName = userRecipeList[i].name;
				$('#recipe_list').prepend('<tr><td class="recipe" style="cursor:default">' + recipeName + '</td></tr>');
			}
		}
	});


	// exit add recipe window
	function exitAddRecipeWindow() {
		// fade out the window
		$('#addRecipeWindow').fadeOut('fast', function() {
			// erase prepended ingredients if any
			$('p').remove('.extraIngredient');
			// reset fields
			$('#recipeNameInput').val('');
			$('#recipeIngredientInput').val('');
			$('#recipeDescriptionInput').val('');
			// erase the global ingredient list
			ingredientList = [];
		});
	}

	// fire: add recipe
	$('#addRecipe').click( function() {
		// open a new window that has entries to add recipe info
		$('#addRecipeWindow').fadeIn('fast');
	});

	// fire: save recipe
	$('#saveRecipe').click( function() {
		// create a new recipe object
		var name = $('#recipeNameInput').val();
		var description = $('#recipeDescriptionInput').val();
		var ingredient = $('#recipeIngredientInput').val();
		if (ingredient != "")
		{
			ingredientList.push(ingredient);
		}

		// create ingredient list ref
		var ingredientListRef = new Firebase('https://ngrifka.firebaseIO.com/RecipeBook/users/' + fbUser + '/recipes/');
	
		// save the recipe in the database, the local copy will update itself in real time
		var recipe = userRecipeRef.push({name:name, description:description});

		var ingredientsRef = recipe.child('ingredients');
		// individually push all ingredients to the ingredients ref
		for (var i = 0; i < ingredientList.length; i++)
		{
			ingredientsRef.push(ingredientList[i]);
		}
		// reset the ingredients array
		ingredientList = [];
	
		exitAddRecipeWindow();
	});
	
	function addIngredient() {
		var enteredIngredient = $('#recipeIngredientInput').val();
		$('#recipeIngredientInput').val('');
		$('#ingredient_field').prepend('<p class="extraIngredient">' + enteredIngredient + '</p>');
		$('#recipeIngredientInput').focus();
		ingredientList.push(enteredIngredient);
	}

	// fire: add ingredient #1
	$('#add_ingredient').click( function() {
		addIngredient();
	});
	
	// fire: add ingredient #2
	$('#recipeIngredientInput').keypress( function(e) {
		if (e.which == 13)
		{
			addIngredient();
		}
	});

	// fire: cancel add recipe
	$('#cancelNewRecipe').click( function() {
		exitAddRecipeWindow();
	});
	
	// Takes out <b></b> html tags produced by the search bar
	function parseOutTags(htmlRecipeName) {
		var cleanRecipeName = '';
		var insideTag = 0;
		for (var i = 0; i < htmlRecipeName.length; i++)
		{
			if (htmlRecipeName[i] == '<')
			{
				i = i + 1;
				while (htmlRecipeName[i] != '>')
				{
					i = i + 1;
				}
				i = i + 1;
			}
			if (i < htmlRecipeName.length)
			{
				cleanRecipeName += htmlRecipeName[i];
			}
		}
		return cleanRecipeName;
	}
	
	// shows the recipe window for a particular recipe
	function showRecipeWindow(recipe, ingredients) {
		// delete old fields
		$('#showRecipeName').html('');
		$('#showRecipeIngredientList').html('');
		$('#showRecipeDescription').html('');
		// Fill in name, ingredients, and description
		$('#showRecipeName').append(recipe.name);
		$('#showRecipeDescription').append(recipe.description);
		
		for (var i = 0; i < ingredients.length; i++)
		{
			$('#showRecipeIngredientList').append('<li>' + ingredients[i] + '</li>');
		}
		
		$('#showRecipeWindow').fadeIn('fast');
		ingredientsList = [];
	}

	//fire: show recipe
	$(".recipeLink").on("click", "tr td", function () {
		// Retrieve the name of the recipe clicked
		var recipeName = $(this).html();
		// Parse out the <b> tags if there are any
		recipeName = parseOutTags(recipeName);
		var ingredients = new Array();
		
		// find the specific recipe ref
		var recipe = 0;
		userRecipeSnapshot.forEach( function(recipeSnapshot) {
			var recipeIter = recipeSnapshot.val();
			if (recipeIter.name == recipeName)
			{
				recipe = recipeIter;
				currentDisplayedRecipeRef = recipeSnapshot.ref();
				// Grab the ingredients and put them in their own array
				var ingredientsSnapshot = recipeSnapshot.child('ingredients');
				ingredientsSnapshot.forEach( function(ingredientSnapshot) {
					ingredients.push(ingredientSnapshot.val());
				});
				return true;
			}
		});
		if (recipe == 0) // should never happen
		{ alert("Error: Did not find recipe: " + recipeName + " in the users recipe ref");				}
		
		// populate the window and display it
		showRecipeWindow(recipe, ingredients);
	});
	
	// fire: close show recipe window
	$('#closeShowRecipeWindow').click( function () {
		$('#showRecipeWindow').fadeOut('fast', function() {
			// TODO: reset all of the fields in the window
			$('#showRecipeName').html('');
			$('#showRecipeIngredientList').html('');
			$('#showRecipeDescription').html('');
		});
		
	});
	
	// fire: delete recipe
	$('#deleteRecipe').click( function () {
		currentDisplayedRecipeRef.remove();
		$('#closeShowRecipeWindow').click();
	});

		
	var oldQuery = '';
	function search()
	{
		var query = $('#searchbar').val().toLowerCase();
		if (oldQuery != query)
		{
			// clear the results
			$('#searchResults').html('');
			
			var query = $('#searchbar').val().toLowerCase();
			var results = new Array();
			if (query != '')
			{
				userRecipeSnapshot.forEach( function(recipeSnapshot) {
					var recipeIter = recipeSnapshot.val();
					var lowercaseRecipeName = recipeIter.name.toLowerCase();
					var substrIndex = lowercaseRecipeName.indexOf(query);
					console.log("Comparing " + recipeIter.name.toLowerCase() + " : " + query);
					if (substrIndex != -1)
					{
						if (results.length >= 8)
						{
							console.log("Maxed out at 8 results");
							// Max results at 8
							return true;
						}
						if (substrIndex != 0)
						{
							var part1 = recipeIter.name.substring(0, substrIndex);
							var part2 = recipeIter.name.substring(substrIndex, (substrIndex + query.length));
							var part3 = recipeIter.name.substring((substrIndex + query.length), lowercaseRecipeName.length);
							$('#searchResults').prepend('<tr><td class="recipe" style="color:white; background:#242424; cursor:default; padding-left:10px;"><b>'
								+ part1 + "</b>" + part2 + "<b>" + part3 + '</b></td></tr>');
						}
						else
						{
							console.log("bold from " + (query.length) + " to " + (lowercaseRecipeName.length - 1));
							var part1 = recipeIter.name.substring(0,query.length);
							var part2 = recipeIter.name.substring(substrIndex + query.length, recipeIter.name.length);
							console.log("Part 1: " + part1 + ", Part 2: " + part2);
							$('#searchResults').prepend('<tr><td class="recipe" style="color:white; background:#242424; cursor:default; padding-left:10px;">'
								+ part1 + "<b>" + part2 + '</b></td></tr>');
						}
						
						results.push(recipeIter.name);
					}
				});
			}
		}
		oldQuery = query;
	}
	
	// fire: highlight a recipe
	$('.recipeLink').on('mouseenter', "tr td", function() {
		$(this).css("background", "#595959");
		
	});
	
	// fire: unhighlight a recipe
	$('.recipeLink').on('mouseleave', 'tr td', function() {
		$(this).css('background', '#242424');
	});
	
	
	setInterval(function() {search()}, 50);
});
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Recipe Manager</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/add-form.css" />
</head>
<body>
	
	<h1>Add a Question</h1>
	
	<form method="post" action="ajax/add-recipe.php">
	
		<fieldset>
			<label for="recipe_title">Title</label>
			<input type="text" name="recipe_title"/>
		</fieldset>
		
		<fieldset>
			<label for="recipe_desc">Description</label>
			<textarea name="recipe_desc" rows="6"></textarea>
		</fieldset>
		
		<fieldset>
			<label for="recipe_image">Image URL</label>
			<input type="text" name="recipe_image"/>
		</fieldset>

		<fieldset>
			<label for="ingredient_1">Ingredient 1</label>
			<input type="text" name="ingredient_1"/>
		</fieldset>
		
		<fieldset>
			<label for="ingredient_2">Ingredient 2</label>
			<input type="text" name="ingredient_2"/>
		</fieldset>
		
		<input type="submit" value="Save this recipe"/>
		
	</form>
	
</body>	
</html>
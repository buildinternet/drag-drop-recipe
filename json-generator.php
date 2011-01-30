<?php
	
	/*
		Output recipes as a JSON file
	*/
	
	require_once 'includes/recipes.php';
	$recipes = new Recipes();
 
	$recipes->json_output();
	//$recipes->make_json_file();
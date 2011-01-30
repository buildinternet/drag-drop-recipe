<?php
   	/*
   		Checks for combinations
   		and displays results via AJAX
   	*/
   	
   	//Error reporting (Debug only)
   	error_reporting(E_ALL); 
	ini_set("display_errors", 1); 
	
   	//Prevent direct script access
   	if (!defined('BASEPATH') &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
    exit('No direct script access allowed.');
	
	//Instantiate Recipes class
	require_once '../includes/recipes.php';
	$recipes = new Recipes();
	
	//Make array of ingredients & implode
	$ingredients = array();
	array_push($ingredients, $_POST['ingredient1']);
	array_push($ingredients, $_POST['ingredient2']);
	$ingredients = implode(':', $ingredients);
	
	//Check for combinations and return results
	if($result = $recipes->combine_ingredients($ingredients)) :
		$return['message'] = "You found a combination!";
		$return['recipe'] = $result;
	else :
		$return['message'] = "Those items don't go together";
		$return['recipe'] = false;
	endif;
	
	//Strip slashes and convert to JSON
	echo stripslashes(json_encode($return));
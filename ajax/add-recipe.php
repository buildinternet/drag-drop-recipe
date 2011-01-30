<?php
   	
   	/*
   		AJAX form handler for adding recipes
   		TO-DO: Call via jQuery AJAX instead of form action
   	*/
   	
   	//Error reporting (Debug only)
   	error_reporting(E_ALL); 
	ini_set("display_errors", 1); 
	
   	//Prevent direct script access
   	/*if (!defined('BASEPATH') &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
    exit('No direct script access allowed.');*/
	
	require_once '../includes/recipes.php';
	$recipes = new Recipes();
	
	//Make array of ingredients & implode
		
	if($recipes->add_recipe($_POST)) :
		$return['success'] = true;
		echo 'Success';
	else :
		$return['success'] = false;
		echo 'Failure';
	endif;
	
	//Strip slashes and convert to JSON
	//echo stripslashes(json_encode($return));
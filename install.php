<?php 

require_once 'includes/recipes.php';
$recipes = new Recipes();

if ( !$recipes->database_exists() ) $recipes->install();

echo 'Everything is good to go';
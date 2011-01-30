<?php

class Recipes
{
	
	private $recipes;
	private $json_result;
	
	//Fill this in with your own information
	private $table_name = 'bi_recipes';
	
	function __construct()
	{
		
		//Database constants
		define('DB_HOST', 'localhost');
		define('DB_NAME', 'omr_buildinternet');
		define('DB_USER', 'root');
		define('DB_PASSWORD', 'root');
		
		//Get recipes from the database
		$this->recipes = $this->get_recipes();
		
		//Make a JSON version
		$this->json_result = stripslashes(json_encode($this->recipes));
	}
	
	private function connect()
	{
	
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		//Connection error? Stop everything.
		if ($mysqli->connect_errno)
    		die('Connection Error: ' . $mysqli->connect_errno);
		
		//All good? Send back the mysqli object
		return $mysqli;
	}
	
	public function database_exists()
	{
		/*
			Check if the recipes database exists
		*/
		
		$mysqli = $this->connect();
		
		if($stmt = $mysqli->prepare("
			SELECT COUNT(*)
			FROM information_schema.TABLES
			WHERE table_schema = ?
			AND table_name = ?"))
		{
		
			//Workaround since bind_param doesn't accept constants
			$db_name = DB_NAME;
			
			$stmt->bind_param('ss', $db_name, $this->table_name);
			$stmt->execute();
			$stmt->bind_result($table_count);
			$stmt->fetch();
			$stmt->close();
		
		}else{
			die('Error: Could not prepare statement');
		}
		
		$table_exists = ($table_count >= 1) ? true : false;
		
		if ($table_exists) :
			return true;
		else :
			return false;
		endif;
	}
	
	public function install()
	{
		/*
			Makes table for recipe information
		*/
		
		$mysqli = $this->connect();
			
		$ingredients_setup = "
		CREATE TABLE `".$this->table_name."` (
		  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
		  `recipe_title` varchar(200) DEFAULT NULL,
		  `recipe_image` text,
		  `recipe_desc` text,
		  `ingredients` varchar(128) DEFAULT NULL,
		  PRIMARY KEY (`recipe_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		";
		
		if($q = $mysqli->query($ingredients_setup)) :
			echo 'Created Table: ' . $this->table_name;
		else:
			die('Error: Could not create table');
		endif;
		
	}
	
	private function get_recipes()
	{
		$mysqli = $this->connect();
		
		//Dump the recipes in db to a local variable
		if($q = $mysqli->query("SELECT * FROM $this->table_name") ) :
			while($row = $q->fetch_object()) {
				$row->ingredients = json_decode($row->ingredients, true); //Ingredients are stored as JSON
				$data[] = $row;
			}
			//We're done with the db
			$mysqli->close();
			return $data;
		else :
			//No Results
			$mysqli->close();
			return false;
		endif;
	}
	
	public function combine_ingredients($ingredients)
	{	
		$ingredients = explode(':', $ingredients);
		
		foreach ($this->recipes as $recipe) :
			
			if( !$this->array_diff_once($ingredients, $recipe->ingredients) ) :
				//You found a combination
				return $recipe;
			endif;
			
		endforeach;
		
		//No recipe found, it was a bad combination
		return false;	
	}
	
	public function make_json_file()
	{
		//Save a recipes.json file
		$json_file = fopen('recipes.json', 'w');
		fwrite($json_file, $this->json_result);
		fclose($json_file);	
	}
	
	/*
		Form Handling for "Add Recipe" page
	*/
	
	public function add_recipe($_POST)
	{
		$mysqli = $this->connect();
		
		//Make sure everything is formatted correctly.
		$recipe = $this->sanitize_data($_POST);
		
		if ($stmt = $mysqli->prepare("INSERT ? (recipe_title, recipe_image, recipe_desc, ingredients) VALUES (?, ?, ?, ?)"))
		{	
			//Once the query is prepared, set the parameters
			$stmt->bind_param('sssss', $this->table_name, $recipe['title'], $recipe['image'], $recipe['desc'], $recipe['ingredients']);
			$stmt->execute();
			$stmt->close();
		}else{
			die('Could not prepare SQL statement.');
		}
		
		//We're done with the db
		$mysqli->close();
		
		return true;	
	}
	
	private function sanitize_data($_POST)
	{	
		//Get and sanitize the post fields
		if (isset($_POST['recipe_title']) && !empty($_POST['recipe_title']) ) :
			$recipe['title'] = filter_var($_POST['recipe_title'], FILTER_SANITIZE_STRING);
		endif;
		
		if (isset($_POST['recipe_desc']) && !empty($_POST['recipe_desc']) ) :
			$recipe['desc'] = filter_var($_POST['recipe_desc'], FILTER_SANITIZE_STRING);
		endif;
		
		if (isset($_POST['recipe_image']) && !empty($_POST['recipe_image']) ) :
			$recipe['image'] = filter_var($_POST['recipe_image'], FILTER_SANITIZE_URL);
		endif;
		
		$ingredients = array();
		
		if (isset($_POST['ingredient_1']) && !empty($_POST['ingredient_1']) ) :
			$ingredients['1'] = filter_var($_POST['ingredient_1'], FILTER_SANITIZE_STRING);
		endif;
		
		if (isset($_POST['ingredient_2']) && !empty($_POST['ingredient_2']) ) :
			$ingredients['2'] = filter_var($_POST['ingredient_2'], FILTER_SANITIZE_STRING);
		endif;
		
		//Encode ingredients array to JSON for DB storage
		$recipe['ingredients'] = json_encode($ingredients);
		
		return $recipe;
	}
	
	/*
		Helper Functions
	*/
	
	private function array_diff_once()
	{
		/*
			Modified array_diff() to evaluate each entry once (Prevents false positives from 50% matches)
			VIA: http://www.php.net/manual/en/function.array-diff.php#75731
		*/
		
	    if(($args = func_num_args()) < 2)
	        return false;
	    $arr1 = func_get_arg(0);
	    $arr2 = func_get_arg(1);
	    if(!is_array($arr1) || !is_array($arr2))
	        return false;
	    foreach($arr2 as $remove){
	        foreach($arr1 as $k=>$v){
	            if((string)$v === (string)$remove){ //NOTE: if you need the diff to be STRICT, remove both the '(string)'s
	                unset($arr1[$k]);
	                break; //That's pretty much the only difference from the real array_diff :P
	            }
	        }
	    }
	    //Handle more than 2 arguments
	    $c = $args;
	    while($c > 2){
	        $c--;
	        $arr1 = array_diff_once($arr1, func_get_arg($args-$c+1));
	    }
	    return $arr1;
	}
	
	/*
		Debugging Functions Only
	*/
	
	public function show_recipes()
	{
		//Debugging function
		echo '<pre>';
		echo var_dump($this->recipes);
		echo '</pre>';
	}
	
	public function json_output()
	{
		print_r($this->json_result);
	}
	
}
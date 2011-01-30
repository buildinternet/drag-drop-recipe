//Define default paths
var results_path = 'images/';
var ingredients_path = 'images/ingredients/';
var thumb_path = 'images/ingredients/thumbs/';

$(document).ready(function() {
	
	$('#result').hide();
	
	$('.dropzone').droppable({
		hoverClass: 	"ui-state-hover",
		tolerance:		"intersect",
		accept:			"#ingredients li",
		drop:			function(event, ui){
			
			//Get ingredient information
			var file_name = ui.draggable.find('img').attr("rel");
			var ingredient_name = ui.draggable.find('img').attr('alt');
			
			//Update hidden field
			if ($(this).attr('id') == "box1"){
				$('#ingredient1').attr("value", ingredient_name);
			}else{
				$('#ingredient2').attr("value", ingredient_name);
			}
			
			//Update image for ingredient box
			$(this).find('img').attr('src', ingredients_path + file_name + '.jpg').attr('alt', ingredient_name);
			
			//Serialize POST data for AJAX call
			var data_string = $('#combo-form').serialize();
			
			//Check the current combination, return as JSON
			$.post('ajax/check-recipe.php', data_string,
				function(data) {
					update_results(data.recipe);
				}, 'json' );
			
			return false;
		}
	});
	
	$('#ingredients li').draggable({
		containment: 	'body',
		revert:			'invalid',
		helper:			'clone',
		zIndex:			2000,
		scroll:			false,
	});
		
});

function update_results(recipe) {
			
	if (recipe == false) {
		console.log('No result found');
		$('#result').hide();
	}else{
		console.log(recipe);
		$('#result').show();
		
		if (recipe.recipe_image == null){
			$('#result').find('img').attr('src', results_path + '/result-circle-bg.jpg');
		}else{
			$('#result').find('img').attr('src', recipe.recipe_image);
		}
		
		$('#result').find('h2').text(recipe.recipe_title);
		$('#result').find('p').text(recipe.recipe_desc);
	}
}
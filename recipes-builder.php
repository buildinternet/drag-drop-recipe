<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Recipe Builder</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<!-- jQuery UI -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://jqueryui.com/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="http://jqueryui.com/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="http://jqueryui.com/ui/jquery.ui.mouse.js"></script>
	<script type="text/javascript" src="http://jqueryui.com/ui/jquery.ui.draggable.js"></script>
	<script type="text/javascript" src="http://jqueryui.com/ui/jquery.ui.droppable.js"></script>
	
	<script type"text/javascript" src="js/recipe-assets.js"></script>
	
</head>
<body>
	
	<div id="header">
		<h1>Drag and Drop Recipe</h1>
	</div>
	
	<div id="wrapper">
		
		<p id="debug"></p>

		<ul id="ingredients">
			<li><img src="images/ingredients/thumbs/bottled-water.png" alt="Bottled Water" rel="bottled-water"/></li>
			<li><img src="images/ingredients/thumbs/newspaper.png" alt="Newspaper" rel="newspaper"/></li>
		</ul>
		
		<div class="clear">&nbsp;</div>
		
		<div id="box1" class="dropzone">
			<img src="images/ingredients/drag-here-default.jpg" alt="First Component"/>
		</div>
		
		<div id="box2" class="dropzone">
			<img src="images/ingredients/drag-here-default.jpg" alt="Second Component"/>
		</div>
		
		<form action="ajax/check-recipe.php" method="post" id="combo-form">
			<input name="ingredient1" id="ingredient1" type="hidden" value=""/>
			<input name="ingredient2" id="ingredient2" type="hidden" value=""/>
		</form>
		
		<div class="clear">&nbsp;</div>
		
		<!-- 
			The result div only shows when a combination has been found.
		-->
		<div id="result">
			
			<img src="images/result-circle-bg.jpg" title="No match found">
			<div class="desc">
				<span class="prefix">You Made</span>
				<h2>Nothing Yet!</h2>
				<p>Drag and drop ingredients to put discover new combinations.</p>
			</div><!-- .desc -->
			
		</div><!-- #result -->
		
		<div class="clear">&nbsp;</div>
	</div>
	
	<div id="footer">
		<p>Drag and Drop with AJAX, JSON, jQuery UI. Tutorial by <a href="http://buildinternet.com">Build Internet</a>.</p>
	</div>
	
</body>	
</html>
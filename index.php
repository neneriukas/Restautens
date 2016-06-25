<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Restautens - Top Ten Restaurants in Your City!</title>
		
		<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyCllEhugklh13y6HjkFU4eR5gt6Oe5PUSI" type="text/javascript"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<script src="https://use.fontawesome.com/dabb02a073.js"></script>
		
		<script type="text/javascript" src="js/initializePlaces.js"></script>
		
	</head>

	<body>
		<?php require 'Restaurant.php'; ?>
		<div class="container">
			<div class="form-group">
				 <form action="#" method="post">
				 <input class="form-control text-center" id="searchTextField" name="searchTextField" type="text" size="50" placeholder="Enter a city name" autocomplete="on" >
				 <div class="text-center">
					 <input type="Submit" name="Submit" id="submitButton" class="btn btn-primary btn-md">
				 </div>
				 </form>
			</div>
<?php 
		$input = filter_input(INPUT_POST, 'searchTextField');

		if ($input !== null){
			$Restaurant = new Restaurant();
			$city = ucwords(strtok($input, ","));

			echo '<div class="text-center">';
			echo '<h1 id="hereIsTheList"> Here are your top 10 restaurants in <span id="shortCity">' . $city .'</span></h1>';
			echo '</div>';

			$restaurants = $Restaurant->getRestraurants($input);
			foreach ($restaurants as $restaurant) {
				
				echo '<div class="well well-lg col-md-6">';
				echo '<h4 class="text-center">'.$restaurant['name']. '</h4>';
				echo '<h5> rating: '. $restaurant['rating'] . '</h5>';
				$rating = $restaurant['rating'];
				echo '<h3>';
				while($rating >= 1){
					echo '<i class="fa fa-star" aria-hidden="true"></i>';
					$rating--;
				}
				if($rating >= 0.5){
					echo '<i class="fa fa-star-half" aria-hidden="true"></i>';
				}
				echo '</h3>';
				if(isset($restaurant['opening_hours']['open_now'])){
					echo 'opened now? ';
					echo $restaurant['opening_hours']['open_now'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
				}
				if (isset($restaurant['photos'])){
					echo '<img src='.$Restaurant->url.'/photo?maxwidth=300&maxheight=300&photoreference='. $restaurant['photos'][0]['photo_reference'] .'&key='. $Restaurant->apiKey .' alt="'.$restaurant['name'].'" />';
				}
				else{
					echo '<img  src="img/SorryNoImageAvailable.jpg" alt="no-image-available"/>';
				}
				if(isset($restaurant['price_level'])){
					echo '</br>';
					$priceLevel = $restaurant['price_level'];
					while ($priceLevel >= 1){
						echo '<i class="fa fa-usd" aria-hidden="true"></i>';
						$priceLevel--;
					}
				}
				echo '<div id="addressDiv">'. $restaurant['formatted_address']. '</div>';
				echo '</div>';
			}
		}
?>
		</div>
	</body>
</html>
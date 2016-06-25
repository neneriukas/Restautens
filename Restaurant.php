<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of restaurant
 *
 * @author Nerijus
 */
class Restaurant {

	//public $apiKey  = 'AIzaSyCMtT7x2-w7swHiqAzCnnKsWVeh4rNUhA0';
	public $apiKey = 'AIzaSyCIHOPVjrR-O7CibSmXsj_OE7Bjj69HZss';
	public $types = 'restaurant|food';
	public $url = 'https://maps.googleapis.com/maps/api/place';

	public function getRestraurants($input){
			$city = str_replace(' ', '+', $input);
			$url = $this->url.'/textsearch/json?query=restaurants+in+'. $city . '&types='. $this->types .'&key='. $this->apiKey;
			//var_dump($url);exit();
			$result = file_get_contents($url);
			$json = json_decode($result, true);

			if (!isset($json['error_message'])){
				//only restaurant with a rating
				$restaurantsRaw = Array_filter( $json['results'], function($restaurant) {
					return !empty($restaurant['rating']);
				});

				//sort restaurants by rating in descending order
				usort($restaurantsRaw, function($a, $b) {
						if ($a['rating'] == $b['rating']) {
							return 0;
						}
						return ($a['rating'] > $b['rating']) ? -1 : 1;
				});

				//leave only 10 restaurants
				$images = array_slice($restaurantsRaw, 0, 10);
				return $images;
			}
			else{
				echo '<div id="errorMsg"><span>error: </span>'. $json['error_message'] . '</div>';
			}
		}
}
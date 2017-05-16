<?php

function theme_name_scripts() {
	wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_style( 'script-name',  '/wp-content/themes/Divi/style.css' );
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

// this filter adds the logic to the SQL query to take the postcode and compare it to the lat / lng of the location.
add_filter( 'em_events_build_sql_conditions', 'my_em_scope_conditions',1,2);
function my_em_scope_conditions($conditions, $args){
	if( !empty($args['postcode']) ){

	$base_url = "http://maps.google.com/maps/geo?output=xml&key=[your google key here]";

    $request_url = $base_url . "&q=" . urlencode($args['postcode']);
    $xml = simplexml_load_file($request_url);

    $status = $xml->Response->Status->code;
    if (strcmp($status, "200") == 0) {
      // Successful geocode
      $geocode_pending = false;
      $coordinates = $xml->Response->Placemark->Point->coordinates;
      $coordinatesSplit = split(",", $coordinates);
      // Format: Longitude, Latitude, Altitude
      $lat = $coordinatesSplit[1];
      $lng = $coordinatesSplit[0];
      $radius=$input_radius;
	}
	$conditions['scope'] = " (3956 * 2 * ASIN(SQRT(POWER(SIN(('".$lat."' - abs(location_latitude))*pi()/180/2),2) + COS('".$lat."' * pi()/180) * COS(abs(location_latitude) * pi()/180) * POWER(SIN(('".$lng."' - location_longitude) * pi()/180/2),2))) < '".$radius."')";	

	}
	return $conditions;
}


?>
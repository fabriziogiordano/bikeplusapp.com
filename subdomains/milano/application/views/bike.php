<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# fitness: http://ogp.me/ns/fitness#">
<title><?php echo $meta['title'];?></title>
<meta property="fb:app_id"         content="<?php echo $meta['app_id'];?>" />
<meta property="og:type"           content="<?php echo $meta['type'];?>" />
<meta property="og:url"            content="<?php echo $meta['url'];?>" />
<meta property="og:title"          content="<?php echo $meta['title'];?>" />
<meta property="og:description"    content="<?php echo $meta['description'];?>" />
<meta property="og:image"          content="<?php echo $meta['image'];?>" />
<meta property="fitness:live_text" content="<?php echo $meta['live_text'];?>" />

<!-- Other Open Graph properties -->

<?php if(!empty($activitydatapoint['stop_lat'])): ?>

	<?php //GMAP ?>
	<?php if(!empty($activitydatapoint['googlemap']) && $activitydatapoint['googlemap']['status'] == 'OK'): ?>
		<?php
		$route = $activitydatapoint['googlemap']['routes'][0]['legs'][0];
		//var_dump($route);
		?>
		<meta property="fitness:calories"                      content="<?php echo round( round($route['distance']['value'] * 0.000621371, 2) * 180); ?>" />
		<meta property="fitness:distance:units"                content="mi" />
		<meta property="fitness:distance:value"                content="<?php echo round($route['distance']['value'] * 0.000621371, 2); ?>" />
		<meta property="fitness:duration:units"                content="s" />
		<meta property="fitness:duration:value"                content="<?php echo $route['duration']['value']; ?>" />

		<?php
		$steps = $activitydatapoint['googlemap']['routes'][0]['legs'][0]['steps'];
		//var_dump($steps);
		foreach ($steps as $step) : ?>

			<!-- ActivityDataPoint -->
			<meta property="fitness:metrics:distance:units"        content="mi" />
			<meta property="fitness:metrics:distance:value"        content="<?php echo round($step['distance']['value'] * 0.000621371, 2); ?>" />
			<meta property="fitness:metrics:location:latitude"     content="<?php echo $step['start_location']['lat']; ?>" />
			<meta property="fitness:metrics:location:longitude"    content="<?php echo $step['start_location']['lng']; ?>" />
			<meta property="fitness:metrics:timestamp"             content="<?php echo gmdate(DATE_ATOM,$activitydatapoint['start_fitness_metrics_timestamp']+$step['duration']['value']); ?>" />

		<?php endforeach; ?>

	<?php //FALL BACK ?>
	<?php else: ?>
		<meta property="fitness:calories"                      content="<?php echo $activitydatapoint['fitness_calories']; ?>" />
		<!-- <meta property="fitness:custom_unit_energy:value"      content="<?php //echo $activitydatapoint['fitness_custom_unit_energy_value']; ?>" /> -->
		<meta property="fitness:distance:units"                content="<?php echo $activitydatapoint['fitness_distance_units']; ?>" />
		<meta property="fitness:distance:value"                content="<?php echo $activitydatapoint['fitness_distance_value']; ?>" />
		<meta property="fitness:duration:units"                content="<?php echo $activitydatapoint['fitness_duration_units']; ?>" />
		<meta property="fitness:duration:value"                content="<?php echo $activitydatapoint['fitness_duration_value']; ?>" />
		<!-- <meta property="fitness:pace:units"                    content="<?php echo $activitydatapoint['fitness_pace_units']; ?>" /> -->
		<!-- <meta property="fitness:pace:value"                    content="<?php echo $activitydatapoint['fitness_pace_value']; ?>" /> -->
		<!-- <meta property="fitness:speed:units"                   content="<?php echo $activitydatapoint['fitness_speed_units']; ?>" /> -->
		<!-- <meta property="fitness:speed:value"                   content="<?php echo $activitydatapoint['fitness_speed_value']; ?>" /> -->


		<!-- First ActivityDataPoint -->
		<meta property="fitness:metrics:distance:units"        content="<?php echo $activitydatapoint['start_fitness_metrics_distance_units']; ?>" />
		<meta property="fitness:metrics:distance:value"        content="<?php echo $activitydatapoint['start_fitness_metrics_distance_value']; ?>" />
		<meta property="fitness:metrics:location:altitude"     content="<?php echo $activitydatapoint['start_fitness_metrics_location_altitude']; ?>" />
		<meta property="fitness:metrics:location:latitude"     content="<?php echo $activitydatapoint['start_fitness_metrics_location_latitude']; ?>" />
		<meta property="fitness:metrics:location:longitude"    content="<?php echo $activitydatapoint['start_fitness_metrics_location_longitude']; ?>" />
		<!-- <meta property="fitness:metrics:pace:units"            content="<?php echo $activitydatapoint['start_fitness_metrics_pace_units']; ?>" /> -->
		<!-- <meta property="fitness:metrics:pace:value"            content="<?php echo $activitydatapoint['start_fitness_metrics_pace_value']; ?>" /> -->
		<meta property="fitness:metrics:timestamp"             content="<?php echo gmdate(DATE_ATOM,$activitydatapoint['start_fitness_metrics_timestamp']); ?>" />

		<!-- <meta property="fitness:metrics:custom_unit_energy:value"    content="0" /> -->
		<!-- <meta property="fitness:metrics:custom_unit_energy:units"    content="NycBikePlus" /> -->

		<!-- <meta property="fitness:metrics:custom_quantity:value" content="<?php echo $activitydatapoint['start_fitness_metrics_custom_quantity_value']; ?>" /> -->
		<!-- <meta property="fitness:metrics:custom_quantity:units" content="<?php echo $activitydatapoint['start_fitness_metrics_custom_quantity_units']; ?>" /> -->




		<!-- Second ActivityDataPoint -->
		<meta property="fitness:metrics:distance:units"        content="<?php echo $activitydatapoint['stop_fitness_metrics_distance_units']; ?>" />
		<meta property="fitness:metrics:distance:value"        content="<?php echo $activitydatapoint['stop_fitness_metrics_distance_value']; ?>" />
		<meta property="fitness:metrics:location:altitude"     content="<?php echo $activitydatapoint['stop_fitness_metrics_location_altitude']; ?>" />
		<meta property="fitness:metrics:location:latitude"     content="<?php echo $activitydatapoint['stop_fitness_metrics_location_latitude']; ?>" />
		<meta property="fitness:metrics:location:longitude"    content="<?php echo $activitydatapoint['stop_fitness_metrics_location_longitude']; ?>" />
		<!-- <meta property="fitness:metrics:pace:units"            content="<?php echo $activitydatapoint['stop_fitness_metrics_pace_units']; ?>" /> -->
		<!-- <meta property="fitness:metrics:pace:value"            content="<?php echo $activitydatapoint['stop_fitness_metrics_pace_value']; ?>" /> -->
		<meta property="fitness:metrics:timestamp"             content="<?php echo gmdate(DATE_ATOM,$activitydatapoint['stop_fitness_metrics_timestamp']); ?>" />

		<!-- <meta property="fitness:metrics:custom_unit_energy:value"    content="200" /> -->
		<!-- <meta property="fitness:metrics:custom_unit_energy:units"    content="NycBikePlus" /> -->

		<!-- <meta property="fitness:metrics:custom_quantity:value" content="<?php echo $activitydatapoint['stop_fitness_metrics_custom_quantity_value']; ?>" /> -->
		<!-- <meta property="fitness:metrics:custom_quantity:units" content="<?php echo $activitydatapoint['stop_fitness_metrics_custom_quantity_units']; ?>" /> -->
	<?php endif; ?>


<?php endif; ?>

<meta name="description" content="<?php echo $meta['description'];?>">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="cleartype" content="on">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/mobile/img/touch/apple-touch-icon-144x144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/mobile/img/touch/apple-touch-icon-114x114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/mobile/img/touch/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="/assets/mobile/img/touch/apple-touch-icon-57x57-precomposed.png">

<!-- <link rel="shortcut icon" href="/assets/mobile/img/touch/apple-touch-icon.png"> -->

<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900' rel='stylesheet' type='text/css'>
<link href='/assets/css/style.desktop.css?v=<?= $version['css'] ?>' rel='stylesheet' type='text/css'>

</head>
<body>
  <div id="header"><h1><span class="icon-bicycle"></span> <?php echo lang('web_title');?></h1></div>
  <div id="content">
    <div id="phone"><img src="/assets/img/mobile.png" alt="<?php echo lang('web_title');?> WEBAPP"></div>
    <h2><?php echo lang('web_summary');?></h2>
    <p><?php echo lang('web_url');?></p>
  </div>
</body>
</html>
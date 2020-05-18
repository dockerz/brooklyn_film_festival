<?php

	require "includes/app.php";
	require "includes/head.php";

	$message = '';
	$film_import_from_tsv_map = 'submit_id,FILM TITLE,Category,IN?,Accepted?,IN Official email,Premiere Status,Posted Online?,Distributor Waiver,Duration,Country,Contact Person,Director,Main Email,Notes,Subject Matter,Programmer Notes,Genre,Link To Screener,Screener PW,On BFF Website?,Press Files?,Stills,Link To Trailer,webpage?,intro recd,1st Time Dir,MF,Local,Alumni';
	$map = explode (",", $film_import_from_tsv_map);

	// $film_data_map_custom needs to be added to the $film_data_map array.

	$film_data_map_custom = [
		"submit_id" => true,
		"title_article" => FALSE,
		"title" => 0,
		"title_original" => FALSE,
		"category" => 1,
		"genre_1" => FALSE,
		"genre_2" => FALSE,
		"genre_3" => FALSE,
		"genre_4" => FALSE,
		"genre_5" => FALSE,
		"year" => FALSE,
		"length" => 8,
		"format" => FALSE,
		"premiere" => FALSE,
		"email" => 12,
		"web" => FALSE,
		"cast" => FALSE,
		"crew" => FALSE,
		"sales" => FALSE,
		"contact_info" => 10,
		"notes" => FALSE,
		"imdb_url" => FALSE,
		"facebook_url" => FALSE,
		"twitter_url" => FALSE,
		"instagram_url" => FALSE,
		"related_url_1" => FALSE,
		"related_url_2" => FALSE,
		"related_url_3" => FALSE,
		"related_url_4" => FALSE,
		"related_url_5" => FALSE,
		"synopsis" => FALSE,
		"festivals" => FALSE,
		"awards_ext" => FALSE,
		"youtube_url" => FALSE,
		"vimeo_url" => FALSE,
		"preview_type" => FALSE,
		"shooting_format_1" => FALSE,
		"shooting_format_2" => FALSE,
		"shooting_format_3" => FALSE,
		"shooting_format_4" => FALSE,
		"shooting_format_5" => FALSE,
		"country_1" => 9,
		"country_2" => FALSE,
		"country_3" => FALSE,
		"country_4" => FALSE,
		"country_5" => FALSE,
		"country_ext" => FALSE,
		"director_1_first_name" => 11,
		"director_1_last_name" => 11,
		"director_1_biography" => FALSE,
		"director_1_imdb_url" => FALSE,
		"director_1_web" => FALSE,
		"director_1_email" => FALSE,
		"director_2_first_name" => FALSE,
		"director_2_last_name" => FALSE,
		"director_2_biography" => FALSE,
		"director_2_imdb_url" => FALSE,
		"director_2_web" => FALSE,
		"director_2_email" => FALSE,
		"director_3_first_name" => FALSE,
		"director_3_last_name" => FALSE,
		"director_3_biography" => FALSE,
		"director_3_imdb_url" => FALSE,
		"director_3_web" => FALSE,
		"director_3_email" => FALSE,
		"director_4_first_name" => FALSE,
		"director_4_last_name" => FALSE,
		"director_4_biography" => FALSE,
		"director_4_imdb_url" => FALSE,
		"director_4_web" => FALSE,
		"director_4_email" => FALSE,
		"director_5_first_name" => FALSE,
		"director_5_last_name" => FALSE,
		"director_5_biography" => FALSE,
		"director_5_imdb_url" => FALSE,
		"director_5_web" => FALSE,
		"director_5_email" => FALSE,
		"director_statement" => FALSE,
		"image_1" => FALSE,
		"image_2" => FALSE,
		"image_3" => FALSE,
		"image_4" => FALSE,
		"image_5" => FALSE,
		"will_attend" => FALSE,
		"who_will_attend" => FALSE,
		"display_order" => FALSE,
		"language" => FALSE
	];

	if (isset ($_POST['submit'])) {

		$submit_id = get_custom_submit_id ();
		$import_films = explode ("\n", $_POST['tsv']);
		$film_input_array = [];
		foreach ($import_films as $k1 => $v1) {
			$film_data = explode ("\t", $v1);
			$submit_id++;
			$mapped_array = [];
			foreach ($film_data_map_custom as $k2 => $v2) {
				if ($v2 !== FALSE) {
					if ($k2 === 'submit_id') {
						$mapped_array[$k2] = 'CSTM' . $submit_id;
					} elseif ($k2 === 'contact_info') {
						$mapped_array[$k2] = 'Submitter: ' . $film_data[$v2];
					} else {
						$mapped_array[$k2] = $film_data[$v2];
					}
				} else {
					$mapped_array[$k2] = '';
				}
			}
			$film_input_array[] = $mapped_array;
		}
		$submit_id = set_custom_submit_id ($submit_id);
		$message = add_films_to_database ($film_input_array);
	}

   ?>
   <div class="container">
	   <div class="row">
		   <div class="cell">
			   <h1>custom add to db</h1>
			   <?=$message?>
			   <form action="custom.php" method="post" accept-charset"UTF-8">
				   <p>use this tool to import non-filmfreeway, .tsv formatted titles from the 2020 lineup G Doc.</p>
				   <p><textarea name="tsv"></textarea></p>
				   <input type="hidden" name="submit" value="1" />
				   <p><button type="submit">import</button></p>
			   </form>
		   </div>
	   </div>
	</div>
	<?php

	require "includes/foot.php";

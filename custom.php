<?php

	require "includes/app.php";
	require "includes/head.php";

	$message = '';
	$film_import_from_tsv_map = 'submit_id,FILM TITLE,Category,IN?,Accepted?,IN Official email,Premiere Status,Posted Online?,Distributor Waiver,Duration,Country,Contact Person,Director,Main Email,Notes,Subject Matter,Programmer Notes,Genre,Link To Screener,Screener PW,On BFF Website?,Press Files?,Stills,Link To Trailer,webpage?,intro recd,1st Time Dir,MF,Local,Alumni';
	$map = explode (",", $film_import_from_tsv_map);

	$film_data_map_custom = [
		"submit_id" => true,
		"title_article" => false,
		"title" => 0,
		"title_original" => false,
		"category" => 1,
		"genre_1" => false,
		"genre_2" => false,
		"genre_3" => false,
		"genre_4" => false,
		"genre_5" => false,
		"year" => false,
		"length" => 8,
		"format" => false,
		"premiere" => false,
		"email" => 12,
		"web" => false,
		"cast" => false,
		"crew" => false,
		"sales" => false,
		"contact_info" => 10,
		"notes" => false,
		"imdb_url" => false,
		"facebook_url" => false,
		"twitter_url" => false,
		"instagram_url" => false,
		"related_url_1" => false,
		"related_url_2" => false,
		"related_url_3" => false,
		"related_url_4" => false,
		"related_url_5" => false,
		"synopsis" => false,
		"festivals" => false,
		"awards_ext" => false,
		"youtube_url" => false,
		"vimeo_url" => false,
		"preview_type" => false,
		"shooting_format_1" => false,
		"shooting_format_2" => false,
		"shooting_format_3" => false,
		"shooting_format_4" => false,
		"shooting_format_5" => false,
		"country_1" => 9,
		"country_2" => false,
		"country_3" => false,
		"country_4" => false,
		"country_5" => false,
		"country_ext" => false,
		"director_1_first_name" => 11,
		"director_1_last_name" => 11,
		"director_1_biography" => false,
		"director_1_imdb_url" => false,
		"director_1_web" => false,
		"director_1_email" => false,
		"director_2_first_name" => false,
		"director_2_last_name" => false,
		"director_2_biography" => false,
		"director_2_imdb_url" => false,
		"director_2_web" => false,
		"director_2_email" => false,
		"director_3_first_name" => false,
		"director_3_last_name" => false,
		"director_3_biography" => false,
		"director_3_imdb_url" => false,
		"director_3_web" => false,
		"director_3_email" => false,
		"director_4_first_name" => false,
		"director_4_last_name" => false,
		"director_4_biography" => false,
		"director_4_imdb_url" => false,
		"director_4_web" => false,
		"director_4_email" => false,
		"director_5_first_name" => false,
		"director_5_last_name" => false,
		"director_5_biography" => false,
		"director_5_imdb_url" => false,
		"director_5_web" => false,
		"director_5_email" => false,
		"director_statement" => false,
		"image_1" => false,
		"image_2" => false,
		"image_3" => false,
		"image_4" => false,
		"image_5" => false,
		"will_attend" => false,
		"who_will_attend" => false,
		"display_order" => false,
		"language" => false
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
				   <p>use this tool to import non-filmfreeway titles from the google doc.</p>
				   <p><textarea name="tsv"></textarea></p>
				   <input type="hidden" name="submit" value="1" />
				   <p><button type="submit">import</button></p>
			   </form>
		   </div>
	   </div>
	</div>
	<?php

	require "includes/foot.php";

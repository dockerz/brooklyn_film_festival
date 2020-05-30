<?php

	require "includes/app.php";

	/*

		get blocks

		iterate through blocks

			get: each film, ordering by block_number, block_order
			get data: dirs(all) first name, dirs(all) last name, original title, length, category, synopsis, website_id, vimeo_program, country, year, premiere

			shorts: LEWISTON by Director David Shayne & Jacob Roberts  NY Premiere - US - 15 min - 2019

	*/

	$output = "";
	$blocks = blocks ();
	$festival_year_id = 1;

	foreach ($blocks as $k1 => $v1) {

		$output .= "<h1><a name=\"" . str_replace (" ", "_", $v1). "\">" . $v1 . "</a></h1>";
		$films = get_films_with_blocks ($festival_year_id, $k1);

		$block_number = 0;

		foreach ($films as $k2 => $v2) {

			$v2['premiere'] = str_replace ("\"", "", $v2['premiere']);
			$premiere = ($v2['premiere']) ? $v2['premiere'] . " Premiere - " : "" ;
			$country = str_replace ("USA", "United States", str_replace ("\"", "", $v2['country']));

			// directors
			$directors = (str_replace ("\"", "", $v2['dir_1_fn'])) . " " . (str_replace ("\"", "", $v2['dir_1_ln']));
			if ($v2['dir_2_fn'] !== "\"\"") {
				$directors .= " & " . (str_replace ("\"", "", $v2['dir_2_fn'])) . " " . (str_replace ("\"", "", $v2['dir_2_ln']));
				$v2['dir_3_fn'] = str_replace ("\"", "", $v2['dir_3_ln']);
				if ($v2['dir_3_fn']) {
					$directors .= " & " . $v2['dir_3_fn'] . " " . (str_replace ("\"", "", $v2['dir_3_ln']));
				}
			}

			/*

				1 Narrative Feature
				2 Documentary Feature
				3 Documentary Short
				4 Animation
				5 Experimental
				6 Narrative Short

			*/

			$output .= "<p>";
			if (($k1 === 1)|| ($k1 === 2)) { // doc feature and narr feature

				$output .= strtoupper ($v2['name_original']) . " by Director " . $directors . "<br />" . $v1 . " - " . $premiere . $country . " - " . (str_replace ("\"", "", $v2['length'])) . " minutes - " . (str_replace ("\"", "", $v2['year'])) . "<br />";
				$lnk = $v2['vimeo_program'];

			} else { // everything else

				if ($v2['block_number'] > $block_number) {

					$block = get_block_data ($k1, $v2['block_number']);
					$lnk = $block[0]['vimeo'];
					$trt = $block[0]['trt'];
					$ttl = $block[0]['title'];

					$output .= "<h2>Block: " . $v2['block_number'] . " / Title: " . $ttl . " / TRT: " . $trt . "</h2>";

				}

				$output .= strtoupper ($v2['name_original']) . " by Director " . $directors . " - " . $premiere . $country . " - " . (str_replace ("\"", "", $v2['length'])) . " minutes - " . (str_replace ("\"", "", $v2['year'])) . "<br />";

				$block_number = $v2['block_number'];

			}
			$output .= "<a href=\"https://vimeo.com/" . $lnk . "\" target=\"_BLANK\">https://vimeo.com/" . $lnk . "</a><br />";
			$output .= "<a href=\"https://www.brooklynfilmfestival.org/film-detail?fid=" . $v2['website_film_id'] . "&filmmaker=a18kkald90\" target=\"_BLANK\">https://www.brooklynfilmfestival.org/film-detail?fid=" . $v2['website_film_id'] . "&filmmaker=a18kkald90</a>";
			if ($_SERVER['REMOTE_ADDR'] === '184.152.37.149') {
				$output .= "<br /><a href=\"edit.php?id=" . $v2['id'] . "\" target=\"_BLANK\">edit</a>";
			}
			$output .= "</p>";
		}
	}

	$show_block_nav = TRUE;

	require "includes/head.php";

?>

	<div class="container">
		<div class="row">
			<ul class="vertical lines">
				<?=$output?>
			</div>
		</div>
	</div>

<?php

	require "includes/foot.php";

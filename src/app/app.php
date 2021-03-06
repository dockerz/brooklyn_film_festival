<?php

	session_start();

	if ($_SERVER['REMOTE_ADDR'] !== '184.152.37.149') {
		define ('STATUS', 'GUEST');
	} else {
		define ('STATUS', 'MEMBER');
	};

	define ('CLIENT_PATH', '/client/bff/');
	define ('ROOT_DIRECTORY', $_SERVER['DOCUMENT_ROOT'] . CLIENT_PATH);
	define ('EXPORT_DIRECTORY_FROM_WEB', $_SERVER['PATH_INFO'] . 'export/');

	header ('Access-Control-Allow-Origin: *'); // This is to allow cross-origin access for React and Babel.

	ini_set('display_errors', 1);
	require 'secrets.php';

	/*

		Since the data imported from Film Freeway and the required data structure for the export are different, the import data needs to be mapped to the output structure.

		$film_freeway_index_map is how the data coming from the Film Freeway .xls file is mapped.
		When used, this is exploded with `

		*/

	$film_freeway_index_map = "First Name`Last Name`Birthdate`Gender`Email`Phone`Address`Address 2`City`State`Postal Code`Country`Tracking Number1`Project Title`Project Title (Original Language)`Synopsis`Synopsis (Original Language)`Lyrics`Duration`Country of Origin`Language`Trailer URL`Country of Filming`Project Website`Twitter`Facebook`Project Type`Genres`Student Project`Completion Date`Production Budget`Shooting Format`Aspect Ratio`Film Color`Camera`Lens`Focal Length`Shutter Speed`Aperture`ISO Film`First-time Filmmaker`Directors`Writers`Producers`Key Cast`Other Credits`Submitter Statement`Submitter Biography`Rating`Flag`Submission Date`Submission Status`Judging Status`Submission Deadlines`Submission Categories`Discount Code`Submission Link`Submission Password`Assigned Judges`Screenings Awards`Distributor Information`Submission ID`Submission Notes";

	/*

		$film_data_map maps the input from the Film Freeway(.xls) import to the required output format of the G Doc(.tsv). The import has fewer fields than what is required, and in a different order.
		All of the keys in $film_data_map exist in the G Doc, in the same order.
		This array is used to map the MySQL data in the "data" row, which is formatted for JSON.
		$film_data_map is also used to render data on the view and edit pages. The map is retrieved and iterated through, with its associated data.

		The structure of the map is as follows:

			example:	"submit_id" => [[12], false, false, "inp"],
			map:			"1" => [[2], 3, 4, 5],

			1.

				The key of the output. This key corresponds to the key in the DB and the key in the export file. These keys are required, in this order, for proper assembly by Wordpress import.

			2.

				This is either an array or Boolen(FALSE). If truthy, the array looks for numbered indexes from the .xls import and maps them to the this key, or these keys. When importing, the return value is an array.

				If FALSE, this key is ignored and the input element does not appear on edit.php, or display on view.php. IMPORTANT: even if the key is ignored, in the UI, it must be included in the export - it must be in the export schema - it simply holds an empty value, such as "will_attend => ''".

			3.

				If the return array from 2 has more than 1 key, this is probably a multiline value. An example of a multi-line value is "genre", which has 5 different keys, in this array - genre_1, genre_2, genre_3, genre_4, genre_5 - so the return array would look like: ["Drama", "Comedy", "Action", "Horror", "Thriller"].

				TRUE means it is multiline. When importing, add the value, then remove from the array, continue to the next key, repeat until there are no more values, or the next multiline is FALSE.

			4.

				When not FALSE, calls the function name, listed, here for specific manipulation of data.

			5.

				Affects the edit page. Is the form element a <textarea>(txt) or <input>(inp)?

			6.

				This is a map for the custom import page, for use with .tsv formatted data from the lineup G Doc.

		*/

	$film_data_map = [
		"submit_id" => [[12], FALSE, FALSE, "inp", FALSE],
		"title_article" => [[13], FALSE, "title", "inp", FALSE],
		"title" => [[13], FALSE, FALSE, "inp", FALSE],
		"title_original" => [[14], FALSE, FALSE, "inp", FALSE],
		"category" => [[54], FALSE, FALSE, "inp", 1],
		"genre_1" => [[27], TRUE, "split", "inp", FALSE],
		"genre_2" => [[27], TRUE, FALSE, "inp", FALSE],
		"genre_3" => [[27], TRUE, FALSE, "inp", FALSE],
		"genre_4" => [[27], TRUE, FALSE, "inp", FALSE],
		"genre_5" => [[27], TRUE, FALSE, "inp", FALSE],
		"year" => [[29], FALSE, "make_date", "inp", FALSE],
		"length" => [[18], FALSE, "make_duration", "inp", 8],
		"format" => [[31], TRUE, FALSE, "inp", FALSE],
		"premiere" => ["manual", FALSE, FALSE, "inp", FALSE],
		"email" => [[4], FALSE, FALSE, "inp", 12],
		"web" => [[23], TRUE, FALSE, "inp", FALSE],
		"cast" => [[44], FALSE, FALSE, "inp", FALSE],
		"crew" => [[42, 43, 45], FALSE, "assemble_crew", "inp", FALSE],
		"sales" => [FALSE],
		"contact_info" => [[0, 1], FALSE, "assemble_submitter", "inp", 10],
		"notes" => [FALSE],
		"imdb_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"facebook_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"twitter_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"instagram_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"related_url_1" => [FALSE],
		"related_url_2" => [FALSE],
		"related_url_3" => [FALSE],
		"related_url_4" => [FALSE],
		"related_url_5" => [FALSE],
		"synopsis" => [[15], FALSE, FALSE, "txt", FALSE],
		"festivals" => [[59], FALSE, FALSE, "txt", FALSE],
		"awards_ext" => [FALSE],
		"youtube_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"vimeo_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"preview_type" => [FALSE],
		"shooting_format_1" => [[31], TRUE, "split", "inp", FALSE],
		"shooting_format_2" => [[31], TRUE, FALSE, "inp", FALSE],
		"shooting_format_3" => [[31], TRUE, FALSE, "inp", FALSE],
		"shooting_format_4" => [[31], TRUE, FALSE, "inp", FALSE],
		"shooting_format_5" => [[31], TRUE, FALSE, "inp", FALSE],
		"country_1" => [[19, 22], TRUE, "assemble_countries", "inp", 9],
		"country_2" => [[19, 22], TRUE, FALSE, "inp", FALSE],
		"country_3" => [[19, 22], TRUE, FALSE, "inp", FALSE],
		"country_4" => [[19, 22], TRUE, FALSE, "inp", FALSE],
		"country_5" => [[19, 22], TRUE, FALSE, "inp", FALSE],
		"country_ext" => [[19, 22], TRUE, FALSE, "inp", FALSE],
		"director_1_first_name" => [[41], TRUE, "director_name", "inp", 11],
		"director_1_last_name" => [[41], TRUE, FALSE, "inp", 11],
		"director_1_biography" => [[47], TRUE, FALSE, "inp", FALSE],
		"director_1_imdb_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_1_web" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_1_email" => [FALSE],
		"director_2_first_name" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_2_last_name" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_2_biography" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_2_imdb_url" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_2_web" => ["manual", FALSE, FALSE, "inp", FALSE],
		"director_2_email" => [FALSE],
		"director_3_first_name" => [FALSE],
		"director_3_last_name" => [FALSE],
		"director_3_biography" => [FALSE],
		"director_3_imdb_url" => [FALSE],
		"director_3_web" => [FALSE],
		"director_3_email" => [FALSE],
		"director_4_first_name" => [FALSE],
		"director_4_last_name" => [FALSE],
		"director_4_biography" => [FALSE],
		"director_4_imdb_url" => [FALSE],
		"director_4_web" => [FALSE],
		"director_4_email" => [FALSE],
		"director_5_first_name" => [FALSE],
		"director_5_last_name" => [FALSE],
		"director_5_biography" => [FALSE],
		"director_5_imdb_url" => [FALSE],
		"director_5_web" => [FALSE],
		"director_5_email" => [FALSE],
		"director_statement" => [[46], FALSE, FALSE, "txt", FALSE],
		"image_1" => ["manual", FALSE, FALSE, "inp", FALSE],
		"image_2" => ["manual", FALSE, FALSE, "inp", FALSE],
		"image_3" => ["manual", FALSE, FALSE, "inp", FALSE],
		"image_4" => ["manual", FALSE, FALSE, "inp", FALSE],
		"image_5" => ["manual", FALSE, FALSE, "inp", FALSE],
		"will_attend" => [FALSE],
		"who_will_attend" => [FALSE],
		"display_order" => [FALSE],
		"language" => [[20], FALSE, FALSE, "inp", FALSE]
	];

	function authorized () {
		return ($_SERVER['REMOTE_ADDR'] === '184.152.37.149') ? TRUE : FALSE;
	}

	function blocks () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT * FROM `category` ORDER BY `id` ASC");
		return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
	}

	function add_festival_year () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT `data` FROM `festival_year` ORDER BY `id` DESC LIMIT 1");
		$festival_year = $stmt->fetchColumn();
		$stmt = $mysqli->prepare("INSERT INTO `festival_year` (`data`) VALUES (?)");
		return $stmt->execute([++$festival_year]);
	}

	function add_film_note ($input) {
		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO `film_note` (`submission_id`, `data`, `time`) VALUES (?, ?, ?)");
		return $stmt->execute([$input['submission_id'], $input['email_data'], time()]);
	}

	function add_festival_vimeo_link ($link, $id) {
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE `film` SET `vimeo_program` = ? WHERE `id`=?");
		return $stmt->execute([$link, $id]);
	}

	function add_data_to_data_row_by_key ($name_original, $website_film_id, $premiere, $id) {
		// adds original film name, premiere status & vimeo website id
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE `film` SET `name_original` = ?, `website_film_id` = ?, data = JSON_SET(data, '$.premiere', ?) WHERE `id`=?");
		return $stmt->execute([$name_original, $website_film_id, $premiere, $id]);
	}

	function is_film_in_db_by_title ($title) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `id` FROM `film` WHERE `name_normalized`=? LIMIT 1");
		$stmt->execute([$title]);
		return $stmt->fetchColumn();
	}

	function get_note ($submission_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `time`, `data` FROM `film_note` WHERE `submission_id`=? ORDER BY `id` DESC");
		$stmt->execute([$submission_id]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function get_category_id_by_name ($category) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `id` FROM `category` WHERE `data`=? LIMIT 1");
		$stmt->execute([$category]);
		return $stmt->fetchColumn();
	}

	function get_festival_year ($festival_year_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `data` FROM `festival_year` WHERE `id`=? LIMIT 1");
		$stmt->execute([$festival_year_id]);
		return $stmt->fetchColumn();
	}

	function get_festival_years () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT * FROM `festival_year` ORDER BY `id` DESC");
		return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
	}

	function get_block_data ($block_id, $block_number) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `trt`, `vimeo`, `title` FROM `block` WHERE `category_id`=? AND `block_number`=? LIMIT 1");
		$stmt->execute([$block_id, $block_number]);
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function get_film_from_database ($submission_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT * FROM `film` WHERE `id`=? LIMIT 1");
		$stmt->execute([$submission_id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	function get_films_for_vimeo_pages () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT `film`.`id`,
			`film`.`ready`,
			`film`.`website_film_id`,
			`film_note`.`id` AS `note`,
			film.data->'$.premiere' AS `premiere`,
			film.data->'$.image_1' AS `img`,
			film.data->'$.category' AS `category`,
			film.data->'$.title' AS `name`,
			`film`.`submission_id`
			FROM `film`
			LEFT JOIN `film_note`
			ON `film_note`.`submission_id` = `film`.`submission_id`
			WHERE in_festival = true
			GROUP BY `film`.`submission_id`
			ORDER BY film.data->'$.category',
			film.data->'$.title' ASC");
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function get_films_with_blocks ($festival_year_id, $data) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `id`,
			`website_film_id`
			`vimeo_program`,
			`block_number`,
			`block_order`,
			`vimeo_program`,
			`name_original`,
			`website_film_id`,
			film.data->'$.director_1_first_name' AS `dir_1_fn`,
			film.data->'$.director_1_last_name' AS `dir_1_ln`,
			film.data->'$.director_2_first_name' AS `dir_2_fn`,
			film.data->'$.director_2_last_name' AS `dir_2_ln`,
			film.data->'$.director_3_first_name' AS `dir_3_fn`,
			film.data->'$.director_3_last_name' AS `dir_3_ln`,
			film.data->'$.premiere' AS `premiere`,
			film.data->'$.year' AS `year`,
			film.data->'$.country_1' AS `country`,
			film.data->'$.length' AS `length`,
			film.data->'$.title' AS `name`
			FROM `film`
			WHERE `festival_year_id` = ?
			AND `block_id` = ?
			AND `in_festival` = true
			ORDER BY `block_number` ASC,
			`block_order` ASC");
		$stmt->execute([$festival_year_id, $data]);
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function get_films ($festival_year_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `film`.`id`,
			`film`.`in_festival`,
			`film`.`ready`,
			`film`.`website_film_id`,
			`film`.`vimeo_program`,
			`film`.`block_id`,
			`film`.`block_number`,
			`film`.`block_order`,
			film.data->'$.premiere' AS `premiere`,
			film.data->'$.image_1' AS `img`,
			film.data->'$.category' AS `category`,
			film.data->'$.title' AS `name`,
			`film`.`submission_id`
			FROM `film`
			LEFT JOIN `film_note`
			ON `film_note`.`submission_id` = `film`.`submission_id`
			WHERE `film`.`festival_year_id` = ?
			AND `film`.`in_festival` = true
			GROUP BY `film`.`submission_id`
			ORDER BY `film`.`block_id` DESC,
			`film`.`block_number` ASC,
			`film`.`block_order` ASC,
			`film`.`name_normalized` ASC");
		$stmt->execute([$festival_year_id]);
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function get_films_data_for_export () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT * FROM `film` ORDER BY `name_normalized` ASC");
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function normalize_film_name ($input) {
		return strtolower(str_replace(" ", "_", preg_replace("/[^A-Za-z0-9 ]/", '', $input[1])));
	}

	function add_film_to_festival ($input) {

		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO `film` (`submission_id`, `block_id`, `block_number`, `block_order`, `vimeo_program`, `website_film_id`, `name_original`, `name_normalized`, `data`, `time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		if ($stmt->execute([$input['submit_id'], $input['block_id'], $input['block_number'], $input['block_order'], $input['vimeo_program'], $input['website_film_id'], $input['title'], normalize_film_name ($input['title']), json_encode ($input), time()])) {
			set_custom_submit_id ($id);
			return "added to database";
		}

	}

	function add_films_to_database_from_FF ($input) {

		/*

			1. foreach through $input
			2. extract submission_id;
			3. extract name.
			4. create image_import_name from film name - remove non-ascii chars, lowercase, replace spaces with underscores, making "Film *** Name" into "film_name", for the image naming convention "film_name-1.jpg". This
			5. make `data` into JSON.
			4. add, repeat.

			*/

		global $mysqli;
		$a = 0;
		foreach ($input as $k1 => $v1) {
			$stmt = $mysqli->prepare("INSERT INTO `film` (`name_normalized`, `name_original`, `data`, `time`) VALUES (?, ?, ?, ?)");
			if ($stmt->execute([normalize_film_name ($v1['title']), $v1['title'], json_encode ($v1), time()])) {
				$a++;
			}
		}
		return "added " . $a . " films to database";
	}

	function assemble_countries ($input) {
		if (!$input[0]&&!$input[1]) {
			return [];
		} else {
			if ($input[0] === $input[1]): return [$input[0]]; endif;
			return [implode (" / ", $input)];
		}
	}

	function has_multiple ($input, $delimiter = ",") {
		return substr_count ($input, $delimiter);
	}

	function split ($input) {
		return explode(",", str_replace(", ", ",", $input[0]));
	}

	function make_date ($input) {
		return [substr($input[0], 0, 4)];
	}

	function make_duration ($input) {
		$data = explode (":", $input[0]);
		$data[1] += ($data[2] === "00") ? 0 : 1;
		return [(60 * $data[0]) + $data[1]];
	}

	function director_name ($input) {
		return explode(" ", $input[0]);
	}

	function assemble_submitter ($input) {
		return ["Submitter: " . implode (" ", $input)];
	}

	function assemble_crew ($input) {
		$output = '';
		foreach ($input as $k1 => $v1) {
			if ($k1 !== 2 && $v1) { // writers or directors not empty.
				$output .= ($k1 === 0) ? "Writer" : "Producer";
				$output .= (has_multiple($v1, ",")) ? "s" : ""; // multiple
				$output .= ": " . $v1 . ". ";
			}
		}
		$output .= $input[2];
		return [$output];
	}

	function remove_existing_submission_id ($input) {
		global $mysqli;
		$array = explode (",", $input);
		$output = [];
		foreach ($array as $k1 => $v1) {
			if (!get_latest_film_id_from_submission_id($v1)): $output[] = $v1; endif;
		}
		return implode (',', $output);
	}

	function title ($input) {
		$pos = stripos($input[0], $needle = "the ");
		if ($pos !== false) {
			return ["The", substr_replace($input[0], "", $pos, strlen($needle))];
		} else {
			return ["", $input[0]];
		}
	}

	function update_film_in_database ($input) {
		global $mysqli;
		$id_to_update = get_latest_film_id_from_submission_id ($input['submit_id']);
		$in_festival = (isset ($input['in_festival'])) ? TRUE : FALSE;
		$stmt = $mysqli->prepare("UPDATE `film` SET `name_normalized`=?, `data`=?, `time`=?, `edited`=true, `in_festival`=?, `name_original`=?, `block_id`=?, `block_number`=?, `block_order`=?, `vimeo_program`=?, `website_film_id`=? WHERE id=?");
		return $stmt->execute([$input['film_name'], json_encode($input), time(), $in_festival, $input['name_original'], $input['block_id'], $input['block_number'], $input['block_order'], $input['vimeo_program'], $input['website_film_id'], $id_to_update]);
	}

	function assemble_film_data ($input, $map) {
		$output = $cached_data = [];
		$cached_index = $cached_key = 0;
		foreach ($map as $k1 => $v1) {
			$data = [];
			if (($v1[0])&&($v1[0] !== "manual")) { // display is set to false, show empty field.
				if ($v1[0] == $cached_key) { // key is cached, move key pointer up by 1, take data from that key, and add to output.
					$output[$k1] = ucfirst($cached_data[++$cached_index]);
				} else {
					$cached_key = $v1[0];
					$cached_index = 0;
					if ($v1[2]) {
						foreach ($v1[0] as $k2 => $v2) { $data[] = $input[$v2]; }
						$cached_data = $v1[2]($data);
					}
					$output[$k1] = ($v1[2]) ? ucfirst($cached_data[$cached_index]) : $input[$v1[0][0]];
				}
			} else {
				$output[$k1] = '';
			}
		}
		return $output;
	}

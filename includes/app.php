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

	header ('Access-Control-Allow-Origin: *');

	ini_set('display_errors', 1);
	require 'secrets.php';

	/*

		$film_freeway_index_map is how the data coming from the Film Freeway .xls file is mapped.
		When used, this is exploded with a `

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
				The key of the output. This key corresponds to the key in the DB and the key in the destination file.

			2.
				This is either an array or Boolen(FALSE). If truthy, the array looks for numbered indexes from the .xls import and maps them to the correct key. When importing, the return value is an array.

				If FALSE, this key is ignored and no other action is taken. Also, if FALSE, does not render on the view and edit pages.

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
		"submit_id" => [[12], false, false, "inp"],
		"title_article" => [[13], false, "title", "inp"],
		"title" => [[13], false, false, "inp"],
		"title_original" => [[14], false, false, "inp"],
		"category" => [[54], false, false, "inp"],
		"genre_1" => [[27], true, "split", "inp"],
		"genre_2" => [[27], true, false, "inp"],
		"genre_3" => [[27], true, false, "inp"],
		"genre_4" => [[27], true, false, "inp"],
		"genre_5" => [[27], true, false, "inp"],
		"year" => [[29], false, "make_date", "inp"],
		"length" => [[18], false, "make_duration", "inp"],
		"format" => [[31], true, false, "inp"],
		"premiere" => [false],
		"email" => [[4], false, false, "inp"],
		"web" => [[23], true, false, "inp"],
		"cast" => [[44], false, false, "inp"],
		"crew" => [[42, 43, 45], false, "assemble_crew", "inp"],
		"sales" => [false],
		"contact_info" => [[0, 1], false, "assemble_submitter", "inp"],
		"notes" => [false],
		"imdb_url" => ["manual", false, false, "inp"],
		"facebook_url" => ["manual", false, false, "inp"],
		"twitter_url" => ["manual", false, false, "inp"],
		"instagram_url" => ["manual", false, false, "inp"],
		"related_url_1" => [false],
		"related_url_2" => [false],
		"related_url_3" => [false],
		"related_url_4" => [false],
		"related_url_5" => [false],
		"synopsis" => [[15], false, false, "txt"],
		"festivals" => [[59], false, false, "txt"],
		"awards_ext" => [false],
		"youtube_url" => ["manual", false, false, "inp"],
		"vimeo_url" => ["manual", false, false, "inp"],
		"preview_type" => [false],
		"shooting_format_1" => [[31], true, "split", "inp"],
		"shooting_format_2" => [[31], true, false, "inp"],
		"shooting_format_3" => [[31], true, false, "inp"],
		"shooting_format_4" => [[31], true, false, "inp"],
		"shooting_format_5" => [[31], true, false, "inp"],
		"country_1" => [[19, 22], true, "assemble_countries", "inp"],
		"country_2" => [[19, 22], true, false, "inp"],
		"country_3" => [[19, 22], true, false, "inp"],
		"country_4" => [[19, 22], true, false, "inp"],
		"country_5" => [[19, 22], true, false, "inp"],
		"country_ext" => [[19, 22], true, false, "inp"],
		"director_1_first_name" => [[41], true, "director_name", "inp"],
		"director_1_last_name" => [[41], true, false, "inp"],
		"director_1_biography" => [[47], true, false, "inp"],
		"director_1_imdb_url" => ["manual", false, false, "inp"],
		"director_1_web" => ["manual", false, false, "inp"],
		"director_1_email" => [false],
		"director_2_first_name" => ["manual", false, false, "inp"],
		"director_2_last_name" => ["manual", false, false, "inp"],
		"director_2_biography" => ["manual", false, false, "inp"],
		"director_2_imdb_url" => ["manual", false, false, "inp"],
		"director_2_web" => ["manual", false, false, "inp"],
		"director_2_email" => [false],
		"director_3_first_name" => [false],
		"director_3_last_name" => [false],
		"director_3_biography" => [false],
		"director_3_imdb_url" => [false],
		"director_3_web" => [false],
		"director_3_email" => [false],
		"director_4_first_name" => [false],
		"director_4_last_name" => [false],
		"director_4_biography" => [false],
		"director_4_imdb_url" => [false],
		"director_4_web" => [false],
		"director_4_email" => [false],
		"director_5_first_name" => [false],
		"director_5_last_name" => [false],
		"director_5_biography" => [false],
		"director_5_imdb_url" => [false],
		"director_5_web" => [false],
		"director_5_email" => [false],
		"director_statement" => [[46], false, false, "txt"],
		"image_1" => ["manual", false, false, "inp"],
		"image_2" => ["manual", false, false, "inp"],
		"image_3" => ["manual", false, false, "inp"],
		"image_4" => ["manual", false, false, "inp"],
		"image_5" => ["manual", false, false, "inp"],
		"will_attend" => [false],
		"who_will_attend" => [false],
		"display_order" => [false],
		"language" => [[20], false, false, "inp"]
	];

	function authorized () {
		return ($_SERVER['REMOTE_ADDR'] === '184.152.37.149') ? TRUE : FALSE;
	}

	function set_email_data ($input) {
		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO `film_email` (`submission_id`, `data`, `time`) VALUES (?, ?, ?)");
		return $stmt->execute([$input['submission_id'], $input['email_data'], time()]);
	}

	function get_latest_film_id_from_submission_id ($submission_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `id` FROM `film` WHERE `submission_id`=? ORDER BY `id` DESC LIMIT 1");
		$stmt->execute([$submission_id]);
		return $stmt->fetchColumn();
	}

	function get_email_data ($submission_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `time`, `data` FROM `film_email` WHERE `submission_id`=? ORDER BY `id` DESC");
		$stmt->execute([$submission_id]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function get_film_from_database ($submission_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT * FROM `film` WHERE `submission_id`=? ORDER BY `id` DESC LIMIT 1");
		$stmt->execute([$submission_id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	function get_note ($submission_id) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT `id` FROM `film_email` WHERE `submission_id`=? LIMIT 1");
		$stmt->execute([$submission_id]);
		return $stmt->fetch();
	}

	function get_custom_submit_id () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT `data` FROM `custom_submission_id` LIMIT 1");
		return $stmt->fetchColumn();
	}

	function set_custom_submit_id ($input) {
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE `custom_submission_id` SET data=? WHERE `id`=1");
		return $stmt->execute([$input]);
	}

	function get_films_from_database () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT `film`.`id`, `film`.`ready`, `film_email`.`id` AS `note`, film.data->'$.email' AS `email`, film.data->'$.image_1' AS `img`, film.data->'$.category' AS `category`, film.data->'$.title' AS `name`, `film`.`submission_id` FROM `film` LEFT JOIN `film_email` ON `film_email`.`submission_id` = `film`.`submission_id` GROUP BY `film`.`submission_id` ORDER BY film.data->'$.category', film.data->'$.title' ASC");
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function get_films_data_for_export () {
		global $mysqli;
		$stmt = $mysqli->query("SELECT * FROM `film` ORDER BY `name` ASC");
		$output = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $output;
	}

	function film_image_in_folder ($filename_to_be_found) {
		return glob (ROOT_DIRECTORY . "img/" . $filename_to_be_found);
	}

	function add_films_to_database ($input) {
		/*
			3. extract submission_id;
			4. extract name.
			5. make image_import_name from film name - remove non-ascii chars, lowercase, replace spaces with underscores, making "Film *** Name" into "film_name", for the image naming convention "film_name-1.jpg".
			3. make data into json.
			4. foreach through list and add to db.
		*/
		global $mysqli;
		$a = 0;
		foreach ($input as $k1 => $v1) {
			$db_input['film_id'] = $v1['submit_id'];
			$db_input['film_name'] = preg_replace("/[^A-Za-z0-9 ]/", '', $v1['title']);
			$db_input['film_name'] = strtolower(str_replace(" ", "_", $db_input['film_name']));
			$db_input['json'] = json_encode($v1);
			$stmt = $mysqli->prepare("INSERT INTO `film` (`submission_id`, `name`, `data`, `time`) VALUES (?, ?, ?, ?)");
			if ($stmt->execute([$db_input['film_id'], $db_input['film_name'], $db_input['json'], time()])) {
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

	function check_web_link ($input) {
		return [__FUNCTION__];
	}

	function get_dir_bio ($input) {
		return [__FUNCTION__];
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
		$ready = (isset ($input['ready'])) ? TRUE : FALSE;
		$stmt = $mysqli->prepare("UPDATE `film` SET `name`=?, `data`=?, `time`=?, `edited`=true, `ready`=? WHERE id=?");
		return $stmt->execute([$input['film_name'], json_encode($input), time(), $ready, $id_to_update]);
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

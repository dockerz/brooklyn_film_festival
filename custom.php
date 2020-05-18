<?php

	require "includes/app.php";
	require "includes/head.php";

	$message = '';
	$film_import_from_tsv_map = 'submit_id,FILM TITLE,Category,IN?,Accepted?,IN Official email,Premiere Status,Posted Online?,Distributor Waiver,Duration,Country,Contact Person,Director,Main Email,Notes,Subject Matter,Programmer Notes,Genre,Link To Screener,Screener PW,On BFF Website?,Press Files?,Stills,Link To Trailer,webpage?,intro recd,1st Time Dir,MF,Local,Alumni';
	$map = explode (",", $film_import_from_tsv_map);

	if (isset ($_POST['submit'])) {

		$submit_id = get_custom_submit_id ();
		$import_films = explode ("\n", $_POST['tsv']);
		$film_input_array = [];
		foreach ($import_films as $k1 => $v1) {
			$film_data = explode ("\t", $v1);
			$submit_id++;
			$mapped_array = [];
			foreach ($film_data_map as $k2 => $v2) {
				if ($v2 !== FALSE) {
					if ($k2 === 'submit_id') {
						$mapped_array[$k2] = 'CSTM' . $submit_id;
					} elseif ($k2 === 'contact_info') {
						$mapped_array[$k2] = 'Submitter: ' . $film_data[$v2[5]];
					} else {
						$mapped_array[$k2] = $film_data[$v2[5]];
					}
				} else {
					$mapped_array[$k2] = '';
				}
			}
			$film_input_array[] = $mapped_array;
		}
		$submit_id = set_custom_submit_id ($submit_id);
		$message = add_films_to_database_from_FF ($film_input_array);
	}

   ?>
   <div class="container">
	   <div class="row">
		   <div class="cell">
			   <h1>Custom(Manual) add to DB</h1>
			   <?=$message?>
			   <form action="custom.php" method="post" accept-charset"UTF-8">
				   <p>Use this tool to import .tsv formatted titles from the 2020 lineup G Doc.</p>
				   <p><textarea name="tsv"></textarea></p>
				   <input type="hidden" name="submit" value="1" />
				   <p><button type="submit">import</button></p>
			   </form>
		   </div>
	   </div>
	</div>
	<?php

	require "includes/foot.php";

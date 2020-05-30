<?php

	require "includes/app.php";
	require "includes/head.php";

	$export_display = '';

	$export_files = [];
	if ($dh = opendir(ROOT_DIRECTORY . 'export/')) {
		while (($file = readdir($dh)) !== false) {
			if (($file !== '.')&&($file !== '..')) {
				$export_files[] = $file;
			}
		}
		closedir($dh);
	}

	echo $latest_file;

	if (isset ($_POST['generate'])) {
		$films_to_export = get_films_data_for_export ();
		$a = 0;
		$number_of_films_to_export = count ($films_to_export);
		// create header
		foreach ($film_data_map as $k2 => $v2): $film_data_array[$k2] = $k2; endforeach;
		$export_data_content = implode ("\t", $film_data_array) . "\n";
		// end
		foreach ($films_to_export as $k1 => $v1) {
			$a++;
			$film_data = json_decode ($v1['data'], true, 512, JSON_UNESCAPED_UNICODE);
			$export_data_array = [];
			foreach ($film_data_map as $k2 => $v2) {
				$data_to_insert = str_replace ("\"", "”", $film_data[$k2]);
				if (strpos ($data_to_insert, "\n")) {
					$data_to_insert = "\"" . $data_to_insert . "\"";
				}
				$film_data_array[$k2] = ($k2 !== 'festivals') ? $data_to_insert : '';
			}
			$cell_delimiter = ($a < $number_of_films_to_export) ? "\n" : "";
			$export_data_content .= implode ("\t", $film_data_array) . $cell_delimiter;
		}

		// write to file
		$last_filename = str_replace ('.tsv', '', $export_files[(count($export_files) - 1)]);
		$new_filename = $last_filename + 1 . '.tsv';
		$new_file = fopen(ROOT_DIRECTORY . 'export/' . $new_filename, "w") or die("Unable to open file!");
		fwrite($new_file, $export_data_content);
		fclose($new_file);

		$message = '<p style="color: red;"><strong>export file(' . $new_filename . ') created</strong></p>';
		$export_display = '<p><a href="' . EXPORT_DIRECTORY_FROM_WEB . $new_filename . '>' . $new_filename . '</a></p>';

	}

	// render file list
	$export_files = array_reverse ($export_files); // reversing array, so latest is rendered first.
	foreach ($export_files as $v1) {
		$export_display .= '<p><a href="' . EXPORT_DIRECTORY_FROM_WEB . $v1 . '">' . $v1 . '</a></p>';
	}

   ?>
   <div class="container">
	   <div class="row">
		   <div class="cell">
			   <h1><strong>export</strong></h1>
			   <?=$message?>
			   <p>files for export</p>
			   <?=$export_display?>
			   <form action="export.php" method="post" enctype="multipart/form-data">
				   <p>would you like generate a tab delimited file for export?</p>
				   <input type="hidden" name="generate" value="1" />
				   <p><button type="submit">yes</button></p>
			   </form>
		   </div>
	   </div>
	</div>
	<?php

	require "includes/foot.php";

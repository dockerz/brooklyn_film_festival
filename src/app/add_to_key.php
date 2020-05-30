<?php

	require "includes/app.php";
	require "includes/head.php";

	/*

		display: get keys from $film_data_map, display in a dropdown, with key name being <option value="key_name">.
		display: add textarea - accepts tsv formatted from g doc.
		user: select key.
		user: paste array into textarea
		user: update.
		form submit: iterate through exploded input, via newline, iterate again via tab. data will look like: BKLYN3420	Into The Storm	WORLD	2225
			dev:
				yes - display input title / db title, with key and data to be added. display what query will look like.
				no - display input title, key and data to be added.
			prod:
				yes - display input title / db title, with key and data to be added.
					add data to be added to key.
				no - display input title, key and data to be added.

		*/

	if (isset ($_POST['submit'])) {
		$output = "";
		$array = explode ("\n", $_POST['input_array']);
		$a = 0;
		foreach ($array as $k1 => $v1) {
			$data = explode ("\t", $v1);
			// update db, set name_original $data[1], website_film_id $data[3], data->premiere $data[2]
			if ($data[0]) {
				// look for film from ff id $data[0]
				$id = get_latest_film_id_from_submission_id ($data[0]);
			} else {
				// if no, normalize title and look for that $data[1]
				$title = normalize_film_name (title ([ trim ($data[1])])); // remove "the "
				echo $title;
				$id = is_film_in_db_by_title ($title);
				echo $id;
			}
			if ($id) {
				if (add_data_to_data_row_by_key ($data[1], $data[3], $data[2], $id)) {
					$output .= "<p><strong>UPDATED</strong> name: " . $title . " / website_film_id: " . $data[3] . " / name_original: " . $data[1] . " / premiere: " . $data[2] . " / indb: " . $id . "</p>";					
				}
			} else {
				$output .= "<p>name: " . $title . " / original title: " . $data[1] . " / not in db</p>";

			}
		}
	?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<h1>viewing <strong><?=$_POST['key']?> / <?=$a?></strong></h1>
				<?=$output?>
			</div>
		</div>
	</div>
	<?php
	}

   $keys = '';
   foreach ($film_data_map as $k1 => $v1) {
	   $keys .= '<option value="' . $k1 . '">' . $k1 . '</option>';
   }

   ?>
   <div class="container">
	   <div class="row">
		   <div class="cell">
			   <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
				   <p>this tool is used to add data to a specific key in the index.</p>
				   <p><select class="" name="key"><?=$keys?></select></p>
					 <p>array format: ["film_title_1" => "data_to_add_1", "film_title_2" => "data_to_add_2"]</p>
				   <p><label>array</label><textarea name="input_array"></textarea> </p>
				   <input type="hidden" name="submit" value="1" />
				   <p><button type="submit">add data</button></p>
			   </form>
		   </div>
	   </div>
	</div>
	<?php

	require "includes/foot.php";

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
			if ((!strpos ($data[0], "LIVE ACTION")) && (!strpos ($data[0], "ANIMATION"))) {
				$title = normalize_film_name (title ([ trim ($data[0])])); // remove "the "
				$id = is_film_in_db_by_title ($title);
				$link = str_replace ("https://vimeo.com/", "", $data[1]);
				if ($id) {
					if (add_festival_vimeo_link ($link, $id)) {
						$output .= "<p><strong>UPDATED</strong> name: " . $title . " / vimeo link: " . $data[1] . " / id: " . $id . "</p>";
					}
				} else {
					$output .= "<p>name: " . $title . " / original title: " . $data[1] . " / not in db</p>";
				}
			}
		}
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
				   <p>this tool is used to add festival viemo link from film masters g doc.</p>
				   <p><select class="" name="key"><?=$keys?></select></p>
					 <p>tsv format: title/tlink\n</p>
				   <p><label>array</label><textarea name="input_array"></textarea> </p>
				   <input type="hidden" name="submit" value="1" />
				   <p><button type="submit">add data</button></p>
			   </form>
		   </div>
	   </div>
	</div>
	<?php

	require "includes/foot.php";

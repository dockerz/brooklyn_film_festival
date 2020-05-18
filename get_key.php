<?php

	require "includes/app.php";
	require "includes/head.php";

	$map = explode("`", $film_freeway_index_map);

	if (isset ($_POST['submit'])) {

		$films_for_output = '';
		$file = file_get_contents($_FILES['script']['tmp_name']);
		$films = explode("\n", $file);

		foreach ($films as $k1 => $film) {
			$film_data_to_be_assembled = explode("`", $film);
			$films_for_output .= ($film_data_to_be_assembled[$_POST['key']]) ? '<p>' . $film_data_to_be_assembled[13] . ': <strong>' . $film_data_to_be_assembled[$_POST['key']] . '</strong></p>' : '<p>&nbsp;</p>';
		}

?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<h1>viewing <strong><?=$map[$_POST['key']]?></strong></h1>
				<?=$films_for_output?>
			</div>
		</div>
	</div>

<?php

	}

   $keys = '';
   foreach ($map as $k1 => $v1) {
	   $keys .= '<option value="' . $k1 . '">' . $v1 . '</option>';
   }

?>
   <div class="container">
	   <div class="row">
		   <div class="cell">
			   <form action="get_key.php" method="post" enctype="multipart/form-data">
				   <p>This tool is used to get data from a specific key in the index. Data format must be .xls.</p>
				   <select class="" name="key">
					   <?=$keys?>
				   </select>
				   <p>file<input type="file" name="script"></p>
				   <input type="hidden" name="submit" value="1" />
				   <p><button type="submit">get key</button></p>
			   </form>
		   </div>
	   </div>
	</div>
<?php

	require "includes/foot.php";

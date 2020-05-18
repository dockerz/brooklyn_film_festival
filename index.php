<?php
	require "includes/app.php";
	require "includes/head.php";
	$films = get_films_from_database();
	$films_output = '';
	$ready_for_export_count = $with_images_count = 0;
	foreach ($films as $k1 => $v1) {
		$img = $ready = $note = '';
		if (strpos ($v1['img'], 'jpg')) {
			$img = 'has img';
			$with_images_count++;
		}
		if ($v1['ready']) { $ready_for_export_count++; }
		if ($v1['note']) { $note = 'note'; }
		$films_output .= '<li><span class="medium">' . (str_replace ("\"", "", $v1['category'])) . '</span> <span class="wide"><a href="view.php?id=' . $v1['submission_id'] . '" target="_BLANK">' . (str_replace ("\"", "", $v1['name'])) . '</a>' . '</span><span class="medium-wide"><a href="mailto:' . (str_replace ("\"", "", $v1['email'])) . '">' . (str_replace ("\"", "", $v1['email'])) . '</a></span> <span class="thin ready">' . (($v1['ready']) ? 'updated': '') . '</span> <span class="thin img">' . $img . '</span> <span class="thin note">' . $note . '</span><a href="edit.php?id=' . $v1['submission_id'] . '" target="_BLANK">edit</a></li>';
	}
	?>
	<div class="container">
		<div class="row">
			<div class="cell">
				<p>total films: <?=count($films)?> / with images: <?=$with_images_count?> / ready for export: <?=$ready_for_export_count?></p>
			</div>
		</div>
		<div class="row">
			<ul class="vertical lines">
				<?=$films_output?>
			</div>
		</div>
	</div>

		<?php

			$films_array = [];
			foreach ($films as $k1 => $v1) {
				$film_array = [];
				foreach ($v1 as $k2 => $v2) {
					$v2 = trim($v2);
					$film_array[] = "\"" . $k2 . "\":" . ((strpos ($v2, "\"") !== 0) ? "\"" . $v2 . "\"" : $v2);
				}
				$films_array[] = "{" . implode (",", $film_array) . "}";
			}
			$final_array = implode (",\n", $films_array);

//			echo "<p><pre>" . $final_array . "</pre></p>";

			require "includes/foot.php";

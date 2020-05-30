<?php

	require "includes/app.php";
	require "includes/head.php";

	$festival_year_id = 1;

	$festival_year = get_festival_year ($festival_year_id); // films output is in JSON format
	$films = get_films ($festival_year_id); // films output is in JSON format
	$films_output = '';
	$ready_for_export_count = $with_images_count = 0;

	$blocks = blocks();

	foreach ($films as $k1 => $v1) {

		$img = '';

		if (strpos ($v1['img'], 'jpg')) {
			$img = 'img';
			$with_images_count += 1;
		}

		if ($v1['ready']) { $ready_for_export_count += 1; }

		$films_output .= '<li class="' . (!$v1['in_festival'] ? 'removed' : ''). '"><span class="medium">' . $blocks[$v1['block_id']] . '</span><span class="thin">' . ($v1['block_number'] ? $v1['block_number'] : '') . '</span><span class="thin">' . ($v1['block_order'] ? $v1['block_order'] : '') . '</span><span class="really-wide"><a href="view.php?id=' . $v1['submission_id'] . '" target="_BLANK">' . (str_replace ("\"", "", $v1['name'])) . '</a>' . '</span><span class="thin img"><a href="https://www.brooklynfilmfestival.org/film-detail?fid=' . $v1['website_film_id'] . '&filmmaker=a18kkald90" target="_BLANK">' . $v1['website_film_id'] . '</a></span><span class="thin img">' . (($v1['vimeo_program']) ? 'yes' : '') . '</span><a href="edit.php?id=' . $v1['id'] . '" target="_BLANK">edit</a></li>';

	}

?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<p>festival year: <?=$festival_year?>(<a href="#">change</a>) / total films: <?=count($films)?> / with images: <?=$with_images_count?> / ready for export: <?=$ready_for_export_count?></p>
			</div>
		</div>
		<div class="row">
			<ul class="vertical lines">
				<li><span class="medium">category</span><span class="thin">number</span><span class="thin">order</span><span class="really-wide">name</span><span class="thin img">film id</span><span class="thin img">vimeo</span></li>
				<?=$films_output?>
			</div>
		</div>
	</div>

<?php

	require "includes/foot.php";

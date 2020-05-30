<?php

	require "includes/app.php";
	require "includes/head.php";

	$map = explode("`", $film_freeway_index_map);

	/*
	$ids = 'BKLYN3453,BKLYN2626,BKLYN3371,BKLYN1839,BKLYN2503,BKLYN2419,BKLYN1960,BKLYN2999,BKLYN1651,BKLYN1260,BKLYN2857,BKLYN2599,BKLYN1189,BKLYN3019,BKLYN1263,BKLYN1265,BKLYN2406,BKLYN3088,BKLYN1937,BKLYN2323,BKLYN2791,BKLYN2685,BKLYN3420,BKLYN2877,BKLYN2571,BKLYN2016,BKLYN2271,BKLYN1995,BKLYN1492,BKLYN1636,BKLYN1379,BKLYN1277,BKLYN1469,BKLYN2597,BKLYN2389,BKLYN2411,BKLYN2873,BKLYN3550,BKLYN3113,BKLYN3148,BKLYN1614,BKLYN3381,BKLYN3284,BKLYN2506,BKLYN2445,BKLYN3207,BKLYN2176,BKLYN3254,BKLYN2867,BKLYN2174,BKLYN1317,BKLYN2591,BKLYN1657,BKLYN1005,BKLYN1015,BKLYN3138,BKLYN3177,BKLYN1896,BKLYN3398,BKLYN3143,BKLYN1768,BKLYN2089,BKLYN1000,BKLYN1027,BKLYN1068,BKLYN1166,BKLYN1210,BKLYN1452,BKLYN1541,BKLYN1575,BKLYN1617,BKLYN1726,BKLYN1727,BKLYN1821,BKLYN1912,BKLYN1975,BKLYN2021,BKLYN2057,BKLYN2278,BKLYN2434,BKLYN2565,BKLYN2783,BKLYN2853,BKLYN2905,BKLYN3041,BKLYN3159,BKLYN3523,BKLYN2090,BKLYN3387,BKLYN3379,BKLYN2484,BKLYN2719,BKLYN3293,BKLYN1923,BKLYN3000,BKLYN2337,BKLYN1080,BKLYN1627,BKLYN2885,BKLYN2620,BKLYN3486,BKLYN2038,BKLYN1121,BKLYN1715,BKLYN3528,BKLYN1928,BKLYN2610';

	BKLYN2626,BKLYN1839,BKLYN1651,BKLYN2089

	$array = explode (',', $ids);
	foreach ($array as $v1) {
		echo "<p>" . $v1 . ': ' . (get_latest_film_id_from_submission_id ($v1) ? $v1 : '') . '</p>';
	}

//	echo remove_existing_submission_id ($ids);
	*/

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
				   <p>this tool is used to get data from a specific key in the index.</p>
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

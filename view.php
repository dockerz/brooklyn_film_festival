<?php

	require "includes/app.php";

	$message = '';

	if (isset ($_POST['submission_id'])) {
		$message = '<p style="color: red;"><strong>';
		$message .= (set_email_data ($_POST)) ? 'note added to this film.' : 'note not added.';
		$message .= '</strong></p>';
		$film_id = $_POST['film_id'];
	} else {
		$film_id = $_GET['id'];
	}

	// film data
	$film = get_film_from_database($film_id);
	$film_data = json_decode($film['data'], true, 512, JSON_UNESCAPED_UNICODE);

	// associated email data
	$email_array = get_email_data ($film['submission_id']);
	$emails = '';
	if ($email_array) {
		foreach ($email_array as $k1 => $v1) {
			$emails .= '<li class="email"><p><strong>' . date ('Y-m-d', $v1['time']) . '</strong></p><p>' . nl2br($v1['data']). '</p></li>';
		}
	} else {
		$emails = '<li><strong>there are no notes for this film.</strong></li>';
	}

	$title = "bff : viewing " . $film['submission_id'];
	require "includes/head.php";

	?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<h1><?=$film['name']?> <strong><?=$film['submission_id']?></strong></h1>
				<?=$message?>
			</div>
		</div>
		<div class="row">
			<ul class="vertical">
				<?php
				$images = [];
				foreach ($film_data_map as $k1 => $v1) {
					if ((strpos($k1, 'image_') === 0)&&($film_data[$k1])) {
						$images[] = $film_data[$k1];
					}
					echo '<li>' . $k1 . ': <strong>' . str_replace ("_NL_", "<br />", $film_data[$k1]) . '</strong></li>';
				}
				?>
			</ul>
		</div>
		<div class="row">
			<div class="cell">
				<?php foreach ($images as $v1): echo '<p>' . $v1 . '<br /><img src="/client/bff/img/' . $v1 . '" style="width: 950px;" /></p>'; endforeach; ?>
			</div>
		</div>
		<div class="row">
			<div class="cell">
				<h2>notes</h2>
				<ul class="vertical">
					<?=$emails?>
				</ul>
				<?php if ($_SERVER['REMOTE_ADDR'] === '184.152.37.149') { ?>
				<form name="add_email" action="view.php" method="post" accept-charset"UTF-8">
					<p>add a note.</p>
					<p><textarea name="email_data"></textarea></p>
					<input type="hidden" name="submission_id" value="<?=$film['submission_id']?>" />
					<input type="hidden" name="film_id" value="<?=$film_id?>" />
					<p><button type="submit">submit</button></p>
				</form>
				<?php } ?>
			</div>
		</div>

	</div>

	<?php

	require "includes/foot.php";

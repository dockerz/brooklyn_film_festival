<?php

	require "includes/app.php";

	$message = $form_elements = '';
	$show_edit_nav = TRUE;

	$id = $_GET['id'];

	if (isset ($_POST['update'])) {
		$id = $_POST['submit_id'];
		if (authorized ()) {
			$message = (update_film_in_database ($_POST)) ? 'film updated' : 'film not updated';
		} else {
			$message = 'you do not have editing privileges';
		}
		$message = '<p style="color: red;"><strong>' . $message . '</strong></p>';
	}

	$disabled = (!authorized ()) ? 'disabled' : '';

	$film = get_film_from_database($id);
	$film_data = json_decode($film['data'], true, 512, JSON_UNESCAPED_UNICODE);

	$checked = $film_data['ready'] ? 'checked ' : ''; // has film been marked "ready"?

	$keys = [];
	foreach ($film_data_map as $k1 => $v1) {
		if ($v1[0]) {
			$keys[] = $k1;
			$form_elements .= '<p><a name="' . $k1 . '"></a><label for="' . $k1 . '">' . $k1 . '</label><textarea name="' . $k1 . '" ' . $disabled . '>' . str_replace ("_NL_", "\n", $film_data[$k1]) . '</textarea></p>';
		}
	}

	// associated email data
	$notes_array = get_email_data ($film_data['submit_id']);
	$notes = '';
	if ($notes_array) {
		foreach ($notes_array as $k1 => $v1) {
			$notes .= '<li class="email"><p><strong>' . date ('Y-m-d', $v1['time']) . '</strong></p><p>' . nl2br($v1['data']). '</p></li>';
		}
	} else {
		$notes = '<li><strong>there are no notes for this film.</strong></li>';
	}

	$title = "bff : editing " . $film['submission_id'];

	require "includes/head.php";

	?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<h1><strong><?=$film_data['title']?></strong></h1>
				<p><span id="film_image"><?=$film['name']?></span> <strong><?=$film['submission_id']?></strong></p>
				<?=$message?>
			</div>
		</div>
		<div class="row">
			<div class="cell">
				<form name="film" action="edit.php" method="post" accept-charset"UTF-8">
					<p><label for="ready">text_updated?</label><span class="form_element_padding"><input type="checkbox" name="ready" value="true" <?=$checked?>/></span></p>
					<p><a name="film_name"></a><label for="film_name">image_root_name</label><input type="text" name="film_name" value="<?=$film['name']?>" /></p>
					<?=$form_elements?>
					<input type="hidden" name="update" value="<?=$film['id']?>">
				</form>
			</div>
		</div>
	</div>

	<?php

	require "includes/foot.php";

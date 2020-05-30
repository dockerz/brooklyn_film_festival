<?php

	require "includes/app.php";

	// edit form assembly begin

	$message = $form_elements = '';
	$show_edit_nav = TRUE;

	$id = $_GET['id'];

	if (isset ($_POST['update'])) {
		$id = $_POST['id'];
		if (authorized ()) { // DB updates are limited to authorized admins.
			$message = (update_film_in_database ($_POST)) ? 'Film updated' : 'Film not updated';
		} else {
			$message = 'You do not have editing privileges.';
		}
		$message = '<p style="color: red;"><strong>' . $message . '</strong></p>';
	}

	$disabled = (!authorized ()) ? 'disabled' : '';

	$film = get_film_from_database($id);
	$film_data = json_decode($film['data'], true, 512, JSON_UNESCAPED_UNICODE);

	$category_id = get_category_id_by_name ($film_data['category']);
	echo $film_data['category'];
	$toggle_show_block = (($category_id !== 1)&&($category_id !== 2)) ? "hide" : "show";

	$ready_checked = $film['ready'] ? 'checked ' : ''; // Has film been marked "ready for export"?
	$in_festival_checked = $film['in_festival'] ? 'checked ' : ''; // Should film be removed from exports?

	// edit form assembly end

	// notes begin

	$notes_array = get_note ($film_data['submit_id']);
	$notes = '';
	if ($notes_array) {
		foreach ($notes_array as $k1 => $v1) {
			$notes .= '<li class="email"><p><strong>' . date ('Y-m-d', $v1['time']) . '</strong></p><p>' . nl2br($v1['data']). '</p></li>';
		}
	} else {
		$notes = '<li><strong>there are no notes for this film.</strong></li>';
	}

	// notes end

	// these keys are assembled to display as the navigation between form elements. this hacky solution needs to be refactored, big time.

	$keys = [];
	foreach ($film_data_map as $k1 => $v1) {
		if ($v1[0]) {
			$keys[] = $k1;
			$form_elements .= '<p><a name="' . $k1 . '"></a><label for="' . $k1 . '">' . $k1 . '</label><textarea name="' . $k1 . '" ' . $disabled . '>' . str_replace ("_NL_", "\n", $film_data[$k1]) . '</textarea></p>';
		}
	}

	$block_display = '<select name="block_id"><option value="0">choose</option>';
	foreach (blocks() as $k1 => $v1) {
		$block_display .= '<option value="' . $k1 . '" ' . (($film['block_id'] == $k1) ? "selected": "") . '>' . $v1 . '</option>';
	}
	$block_display .= '</select>';

	$title = "bff : editing " . $film['submission_id'];

	require "includes/head.php";

	/*
	<p><label for="ready">text_updated?</label><span class="form_element_padding"><input type="checkbox" name="ready" value="true" <?=$ready_checked?>/></span></p>
	*/

	?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<h1><strong><?=$film_data['title']?></strong></h1>
				<?=$message?>
			</div>
		</div>
		<div class="row">
			<div class="cell">
				<form name="film" action="edit.php" method="post" accept-charset"UTF-8">
					<p><label for="ready">in_festival?</label><span class="form_element_padding"><input type="checkbox" name="in_festival" value="true" <?=$in_festival_checked?>/></span></p>
					<p><a name="category"></a><label for="category">category</label><?=$block_display?></p>
					<p class="block <?=$toggle_show_block?>"><a name="block_number"></a><label for="block_number">block_number</label><input type="number" name="block_number" value="<?=$film['block_number']?>" /></p>
					<p class="block <?=$toggle_show_block?>"><a name="block_order"></a><label for="block_order">block_order</label><input type="number" name="block_order" value="<?=$film['block_order']?>" /></p>
					<p><a name="vimeo_program"></a><label for="vimeo_program">vimeo_program</label><input type="text" name="vimeo_program" value="<?=$film['vimeo_program']?>" /></p>
					<p><a name="website_film_id"></a><label for="website_film_id">website_film_id</label><input type="number" name="website_film_id" value="<?=$film['website_film_id']?>" /></p>
					<p><a name="name_original"></a><label for="name_original">name_original</label><input type="text" name="name_original" value="<?=$film['name_original']?>" /></p>
					<p><a name="name_normalized"></a><label for="name_normalized">name_normalized</label><input type="text" name="name_normalized" value="<?=$film['name_normalized']?>" /></p>
					<?=$form_elements?>
					<input type="hidden" name="id" value="<?=$id?>">
					<input type="hidden" name="update" value="<?=$film['id']?>">
				</form>
			</div>
		</div>
	</div>

	<?php

	require "includes/foot.php";

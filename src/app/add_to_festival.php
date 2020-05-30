<?php

	require "includes/app.php";

	$message = $form_elements = '';
	$show_edit_nav = TRUE;

	if (isset ($_POST['add'])) {
		if (authorized ()) { // DB updates are limited to authorized admins.
			$id = $_POST['submit_id'];
			$message = add_film_to_festival ($_POST);
		} else {
			$message = 'You do not have editing privileges.';
		}
		$message = '<p style="color: red;"><strong>' . $message . '</strong></p>';
	}

	$submit_id = get_custom_submit_id ();
	$submit_id += 1;

	$keys = [];
	foreach ($film_data_map as $k1 => $v1) {
		if ($v1[0]) {
			$keys[] = $k1;
			$form_elements .= '<p><a name="' . $k1 . '"></a><label for="' . $k1 . '">' . $k1 . '</label><textarea name="' . $k1 . '" ' . $disabled . '>' . str_replace ("_NL_", "\n", $film_data[$k1]) . '</textarea></p>';
		}
	}

	$block_display = '<select name="block_id"><option value="0">choose</option>';
	foreach (blocks() as $k1 => $v1) {
		$block_display .= '<option value="' . $k1 . '">' . $v1 . '</option>';
	}
	$block_display .= '</select>';

	$title = "bff : add to festival ";

	require "includes/head.php";

	?>

	<div class="container">
		<div class="row">
			<div class="cell">
				<h1><strong>add a film</strong></h1>
				<?=$message?>
			</div>
		</div>
		<div class="row">
			<div class="cell">
				<form name="film" action="<?=$_SERVER['PHP_SELF']?>" method="post" accept-charset"UTF-8">
					<p><a name="submit_id"></a><label for="submit_id">submit_id</label><input type="text" name="submit_id" value="CSTM<?=$submit_id?>" /></p>
					<p><label for="ready">in_festival?</label><span class="form_element_padding"><input type="checkbox" name="in_festival" value="true" /></span></p>
					<p><a name="block_id"></a><label for="block_id">block_id</label><?=$block_display?></p>
					<p><a name="block_number"></a><label for="block_number">block_number</label><input type="number" name="block_number" value="" /></p>
					<p><a name="block_order"></a><label for="block_order">block_order</label><input type="number" name="block_order" value="" /></p>
					<p><a name="vimeo_program"></a><label for="vimeo_program">vimeo_program</label><input type="text" name="vimeo_program" value="" /></p>
					<p><a name="website_film_id"></a><label for="website_film_id">website_film_id</label><input type="number" name="website_film_id" value="" /></p>
					<p><a name="film_name"></a><label for="film_name">image_root_name</label><input type="text" name="film_name" value="" /></p>
					<?=$form_elements?>
					<input type="hidden" name="custom" value="">
					<input type="hidden" name="add" value="1">
				</form>
			</div>
		</div>
	</div>

	<?php

	require "includes/foot.php";

<?php

	$title = "bff : import";
	require "includes/app.php";
	require "includes/head.php";

	if (isset ($_POST['submit'])) {

		if (authorized ()) {

			$message = "";
			$films_for_output = [];
			$file = file_get_contents($_FILES['script']['tmp_name']);
			$films = explode("\n", $file);

			foreach ($films as $k1 => $film) {
				$film_data_to_be_assembled = explode("`", $film);
				if ($film) {
					$films_for_output[$k1] = assemble_film_data ($film_data_to_be_assembled, $film_data_map);
				}
			}

			$message = add_films_to_database ($films_for_output);

			echo $message;

		} else {
			echo "you are not authorized to import files to the db.";
		}

	} else {

		?>
		<div class="container">
			<div class="row">
				<h1>file upload</h1>
				<ol>
					<li>in the g doc list with all the selected films in it, select the entire vertical column, with the film ids(BKLYN2337, BKLYN2338, etc.). copy the contents of all the cells.</li>
					<li>open a page in a text editor and paste in. delete blank lines. convert all \n to commas, making it look like: BKLYN2337,BKLYN2338,BKLYN2339,BKLYN2340,BKLYN2341,BKLYN2342, etc.</li>
					<li>copy this list and go to filmfreeway. on the search page, do an advanced search and in the "bulk tracking numbers" field, paste the id list. submit form.</li>
					<li>make sure the amount of results correspond to the number that should be there.</li>
					<li>select all and export all as excel. this will make a single excel file, with all the results.</li>
					<li>open the excel file in an editor and delete everything that isn't a &lt;cell&gt; or &lt;row&gt;.</li>
					<li>delete all carriage returns(\r, &lt;CR&gt;).</li>
					<li>search and replace all new lines(\n) with _NL_.</li>
					<li>delete all &lt;row&gt;.</li>
					<li>search and replace &lt;/row&gt; with \n, making new lines, which is to be the delimiter for chunking via explode.</li>
					<li>delete all &lt;cell&gt;</li>
					<li>search and replace all &lt;/cell&gt; with backtick(`) and delete final backtick in file.</li>
					<li>search and replace all `\n with \n.</li>
					<li>delete final `, at the end of the file.</li>
					<li>save to file.</li>
					<li>run the file, using the form, below.</li>
				</ol>
			</div>
			<div class="row">
				<div class="cell">
					<form action="import.php" method="post" enctype="multipart/form-data">
				  		<p>file<input type="file" name="script"></p>
				  		<input type="hidden" name="submit" value="1" />
				    	<p><button type="submit">upload</button></p>
				    </form>
				</div>
			</div>
		</div>
		<?php
	}
	require "includes/foot.php";

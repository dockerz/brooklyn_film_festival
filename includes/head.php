<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="x-ua-compatible" content="ie=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  	<style>
	  html { font-family: 'trebuchet ms'; text-align: center; font-size: 90%; }
	  span { color: #333; }
	  h1 { margin-bottom: 25px; font-weight: 300; color: #666; font-size: 1.5em; }
		h1 strong { font-weight: 700; color: #333; }
		h2 { padding-bottom: 15px; margin-bottom: 15px; font-weight: 300; color: #333; font-size: 1.25em; border-bottom: 1px dotted #333; }
	  .container { margin: 0 auto; width: 950px; }
	  .container .row { text-align: left; }
	  .clicked { color: blue; }
		.hide { display: none; }
	  .cell { padding-right: 25px; overflow: hidden; }
	  button { padding: 20px; border: none; background-color: red; color: white; }
	  p { margin-bottom: 25px; }
	  ul { margin-left: 0; padding-left: 0; list-style-type: none; }
	  ul.nav { margin: 25px 0; padding: 0; overflow: auto; }
	  ul.nav li { margin-right: 10px; box-sizing: border-box; width: 120px; display: inline-block; float: left; clear: none; }
	  ul.vertical li { padding: 24px 0; }
	  ul.vertical.lines li { border-top: 1px solid #999; }
		ul li.removed { background-color: #e2c7c7; }
	  ul li span { display: inline-block; }
		span.really-wide { width: 400px; }
	  span.wide { width: 350px; }
	  span.medium { width: 170px; }
	  span.medium-wide { width: 220px; }
	  span.thin { width: 80px; }
	  .form_element_padding { display: inline-block; padding: 15px; }
	  label { padding: 15px 15px 15px 0; box-sizing: border-box; display: inline-block; width: 200px; vertical-align: top; }
	  input[type="text"], input[type="password"], input[type="number"] { font-family: 'trebuchet ms'; padding: 15px; border: none; background-color: #333; color: #fff; width: 300px; }
	  textarea { font-family: 'trebuchet ms'; padding: 15px; border: none; background-color: #333; color: #fff; width: 300px; height: 100px; }
	  #edit_notes_panel { padding: 10px; position: fixed; width: 350px; height: 100%; right: 200px; top: 50px; box-sizing: border-box; overflow: scroll; }
	  #edit_node_navigation { padding: 10px; position: fixed; width: 200px; height: 100%; right: 0px; box-sizing: border-box; overflow: scroll; }
	  #edit_node_navigation a, #edit_node_navigation button { padding: 3px; margin: 3px; display: inline-block; background-color: #999; color: #fff; }
	  #edit_node_navigation button { background: red; cursor: pointer; }
	  @media (max-width: 1000px) {
		  #edit_notes_panel, #edit_node_navigation { display: none; }
	  }
	  @media (max-width: 800px) {
		  .container { width: 90%; overflow: hidden; }
	  }
  	</style>
  	<title><?=$title?></title>
</head>
<body>
	<?php if (isset ($show_block_nav)) { ?>
		<div id="edit_node_navigation">
			<?php foreach ($blocks as $k1 => $v1): echo '<a href="#' . str_replace (" ", "_", $v1) . '">' . $v1 . '</a>'; endforeach; ?>
		</div>
	<?php } ?>
	<?php if (isset ($show_edit_nav)) { ?>
		<div id="edit_node_navigation">
			<?='<button id="submit_form">submit</button>'?>
			<?php foreach ($keys as $v1): echo '<a href="#' . $v1 . '">' . $v1 . '</a>'; endforeach; ?>
		</div>
		<div id="edit_notes_panel">
			<ul class="vertical">
				<?=$notes?>
			</ul>
		</div>
	<?php } ?>
	<div class="container fixed">
		<div class="row">
			<ul class="nav">
  			<li><a href="index.php">home</a></li>
				<li><a href="import.php">import file</a></li>
				<li><a href="custom.php">import custom</a></li>
				<li><a href="add_to_festival.php">add</a></li>
				<li><a href="export.php">export file</a></li>
				<li><a href="output.php">output</a></li>
			</ul>
		</div>
	</div>

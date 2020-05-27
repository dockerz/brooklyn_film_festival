	<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
	<script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
	<script src="/generic/jq.js"></script>
		<script>
		// submit form from page navigation area.
		$('#submit_form')
			.on('click', function () {
				$('form[name="film"]').submit();
			});
		/*
			Clicking on an image_n textarea populates this with the film title, following the approved naming convention - film_name-n.jpg.
			*/
		$('textarea')
			.on('focus', function () {
				if ($(this).attr('name').search('image_') > -1) { // element clicked is associated with the images.
					let img_name = $('input[name="name_normalized').val(),
							el_name = $(this).attr('name').replace('image_', '');
							console.log(img_name);
					$(this).text(img_name + '-' + el_name + '.jpg');
				}
			});
		</script>
	</body>
</html>

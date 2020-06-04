import React from 'react';

function App() {
  return (
		<div class="container">
			<div class="row">
				<div class="cell">
					<h1><strong>add a film</strong></h1>
				</div>
			</div>
			<div class="row">
				<div class="cell">
					<form name="film" action="/" method="post" accept-charset="utf-8">
						<p><a name="submit_id"></a><label for="submit_id">submit_id</label><input type="text" name="submit_id" value="" /></p>
						<p><a name="title_article"></a><label for="title_article">title_article</label><input type="text" name="title_article" value="" /></p>
						<p><a name="title"></a><label for="title">title</label><input type="text" name="title" value="" /></p>
						<p><a name="title_original"></a><label for="title_original">title_original</label><input type="text" name="title_original" value="" /></p>
						<p><a name="category"></a><label for="category">category</label><input type="text" name="category" value="" /></p>
						<p><a name="genre_1"></a><label for="genre_1">genre_1</label><input type="text" name="genre_1" value="" /></p>
						<p><a name="genre_2"></a><label for="genre_2">genre_2</label><input type="text" name="genre_2" value="" /></p>
						<p><a name="genre_3"></a><label for="genre_3">genre_3</label><input type="text" name="genre_3" value="" /></p>
						<p><a name="genre_4"></a><label for="genre_4">genre_4</label><input type="text" name="genre_4" value="" /></p>
						<p><a name="genre_5"></a><label for="genre_5">genre_5</label><input type="text" name="genre_5" value="" /></p>
						<p><a name="year"></a><label for="year">year</label><input type="text" name="year" value="" /></p>
						<p><a name="length"></a><label for="length">length</label><input type="text" name="length" value="" /></p>
						<p><a name="format"></a><label for="format">format</label><input type="text" name="format" value="" /></p>
						<p><a name="premiere"></a><label for="premiere">premiere</label><input type="text" name="premiere" value="" /></p>
						<p><a name="email"></a><label for="email">email</label><input type="text" name="email" value="" /></p>
						<p><a name="web"></a><label for="web">web</label><input type="text" name="web" value="" /></p>
						<p><a name="cast"></a><label for="cast">cast</label><input type="text" name="cast" value="" /></p>
						<p><a name="crew"></a><label for="crew">crew</label><input type="text" name="crew" value="" /></p>
						<p><a name="contact_info"></a><label for="contact_info">contact_info</label><input type="text" name="contact_info" value="" /></p>
						<p><a name="imdb_url"></a><label for="imdb_url">imdb_url</label><input type="text" name="imdb_url" value="" /></p>
						<p><a name="facebook_url"></a><label for="facebook_url">facebook_url</label><input type="text" name="facebook_url" value="" /></p>
						<p><a name="twitter_url"></a><label for="twitter_url">twitter_url</label><input type="text" name="twitter_url" value="" /></p>
						<p><a name="instagram_url"></a><label for="instagram_url">instagram_url</label><input type="text" name="instagram_url" value="" /></p>
						<p><a name="synopsis"></a><label for="synopsis">synopsis</label><textarea name="synopsis"></textarea></p>
						<p><a name="festivals"></a><label for="festivals">festivals</label><textarea name="festivals"></textarea></p>
						<p><a name="youtube_url"></a><label for="youtube_url">youtube_url</label><input type="text" name="youtube_url" value="" /></p>
						<p><a name="vimeo_url"></a><label for="vimeo_url">vimeo_url</label><input type="text" name="vimeo_url" value="" /></p>
						<p><a name="shooting_format_1"></a><label for="shooting_format_1">shooting_format_1</label><input type="text" name="shooting_format_1" value="" /></p>
						<p><a name="shooting_format_2"></a><label for="shooting_format_2">shooting_format_2</label><input type="text" name="shooting_format_2" value="" /></p>
						<p><a name="shooting_format_3"></a><label for="shooting_format_3">shooting_format_3</label><input type="text" name="shooting_format_3" value="" /></p>
						<p><a name="shooting_format_4"></a><label for="shooting_format_4">shooting_format_4</label><input type="text" name="shooting_format_4" value="" /></p>
						<p><a name="shooting_format_5"></a><label for="shooting_format_5">shooting_format_5</label><input type="text" name="shooting_format_5" value="" /></p>
						<p><a name="country_1"></a><label for="country_1">country_1</label><input type="text" name="country_1" value="" /></p>
						<p><a name="country_2"></a><label for="country_2">country_2</label><input type="text" name="country_2" value="" /></p>
						<p><a name="country_3"></a><label for="country_3">country_3</label><input type="text" name="country_3" value="" /></p>
						<p><a name="country_4"></a><label for="country_4">country_4</label><input type="text" name="country_4" value="" /></p>
						<p><a name="country_5"></a><label for="country_5">country_5</label><input type="text" name="country_5" value="" /></p>
						<p><a name="country_ext"></a><label for="country_ext">country_ext</label><input type="text" name="country_ext" value="" /></p>
						<p><a name="director_1_first_name"></a><label for="director_1_first_name">director_1_first_name</label><input type="text" name="director_1_first_name" value="" /></p>
						<p><a name="director_1_last_name"></a><label for="director_1_last_name">director_1_last_name</label><input type="text" name="director_1_last_name" value="" /></p>
						<p><a name="director_1_biography"></a><label for="director_1_biography">director_1_biography</label><textarea name="director_1_biography"></textarea></p>
						<p><a name="director_1_imdb_url"></a><label for="director_1_imdb_url">director_1_imdb_url</label><input type="text" name="director_1_imdb_url" value="" /></p>
						<p><a name="director_1_web"></a><label for="director_1_web">director_1_web</label><input type="text" name="director_1_web" value="" /></p>
						<p><a name="director_2_first_name"></a><label for="director_2_first_name">director_2_first_name</label><input type="text" name="director_2_first_name" value="" /></p>
						<p><a name="director_2_last_name"></a><label for="director_2_last_name">director_2_last_name</label><input type="text" name="director_2_last_name" value="" /></p>
						<p><a name="director_2_biography"></a><label for="director_2_biography">director_2_biography</label><textarea name="director_2_biography"></textarea></p>
						<p><a name="director_2_imdb_url"></a><label for="director_2_imdb_url">director_2_imdb_url</label><input type="text" name="director_2_imdb_url" value="" /></p>
						<p><a name="director_2_web"></a><label for="director_2_web">director_2_web</label><input type="text" name="director_2_web" value="" /></p>
						<p><a name="director_statement"></a><label for="director_statement">director_statement</label><textarea name="director_statement"></textarea></p>
						<p><a name="image_1"></a><label for="image_1">image_1</label><input type="text" name="image_1" value="" /></p>
						<p><a name="image_2"></a><label for="image_2">image_2</label><input type="text" name="image_2" value="" /></p>
						<p><a name="image_3"></a><label for="image_3">image_3</label><input type="text" name="image_3" value="" /></p>
						<p><a name="image_4"></a><label for="image_4">image_4</label><input type="text" name="image_4" value="" /></p>
						<p><a name="image_5"></a><label for="image_5">image_5</label><input type="text" name="image_5" value="" /></p>
						<p><a name="language"></a><label for="language">language</label><input type="text" name="language" value="" /></p>
						<input type="hidden" name="custom" value="" />
						<input type="hidden" name="add" value="1" />
					</form>
				</div>
			</div>
		</div>
  );
}

export default App;

import React from 'react';
import { Link } from 'react-router-dom';

import FilmData from '../app/data/films.json';


function App() {
  return (
	<div className="App">
		<div class="container">
			<div class="row">
				<div class="cell">
					<p><strong>to do: get json for index, edit/view and output pages and render accordingly</strong></p>
					<p>festival year: 2020(<a href="#">change</a>) / total films: 131 / with images: 95 / ready for export: 58</p>
				</div>
			</div>
			<div class="row">
				<ul class="vertical lines">
					<li><span class="medium">category</span><span class="thin">number</span><span class="thin">order</span><span class="really-wide">name</span><span class="thin img">film id</span><span class="thin img">vimeo</span></li>
					{
						FilmData.map((film, i) => {
							return (
								<li><span class="medium">{film['category']}</span><span class="thin">{film['block_number']}</span><span class="thin">{film['block_order']}</span><span class="really-wide"><a href={'view.php?id=' + film.id}>{film['name']}</a></span><span class="thin img"><a href={'https://www.brooklynfilmfestival.org/film-detail?fid=' + film.website_film_id + '&filmmaker=a18kkald90'} target="_BLANK">{film['website_film_id']}</a></span><span class="thin img">{(film['img']) ? 'img' : ''}</span><Link to={'/edit?id=' + film.id}>edit</Link></li>
							)
						})
					}
				</ul>
			</div>
		</div>
	</div>
  );
}

export default App;

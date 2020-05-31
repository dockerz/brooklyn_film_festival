// react
import React from 'react';
import { Link } from 'react-router-dom';

function IndexListItem (props) {
  return (
		<li>
			<span className="medium">{props.film.category}</span>
			<span className="thin">{props.film.block_number}</span>
			<span className="thin">{props.film.block_order}</span>
			<span className="really-wide">
				<Link to={"view.php?id=" + props.film.id}>{props.film.name}</Link>
			</span>
			<span className="thin img"><a href={"https://www.brooklynfilmfestival.org/film-detail?fid=" + props.film.website_film_id} target="_BLANK">{props.film.website_film_id}</a></span>
			<span className="thin img">{(props.film.img) ? 'img' : ''}</span>
			<Link to={"/edit?id=" + props.film.id}>edit</Link>
		</li>
  );
}

export default IndexListItem;

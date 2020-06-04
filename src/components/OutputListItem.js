// react
import React from 'react';
import { Link } from 'react-router-dom';

function IndexListItem (props) {
	console.log(props);
  return (
		<div className="film">
			<span className="title">{props.films.name}</span>
			<span className="info">{props.category} - {props.films.premiere ? props.films.premiere + ' PREMIERE' : ''} - {props.films.country} - {props.films.length} minutes - {props.films.year}</span>
			<span className="link vimeo"><a href={"https://vimeo.com/" + props.films.vimeo_program} target="_BLANK">https://vimeo.com/{props.films.vimeo_program}</a></span>
			<span className="link bff"><a href={"https://www.brooklynfilmfestival.org/film-detail?fid=" + props.films.website_film_id} target="_BLANK">https://www.brooklynfilmfestival.org/film-detail?fid={props.films.website_film_id}</a></span>
			<span className="link edit"><Link to={"edit?id=" + props.films.id}>edit</Link></span>
		</div>
  );
}

export default IndexListItem;

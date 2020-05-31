// react
import React from 'react';

// data
import filmData from '../app/data/films.json';

// components
import IndexListItem from '../components/IndexListItem';

function List(props) {

  return (

		<ul className="vertical lines">
			<li>
				<span className="medium">category</span>
				<span className="thin">number</span>
				<span className="thin">order</span>
				<span className="really-wide">name</span>
				<span className="thin img">film id</span>
				<span className="thin img">vimeo</span>
			</li>
			{
				filmData.map((film) => {
					return (
						<IndexListItem film={film} />
					)
				})
			}
	</ul>

  );
}

export default List;

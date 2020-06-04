// react
import React from 'react';

// data
import filmData from '../data/films.json';

// components
import IndexListItem from '../components/IndexListItem';

function List (props) {

  return (

		<ul className="vertical lines">
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

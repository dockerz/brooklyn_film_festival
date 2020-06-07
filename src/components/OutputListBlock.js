// react
import React from 'react';

// components
import OutputListItem from '../components/OutputListItem';

function OutputBlock (props) {
  return (
		<div className="filmOutputBlock">
			<h2>{props.filmBlock.category}</h2>
			{
				props.filmBlock.films.map(
					block => <OutputListItem films={block} category={props.filmBlock.category} key={block.id} />
				)
			}
		</div>
  );
}

export default OutputBlock;

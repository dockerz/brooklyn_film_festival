// react
import React from 'react';

// components
import OutputListBlock from '../components/OutputListBlock';

// data
import filmBlocks from "../data/output.json";

function List(props) {
  return (
		filmBlocks.map((block) => {
			return (
				<OutputListBlock filmBlock={block} />
			)
		})
  );
}

export default List;

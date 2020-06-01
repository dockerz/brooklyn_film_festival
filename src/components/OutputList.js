// react
import React from 'react';

// data
import outputData from '../data/output.json';

// components
import OutputListBlock from '../components/OutputListBlock';

function List(props) {

  return (
		outputData.map((block) => {
			return (
				<OutputListBlock block={block} />
			)
		})
  );
}

export default List;

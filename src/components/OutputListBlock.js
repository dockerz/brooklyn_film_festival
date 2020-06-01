// react
import React from 'react';

// components
import OutputListItem from '../components/OutputListItem';

function OutputBlock (props) {
	console.log(props.block);
	for (var i = 0; i < props.block.length; i++) {
		console.log(props.block[i]);
	}
	return ('foo')
	/*
	return (
		props..map((film) => {
			console.log(film);
			return (
				<OutputListItem film={props.film} />
			)
		})
	);
*/
}

export default OutputBlock;

import React from 'react';

import OutputData from '../app/data/output.json';
import FilmData from '../app/data/films.json';

function Output() {
  return (
		<div className="App">
		{
			OutputData.map((section, i) => {
			console.log(section[0]);
//				section.map((film, i) => {
	//				return (<p>{foo}</p>)
		//		})
			})
		}
		</div>
  )
}

export default Output;

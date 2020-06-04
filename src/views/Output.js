import React, {useEffect} from 'react';
import ReactDOM from 'react-dom'

// components
import OutputList from '../components/OutputList';

function Output() {

  useEffect(() => {
		// Update the document title using the browser API
		document.title = `bff: output for program blocks`;
	});

  return (
		<div className="container">
			<div className="row">
				<OutputList />
			</div>
		</div>
  )
}

export default Output;

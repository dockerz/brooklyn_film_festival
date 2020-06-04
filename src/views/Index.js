// react
import React, {useEffect} from 'react';

// components
import IndexList from '../components/IndexList';

function App() {

	useEffect(() => {
		// Update the document title using the browser API
		document.title = `bff: index`;
	});

  return (
		<div className="App">
			<div className="container">
				<div className="row">
					<div className="cell">
						<p><strong>to do: get json for index, edit/view and output pages and render accordingly</strong></p>
						<p>festival year: 2020(<a href="#">change</a>) / total films: 131 / with images: 95 / ready for export: 58</p>
					</div>
				</div>
				<div className="row">
					<IndexList />
				</div>
			</div>
		</div>
  );
}

export default App;

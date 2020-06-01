import React from 'react';

function App() {
  return (
		<div className="container fixed">
			<div className="row">
				<ul className="nav">
					<li><a href="/">home</a></li>
					<li><a href="/import">import: file</a></li>
					<li><a href="/custom">import: custom</a></li>
					<li><a href="/add_to_festival">add film</a></li>
					<li><a href="/export">WP export</a></li>
					<li><a href="/output">Vimeo output</a></li>
				</ul>
			</div>
		</div>
  );
}

export default App;

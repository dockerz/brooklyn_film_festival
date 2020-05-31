import React from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom';

import Nav from './Nav';

import Index from '../views/Index';
import Import from '../views/Import';
import Export from '../views/Export';
import Edit from '../views/Edit';
import View from '../views/View';
import Output from '../views/Output';

function App() {
  return (
		<Router>
			<div className="wrapper">
				<Nav />
				<Route path="/" component={Index} exact />
				<Route path="/import" component={Import} exact />
				<Route path="/export" component={Export} exact />
				<Route path="/output" component={Output} exact />
				<Route path="/view" component={View} exact />
				<Route path="/edit" component={Edit} exact />
			</div>
		</Router>
  );
}

export default App;

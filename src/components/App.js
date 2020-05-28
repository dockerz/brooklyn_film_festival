import React from 'react';
import { Route, Switch } from 'react-router-dom';

import Nav from './Nav';
import Index from '../views/Index';

function App() {
  return (
		<main>
			<Nav />
			<Switch>
				<Route path="/" component={Index} exact />
			</Switch>
    </main>
  );
}

export default App;

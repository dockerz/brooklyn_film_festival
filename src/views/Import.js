import React from 'react';

function Import() {
  return (
		<div class="container">
			<div class="row">
				<h1>file upload</h1>
				<p>this tool is for importing films via the film freeway export tool. there are 2 steps in this import. this part of the process of importing the festival will take 10 minutes.</p>
			</div>
			<div class="row">
				<h2>step 1</h2>
				<ol>
					<li>in the g doc list with all the "selected" films in it, select the entire vertical column of film ids(BKLYN2337, BKLYN2338, etc.).</li>
					<li>copy the contents of all the cells.</li>
					<li>open a page in a text editor and paste in. delete blank lines. convert all \n to commas, making the list look like: BKLYN2337,BKLYN2338,BKLYN2339,BKLYN2340,BKLYN2341,BKLYN2342, etc.</li>
					<li>copy this list and go back to filmfreeway.</li>
					<li>on the ff search <a href="https://filmfreeway.com/submissions" target="_BLANK">page</a>, do an advanced search and paste the list into the "bulk tracking numbers" field.</li>
					<li>submit form.</li>
					<li>make sure the amount of results correspond to the number that should be there.</li>
					<li>select all and export all as excel. this will make a single excel file, with all the results.</li>
				</ol>
			</div>
			<div class="row">
				<h2>step 2</h2>
				<ol>
					<li>open the excel file in an editor. you will be using regex search and replace.</li>
					<li>delete all carriage returns(\r, &lt;CR&gt;).</li>
					<li>search and replace all new lines(\n) with _NL_.</li>
					<li>delete all &lt;row&gt;.</li>
					<li>delete all &lt;cell&gt;</li>
					<li>search and replace &lt;/row&gt; with \n, making new lines, which is to be the delimiter for chunking via explode.</li>
					<li>search and replace all &lt;/cell&gt; with backtick(`) and delete final backtick in file.</li>
					<li>search and replace all `\n with \n.</li>
					<li>delete final `, at the end of the file.</li>
					<li>save to file.</li>
					<li>import the file, using the form, below.</li>
				</ol>
			</div>
			<div class="row">
				<form action="/import" method="post" enctype="multipart/form-data">
					<p><label for="festival_year">festival year: </label></p>
					<p><label for="script">file: </label><input type="file" name="script" /><input type="hidden" name="submit" value="1" /></p>
					<p><button type="submit">upload</button></p>
				</form>
			</div>
		</div>
  );
}

export default Import;

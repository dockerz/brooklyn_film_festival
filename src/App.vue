<template>
	<div id="app">
		<div class="container">
			<div class="row">
				<ul class="nav">
					<li><router-link to="/">Home</router-link></li>
					<li><router-link to="/import">File Import</router-link></li>
					<li><router-link to="/custom">Custom Import</router-link></li>
					<li><router-link to="/find_key">Utility</router-link></li>
					<li><router-link to="/export">Export</router-link></li>
				</ul>
			</div>
		</div>
		<router-view />
	</div>
</template>

<script>

//	import DataMap from '@/app/DataMap.json'

	export default {
		data () {
			return {
//				DataMap: Datamap
			}
		}
	};
</script>

<style>
	html { font-family: 'trebuchet ms'; text-align: center; font-size: 90%; }
	span { color: #333; }
	h1 { margin-bottom: 25px; font-weight: 300; color: #666; font-size: 1.5em; }
	h1 strong { font-weight: 700; color: #333; }
	.container { margin: 0 auto; width: 950px; }
	.container .row { text-align: left; }
	.clicked { color: blue; }
	.cell { padding-right: 25px; overflow: hidden; }
	button { padding: 20px; border: none; background-color: red; color: white; }
	p { margin-bottom: 25px; }
	ul { margin-left: 0; padding-left: 0; list-style-type: none; }
	ul.nav { margin: 25px 0; padding: 0; overflow: auto; }
	ul.nav li { margin-right: 10px; box-sizing: border-box; width: 120px; display: inline-block; float: left; clear: none; }
	ul.vertical li { padding: 15px 0 0; margin: 15px 0 0; }
	ul.vertical.lines li { border-top: 1px solid #999; }
	li span { display: inline-block; }
	span.wide { width: 300px; }
	span.medium { width: 120px; }
	span.medium-wide { width: 220px; }
	span.thin { width: 80px; }
	.form_element_padding { display: inline-block; padding: 15px; }
	label { padding: 15px 15px 15px 0; box-sizing: border-box; display: inline-block; width: 200px; vertical-align: top; }
	input[type="text"], input[type="password"] { font-family: 'trebuchet ms'; padding: 15px; border: none; background-color: #333; color: #fff; width: 300px; }
	textarea { font-family: 'trebuchet ms'; padding: 15px; border: none; background-color: #333; color: #fff; width: 300px; height: 100px; }
	#edit_notes_panel { padding: 10px; position: fixed; width: 350px; height: 100%; right: 200px; box-sizing: border-box; overflow: scroll; }
	#edit_node_navigation { padding: 10px; position: fixed; width: 200px; height: 100%; right: 0px; box-sizing: border-box; overflow: scroll; }
	#edit_node_navigation a, #edit_node_navigation button { padding: 3px; margin: 3px; display: inline-block; background-color: #999; color: #fff; }
	#edit_node_navigation button { background: red; cursor: pointer; }
	@media (max-width: 1000px) {
		#edit_notes_panel, #edit_node_navigation { display: none; }
	}
	@media (max-width: 800px) {
		.container { width: 90%; overflow: hidden; }
	}
</style>

<template>
	<div class="row">
		<form name="film" action="edit.php" method="post" accept-charset="UTF-8">
			<p><label for="ready">text_updated</label><span class="form_element_padding"><input type="checkbox" name="ready" value="true" checked/></span></p>
			<p><a name="film_name"></a><label for="film_name">image_root_name</label><input type="text" name="film_name" value="film['name']" /></p>
			<p v-for="(val, ind) in DataMap" :key="ind" v-show="val !== false">
				<a :name="ind"></a>
				<label :for="ind">{{ ind }}</label>
				<textarea name="submit_id" v-model="DataMap[ind]"></textarea>
			</p>
			<input type="hidden" name="update" value="film['id']">
			<p><label></label><button type="submit">update</button></p>
		</form>
	</div>
</template>

<script>

	import JSON from '@/app/Film.json'
	import DataMap from '@/app/DataMap.json'

	export default {
		data () {
			return {
				myJSON: JSON,
				DataMap: DataMap
			}
		}
	};

</script>

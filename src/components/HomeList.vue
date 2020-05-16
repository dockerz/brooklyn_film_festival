<template>
	<div class="row">
		<ul class="vertical lines">
			<li>
				<span class="medium">category</span>
				<span class="wide">film title</span>
				<span class="thin ready">export ready</span>
				<span class="thin img">has image</span>
				<span class="thin note">has note</span>
			</li>
			<li v-for="i in myJSON" :key="i">
				<span class="medium">{{ i.category }}</span>
				<span class="wide">
					<router-link to="/view">{{ i.name }}</router-link>
				</span>
				<span class="thin ready">{{ i.ready === "1" ? "yes" : "" }}</span>
				<span class="thin img">{{ i.img ? "yes" : "" }}</span>
				<span class="thin note">{{ i.note ? "yes" : "" }}</span>
				<router-link to="/edit">edit</router-link>
			</li>
		</ul>
	</div>
</template>

<script>

	// @ is an alias to /src
	import json from '@/app/HomeList.json'

	export default {
		data () {
			return {
				myJSON: json
			}
		}
	};

</script>

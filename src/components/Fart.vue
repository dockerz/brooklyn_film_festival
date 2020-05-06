<template>
	<ul class="vertical lines">
		<li v-for="i in myJSON" :key="i">
			<span class="medium">{{ i.category }}</span>
			<span class="wide">
				<router-link to="/view">{{ i.name }}</router-link>
			</span>
			<span class="medium-wide">
				<a href="mailto:">{{ i.email }}</a>
			</span>
			<span class="thin ready">{{ i.ready === "1" ? "ready" : "" }}</span>
			<span class="thin img">{{ i.img ? "img" : "" }}</span>
			<span class="thin note">{{ i.note ? "note" : "" }}</span>
			<router-link to="/edit">edit</router-link>
		</li>
	</ul>
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

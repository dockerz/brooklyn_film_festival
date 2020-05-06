<template>
	<div class="row">
		<HomeList />
	</div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from "@/components/HelloWorld.vue";
import HomeList from "@/components/HomeList.vue";

export default {
	name: "Home",
	components: {
		HomeList
 	}
};
</script>

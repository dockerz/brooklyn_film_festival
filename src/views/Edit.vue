<template>
	<div class="container">
		<Header />
		<Editing />
	</div>
</template>

<script>

	import Editing from "@/components/Edit.vue";
	import Header from "@/components/Header.vue";

	export default {
		name: "Edit",
		components: {
			Editing,
			Header
	 	}
	};

</script>

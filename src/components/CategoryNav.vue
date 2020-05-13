<template>
	<div class="row">
		<a v-for="(val, ind) in DataMap" :href="#" :key="ind" v-show="val !== false">
			DataMap[ind]
		</a>
	</div>
</template>

<script>

	import DataMap from '@/app/DataMap.json'

	export default {
		data () {
			return {
				DataMap: DataMap
			}
		}
	};

</script>

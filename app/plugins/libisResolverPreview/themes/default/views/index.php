<?php

$script = __CA_URL_ROOT__."/app/plugins/libisResolverPreview/themes/".__CA_THEME__."/js/vue.js";
?>

<script src="<?php echo $script ?>"></script>

<div id="resolver" width="500">
    <textarea v-model="ies"  rows="4" cols="50"></textarea>

    <div v-for="item in ies.split(',')">
        <img :src="'https://resolver.libis.be/' + item + '?quality=low'" title="low"  />
        <img :src="'https://resolver.libis.be/' + item + '?quality=high'" title="high" />
        <img :src="'https://resolver.libis.be/' + item + '?quality=archive'" title="archive" />
        <img :src="'https://resolver.libis.be/' + item + '/stream'" title="stream" />
        <img :src="'https://resolver.libis.be/' + item + '/thumbnail'" title="thumb" />
    </div>
</div>



<script>
	const ResolverApp = {
		data() {
			return {
				ies:"IE4574892,IE10108283,IE10108290,IE10108297,IE10108304,IE10108311,IE10108314,IE10108325,IE10108332,IE10108339,IE10108346,IE10108353,IE10108360,IE10108367,IE10108374,IE10108381,IE10108388,IE10108395,IE10108402,IE10108409"
			}
		}
	}

	Vue.createApp(ResolverApp).mount('#resolver')
</script>


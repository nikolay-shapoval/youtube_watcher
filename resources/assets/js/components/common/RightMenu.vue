<template>
  <router-link :to="{name: 'personal'}" exact>{{ $t('bloggers.personal.title') }}</router-link>
</template>

<script>
  import Loader from '../common/Loader.vue'

  export default {
    components: {
      Loader
    },
    data() {
      return {}
    },
    mounted() {
      this.fetch()
    },
    methods   : {
      fetch() {
        console.log('Loaded');
      }
    }
  }
</script>
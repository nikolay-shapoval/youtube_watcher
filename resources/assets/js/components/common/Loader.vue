<template>
  <div class="loader" v-if="loading"></div>
</template>

<script>
  export default {
    data() {
      return {
        loading: false,
        started: false
      }
    },
    methods: {
      get() {
        return this.loading
      },
      start() {
        this.started = true;
        this.loading = true;
      },
      stop() {
        this.loading = false;
      },
    }
  }
</script>

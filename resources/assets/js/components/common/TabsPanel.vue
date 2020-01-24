<template>
  <div class="subheader navbar-fixed-top">
    <div class="subheader_search search">
      <!--a class="search_id" href="#">ID<img src="img/left-up.png" alt=""></a-->
      <input class="search_input form-control" v-model="title_filter">
      <a @click.prevent="sidebarActive = !sidebarActive" class="search_btn submit menu-toggle" href="#"><img src="img/left-btn.png" alt=""></a>
    </div>
    <div class="subheader_cnt">
      <!--title-->
      <!--<h1 class="subheader_t">{{ $t('bloggers.title') }}</h1>-->
      <!--tabs-->
      <ul class="top-panel nav nav-tabs">
        <!--<li>-->
          <!--<router-link :to="{name: 'welcome'}" exact><i class="icon-stack"></i> {{ $t('bloggers.welcome.title') }}</router-link>-->
        <!--</li>-->
        <!--<li>-->
        <!--<router-link :to="{name: 'filter'}"><i class="icon-stack"></i> {{ $t('bloggers.filter.title') }}</router-link>-->
        <!--</li>-->
        <!--<li>-->
        <!--<router-link :to="{name: 'program'}"><i class="icon-stack"></i> {{ $t('bloggers.program.title') }}</router-link>-->
        <!--</li>-->
        <!--<li>-->
        <!--<router-link :to="{name: 'blogger'}"><i class="icon-stack"></i> {{ $t('bloggers.blogger.title') }}</router-link>-->

        <!--</li>-->
      </ul>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import Loader from '../common/Loader.vue'

  export default {
    computed: {
      ...mapGetters({
        sortParam       : 'sortParam',
        filteredBloggers: 'filteredBloggers'
      }),
      sidebarActive: {
        get() {
          return this.$store.state.common.sidebarActive;
        },
        set(value) {
          this.$store.commit('setSidebarActive', value);
        }
      },

      title_filter: {
        get() {
          return this.$store.state.bloggers.title_filter;
        },
        set(value) {
          this.$store.commit('setTitleFilter', value);
          this.$store.dispatch('filteredList', {})
        }
      },
    },
    data() {
      return {}
    },
    mounted() {
      //this.fetch()
    },

    methods: {
      setSortParam(param) {
        this.$store.commit('setSortParam', param);
        this.$store.dispatch('filteredList', {})
      }
//      watch: {
//        '$route': 'fetch'
//      }
    }
  }
</script>
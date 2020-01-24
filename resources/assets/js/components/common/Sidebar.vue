<template>
  <div :hidden="!sidebarActive" id="sidebar" class="sidebar">
    <div id="sidebar_menu" class="sidebar_menu">
      <table class="table table-striped table-fixed" id="sidebar-menu-table">
        <thead>
        <tr>
          <th class="col-xs-2" style="text-align: center">
            <img style="cursor: pointer" @click="setSortParam('idasc')"
                 src="img/left-down.png" :hidden="sortParam != 'idasc' ? false : 'hidden'"
            >
            <img style="cursor: pointer" @click="setSortParam('iddesc')"
                 src="img/left-up.png" :hidden="sortParam != 'iddesc' ? false : 'hidden'"
            >
          </th>
          <th class="col-xs-10" style="text-align: center">
            <img style="cursor: pointer" @click="setSortParam('titleasc')"
                 src="img/left-down.png" :hidden="sortParam != 'titleasc' ? false : 'hidden'"
            >
            <img style="cursor: pointer" @click="setSortParam('titledesc')"
                 src="img/left-up.png" :hidden="sortParam != 'titledesc' ? false : 'hidden'"
            >
          </th>
        </tr>
        </thead>
        <tbody>
        <tr style="cursor: pointer" v-bind:class="[blogger.id === currentBlogger ? '__active' : '']"
            @click="menuAction(blogger)" v-for="blogger in filteredBloggers">
          <td class="col-xs-2">{{ blogger.id }}</td>
          <td class="col-xs-10">{{ blogger.title }}</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  import {mapGetters} from 'vuex'

  export default {
    computed: {
      ...mapGetters({
        bloggers        : 'bloggers',
        currentBlogger  : 'currentBlogger',
        videos          : 'videos',
        sortParam       : 'sortParam',
        filteredBloggers: 'filteredBloggers',
        sidebarActive   : 'sidebarActive'
      }),
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
    },

    methods: {
      menuAction(blogger) {
        if (this.$route.name == 'videos') {
          this.showVideo(blogger);
        } else {
          this.showBlogger(blogger);
        }
      },
      showBlogger(blogger) {
        this.$router.push({name: 'blogger', params: {id: blogger.id}})
      },
      showVideo(blogger) {
        this.$router.push({name: 'videos', params: {id: blogger.id}})
      },
      setSortParam(param) {
        this.$store.commit('setSortParam', param);
        this.$store.dispatch('filteredList', {})
      }
    }
  }
</script>

<template>
  <div id="main-block" class="main-block" v-bind:class="[sidebarActive ? 'main-block-with-sidebar' : 'main-block-full-width']">
    <loader ref="loader"></loader>

    <div id="main-scroll" v-if="loaded" class="main-block_inner">
      <div class="subheader_cnt subheader-mob">
        <!--title-->
        <h1 class="subheader_t">{{ $t('bloggers.personal.title') }}</h1>
      </div>
      <!--content-->
      <form class="content form add-tourist" role="form">
        <div class="row">
          <div class="col-lg-12 lev-1">
            <div class="box">
              <table class="table table-fixed">
                <thead>
                <tr>
                  <th class="col-xs-12">{{ $t('bloggers.personal.channel_url') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="col-xs-12">
                    <input type="text" class="form-control" v-model="personal.feed_url" id="feed-url-input">
                  </td>
                </tr>
                <tr>
                  <td class="col-xs-12">
                    {{ $t('bloggers.personal.copy_url') }}
                    <br>
                    <img src="/img/url.png">
                  </td>
                <tr>
                  <td class="col-xs-12">
                    <div class="alert alert-warning">
                      {{ $t('bloggers.personal.do_public') }}
                    </div>
                  </td>
                </tr>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <td>
                    <div @click.prevent="updatePersonal()" class="btn bt-sub" id="feed-url-submit">
                      <span v-if="!saving">
                        {{ $t('bloggers.personal.save') }}
                      </span>
                      <span v-if="saving">
                        <img src="/img/142.gif" style="width: 30px;">
                      </span>
                    </div>
                  </td>
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import Loader from '../common/Loader.vue'

  export default {
    components: {
      Loader
    },
    computed  : {
      ...mapGetters({
        personal     : 'personal',
        sidebarActive: 'sidebarActive',
        bloggers     : 'bloggers',
      })
    },
    data() {
      return {
        loaded: false,
        saving: false,
      }
    },
    mounted() {
      this.fetch();
    },
    methods   : {
      fetch() {
        this.loaded = false;

        this.$store.dispatch('getPersonal').then(() => {
          this.loaded = true;
          console.log(this.loaded);
        });
      },
      updatePersonal() {
        this.saving = true;
        let params = this.personal;
        this.$store.dispatch('updatePersonal', params).then(res => {
          this.getSubscribes();
        });
      },
      getSubscribes() {
        let params = this.personal;
        this.$store.dispatch('getSubscribes', params).then(res => {
          if(res.success){
            this.$store.dispatch('getBloggers');
          }else{
            alert('Check your channel URL and security options!');
          }
          this.saving = false;
        });
      }
    },
    watch     : {
      '$route': 'fetch'
    }
  }
</script>
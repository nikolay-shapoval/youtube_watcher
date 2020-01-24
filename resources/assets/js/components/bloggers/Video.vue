<template>
  <div id="main-block" class="main-block" v-bind:class="[sidebarActive ? 'main-block-with-sidebar' : 'main-block-full-width']">
    <loader ref="loader"></loader>

    <div id="main-scroll" v-if="loaded" class="main-block_inner">
      <div class="subheader_cnt subheader-mob">
        <!--title-->
        <h1 class="subheader_t">{{ $t('bloggers.video.title') }}</h1>
      </div>
      <!--content-->
      <form class="content form add-tourist" role="form">
        <div class="row">
          <div class="col-lg-12 lev-1">
            <div class="box">
              <table class="table table-fixed table-videos">
                <thead>
                <tr>
                  <th class="col-xs-4">
                    <div class="btn btn-primary" @click="goBack()">
                      {{ $t('bloggers.video.back') }}
                    </div>
                  </th>
                  <th class="col-xs-4">{{ $t('bloggers.video.details.title') }}</th>
                  <th class="col-xs-4">{{ $t('bloggers.video.details.description') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="video in videos">
                  <td class="col-xs-4">
                    <div class="video" :data-video_id="video.video_id">
                      <a class="video__link" :href="'https://youtu.be/' + video.video_id">
                        <picture>
                          <source :srcset="'https://i.ytimg.com/vi_webp/' + video.video_id + '/maxresdefault.webp'" type="image/webp">
                          <img class="video__media"
                               :src="'https://i.ytimg.com/vi/' + video.video_id + '/maxresdefault.jpg'"
                               :alt="video.title"
                          >
                        </picture>
                      </a>
                      <button class="video__button" type="button" aria-label="Запустить видео">
                        <svg width="68" height="48" viewBox="0 0 68 48">
                          <path class="video__button-shape"
                                d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                          <path class="video__button-icon" d="M 45,24 27,14 27,34"></path>
                        </svg>
                      </button>
                    </div>
                  </td>
                  <td class="col-xs-4"><a :href="video.url" target="_blank">{{video.title}}</a></td>
                  <td class="col-xs-4">{{video.description}}</td>
                </tr>
                </tbody>
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
        videos       : 'videos',
        sidebarActive: 'sidebarActive'
      })
    },

    data() {
      return {
        loaded: false,
      }
    },

    mounted() {
      this.fetch();
    },

    methods   : {
      fetch() {
        let app = this;
        app.loaded = false;

        let bloggerId = app.$route.params.id;
        app.$refs.loader.start();

        app.$store.dispatch('getVideos', bloggerId).then(() => {
          app.loaded = true;
          app.$refs.loader.stop();
          setTimeout(function(){app.findVideos()}, 1000);
        });

        app.$store.dispatch('getBloggers').then(() => {
        });
      },
      goBack() {
        let bloggerId = this.$route.params.id;
        this.$router.push({name: 'blogger', params: {id: bloggerId}})
      },
      findVideos() {
        let videos = document.querySelectorAll('.video');

        for (let i = 0; i < videos.length; i++) {
          this.setupVideo(videos[i]);
        }
      },
      setupVideo(video) {
        let link = video.querySelector('.video__link');
        let media = video.querySelector('.video__media');
        let button = video.querySelector('.video__button');
        let id = video.getAttribute('data-video_id');

        video.addEventListener('click', () => {
          $('.video__link').show();
          $('.video__button').show();
          $('iframe.video__media').detach();
          let iframe = this.createIframe(id);

          link.style.display = 'none';
          button.style.display = 'none';
          video.appendChild(iframe);
        });

        link.removeAttribute('href');
        video.classList.add('video--enabled');
      },
      createIframe(id) {
        let iframe = document.createElement('iframe');

        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('allow', 'autoplay');
        iframe.setAttribute('src', this.generateURL(id));
        iframe.classList.add('video__media');

        return iframe;
      },
      generateURL(id) {
        let query = '?rel=0&showinfo=0&autoplay=1';

        return 'https://www.youtube.com/embed/' + id + query;
      }
    },

    watch     : {
      '$route': 'fetch'
    }
  }
</script>
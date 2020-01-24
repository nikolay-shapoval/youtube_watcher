<template>
  <div id="main-block" class="main-block" v-bind:class="[sidebarActive ? 'main-block-with-sidebar' : 'main-block-full-width']">
    <loader ref="loader"></loader>

    <div id="main-scroll" v-if="loaded" class="main-block_inner">
      <!--content-->
      <form class="content form add-tourist" role="form">
        <div class="row">
          <div class="col-lg-12 lev-1">
            <div class="row">
              <div class="col-lg-4 lev-2">
                <div class="box add-tourist_self">
                  <div class="form-group add-tourist_photo form_file">
                      <img class="photo" :src="blogger.avatar_url" alt="" style="max-height: 164px" id="channel_photo"/>
                  </div>
                  <div class="info-panel">
                    <p><span class="info-panel_t">{{ $t('bloggers.blogger.published') }}:</span>
                      <br/>{{blogger.published_at}}
                    </p>
                    <hr class="info-panel_hr"/>
                    <p><span class="info-panel_t">ID:</span>&nbsp;{{blogger.id}}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 lev-2">
                <div class="box add-tourist_self">
                  <h2 class="box_t">{{ $t('bloggers.blogger.title') }}</h2>
                  <div class="row">
                    <div class="col-lg-12 lev-3">
                      <div class="form-group">
                        <label for="name">{{ $t('bloggers.blogger.name') }}</label>
                        <input v-bind:title="blogger.title" type="text" v-model="blogger.title" class="form-control" id="name">
                      </div>
                      <div class="form-group">
                        <label>{{ $t('bloggers.blogger.url') }}</label>
                        <br>
                        <a :href="blogger.url" target="_blank">{{blogger.url}}</a>
                      </div>
                      <div class="form-group">
                        <label>{{ $t('bloggers.blogger.description') }}</label>
                        <p>
                          {{blogger.description}}
                        </p>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 lev-3">
                          <div class="btn-row">
                            <button @click.prevent="showVideo(blogger)" v-bind:title="$t('bloggers.video.tooltip')" type="submit" class="btn">{{ $t('bloggers.video.title') }}</button>
                          </div>
                        </div>
                        <div class="col-lg-6 lev-3">
                          <div class="btn-row" style="float:right">
                            <button @click.prevent="updateBlogger(blogger)" class="btn bt-sub">{{ $t('bloggers.blogger.save') }}</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <form class="content form add-comment" role="form" @keyup.ctrl.enter="sendComment()">
        <div class="row">
          <div class="col-lg-12 lev-1">
            <div class="box">
              <h3>{{ $t('bloggers.comments.header') }}</h3>
              <table class="table">
                <tbody>
                <tr v-for="comment in blogger.comments">
                  <td v-html="comment.text">{{comment.text}}</td>
                </tr>
                </tbody>
              </table>
              <div class="comments-editor">
                <vue-editor
                  v-model="newComment"
                  :editorOptions="editorSettings"
                >
                </vue-editor>

                <emoji-picker @emoji="append" :search="search">
                  <div
                    class="emoji-invoker"
                    slot="emoji-invoker"
                    slot-scope="{ events }"
                    v-on="events"
                  >
                    <img src="/img/smile.svg">
                  </div>
                  <div slot="emoji-picker" slot-scope="{ emojis, insert, display }">
                    <div class="emoji-picker">
                      <div class="emoji-picker__search">
                        <input type="text" v-model="search" v-focus>
                      </div>
                      <div>
                        <div v-for="(emojiGroup, category) in emojis" :key="category">
                          <h5>{{ category }}</h5>
                          <div class="emojis">
                          <span v-for="(emoji, emojiName) in emojiGroup" :key="emojiName"
                                @click="insert(emoji)" :title="emojiName">
                            {{ emoji }}
                          </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </emoji-picker>
                <div class="row">
                  <div class="col-lg-12 lev-3">
                    <div class="btn-row" style="float:right">
                      <button @click.prevent="sendComment()" class="btn bt-sub">{{ $t('bloggers.comments.send') }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
  import {mapGetters} from 'vuex'
  import {VueEditor, Quill} from 'vue2-editor'
  import EmojiPicker from 'vue-emoji-picker'
  import Loader from '../common/Loader.vue'

  export default {
    components: {
      VueEditor,
      EmojiPicker,
      Loader
    },

    computed  : {
      ...mapGetters({
        blogger       : 'blogger',
        currentBlogger: 'currentBlogger',
        sidebarActive : 'sidebarActive'

      })
    },

    data      : () => ({
      newComment    : '',
      search        : '',
      editorSettings: {
        modules: {
          toolbar: {
            container: [
              ['bold', 'italic', 'underline', 'strike'],
              ['blockquote', 'code-block']
            ]
          }
        }
      },
      loaded        : false,
    }),

    mounted() {
      this.fetch()
    },

    methods   : {
      append(emoji) {
        this.newComment += emoji
      },
      insert(emoji) {
        this.newComment += emoji
      },
      fetch() {
        this.loaded = false;

        this.$refs.loader.start();

        let bloggerId = this.$route.params.id;

        this.$store.dispatch('getBlogger', bloggerId).then(() => {
          this.loaded = true;
          this.$refs.loader.stop()
        });

      },
      openLink() {
        window.open(this.blogger.url, '_blank');
      },
      showVideo(blogger) {
        this.$router.push({name: 'videos', params: {id: blogger.id}})
      },
      updateBlogger() {
        let params = this.blogger;
        this.$store.dispatch('updateBlogger', params);
      },
      sendComment() {
        if (this.newComment) {
          let params = {};
          params.type = 'comment';
          params.text = this.newComment;
          params.item_id = this.blogger.id;
          params.is_visible = 1;
          this.blogger.comments.push(params);
          this.$store.dispatch('sendComment', params);
          this.newComment = '';
          $('.ql-editor').empty();
          let block = document.getElementById("main-block");
          block.scrollTop = block.scrollHeight;
        } else {
          alert(this.$t('bloggers.comments.empty'));
        }
      },
      addFile() {
        let params = new FormData();
        params.append("attachment", $('#photo')[0].files[0]);
        params.append("channel_id", this.blogger.id);
        this.$store.dispatch('addFile', params);
      }
    },

    directives: {
      focus: {
        inserted(el) {
          el.focus()
        },
      },
    },

    watch     : {
      '$route': 'fetch'
    }
  }
</script>

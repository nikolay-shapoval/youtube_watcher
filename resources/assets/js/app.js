require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import VueI18n from 'vue-i18n'
import moment from 'moment'
import store from './stores/store'
import {mapGetters} from 'vuex'
import Blogger from './components/bloggers/Blogger.vue'
import Videos from './components/bloggers/Video.vue'
import Personal from './components/bloggers/Personal.vue'
import Footbar from './components/common/Footbar.vue'
import Welcome from './components/bloggers/Welcome.vue'
import Sidebar from './components/common/Sidebar.vue'
import TabsPanel from './components/common/TabsPanel.vue'
import NoSubscribes from './components/common/NoSubscribes.vue'

import {EmojiPickerPlugin} from 'vue-emoji-picker'

Vue.use(EmojiPickerPlugin);

Vue.use(VueI18n);
Vue.use(VueRouter);

const routes = [
  {path: '/', name: 'welcome', component: Welcome},
  {path: '/blogger/:id', name: 'blogger', component: Blogger},
  {path: '/blogger/:id/videos', name: 'videos', component: Videos},
  {path: '/personal', name: 'personal', component: Personal},
  // {path: '/program', name: 'program', component: Program},
];

const router = new VueRouter({
  linkActiveClass: 'active',
  routes
});

import enTranslation from './translations/en'
import ruTranslation from './translations/ru'
import chTranslation from './translations/ch'

const messages = {
  en: enTranslation,
  ru: ruTranslation,
  ch: chTranslation
};

const i18n = new VueI18n({
  locale: 'en',
  messages,
});

const app = new Vue({
  router,
  store,
  i18n,
  el        : '#app',

  data() {
    return {
      modalVisible: false,
      currentFlag: '/img/flag_en.png'
    }
  },

  computed  : {
    ...mapGetters({
      currentUser: 'currentUser',
      bloggers   : 'bloggers',
      personal   : 'personal',
    }),
    noSubscribes: {
      get() {
        return this.$store.state.common.noSubscribes;
      },
      set(value) {
        this.$store.commit('setNoSubscribes', value);
      }
    },
  },

  methods   : {
    toggleLang(lang){
      this.$i18n.locale = lang;
      this.currentFlag = '/img/flag_' + lang + '.png';
    },

    fetch() {
      this.loaded = false;

      this.$store.dispatch('getPersonal').then(() => {
        this.loaded = true;
        this.getSubscribes();
      });
    },

    getSubscribes() {
      let app = this;
      app.$store.dispatch('getBloggers').then((res) => {
        console.log(res);
        app.noSubscribes = res.length == 0 ? true : false
      });
    }
  },

  components: {
    Sidebar,
    Footbar,
    TabsPanel,
    NoSubscribes,
  },

  mounted() {
    this.fetch();
  },
  // watch: {
  // 'currentUser': 'getUser'
  // }
});

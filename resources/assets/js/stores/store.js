import Vue from 'vue'
import Vuex from 'vuex'
import bloggers from './bloggers'
import videos from './videos'
import personal from './personal'
import common from './common'

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    bloggers,
    videos,
    personal,
    common
  }
})
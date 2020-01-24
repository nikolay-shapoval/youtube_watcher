export default {
  state    : {
    videos: []
  },
  getters  : {
    videos: state => state.videos
  },
  mutations: {
    setVideos(state, videos) {
      state.videos = videos;
    }
  },
  actions  : {
    getVideos({state, commit}, id) {
      return axios.post('/api/channels/' + id + '/getVideos/').then(res => {
        commit('setVideos', res.data);
        commit('setCurrentBlogger', id);
        return res.data;
      })
    }
  }
}

function compareIdAsc(a, b) {
  if (a.id > b.id) return 1;
  if (a.id < b.id) return -1;
}

function compareIdDesc(a, b) {
  if (a.id < b.id) return 1;
  if (a.id > b.id) return -1;
}

function compareTitleAsc(a, b) {
  if (a.title.toLowerCase() > b.title.toLowerCase()) return 1;
  if (a.title.toLowerCase() < b.title.toLowerCase()) return -1;
}

function compareTitleDesc(a, b) {
  if (a.title.toLowerCase() < b.title.toLowerCase()) return 1;
  if (a.title.toLowerCase() > b.title.toLowerCase()) return -1;
}

export default {
  state    : {
    bloggers        : [],
    filteredBloggers: [],
    blogger         : {},
    currentBlogger  : null,
    title_filter    : '',
    sortParam       : 'idasc'
  },
  
  getters  : {
    bloggers        : state => state.bloggers,
    filteredBloggers: state => state.filteredBloggers,
    blogger         : state => state.blogger,
    currentBlogger  : state => state.currentBlogger,
    title_filter    : state => state.title_filter,
    sortParam       : state => state.sortParam,
  },

  mutations: {
    setBloggers(state, bloggers) {
      state.bloggers = bloggers
    },
    setFilteredBloggers(state, filteredBloggers) {
      state.filteredBloggers = filteredBloggers
    },
    setBlogger(state, blogger) {
      state.blogger = blogger
    },
    setCurrentBlogger(state, currentBlogger) {
      state.currentBlogger = currentBlogger
    },
    setTitleFilter(state, title_filter) {
      state.title_filter = title_filter
    },
    setSortParam(state, sortParam) {
      state.sortParam = sortParam
    }
  },

  actions  : {
    getBloggers({state, commit}, query) {
      return axios.get('/api/channels/', {params: query}).then(res => {
        commit('setBloggers', res.data);
        commit('setFilteredBloggers', res.data);
        return res.data;
      })
    },
    getBloggersDefault({state, commit}, query) {
      return axios.post('/api/channels/channelsDefault/', {params: query}).then(res => {
        commit('setBloggers', res.data);
        commit('setFilteredBloggers', res.data);
        return res.data;
      })
    },
    filteredList({state, commit}) {
      switch (state.sortParam) {
        case 'idasc':
          state.bloggers.sort(compareIdAsc);
          break;
        case 'iddesc':
          state.bloggers.sort(compareIdDesc);
          break;
        case 'titleasc':
          state.bloggers.sort(compareTitleAsc);
          break;
        case 'titledesc':
          state.bloggers.sort(compareTitleDesc);
          break;
      }
      let bloggers = state.bloggers.filter(function (elem) {
        if (state.title_filter === '') return true;
        else return elem.title.indexOf(state.title_filter) > -1;
      });
      commit('setFilteredBloggers', bloggers);
    },
    getBlogger({state, commit}, id) {
      if (state.bloggers.length > 0) {
        for (let blogger of state.bloggers) {
          if (blogger.id == id) {
            commit('setCurrentBlogger', blogger.id);
            commit('setBlogger', blogger)
          }
        }
      }
    },
    updateBlogger({state, commit}, params) {
      return axios.put('/api/channels/' + params.id, {params: params});
    },
    sendComment({state, commit}, params) {
      return axios.post('/api/comments/', {params: params});
    },
    addFile({state, commit}, params) {
      return axios.post('/api/files/', params).then(res => {
        commit('setBlogger', res.data);
        return res.data;
      });
    }
  }
}

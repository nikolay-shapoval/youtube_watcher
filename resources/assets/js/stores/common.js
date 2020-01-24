export default {
  state    : {
    sidebarActive: true,
    noSubscribes : false
  },
  getters  : {
    sidebarActive: state => state.sidebarActive,
    noSubscribes : state => state.noSubscribes
  },
  mutations: {
    setSidebarActive(state, sidebarActive) {
      state.sidebarActive = sidebarActive;
    },
    setNoSubscribes(state, noSubscribes) {
      state.noSubscribes = noSubscribes;
    }
  },
  actions  : {}
}

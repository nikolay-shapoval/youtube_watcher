export default {
  state    : {
    personal: [],
  },
  getters  : {
    personal: state => state.personal
  },
  mutations: {
    setPersonal(state, personal) {
      state.personal = personal;
    }
  },
  actions  : {
    getPersonal({state, commit}) {
      return axios.get('/api/users/').then(res => {
        commit('setPersonal', res.data);
        return res.data;
      })
    },
    updatePersonal({state, commit}, params) {
      return axios.put('/api/users/' + params.id, {params: params});
    },
    getSubscribes({state, commit}, params) {
      return axios.post('/api/users/' + params.id + '/getSubscribes/', {params: params}).then(res => {
        return res.data;
      });
    },
  }
}

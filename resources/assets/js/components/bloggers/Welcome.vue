<template>
  <div id="main-block" class="main-block main-block-with-sidebar">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3>Welcome to Youtube Watcher!</h3>
          <!--<div class="btn btn-primary" @click="synchronize()">-->
            <!--{{ $t('common.synchronize_btn') }}-->
          <!--</div>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'

  export default{
    computed: {
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

    data() {
      return {}
    },

    methods:{
      synchronize(){
        let params = this.personal;
        this.$store.dispatch('getSubscribes', params).then(res => {
          if(res.success){
            this.$store.dispatch('getBloggers');
          }else{
            alert('Check your security options!');
          }
          this.saving = false;
        });
      }
    }
  }
</script>
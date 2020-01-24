<template>
  <div class="modal" v-if="noSubscribes" style="display: block">
    <div class="panel panel-default modal-dialog">
      <div class="panel-heading">
        <h3>{{ $t('common.no_subscriptions') }}</h3>
      </div>
      <div class="panel-body">
        <p>
          {{ $t('common.go_to_settings_msg') }}
        </p>
        <a href="https://www.youtube.com/account_privacy" class="btn btn-primary" target="_blank">
          {{ $t('common.go_to_settings_btn') }}
        </a>
        <a href="#" @click="tryAgain()" class="btn btn-primary">{{ $t('common.try_again_btn') }}</a>
        <a href="/logout/"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
           class="btn btn-primary"
        >
          {{ $t('common.sing_in_another') }}
        </a>
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
      tryAgain(){
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
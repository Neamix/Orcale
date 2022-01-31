<template>
    <vue-progress-bar></vue-progress-bar>
    <div class="main-container" :class="{'screen-max': $store.state.load}">
        <notifications />
        <load v-if="$store.state.load"></load>
        <router-view :key="$route.path"></router-view>
    </div>
</template>

<script>
  import load from './Pages/load.vue'

 export default {
    components: {
      'load': load
    },
  
    mounted() {
      //  [App.vue specific] When App.vue is finish loading finish the progress bar
      this.$Progress.finish();
    },
    created() {
      //  [App.vue specific] When App.vue is first loaded start the progress bar
      this.$Progress.start();
      //  hook the progress bar to start before we move router-view
      this.$router.beforeEach((to, from, next) => {
        //  does the page we want to go to have a meta.progress object
        if (to.meta.progress !== undefined) {
          let meta = to.meta.progress;
          // parse meta tags
          this.$Progress.parseMeta(meta);
        }
        //  start the progress bar
        this.$Progress.start();
        //  continue to next page
        next();
      });
      //  hook the progress bar to finish after we've finished moving router-view
      this.$router.afterEach((to, from) => {
        //  finish the progress bar
        this.$Progress.finish();
      });
    },
  };
</script>
<template>
<div id="app">

    <router-view/>
</div>
</template>

<style>
html,
body {
    width: 100%;
    height: 100%;
    margin: 0px !important;
    padding: 0px;
    min-width: 100%;
    overflow-x: hidden !important;
    
    font-family: 'Roboto', sans-serif !important;

}


</style>

<script>
export default {

    mounted() {
      
      if(localStorage.tokentraining == '' || localStorage.tokentraining == undefined)
      {
        this.goToLogin();
      }

    },

    methods: {
        goToLogin() {
            this.$router.push("login");
        },
        goToHome(){
            this.$router.push("home");
        }

    }
}
</script>

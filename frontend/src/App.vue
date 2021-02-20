<template>
  <div id="app">
    <!-- <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div> -->
    <router-view />

    <div
      class="md-layout md-alignment-center-center"
      style="height: 100vh;"
    >

    <form novalidate class="md-layout" @submit.prevent="validateUser">
      <md-card md-with-hover style="padding:100px;">
        <md-ripple>
          <md-card-header>
            <div class="md-title">Login</div>
          </md-card-header>

          <md-card-content>
            <md-field>
              <label>Username</label>
              <md-input v-model="email"></md-input>
            </md-field>

            <md-field>
              <label>Password </label>
              <md-input v-model="password" type="password"></md-input>
            </md-field>
          </md-card-content>

          <md-card-actions clas="md-alignment-left-left" >
            <md-button v-on:click="login" class="md-primary"  >συνδεση</md-button>
          </md-card-actions>
        </md-ripple>
      </md-card>
    </form>


    </div>
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>


<script>
import axios from "axios";
import environment from "./environment";
export default {
  
data(){
  return{
    email:'',
    password:'',
  };

},
methods: {

  login(){
    console.log("dd");

      axios
        .post(`${environment.baseUrl}/api/login`, {
         
            email: this.email,
            password: this.password,
            
         
        })
        .then(() => {
          console.log("ok");

        })
        .catch(() => {
          alert("connect error");
        });



  }

},


}
</script>
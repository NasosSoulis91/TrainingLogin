<template>
<div id="app">
    <div class="body-container">

        <div class="login-container">
            <form novalidate class="md-layout" @submit.prevent="validateUser">
                <md-card md-with-hover style="padding-top:0px; padding-bottom:60px; padding-left:40px; padding-right:40px; width:100%">
                    <!-- <md-ripple> -->

                    <md-card-header style="text-align:center; margin-bottom:30px; "  >
                        <div style="padding-top:10px; padding-bottom:10px; width:100%;" class="md-title">Login</div>
                    </md-card-header>

                    <md-card-content style="margin-bottom:10px;">

                        <md-field :class="getValidationClass('email')">
                            <label for="email">Username</label>
                            <md-input name="email" id="email" autocomplete="email" v-model="form.email" :disabled="sending" />
                            <span class="md-error" v-if="!$v.form.email.required">The username is required</span>
                            <span class="md-error" v-else-if="!$v.form.email.minlength">Invalid first name</span>
                        </md-field>

                        <md-field :class="getValidationClass('password')">
                            <label for="password">Password</label>
                            <md-input type="password" name="password" id="password" v-model="form.password" :disabled="sending" />
                            <span class="md-error" v-if="!$v.form.password.required">The password is required</span>
                            <span class="md-error" v-else-if="!$v.form.password.minlength">Invalid password </span>
                        </md-field>

                    </md-card-content>

                    <div class="actions md-layout md-alignment-center-space-between">
                        <md-button v-on:click="goregister">ΕΓΓΡΑΦΗ</md-button>
                        <md-button type="submit" class="md-raised md-primary" :disabled="sending">ΣΥΝΔΕΣΗ</md-button>
                    </div>
                    <div style="text-align:center; margin-top:45px;">
                        <a href="/resetpassword">Ξεχάσατε τον κωδικό σας;</a>
                    </div>

                    <!-- </md-ripple> -->

                    <md-snackbar :md-active.sync="wrongCredentialsAlert"><span>Λάθος στοιχεία </span></md-snackbar>
                </md-card>

            </form>
        </div>
    </div>
   
</div>
</template>

<script>
import {
    validationMixin
} from 'vuelidate'
import {
    required,
    email,
    minLength

} from 'vuelidate/lib/validators'
import axios from "axios";
import environment from "../environment";

export default {
    name: 'Login',
    mixins: [validationMixin],
    data: () => ({
        form: {
            email: null,
            password: null,
        },
        wrongCredentialsAlert: false,
        sending: false
    }),
    validations: {
        form: {

            email: {
                required,
                email,
                minLength: minLength(3)

            },
            password: {
                required,
                minLength: minLength(3)
            },
        }
    },
    methods: {
        getValidationClass(fieldName) {
            const field = this.$v.form[fieldName]

            if (field) {
                return {
                    'md-invalid': field.$invalid && field.$dirty
                }
            }
        },
        clearForm() {
            this.$v.$reset()
            this.form.password = null
            this.form.email = null
        },
        saveUser() {
            this.sending = true;
            this.wrongCredentialsAlert = false,


            // Instead of this timeout, here you can call your API

            axios
                .post(`${environment.baseUrl}/api/login`, {

                    email: this.form.email,
                    password: this.form.password,

                })
                .then((res) => {
                    console.log("ok");
                    if (res.data.message == "success") {
                        console.log('ok');
                        this.sending = false;
                        localStorage.tokentraining = res.data.token;
                        this.$router.push("/");

                        //document.getElementById("error-alert").style.display = "block";
                    } else {
                        this.wrongCredentialsAlert = true;
                    }
                    this.sending = false;
                })
                .catch(() => {
                    
                    this.sending = false;

                });

  
        },
        validateUser() {
            this.$v.$touch()

            if (!this.$v.$invalid) {
                this.saveUser()
            }
        },
            goregister: function(){
      
        this.$router.push("register");
    },
    },

}
</script>

<style scoped>
.body-container {
    position: absolute;
    width: 100vw;
    height: 100vh;
    margin: 0;
    padding: 0;
 
    /* For browsers that do not support gradients */
    background-image: linear-gradient(#448AFF, white);

    ;

}

.login-container {
    width: 90%;
    max-width: 400px;

    position: fixed;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);

}

.md-snackbar span {
    margin: auto;
    text-align: center;
}
</style>

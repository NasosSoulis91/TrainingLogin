<template>
<div>
    <div class="body-container" style="background-color:red!important;">

        <div class="register-container" style="background-color:yellow!important;">
            <form novalidate class="md-layout" @submit.prevent="validateUser">
                <md-card md-with-hover class="md-layout-item width:100%" style="padding:40px;">
                    <md-card-header>
                        <div class="md-title">Δημιουργία λογαριασμού</div>
                    </md-card-header>

                    <md-card-content>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('firstName')">
                                    <label for="first-name">Όνομα</label>
                                    <md-input name="first-name" id="first-name" autocomplete="given-name" v-model="form.firstName" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.firstName.required">The first name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.firstName.minlength">Invalid first name</span>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('lastName')">
                                    <label for="last-name">Επίθετο</label>
                                    <md-input name="last-name" id="last-name" autocomplete="family-name" v-model="form.lastName" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.lastName.required">The last name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.lastName.minlength">Invalid last name</span>
                                </md-field>
                            </div>
                        </div>

                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('gender')">
                                    <label for="gender">Φύλο</label>
                                    <md-select name="gender" id="gender" v-model="form.gender" md-dense :disabled="sending">
                                        <md-option></md-option>
                                        <md-option value="1">Άντρας</md-option>
                                        <md-option value="0">Γυναίκα</md-option>

                                    </md-select>
                                    <span class="md-error">The gender is required</span>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-small-size-100">

                                <md-datepicker name="age" id="age" v-model="form.age" :disabled="sending" :class="getValidationClass('age')">
                                    <label>Ημερομηνία γέννησης</label>
                                    <span class="md-error" v-if="!$v.form.age.required">The age is required</span>
                                </md-datepicker>

                            </div>
                        </div>

                        <md-field :class="getValidationClass('email')">
                            <label for="email">Email</label>
                            <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" :disabled="sending" />
                            <span class="md-error" v-if="!$v.form.email.required">The email is required</span>
                            <span class="md-error" v-else-if="!$v.form.email.email">Invalid email</span>
                        </md-field>

                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('password')">
                                    <label for="password">Κωδικός</label>
                                    <md-input type="password" name="password" id="password" v-model="form.password" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.password.required">The password is required</span>
                                    <span class="md-error" v-else-if="!$v.form.password.minlength">Invalid password</span>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('comfirmpassword')">
                                    <label for="comfirmpassword">Επιβεβαίωση κωδικού</label>
                                    <md-input type="password" name="comfirmpassword" id="comfirmpassword" v-model="form.comfirmpassword" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.comfirmpassword.required">The last name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.comfirmpassword.minlength">Invalid last name</span>
                                </md-field>
                            </div>
                        </div>

                    </md-card-content>

                    <md-progress-bar md-mode="indeterminate" v-if="sending" />

                    <md-card-actions>
                        <md-button type="submit" class="md-primary" :disabled="sending">ΔΗΜΙΟΥΡΓΙΑ</md-button>
                    </md-card-actions>
                </md-card>

                <md-snackbar :md-active.sync="userSaved">Επιτυχής δημιουργία λογαριασμού</md-snackbar>
                <md-snackbar :md-active.sync="passwordsnomatch"><span>Λαναθσμένη επιβαιβέωση κωδικού</span></md-snackbar>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import moment from 'moment'
import axios from "axios";
import environment from "../environment";
import {
    validationMixin
} from 'vuelidate'
import {
    required,
    email,
    minLength,
    maxLength
} from 'vuelidate/lib/validators'

export default {
    name: 'FormValidation',
    mixins: [validationMixin],
    data: () => ({
        form: {
            firstName: null,
            lastName: null,
            gender: null,
            age: null,
            email: null,
            password: null,
            comfirmpassword: null,
        },
        userSaved: false,
        sending: false,
        lastUser: null,
        passwordsnomatch: false,

    }),
    validations: {
        form: {
            firstName: {
                required,
                minLength: minLength(3)
            },
            lastName: {
                required,
                minLength: minLength(3)
            },
            age: {
                required,
                maxLength: maxLength(3)
            },
            gender: {
                required
            },
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(3)
            },
            comfirmpassword: {
                required,
                minLength: minLength(3)
            }
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
            this.form.firstName = null
            this.form.lastName = null
            this.form.age = null
            this.form.gender = null
            this.form.email = null
            this.form.password = null
            this.form.comfirmpassword = null
        },
        saveUser() {
            this.sending = true

            // Instead of this timeout, here you can call your API



          this.form.age =  moment(String(this.form.age)).format('YYYY/MM/DD');

            axios
                .post(`${environment.baseUrl}/api/register`, {

                    firstName : this.form.firstName,
                    lastName : this.form.lastName,
                    gender : this.form.gender,
                    birthday : this.form.age,
                    email : this.form.email,
                    password : this.form.password,
                    
                })
                .then((res) => {
                   
                    if (res.data.message == "success") {
                        this.userSaved= true;
                    } else {
                        this.wrongCredentialsAlert = true;
                    }
                   
                                   
                this.sending = false
                this.clearForm()
                })
                .catch(() => {

                    this.sending = false;

                });

        },
        validateUser() {
            this.$v.$touch()

            if (!this.$v.$invalid) {
                if (this.form.password == this.form.comfirmpassword) {

                    this.saveUser()
                } else {
                    this.passwordsnomatch = true;
                }

            }
        }
    }
}
</script>

<style lang="css" scoped>
.md-progress-bar {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
}

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

.register-container {
    width: 90%;
    max-width: 800px;

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

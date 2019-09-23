<template>

  <div id="register-app">

    <br />

    <p class="text-dark h1 text-center mb-5">Signup</p>

    <div class="container">

        <div class="row">

            <div class="col-lg-7 col-sm-12">


            </div>

            <div class="col-lg-5 col-sm-12 shadow-lg p-3 mb-5 bg-white rounded">
                <div class="container">

                    <p class="h3 text-dark text-center mb-3">Signup An Account!</p>

                    <form @submit.prevent="register">
                        <input v-model="register_data.email"
                        type="email" class="form-control mb-3" placeholder="Email Address" required>

                        <input v-model="register_data.password"
                        type="password" class="form-control mb-3" placeholder="Password" required>

                        <input v-model="register_data.password_confirmation"
                        type="password" class="form-control mb-3" placeholder="Password Confirmation" required>

                        <input v-model="register_data.fname"
                        type="text" class="form-control mb-3" placeholder="Firstname" required>

                        <input v-model="register_data.mname"
                        type="text" class="form-control mb-3" placeholder="Middlename">

                        <input v-model="register_data.lname"
                        type="text" class="form-control mb-3" placeholder="Lastname" required>

                        <select v-model="register_data.gender"
                        class="form-control mb-3" required>
                            <option value="">Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>

                        <input v-model="register_data.bday"
                        type="date" class="form-control mb-3" placeholder="Birthday" required>

                        <input v-model="register_data.phone"
                        type="text" class="form-control mb-3" placeholder="Mobile Number" required>

                        <button type="submit" class="btn btn-dark text-dark bg-transparent btn-md   ">Register</button>

                    </form>
                </div>
            </div>
        </div>

    </div>


  </div>

</template>

<script>

import {register} from '../../helpers/auth';

export default {

    data() {

        return {

            register_data: {

                email: null,
                password: null,
                password_confirmation: null,
                fname: null,
                mname: null,
                lname: null,
                gender: "",
                bday: null,
                phone: null,

            }


        }

    },

    methods: {

        register() {

          this.$store.dispatch('register');

          register(this.register_data).then((res) => {

            this.$toastr.s(res.user.fname + ' ' + res.user.lname + ' Successfully Registered');

            this.$store.commit("register_success", res);
            this.$router.push({path: '/home'});

          }).catch((error) => {

              let return_val = {
                  email: this.register_data.email,
                  fname: this.register_data.fname,
                  mname: this.register_data.mname,
                  lname: this.register_data.lname,
                  gender: this.register_data.gender,
                  bday: this.register_data.bday,
                  phone: this.register_data.phone,
              }

              this.$store.commit("register_failsafe", return_val);
              this.$router.push({path: '/register'});
              for(let i = 0; i < Object.values(error.errors).length; i++) {
                  this.$toastr.e(Object.values(error.errors)[i][0]);
              }

          });

        },

    },

    computed: {

        failed_register_data() {

            return this.$store.getters.register_failsafe;

        }

    },

    created() {

        if(this.failed_register_data !== null) {

           let reg =  this.register_data;
           let val =  this.failed_register_data;

           reg.email = val.email;
           reg.fname = val.fname;
           reg.mname = val.mname;
           reg.lname = val.lname;
           reg.gender = val.gender;
           reg.bday = val.bday;
           reg.phone = val.phone;

        }

    },

    destroyed () {

    }

}

</script>

<style lang="scss" scoped>

</style>

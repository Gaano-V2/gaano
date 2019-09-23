<template>

  <div id="header-app">

    <nav id="main-nav-tl" class="navbar navbar-expand-lg fixed-top navbar-dark shadow-lg p-3 mb-5" style="background-color: #00285F;">
    <router-link class="navbar-brand" :to="{ path: '/'}" style="padding-left: 4%;"><img src="/tools/logo.png" class="img-fluid" /></router-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
    <ul class="navbar-nav" style="padding-right: 4%;">

        <template v-if="current_user">

        <li class="nav-item text-white px-3" style="margin-top: 2.1%;"><img src="/tools/reserved-gly.png" class="img-fluid px-1"> Reserve</li>
        <li class="nav-item text-white px-3" style="margin-top: 2.1%;"><img src="/tools/reserved-gly.png" class="img-fluid px-1"> Reserve</li>
        <li class="nav-item text-white px-3" style="margin-top: 2.1%;"><img src="/tools/reserved-gly.png" class="img-fluid px-1"> Reserve</li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <template v-if="current_user.avatar === null">
                    <img src="/tools/noavatar.png" class="img-fluid rounded-circle px-1">
                </template>
                <template v-else>
                    <img
                    :src="'../../storage/' + current_user.avatar"
                    class="img-fluid rounded-circle px-1">
                </template>
                {{ current_user.fname }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <router-link class="dropdown-item" style="text-decoration: none;" :to="{ path: '/profile/' +  current_user.fname + '-' + current_user.lname }">Profile</router-link>
            <a class="dropdown-item" href="#">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="cursor: pointer;"
            v-on:click="logout()">Logout</a>
            </div>
        </li>

        </template>

        <template v-else>

            <li class="nav-item text-white px-3"><img src="/tools/reserved-gly.png" class="img-fluid px-1"> Reserve</li>
            <li class="nav-item text-white px-3" style="cursor: pointer" @click="s_login_m"><img src="/tools/login-gly.png" class="img-fluid px-1"> Login</li>
            <li class="nav-item px-3"><router-link class="text-white" style="text-decoration: none;" :to="{ path: '/register'}"><img src="/tools/signip-gly.png" class="img-fluid px-1">Signup</router-link></li>

        </template>
    </ul>


  </div>
</nav>

<modal class="rounded"
    name="login-modal"
    :height="399"
    :width="301"
    :adaptive="true"
    :scrollable="true"
    :clickToClose="true">

        <p class="h4 text-dark text-center mb-5 p-3">Login Form</p>

        <form @submit.prevent="login">

            <div class="group">
                <input type="email" v-model="login_data.email" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Email Address</label>
            </div>

            <div class="group">
                <input type="password" v-model="login_data.password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>

            <div class="group text-center">
                <button type="submit" class="btn btn-dark text-dark bg-transparent btn-md">Login</button>
            </div>

            <div class="group text-left">
                <a href="#">Forgot Password?</a> | <a href="#">Signup?</a>
            </div>

        </form>

    </modal>

  </div>

</template>

<script>

import {login} from '../helpers/auth';

import {logout} from '../helpers/auth';

export default {

    name: "header-app",

    data() {

        return {

            login_data: {
                email: null,
                password: null
            }

        }

    },

    methods: {

        s_login_m() {
            this.$modal.show('login-modal');
        },

        h_login_m() {
            this.$modal.hide('login-modal');
        },

        login() {

            this.$store.dispatch('login');

            login(this.login_data).then((res) => {

                this.$toastr.s(res.user.fname + ' ' + res.user.lname + ' Successfully Login');

                this.$store.commit("login_success", res);

                if(res.profile.status === 1) {

                    this.$router.push({path: '/home'});

                } else if(res.profile.status === 2) {

                    this.$router.push({path: '/admin'});

                }

            }).catch((error) => {

                this.$store.commit("login_failed");
                this.$toastr.e(error.error);

            });

        },

        logout() {

            this.$store.dispatch('logout');

            logout(this.current_user).then((res) => {

              this.$toastr.s('Successfully Logout');

              this.$store.commit("logout_success");
              this.$router.push({path: '/'});

            }).catch((error) => {

              this.$store.commit("logout_failed");
              this.$router.push({path: '/home'});

            });

        },

    },

    computed: {

        current_user() {
            return this.$store.getters.current_user;
        }

    }

}

</script>

<style lang="scss" scoped>

.group 			  {
  position:relative;
  margin-bottom:45px;
}
input 				{
  font-size:18px;
  padding:10px 10px 10px 5px;
  display:block;
  width:300px;
  border:none;
  border-bottom:1px solid #757575;
}
input:focus 		{ outline:none; }

/* LABEL ======================================= */
label 				 {
  color:#999;
  font-size:18px;
  font-weight:normal;
  position:absolute;
  pointer-events:none;
  left:5px;
  top:10px;
  transition:0.2s ease all;
  -moz-transition:0.2s ease all;
  -webkit-transition:0.2s ease all;
}

/* active state */
input:focus ~ label, input:valid ~ label 		{
  top:-20px;
  font-size:14px;
  color:#000000;
}

/* BOTTOM BARS ================================= */
.bar 	{ position:relative; display:block; width:300px; }
.bar:before, .bar:after 	{
  content:'';
  height:2px;
  width:0;
  bottom:1px;
  position:absolute;
  background:#EC5E06;
  transition:0.2s ease all;
  -moz-transition:0.2s ease all;
  -webkit-transition:0.2s ease all;
}
.bar:before {
  left:50%;
}
.bar:after {
  right:50%;
}

/* active state */
input:focus ~ .bar:before, input:focus ~ .bar:after {
  width:50%;
}

/* HIGHLIGHTER ================================== */
.highlight {
  position:absolute;
  height:60%;
  width:100px;
  top:25%;
  left:0;
  pointer-events:none;
  opacity:0.5;
}

/* active state */
input:focus ~ .highlight {
  -webkit-animation:inputHighlighter 0.3s ease;
  -moz-animation:inputHighlighter 0.3s ease;
  animation:inputHighlighter 0.3s ease;
}

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
	from { background:#EC5E06; }
  to 	{ width:0; background:transparent; }
}
@-moz-keyframes inputHighlighter {
	from { background:#EC5E06; }
  to 	{ width:0; background:transparent; }
}
@keyframes inputHighlighter {
	from { background:#EC5E06; }
  to 	{ width:0; background:transparent; }
}

</style>

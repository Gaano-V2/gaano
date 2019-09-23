<template>

  <div id="admin-side-app">

      <div class="mb-5"></div>

      <div class="container">

          <div class="card shadow-lg p-3 mb-1 bg-white rounded sticky-top">

              <div class="card-body">

                  <template v-if="current_user.avatar === null">
                      <img src="/tools/noavatar.png" class="img-fluid rounded-circle px-1">
                  </template>
                  <template v-else>
                      <img
                      :src="'../../storage/' + current_user.avatar"
                      class="img-fluid rounded-circle px-1">
                  </template>
                  {{ current_user.fname }} <button @click="logout"
                  type="button"
                  class="btn btn-danger text-danger bg-transparent btn-sm">Logout</button>

                  <hr />
                  <router-link  :to="{ path: '/admin' }">
                  <button type="button"
                  class="btn btn-dark text-dark bg-transparent mb-3 w-100">Home</button>
                  </router-link>

                  <router-link  :to="{ path: '/admin/profile' }">
                  <button type="button"
                  class="btn btn-dark text-dark bg-transparent mb-3 w-100">Profile</button>
                  </router-link>

                  <router-link  :to="{ path: '/admin/vehicle' }">
                  <button type="button"
                  class="btn btn-dark text-dark bg-transparent mb-3 w-100">Vehicle</button>
                  </router-link>

                  <router-link  :to="{ path: '/admin/repair' }">
                  <button type="button"
                  class="btn btn-dark text-dark bg-transparent mb-3 w-100">Repair</button>
                  </router-link>

                  <router-link  :to="{ path: '/admin/users' }">
                  <button type="button"
                  class="btn btn-dark text-dark bg-transparent mb-3 w-100">Users</button>
                  </router-link>

                  <router-link  :to="{ path: '/admin/reservation' }">
                  <button type="button"
                  class="btn btn-dark text-dark bg-transparent w-100">Reservation</button>
                  </router-link>


              </div>

          </div>

      </div>

  </div>

</template>

<script>

import {logout} from '../../helpers/auth';

export default {

    name: "admin-side-app",

    data() {

        return {


        }

    },

    methods: {

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

    },

    created() {

    },

    destroyed () {

    }

}

</script>

<style lang="scss" scoped>

</style>

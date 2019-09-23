<template>

  <div id="admin-user-read-app">

      <br /><br />

      <div class="row">

          <div class="col-lg-4 col-sm-12">

              <button @click="update_user"
              class="btn btn-dark text-dark bg-transparent btn-sm">

                  <template v-if="user_read.status === 1">
                      Banned
                  </template>

                  <template v-if="user_read.status === 0">
                      Active
                  </template>

              </button>

              <div class="card">

                  <img class="card-img-top"
                  :src="'../../storage/' + user_read.profile.avatar"
                  :alt="user_read.profile.fname + '-' + user_read.profile.lname">

                  <div class="card-body">

                      <p class="h5 card-title">Name: {{ user_read.profile.fname }} {{ user_read.profile.lname }}</p>
                      <p class="h6">Email: {{ user_read.email }}</p>
                      <p class="h6">Phone: {{ user_read.profile.phone }}</p>
                      <p class="h6">Birthday: {{ user_read.profile.bday }}</p>
                      <p class="h6">Created At: {{ user_read.created_at }}</p>
                      <p class="h6">Email Verified:
                          <template v-if="user_read.email_verified_at !== null">Verified</template>
                          <template v-else>Not Verified</template>
                      </p>

                      <template v-if="user_read.identification !== null">

                          <img class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + user_read.identification.license" :alt="user_read.profile.fname + ' ' + user_read.profile.lname">
                          <img class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + user_read.identification.government_id" :alt="user_read.profile.fname + ' ' + user_read.profile.lname">

                      </template>



                  </div>
              </div>
          </div>

          <div class="col-lg-8 col-sm-12">

              <template v-if="user_read.has_reservation !== null">

                  <br>

                  <template v-for="reservation in user_read.has_reservation">
                      {{ reservation }}
                      <hr>
                  </template>

              </template>

              <template v-else>

                 <h1>No Reservation</h1>

              </template>

          </div>

      </div>

  </div>

</template>

<script>

import utility from '../../mixins/utility';

import {users_read} from '../../helpers/users';

import {update_status} from '../../helpers/users';

export default {

    mixins: [utility],

    name: "admin-user-read-app",

    data() {

        return {

        }

    },

    methods: {

        update_user() {

            // 1 = user 2 = admin 0 = banned

            let id = this.$route.params.id;

            let status;

            if(this.user_read.status === 1) {
                status = 0;
            }

            if(this.user_read.status === 0) {
                status = 1;
            }

            update_status(id, status).then((res) => {

                console.log(res);

            }).catch((error) => {});


        }


    },

    computed: {

        user_read() {

            return this.$store.getters.user_read;

        },

    },

    created() {

        if(Object.keys(this.user_read.profile).length === 0) {

            users_read(this.$route.params.id).then((res) => {

                this.$store.commit("user_payload", res);

            }).catch((error) => {

            });

        }

    },

    destroyed() {

        this.$store.commit("user_payload", null);

    }

}

</script>

<style lang="scss" scoped>

</style>

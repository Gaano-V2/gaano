<template>

  <div id="admin-home-app">

      <br /><br />

      <button @click="users_datas" type="button" class="btn btn-primary text-primary bg-transparent btn-sm">Refresh List</button>

      <vue-good-table
      @on-page-change="on_page_change"
      max-height="400px"
      :columns="columns"
      :rows="users_list"
      :fixed-header="true"
      :search-options="{
          enabled: true,
          trigger: 'enter',
          skipDiacritics: true,
          placeholder: 'Search this table',
      }"
      :pagination-options="{
          enabled: true,
          mode: 'pages',
          position: 'top',
          perPageDropdown: [10, 50, 100],
          dropdownAllowAll: false,
          setCurrentPage: page_count_number,
          nextLabel: 'next',
          prevLabel: 'prev',
          rowsPerPageLabel: 'Rows per page',
          ofLabel: 'of',
          pageLabel: 'page', // for 'pages' mode
          allLabel: 'All',
      }">

          <template slot="table-row" slot-scope="props" >

            <span v-if="props.column.field == 'view'">
              <a style="cursor: pointer;"
              class="btn btn-dark text-dark bg-transparent btn-sm"  @click="user_view(props.row)">View</a>
            </span>

            <span v-else>

              <span v-if="props.column.field == 'avatar'">
                <img :src="'../../storage/' + props.row.profile.avatar" alt="" width="50" height="50">
              </span>
              {{props.formattedRow[props.column.field]}}
            </span>

          </template>

      </vue-good-table>

  </div>

</template>

<script>

import Utility from '../../mixins/utility';

import {users_all} from '../../helpers/users';


export default {

    mixins: [Utility],

    name: "admin-users-app",

    data() {

        return {

          page_count_number: 1,

          columns: [

              {
                label: 'Avatar',
                field: 'avatar',
                type: 'file',
              },
              {
                label: 'First Name',
                field: 'profile.fname',
              },
              {
                label: 'Last Name',
                field: 'profile.lname',
              },
              {
                label: 'Email Address',
                field: 'email',
                type: 'email',
              },
              {
                label: 'Phone Number',
                field: 'profile.phone',
                type: 'phone',
              },
              {
                label: 'View',
                field: 'view',
                html: true,
              },

          ],

        }

    },

    methods: {

        on_page_change(params) {
            this.$router.push('/admin/users?page=' + params.currentPage, { name: "admin-users-app", query: {page: params.currentPage} });
        },

        user_view(user) {

            this.$store.commit("user_payload", user);

            this.$router.push('/admin/user/' + this.hashid(user.id));

        },

        users_datas() {

            users_all().then((res) => {

                if(this.users_list.length !== 0) {

                    this.$store.commit("users_payload", []);

                }

                this.$store.commit("users_payload", res);

            }).catch((error) => {

                this.$toastr.e(error.error);

            });

        },


    },

    computed: {

        users_list() {

            return this.$store.getters.users_list;

        },

    },

    created() {

        if(this.users_list.length === 0) {

            this.users_datas();

        }

        if(Object.keys(this.$route.query).length !== 0) {

            this.page_count_number = parseInt(this.$route.query.page, 10);

        }

    },

    destroyed () {

    }

}

</script>

<style lang="scss" scoped>

</style>

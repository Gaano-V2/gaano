<template>

  <div id="main-app">

    <template v-if="main_loading">
        <h1>Loading.....</h1>
    </template>

    <template v-else>

        <template v-if="current_user === null || current_user.status === 1">

            <Header />

            <main class="cotent">

                <router-view></router-view>

            </main>

        </template>

        <template v-else-if="current_user.status === 2">

            <div class="row" style="width: 100%;">

                <div class="col-lg-3 col-sm-12"><Admin_Side /></div>

                <div class="col-lg-9 col-sm-12">

                    <main class="cotent">

                        <router-view></router-view>

                    </main>

                </div>

            </div>

        </template>

    </template>

  </div>

</template>

<script>

import Header from './HeaderApp';
import Admin_Side from './Admin/SideBarApp';

export default {

    name: "main-app",

    data() {

        return {


        }

    },

    components: {Header, Admin_Side},

    methods: {

    },

    computed: {

        main_loading() {

            return this.$store.getters.is_main_loading;

        },

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

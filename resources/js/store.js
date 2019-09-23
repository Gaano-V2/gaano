import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {

  state: {

      main_loader: false,
      current_user: user,
      is_logged_in: !!user,
      register_failsafe: null,
      vehicles: [],
      users: [],
      user_read: {
          profile: {},
          identification: {},
      },
      admin_reservation: {

      },

      admin_reservation_read: {
          vehicle_reserve: {},
          is_walkin: {},
          user_reserve: {
              profile: {},
              identification: {}
          },
      },

  },

  getters: {

      is_main_loading(state) {

          return state.main_loader;

      },

      is_logged_in(state) {

          return state.is_logged_in;

      },

      current_user(state) {

          return state.current_user;

      },

      register_failsafe(state) {

          return state.register_failsafe;

      },

      vehicle_list(state) {
          return state.vehicles;
      },

      users_list(state) {
          return state.users;
      },

      user_read(state) {

          return state.user_read;

      },

      admin_reservation(state) {

          return state.admin_reservation;

      },

      admin_reservation_read(state) {

          return state.admin_reservation_read;

      }


  },


  mutations: {

      loading(state) {

          state.main_loader = true;

      },


      on_register(state) {

          state.main_loader = true;
          state.register_error = null;

      },

      register_success(state, payload) {
          state.is_logged_in = true;
          state.main_loader = false;
          state.current_user = Object.assign({}, payload.user, payload.profile, payload.identification,  {token: payload.access_token});
          localStorage.setItem("user", JSON.stringify(state.current_user));
      },

      register_failsafe(state, payload) {

          state.main_loader = false;
          state.register_failsafe = payload;

      },


      on_login(state) {

          state.main_loader = true;
          state.login_error = null;

      },

      login_success(state, payload) {

          state.is_logged_in = true;
          state.main_loader = false;
          state.current_user = Object.assign({}, payload.user, payload.profile, payload.identification, {token: payload.access_token});
          localStorage.setItem("user", JSON.stringify(state.current_user));

      },

      login_failed(state, payload) {

          state.main_loader = false;
          state.login_error = payload.error;

      },

      on_logout(state) {

          state.main_loader = true;

      },

      logout_success(state) {

          state.main_loader = false;
          state.is_logged_in = false;
          state.current_user = null;
          state.vehicles = [];
          state.users = [];
          localStorage.removeItem("user");

      },

      logout_failed(state) {

          state.main_loader = false;

      },

      update_profile_info(state) {

          state.main_loader = true;

      },

      update_profile_info_success(state, payload) {

          localStorage.removeItem("user");
          state.current_user = null;
          state.current_user = Object.assign({}, payload.user, payload.profile, payload.identification, {token: payload.access_token});
          localStorage.setItem("user", JSON.stringify(state.current_user));
          state.main_loader = false;

      },

      update_profile_info_failed(state) {

          state.main_loader = false;

      },

      vehicle_payload(state, payload) {

          state.vehicles = payload;

      },

      users_payload(state, payload) {

          state.users = payload;

      },

      user_payload(state, payload) {

          state.user_read = payload;

      },

      admin_reservation_payload(state, payload) {

          state.admin_reservation = payload;

      },

      admin_reservation_read(state, payload) {

          state.admin_reservation_read = payload;

      },

      failsafe(state) {

          state.vehicles = [];
          state.users = [];
          state.is_logged_in = false;
          state.current_user = null;
          state.register_failsafe = null;
          localStorage.removeItem("user");

      }

  },

  actions: {

      loading(context) {

          context.commit("loading");

      },

      register(context) {

          context.commit("on_register");

      },

      login(context) {

          context.commit("on_login");

      },

      logout(context) {

          context.commit("on_logout");

      },

      profile_update(context) {

          context.commit("update_profile_info");

      },


  }


}

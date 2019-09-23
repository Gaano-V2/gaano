<template>

  <div id="admin-reservation-read-app">

      {{ reserved }}

      <br />
      <br />


      <template v-if="reserved.status === 0 || (reserved.status === 1)">

          <button @click="s_u_d_reservation"
          type="button" class="btn btn-dark text-dark bg-transparent btn-sm">Change Date</button>

          <template v-if="format_date(new Date()) <= reserved.start_date">
              <button @click="s_u_v_reservation"
              type="button" class="btn btn-dark text-dark bg-transparent btn-sm">Change Vehicle</button>
          </template>

          <template v-if="reserved.is_walkin === 1">
              <button @click="s_u_w_reservation"
              type="button" class="btn btn-dark text-dark bg-transparent btn-sm">Change Profile</button>
          </template>

      </template>

      <br />
      <br />

      <div class="row">

          <div class="col-lg-8 row">

              <div class="col-lg-6"><img :src="'../../storage/' + reserved.vehicle_reserve.image" :alt="reserved.vehicle_reserve.name + '-' + reserved.vehicle_reserve.brand"
                class="img-fluid shadow-lg p-3 mb-3 bg-white rounded"></div>
                <div class="col-lg-6"><p>Date/Time: {{reserved.start_date}} - {{reserved.end_date}}:  {{reserved.time}}</p> </div>
                <div class="col-lg-6">Total: ₱{{ calculate_total(reserved.start_date, reserved.end_date, reserved.vehicle_reserve.d_price, reserved.vehicle_reserve.w_price, reserved.vehicle_reserve.m_price) }}</div>
                <div class="col-lg-6">Daily: {{ reserved.vehicle_reserve.d_price }}, Weekly: {{ reserved.vehicle_reserve.w_price }}, Monthly: {{ reserved.vehicle_reserve.m_price }}</div>
                <div class="col-lg-6">Name: {{ reserved.vehicle_reserve.name }} - Brand: {{ reserved.vehicle_reserve.brand }}</div>
                <div class="col-lg-6">
                  Transmission:
                  <template v-if="reserved.vehicle_reserve.transmassion === 1">Manual</template><template v-else>Automatic</template>,
                  Gas Type:
                  <template v-if="reserved.vehicle_reserve.transmassion === 1">Gas</template><template v-else>Diesel</template>
                </div>

          </div>

          <div class="col-lg-4 row">

              <template v-if="reserved.is_walkin === 1">
                  <div>Name: {{ reserved.customer_walkin.fname }} {{ reserved.customer_walkin.mname }} {{ reserved.customer_walkin.lname }}</div>
                  <div>Email: {{ reserved.customer_walkin.email }}</div>
                  <div>Phone: {{ reserved.customer_walkin.phone }}</div>
                  <div>Birthday: {{ reserved.customer_walkin.bday }}</div>
                  <div>Gender:
                      <template v-if="reserved.customer_walkin.gender === 1">Male</template>
                      <template v-else>Female</template>
                  </div>
                  <div><img v-if="reserved.customer_walkin.license !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + reserved.customer_walkin.license" :alt="reserved.customer_walkin.fname + ' ' + reserved.customer_walkin.lname"></div>
                  <div><img v-if="reserved.customer_walkin.government_id !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + reserved.customer_walkin.government_id" :alt="reserved.customer_walkin.fname + ' ' + reserved.customer_walkin.lname"></div>
              </template>

              <template v-else>
                  <div>Name: {{ reserved.user_reserve.profile.fname }} {{ reserved.user_reserve.profile.mname }} {{ reserved.user_reserve.profile.lname }}</div>
                  <div>Email: {{ reserved.user_reserve.email }}</div>
                  <div>Phone: {{ reserved.user_reserve.profile.phone }}</div>
                  <div>Birthday: {{ reserved.user_reserve.profile.bday }}</div>
                  <div>Gender:
                      <template v-if="reserved.user_reserve.profile.gender === 1">Male</template>
                      <template v-else>Female</template>
                  </div>
                  <div><img v-if="reserved.user_reserve.identification.license !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + reserved.user_reserve.identification.license" :alt="reserved.user_reserve.profile.fname + ' ' + reserved.user_reserve.profile.lname"></div>
                  <div><img v-if="reserved.user_reserve.identification.government_id !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + reserved.user_reserve.identification.government_id" :alt="reserved.user_reserve.profile.fname + ' ' + reserved.user_reserve.profile.lname"></div>
              </template>

          </div>

      </div>

      <modal name="u-date-reserve" height="500px" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">Create Walkin Reservation</h5>
              </div>

              <div class="card-body">

                  <form @submit.prevent="update_date">

                    <template v-if="format_date(new Date) <= reserved.start_date">

                        <date-picker v-model="change_reservation_date.start"
                                    format="YYYY/MM/DD"
                                    type="date"
                                    valueType="format"
                                    :disabled-days="not_available_dates"
                                    :clearable="false"
                                    :input-attr="{required: true,}"
                                    :shortcuts="shortcuts"
                                    :lang="lang"
                                    :not-before="not_before_date"
                                    :not-after="change_reservation_date.end"
                                    @change="change_not_before_date"
                                    class="mb-3"></date-picker>
                    </template>

                    <template v-if="change_reservation_date.start !== null">

                          <date-picker v-model="change_reservation_date.end"
                                      format="YYYY/MM/DD"
                                      type="date"
                                      valueType="format"
                                      :disabled-days="not_available_dates"
                                      :clearable="false"
                                      :input-attr="{required: true,}"
                                      :shortcuts="shortcuts"
                                      :lang="lang"
                                      :not-before="not_before_date"
                                      :not-after="not_after_date"
                                      class="mb-3"></date-picker>

                      </template>

                    <select v-model="change_reservation_date.time"
                    class="form-control mb-3" required>
                        <option value="">Time</option>
                        <option value="9:00">9:00 AM</option>
                        <option value="9:30">9:30 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="10:30">10:30 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="11:30">11:30 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="12:30">12:30 PM</option>
                        <option value="1:00">1:00 PM</option>
                        <option value="1:30">1:30 PM</option>
                        <option value="2:00">2:00 PM</option>
                        <option value="2:30">2:30 PM</option>
                        <option value="3:00">3:00 PM</option>
                        <option value="3:30">3:30 PM</option>
                        <option value="4:00">4:00 PM</option>
                        <option value="4:30">4:30 PM</option>
                        <option value="5:00">5:00 PM</option>

                    </select>


                    <div class="form-group row mb-0">

                      <div class="col-md-8 offset-md-4">

                        <button type="submit" class="btn btn-primary">
                              Update Date
                        </button>

                      </div>

                    </div>

                  </form>



              </div>

          </div>

      </modal>

      <modal name="u-vehicle-reserve" height="500px" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">Create Walkin Reservation</h5>
              </div>

              <div class="card-body">

                  <form @submit.prevent="change_vehicle">


                    <select v-model="change_reservation_vehicle.vehicleid"
                    class="form-control mb-3" required>

                        <template v-for="vehicle in vehicles">

                            <option :value="vehicle.id">{{ vehicle }}</option>

                        </template>

                    </select>


                    <div class="form-group row mb-0">

                      <div class="col-md-8 offset-md-4">

                        <button type="submit" class="btn btn-primary">
                              Update Date
                        </button>

                      </div>

                    </div>

                  </form>


              </div>

          </div>

      </modal>

      <modal name="u-walkin-reserve" height="auto" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">Create Walkin Reservation</h5>
              </div>

              <div class="card-body">

                  <form @submit.prevent="change_walkin">

                    <input v-model="change_walkin_datas.email"
                    type="email" class="form-control mb-3" placeholder="Email Address" required>

                    <input v-model="change_walkin_datas.fname"
                    type="text" class="form-control mb-3" placeholder="Firstname" required>

                    <input v-model="change_walkin_datas.mname"
                    type="text" class="form-control mb-3" placeholder="Middlename">

                    <input v-model="change_walkin_datas.lname"
                    type="text" class="form-control mb-3" placeholder="Lastname" required>

                    <select v-model="change_walkin_datas.gender"
                    class="form-control mb-3" required>
                        <option value="">Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>

                    <input v-model="change_walkin_datas.bday"
                    type="date" class="form-control mb-3" placeholder="Birthday" required>

                    <input v-model="change_walkin_datas.phone"
                    type="text" class="form-control mb-3" placeholder="Mobile Number" required>


                    <div class="form-group row mb-0">

                      <div class="col-md-8 offset-md-4">

                        <button type="submit" class="btn btn-primary">
                              Update
                        </button>

                      </div>

                    </div>

                  </form>

              </div>

          </div>

      </modal>


  </div>

</template>

<script>

var moment = require('moment');
import DatePicker from 'vue2-datepicker'
import Utility from '../../mixins/utility';

import {vehicle_check} from '../../helpers/reservation';
import {reservation_read} from '../../helpers/reservation';
import {reservation_update_date} from '../../helpers/reservation';
import {reservation_update_vehicle} from '../../helpers/reservation';
import {reservation_update_walkin} from '../../helpers/reservation';
import {reservation_near_date} from '../../helpers/reservation';

export default {

    components: { DatePicker },

    mixins: [Utility],

    name: "admin-reservation-read-app",

    data() {

        return {

            lang: {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                pickers: ['next 7 days', 'next 30 days'],
                placeholder: {
                    date: 'Select Date',
                    dateRange: 'Select Date Range'
                }
            },

            shortcuts: [],

            not_before_date: null,

            not_after_date: null,

            change_reservation_date: {
                reservationid: this.$route.params.id,
                vehicleid: null,
                start: null,
                end: null,
                time: ""
            },

            change_reservation_vehicle: {
                reservationid: this.$route.params.id,
                vehicleid: ""
            },

            not_available_dates: [],

            vehicles: [],

            change_walkin_datas: {

                id: null,
                email: null,
                fname: null,
                mname: "",
                lname: null,
                gender: "",
                bday: null,
                phone: null,


            },


        }

    },

    methods: {

      change_not_before_date() {

          if(this.change_reservation_date.start === "" || this.change_reservation_date.start === null) {

              this.not_before_date = new Date();

          } else {


              if(this.format_date(new Date()) > this.change_reservation_date.start) {

                  this.not_before_date = new Date();

              } else {

                  this.not_before_date = this.change_reservation_date.start;

                  this.change_reservation_date.vehicleid = this.reserved.vehicle_reserve.id;

                  reservation_near_date(this.change_reservation_date).then((res) => {

                      this.not_after_date = res.start_date;

                  }).catch((err) => {

                  });

              }

          }

      },

      count_days(from, to) {

            var a = moment(from, 'YYYY/MM/DD');
            var b = moment(to, 'YYYY/MM/DD');
            var days = b.diff(a, 'days');

            return days;

        },

        calculate_total(from, to, d_pay, w_pay, m_pay) {

            let total = 0;

            let days = this.count_days(from, to);

            for(let x = (days + 1); x--;) {

                if(x >= 30) {

                    total += parseInt(m_pay, 10);

                    x -= 29;

                    x--;

                } else if(x >= 7) {

                    total += parseInt(w_pay, 10);

                    x -= 6;

                    x--;


                } else if(x <= 6 && x >= 1) {

                    total += parseInt(d_pay, 10);

                    x--;

                }


                if(x == 0) {

                    break;

                }

            }

            return total;

        },

        s_u_d_reservation() {

            if(this.format_date(new Date()) > this.reserved.start_date) {

                this.change_reservation_date.start = this.reserved.start_date;

                this.change_not_before_date();

            }

            this.$modal.show('u-date-reserve');

        },

        h_u_d_reservation() {


            this.change_reservation_date.start_date = null;
            this.change_reservation_date.end_date = null;
            this.change_reservation_date.time = "";

            this.$modal.hide('u-date-reserve');

        },

        update_date() {

            reservation_update_date(this.change_reservation_date).then((res) => {

                this.reserved.start_date = res.start_date;
                this.reserved.end_date = res.end_date;
                this.reserved.time = res.time;

                this.h_u_d_reservation();


            }).catch((err) => {

            })
        },

        s_u_v_reservation() {

            vehicle_check(this.reserved.start_date, this.reserved.end_date).then((res) => {

                this.vehicles = res;

            }).catch((error) => {

            });

            this.$modal.show('u-vehicle-reserve');

        },

        h_u_v_reservation() {

            this.vehicle = [];

            this.$modal.hide('u-vehicle-reserve');

        },

        change_vehicle() {

            reservation_update_vehicle(this.change_reservation_vehicle).then((res) => {

                this.change_reservation_date.vehicleid = res.vehicle_reserve.id;

                this.reserved.vehicle_reserve = res.vehicle_reserve;

                this.h_u_v_reservation();


            }).catch((err) => {

            });

        },

        s_u_w_reservation() {

            this.change_walkin_datas.id = this.reserved.customer_walkin.id;
            this.change_walkin_datas.email = this.reserved.customer_walkin.email;
            this.change_walkin_datas.fname = this.reserved.customer_walkin.fname;
            this.change_walkin_datas.mname = this.reserved.customer_walkin.mname;
            this.change_walkin_datas.lname = this.reserved.customer_walkin.lname;
            this.change_walkin_datas.gender = this.reserved.customer_walkin.gender;
            this.change_walkin_datas.bday = this.reserved.customer_walkin.bday;
            this.change_walkin_datas.phone = this.reserved.customer_walkin.phone;

            this.$modal.show('u-walkin-reserve');

        },

        h_u_w_reservation() {

            this.change_walkin_datas.id = null;
            this.change_walkin_datas.email = null;
            this.change_walkin_datas.fname = null;
            this.change_walkin_datas.mname = "";
            this.change_walkin_datas.lname = null;
            this.change_walkin_datas.gender = "";
            this.change_walkin_datas.bday = null;
            this.change_walkin_datas.phone = null;

            this.$modal.hide('u-walkin-reserve');

        },

        change_walkin() {

            reservation_update_walkin(this.change_walkin_datas).then((res) => {

                this.reserved.customer_walkin.email = res.email;
                this.reserved.customer_walkin.fname = res.fname;
                this.reserved.customer_walkin.mname = res.mname;
                this.reserved.customer_walkin.lname = res.lname;
                this.reserved.customer_walkin.gender = res.gender;
                this.reserved.customer_walkin.bday = res.bday;
                this.reserved.customer_walkin.phone = res.phone;

                this.h_u_w_reservation();

            }).catch((err) => {

            });

        }

    },

    computed: {

        reserved() {

            return this.$store.getters.admin_reservation_read;

        },

    },

    created() {

        //if(this.reserved === "") {

            reservation_read(this.$route.params.id).then((res) => {

                this.$store.commit("admin_reservation_read", res);

                axios.get('/api/reservation/vehicle/date/' + this.hashid(res.vehicle_id) + '/' + this.$route.params.id).then((res) => {
                    for(var i = 0; i < res.data.length; i++) {
                        this.not_available_dates.push(res.data[i]);
                    }
                });

            });


        //}

        if(this.change_reservation_date.start === null) {

            this.not_before_date = new Date();

        }

    },

    destroyed () {

        this.$store.commit("admin_reservation_read", null);

    }

}

</script>

<style lang="scss" scoped>

</style>

<template>

  <div id="admin-reservation-app">

      <br /><br />


      <div class="card mt-3 mb-3">

          <div class="card-header">

              <button @click="s_c_reserve"
              type="button" class="btn btn-success text-success bg-transparent"
              >Create Reservation</button>

          </div>

          <form @submit.prevent="reservation_search(1)">

              <div class="card-body row">

                  <div class="col-lg-2 col-sm-12">
                      <input v-model="reserve_search_data.fname"
                      type="text" class="form-control" placeholder="Firstname">
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <input v-model="reserve_search_data.mname"
                      type="text" class="form-control" placeholder="Middlename">
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <input v-model="reserve_search_data.lname"
                      type="text" class="form-control" placeholder="Lastname">
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <input v-model="reserve_search_data.email"
                      type="email" class="form-control" placeholder="Email Address">
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <input v-model="reserve_search_data.vehicle"
                      type="text" class="form-control" placeholder="Vehicle">
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <input v-model="reserve_search_data.brand"
                      type="text" class="form-control" placeholder="Brand">
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <select v-model="reserve_search_data.status"
                      class="form-control">
                          <option value="">Status</option>
                          <option value="0">Pending</option>
                          <option value="1">Approved</option>
                          <option value="2">Disapproved</option>
                          <option value="3">Completed</option>
                      </select>
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <select v-model="reserve_search_data.walkin"
                      class="form-control">
                          <option value="">Walkin</option>
                          <option value="1">True</option>
                          <option value="0">False</option>
                      </select>
                  </div>

                  <div class="col-lg-2 col-sm-12">
                      <date-picker v-model="reserve_search_data.dates"
                                  range
                                  :clearable="false"
                                  confirm
                                  :editable="true"
                                  format="YYYY/MM/DD"
                                  type="date"
                                  valueType="format"
                                  :shortcuts="shortcuts"
                                  :lang="lang"></date-picker>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <button type="submit" class="btn btn-primary text-primary bg-transparent btn-sm">Search</button>
                  </div>

              </div>

          </form>

      </div>

      <!--{{ reservation_list }}-->

      <table>
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Vehicle</th>
            <th scope="col">Brand</th>
            <th scope="col">Period</th>
            <th scope="col">Time</th>
            <th scope="col">Status</th>
            <th scope="col">Reserve Created At</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody v-for="(reserved, index) in reservation_list.data">


          <tr v-if="!reserved.is_walkin">
            <td data-label="Name">{{ reserved.user_reserve.profile.fname }} {{ reserved.user_reserve.profile.mname }} {{ reserved.user_reserve.profile.lname }}</td>
            <td data-label="Vehicle">{{ reserved.vehicle_reserve.name }}</td>
            <td data-label="Brand">{{ reserved.vehicle_reserve.brand }}</td>
            <td data-label="Period">{{ reserved.start_date }} - {{ reserved.end_date }}</td>
            <td data-label="Time">{{ reserved.time }}</td>
            <td data-label="Status">
                <template v-if="reserved.status === 0">Pending</template>
                <template v-if="reserved.status === 1">Approved</template>
                <template v-if="reserved.status === 2">Disapproved</template>
                <template v-if="reserved.status === 3">Completed</template>
            </td>
            <td data-label="Reserve Created At">({{ change_date_filter(reserved.created_at) }}) {{ reserved.created_at }}</td>
            <td data-label="">
              <div class="dropdown show">
                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Functions
                  </a>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" @click="reservation_read(reserved)">View</a>
                    <template v-if="reserved.status === 0">
                        <a class="dropdown-item" @click="reservation_update_status(hashid(reserved.id), 1)" href="#">Approved</a>
                        <a class="dropdown-item" @click="reservation_update_status(hashid(reserved.id), 2)" href="#">Disapproved </a>
                    </template>
                    <template v-if="reserved.status === 1">
                        <a class="dropdown-item" @click="reservation_update_status(hashid(reserved.id), 3, reserved.start_date, reserved.end_date, reserved.vehicle_reserve.d_price, reserved.vehicle_reserve.w_price, reserved.vehicle_reserve.m_price)" href="#">Complete</a>
                    </template>
                  </div>
              </div>
            </td>
          </tr>
          <tr v-else>
            <td data-label="Name">{{ reserved.customer_walkin.fname }} {{ reserved.customer_walkin.mname }} {{ reserved.customer_walkin.lname }}</td>
            <td data-label="Vehicle">{{ reserved.vehicle_reserve.name }}</td>
            <td data-label="Brand">{{ reserved.vehicle_reserve.brand }}</td>
            <td data-label="Period">{{ reserved.start_date }} -
              <template v-if="reserved.status === 1 && format_date(new Date()) >  reserved.end_date">
                {{ format_date(new Date()) }}
              </template>
              <template v-else>
                {{ reserved.end_date }}
              </template>
            </td>
            <td data-label="Time">{{ reserved.time }}</td>
            <td data-label="Status">
                <template v-if="reserved.status === 0">Pending</template>
                <template v-if="reserved.status === 1">Approved</template>
                <template v-if="reserved.status === 2">Disapproved</template>
                <template v-if="reserved.status === 3">Completed</template>
            </td>
            <td data-label="Reserve Created At">({{ change_date_filter(reserved.created_at) }}) {{ reserved.created_at }}</td>
            <td data-label="">
              <div class="dropdown show">
                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Functions
                  </a>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" @click="reservation_read(reserved)">View</a>
                    <template v-if="reserved.status === 0">
                        <a class="dropdown-item" @click="reservation_update_status(hashid(reserved.id), 1)" href="#">Approved</a>
                        <a class="dropdown-item" @click="reservation_update_status(hashid(reserved.id), 2)" href="#">Disapproved </a>
                    </template>
                    <template v-if="reserved.status === 1">
                        <a class="dropdown-item" @click="reservation_update_status(hashid(reserved.id), 3, reserved.start_date, reserved.end_date, reserved.vehicle_reserve.d_price, reserved.vehicle_reserve.w_price, reserved.vehicle_reserve.m_price)" href="#">Complete</a>
                    </template>
                  </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <pagination @pagination-change-page="get_results"
      :data="reservation_list">
        	<span slot="prev-nav">&lt; Previous</span>
        	<span slot="next-nav">Next &gt;</span>
      </pagination>


      <modal name="c-reserve" height="auto" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">Create Walkin Reservation</h5>
              </div>

              <div class="card-body">

                  <form @submit.prevent="reservation_create">

                    <date-picker @change="check_vehicle"
                    v-model="reservation_data.date"
                                range
                                :clearable="false"
                                confirm
                                :editable="true"
                                :input-attr="{required: true,}"
                                format="YYYY/MM/DD"
                                type="date"
                                valueType="format"
                                :shortcuts="shortcuts"
                                :lang="lang"
                                :not-before="new Date()"
                                class="mb-3"></date-picker>

                    <select
                    v-model="reservation_data.time"
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

                    <select v-model="reservation_data.vehicleid"
                    class="form-control mb-3" required>

                        <template v-for="vehicle in vehicles">

                            <option :value="vehicle.id">{{ vehicle }}</option>

                        </template>

                    </select>

                    <input v-model="reservation_data.email"
                    type="email" class="form-control mb-3" placeholder="Email Address" required>

                    <input v-model="reservation_data.fname"
                    type="text" class="form-control mb-3" placeholder="Firstname" required>

                    <input v-model="reservation_data.mname"
                    type="text" class="form-control mb-3" placeholder="Middlename">

                    <input v-model="reservation_data.lname"
                    type="text" class="form-control mb-3" placeholder="Lastname" required>

                    <select v-model="reservation_data.gender"
                    class="form-control mb-3" required>
                        <option value="">Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>

                    <input v-model="reservation_data.bday"
                    type="date" class="form-control mb-3" placeholder="Birthday" required>

                    <input v-model="reservation_data.phone"
                    type="text" class="form-control mb-3" placeholder="Mobile Number" required>

                    <div class="form-group row">

                        <label for="government_id" class="col-md-4 col-form-label text-md-right">Government ID:</label>

                        <div class="col-lg-6">

                            <input id="government_id" type="file" @change="on_govern_file_select"
                            accept="image/x-png,image/gif,image/jpeg" class="form-control" required autofocus>

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="license" class="col-md-4 col-form-label text-md-right">License:</label>

                        <div class="col-lg-6">

                            <input id="license" type="file" @change="on_license_file_select"
                            accept="image/x-png,image/gif,image/jpeg" class="form-control" required autofocus>

                        </div>

                    </div>

                    <div class="form-group row mb-0">

                      <div class="col-md-8 offset-md-4">

                        <button type="submit" class="btn btn-primary">
                              Upload
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
import {vehicle_check} from '../../helpers/reservation';
import {reservation_all} from '../../helpers/reservation';
import {reservation_search} from '../../helpers/reservation';
import {reservation_create} from '../../helpers/reservation';
import {reservation_update_status} from '../../helpers/reservation';
import Utility from '../../mixins/utility';


export default {

    components: { DatePicker },

    mixins: [Utility],

    name: "admin-reservation-app",

    data() {

        return {

            lang: {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                pickers: ['next 7 days', 'next 30 days',],
                placeholder: {
                    date: 'Select Date',
                    dateRange: 'Select Date Range'
                }
            },

            shortcuts: [

            ],

            reserve_search: false,

            reserve_search_data: {

                walkin: "",
                dates: [],
                email: null,
                fname: null,
                mname: null,
                lname: null,
                vehicle: null,
                brand: null,
                status: "",

            },

            reservation_data: {

                date: [],
                time: "",
                vehicleid: null,
                email: null,
                fname: null,
                mname: "",
                lname: null,
                gender: "",
                bday: null,
                government_id: null,
                license: null,


            },

            vehicles: []


        }

    },

    methods: {

        get_results(page = 1) {

            this.reserve_search = true;

            if(this.$route.query.hasOwnProperty('walkin') === true ||
            this.$route.query.hasOwnProperty('dates') === true ||
            this.$route.query.hasOwnProperty('email') === true ||
            this.$route.query.hasOwnProperty('fname') === true ||
            this.$route.query.hasOwnProperty('mname') === true ||
            this.$route.query.hasOwnProperty('lname') === true ||
            this.$route.query.hasOwnProperty('vehicle') === true ||
            this.$route.query.hasOwnProperty('brand') === true ||
            this.$route.query.hasOwnProperty('status') === true ) {


                let walkin = false;
                let start_date = null;
                let end_date = null;
                let email = null;
                let fname = null;
                let mname = null;
                let lname = null;
                let vehicle = null;
                let brand = null;
                let status = null;

                if(this.$route.query.hasOwnProperty('walkin') === true) {
                    walkin = this.$route.query.walkin;
                }

                if(this.$route.query.hasOwnProperty('start_date') === true) {
                    start_date = this.$route.query.start_date;
                }

                if(this.$route.query.hasOwnProperty('end_date') === true) {
                    end_date = this.$route.query.end_date;
                }

                if(this.$route.query.hasOwnProperty('email') === true) {
                    email = this.$route.query.email;
                }

                if(this.$route.query.hasOwnProperty('fname') === true) {
                    fname = this.$route.query.fname;
                }

                if(this.$route.query.hasOwnProperty('mname') === true) {
                    mname = this.$route.query.mname;
                }

                if(this.$route.query.hasOwnProperty('lname') === true) {
                    lname = this.$route.query.lname;
                }

                if(this.$route.query.hasOwnProperty('vehicle') === true) {
                    vehicle = this.$route.query.vehicle;
                }

                if(this.$route.query.hasOwnProperty('brand') === true) {
                    brand = this.$route.query.brand;
                }

                if(this.$route.query.hasOwnProperty('status') === true) {
                    status = this.$route.query.status;
                }

                this.$router.push(`/admin/reservation?page=${page}&walkin=${walkin}&start_date=${start_date}&end_date=${end_date}&email=${email}&fname=${fname}&mname=${mname}&lname=${lname}&vehicle=${vehicle}&brand=${brand}&status=${status}`);

                this.reservation_search(page);

            } else {

                this.$router.push('/admin/reservation?page=' + page);

                this.reservation_datas(page);

            }

        },

        on_govern_file_select(e) {

            this.reservation_data.government_id = e.target.files[0];

        },

        on_license_file_select(e) {

            this.reservation_data.license = e.target.files[0];

        },

        check_vehicle() {

              vehicle_check(this.reservation_data.date[0], this.reservation_data.date[1]).then((res) => {

                  this.vehicles = res;

              }).catch((error) => {

              });


        },

        reservation_datas(page) {

            reservation_all(page).then((res) => {

                this.$store.commit("admin_reservation_payload", res);

            }).catch((error) => {

                this.$toastr.e(error.error);

            });

        },

        reservation_search(page = 1) {

            let datas;

            if(this.$route.query.hasOwnProperty('walkin') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('dates') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('email') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('fname') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('mname') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('lname') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('vehicle') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('brand') === true && !this.reserve_search ||
            this.$route.query.hasOwnProperty('status') === true && !this.reserve_search) {

                datas = {

                    walkin: this.$route.query.walkin,
                    dates: [this.$route.query.start_date, this.$route.query.end_date],
                    email: this.$route.query.email,
                    fname: this.$route.query.fname,
                    mname: this.$route.query.mname,
                    lname: this.$route.query.lname,
                    vehicle: this.$route.query.vehicle,
                    brand: this.$route.query.brand,
                    status: this.$route.query.status,

                }

                this.$router.push(`/admin/reservation?page=1&walkin=${this.$route.query.walkin}&start_date=${this.$route.query.start_date}&end_date=${this.$route.query.end_date}&email=${this.$route.query.email}&fname=${this.$route.query.fname}&mname=${this.$route.query.mname}&lname=${datas.lname}&vehicle=${this.$route.query.vehicle}&brand=${this.$route.query.brand}&status=${this.$route.query.status}`);

            } else {

                datas = this.reserve_search_data;


                this.$router.push(`/admin/reservation?page=1&walkin=${this.reserve_search_data.walkin}&start_date=${this.reserve_search_data.dates[0]}&end_date=${this.reserve_search_data.dates[1]}&email=${this.reserve_search_data.email}&fname=${this.reserve_search_data.fname}&mname=${this.reserve_search_data.mname}&lname=${datas.lname}&vehicle=${this.reserve_search_data.vehicle}&brand=${this.reserve_search_data.brand}&status=${this.reserve_search_data.status}`);

            }

            reservation_search(page, datas).then((res) => {

                this.reserve_search = true;

                this.$store.commit("admin_reservation_payload", res);

            }).catch((error) => {

                this.$toastr.e(error.error);

            });

        },

        s_c_reserve() {

            this.$modal.show('c-reserve');

        },

        h_c_reserve() {


            this.$modal.hide('c-reserve');

        },

        reservation_create() {

            reservation_create(this.reservation_data).then((res) => {

                this.$toastr.s('Reservation has been created');

                this.h_c_reserve();

                this.reservation_datas();


            }).catch((err) => {

            })


        },

        reservation_read(reservation) {

            this.$store.commit("admin_reservation_read", reservation);

            this.$router.push('/admin/reservation/' + this.hashid(reservation.id));

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

        reservation_update_status(id, status, from = null, to = null, d_pay = null, w_pay = null, m_pay = null) {

            let total = this.calculate_total(from, to, d_pay, w_pay, m_pay);

            reservation_update_status(id, status, total).then((res) => {
                console.log(res);
            }).catch((err) => {

            });



        }


    },

    computed: {

        reservation_list() {

            return this.$store.getters.admin_reservation;

        },

    },

    created() {

        if(this.$route.query.hasOwnProperty('walkin') === true ||
        this.$route.query.hasOwnProperty('dates') === true ||
        this.$route.query.hasOwnProperty('email') === true ||
        this.$route.query.hasOwnProperty('fname') === true ||
        this.$route.query.hasOwnProperty('mname') === true ||
        this.$route.query.hasOwnProperty('lname') === true ||
        this.$route.query.hasOwnProperty('vehicle') === true ||
        this.$route.query.hasOwnProperty('brand') === true ||
        this.$route.query.hasOwnProperty('status') === true ) {

            this.reservation_search(this.$route.query.page);

        } else if(this.$route.query.hasOwnProperty('walkin') === false ||
        this.$route.query.hasOwnProperty('dates') === false ||
        this.$route.query.hasOwnProperty('email') === false ||
        this.$route.query.hasOwnProperty('fname') === false ||
        this.$route.query.hasOwnProperty('mname') === false ||
        this.$route.query.hasOwnProperty('lname') === false ||
        this.$route.query.hasOwnProperty('vehicle') === false ||
        this.$route.query.hasOwnProperty('brand') === false ||
        this.$route.query.hasOwnProperty('status') === false ) {

            if (Object.keys(this.reservation_list).length === 0) {

                if(Object.keys(this.$route.query).length === 0) {

                    this.reservation_datas();

                } else if(Object.keys(this.$route.query.page).length !== 0) {

                    this.reservation_datas(this.$route.query.page);

                }


            }

        }


    },

    destroyed () {

        if (this.reserve_search) {

            this.reservation_datas();

        }

    }

}

</script>

<style lang="scss" scoped>

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }

  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }

  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }

  table td:last-child {
    border-bottom: 0;
  }
}

</style>

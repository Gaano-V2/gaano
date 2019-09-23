<template>

  <div id="admin-vehicle-app">

      <br /><br /><br />

      <button @click="s_c_vehicle"
      type="button" class="btn btn-success text-success bg-transparent btn-md">Add Vehicle</button>

      <vue-good-table
      @on-page-change="on_page_change"
      max-height="400px"
      :columns="columns"
      :rows="vehicle_list"
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
              class="btn btn-dark text-dark bg-transparent btn-sm"  @click="s_r_vehicle(props.row, props.row.index)">View</a>
            </span>

            <span v-if="props.column.field == 'update'">
              <a style="cursor: pointer;"
              class="btn btn-dark text-dark bg-transparent btn-sm"  @click="s_u_vehicle(props.row, props)">Update</a>
            </span>

            <span v-else>

              <span v-if="props.column.field == 'image-file'">
                <img :src="'../../storage/' + props.row.image" alt="" width="50" height="50">
              </span>
              {{props.formattedRow[props.column.field]}}
            </span>

          </template>

      </vue-good-table>

      <modal name="c-vehicle" height="auto" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">Create Vehicle Details</h5>
              </div>

              <div class="card-body">

                  <form @submit.prevent="vehicle_create" enctype="multipart/form-data">

                     <div class="form-group row">

                         <label for="avatar" class="col-md-4 col-form-label text-md-right">Image:</label>

                         <div class="col-lg-6">

                             <input id="avatar" type="file" @change="on_c_file"
                             accept="image/x-png,image/gif,image/jpeg"
                             class="form-control" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="password" class="col-md-4 col-form-label text-md-right">Brand:</label>

                         <div class="col-lg-6">

                             <input type="text" v-model="vehicle_data.brand" id="vbrand" name="vbrand"
                             class="form-control" placeholder="Vehicle Brand" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="vname" class="col-md-4 col-form-label text-md-right">Name:</label>

                         <div class="col-lg-6">

                             <input type="text" v-model="vehicle_data.name" id="vname" name="vname"
                             class="form-control" placeholder="Vehicle Name" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Seat Count:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.seat" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Seat" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Day Price:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.d_price" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Price" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Week Price:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.w_price" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Price" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Month Price:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.m_price" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Price" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="password" class="col-md-4 col-form-label text-md-right">Gas:</label>

                         <div class="col-lg-6">

                             <select v-model="vehicle_data.gas"
                             class="form-control" required autofocus>

                                <option value="">Gas Type</option>
                                <option value="1">Gas</option>
                                <option value="2">Diesel</option>

                             </select>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="password" class="col-md-4 col-form-label text-md-right">Transmission:</label>

                         <div class="col-lg-6">

                             <select v-model="vehicle_data.transmission"
                             class="form-control" required autofocus>

                                <option value="">Transmission Type</option>
                                <option value="1">Manual</option>
                                <option value="2">Automatic</option>

                             </select>

                         </div>

                     </div>

                     <div class="form-group row mb-0">

                       <div class="col-md-8 offset-md-4">

                         <button type="submit" class="btn btn-primary">
                               Create
                         </button>

                       </div>

                     </div>

                  </form>

              </div>

          </div>

      </modal>

      <modal name="r-vehicle" height="auto" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">{{ vehicle_data.name }}</h5>
              </div>

              <div class="card-body">

                  <center>

                      <img :src="'../../storage/' + vehicle_data.image" class="img-fluid shadow-lg p-3 mb-3 bg-white rounded">

                  </center>

                  <p>{{ vehicle_data.brand }}</p>
                  <p>{{ vehicle_data.seat }} Seats</p>
                  <p>P{{ vehicle_data.d_price }} Daily</p>
                  <p>P{{ vehicle_data.w_price }} Weekly</p>
                  <p>P{{ vehicle_data.m_price }} Monthly</p>
                  <p><template v-if="vehicle_data.gas === 1">Gas</template> <template v-else>Diesel</template></p>
                  <p><template v-if="vehicle_data.transmission === 1">Manual</template> <template v-else>Automatic</template></p>

                  <form @submit.prevent="vehicle_delete">

                      <button type="submit" class="btn btn-danger text-danger bg-transparent">Delete</button>

                  </form>



              </div>

          </div>

      </modal>

      <modal name="u-vehicle" height="auto" :scrollable="true">

          <div class="card">

              <div class="card-header">
                  <h5 class="text-center">Create Vehicle Details</h5>
              </div>

              <div class="card-body">

                  <form @submit.prevent="vehicle_update" enctype="multipart/form-data">

                     <div class="form-group row">

                         <label for="avatar" class="col-md-4 col-form-label text-md-right">Image:</label>

                         <div class="col-lg-6">

                             <input id="avatar" type="file" @change="on_c_file"
                             accept="image/x-png,image/gif,image/jpeg"
                             class="form-control" autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="password" class="col-md-4 col-form-label text-md-right">Brand:</label>

                         <div class="col-lg-6">

                             <input type="text" v-model="vehicle_data.brand" id="vbrand" name="vbrand"
                             class="form-control" placeholder="Vehicle Brand" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="vname" class="col-md-4 col-form-label text-md-right">Name:</label>

                         <div class="col-lg-6">

                             <input type="text" v-model="vehicle_data.name" id="vname" name="vname"
                             class="form-control" placeholder="Vehicle Name" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Seat Count:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.seat" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Seat" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Day Price:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.d_price" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Price" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Week Price:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.w_price" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Price" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="seat" class="col-md-4 col-form-label text-md-right">Month Price:</label>

                         <div class="col-lg-6">

                             <input type="number" v-model="vehicle_data.m_price" id="seat" name="seat"
                             class="form-control" placeholder="Vehicle Price" required autofocus>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="password" class="col-md-4 col-form-label text-md-right">Gas:</label>

                         <div class="col-lg-6">

                             <select v-model="vehicle_data.gas"
                             class="form-control" required autofocus>

                                <option value="">Gas Type</option>
                                <option value="1">Gas</option>
                                <option value="2">Deisel</option>

                             </select>

                         </div>

                     </div>

                     <div class="form-group row">

                         <label for="password" class="col-md-4 col-form-label text-md-right">Transmission:</label>

                         <div class="col-lg-6">

                             <select v-model="vehicle_data.transmission"
                             class="form-control" required autofocus>

                                <option value="">Transmission Type</option>
                                <option value="1">Manual</option>
                                <option value="2">Automatic</option>

                             </select>

                         </div>

                     </div>

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

import Utility from '../../mixins/utility';

import {vehicle_all} from '../../helpers/vehicle';
import {vehicle_search} from '../../helpers/vehicle';
import {vehicle_create} from '../../helpers/vehicle';
import {vehicle_read} from '../../helpers/vehicle';
import {vehicle_update} from '../../helpers/vehicle';
import {vehicle_delete} from '../../helpers/vehicle';

export default {

    name: "admin-vehicle-app",

    mixins: [Utility],

    data() {

        return {

            page_count_number: 1,

            columns: [

                {
                  label: 'Image',
                  field: 'image-file',
                  type: 'file',
                },
                {
                  label: 'Name',
                  field: 'name',
                },
                {
                  label: 'Brand',
                  field: 'brand',
                },
                {
                  label: 'View/Delete',
                  field: 'view',
                  html: true,
                },
                {
                  label: 'Update',
                  field: 'update',
                  html: true,
                },

            ],

            vehicle_data: {

                id: "",
                image: "",
                brand: "",
                name: "",
                seat: "",
                d_price: "",
                w_price: "",
                m_price: "",
                gas: "",
                transmission: "",
                index: "",

            },

            vehicle_search_data: {

                brand: "",
                name: "",
                seat: "",
                gas: "",
                transmission: "",

            },

            search_true: false,

        }

    },

    methods: {

        on_page_change(params) {
            this.$router.push('/admin/vehicle?page=' + params.currentPage, { name: "admin-users-app", query: {page: params.currentPage} });
        },

        on_c_file(e) {

            this.vehicle_data.image = e.target.files[0];

        },


        s_c_vehicle() {

            this.$modal.show('c-vehicle');

        },

        h_c_vehicle() {

            this.vehicle_data.image = "";
            this.vehicle_data.brand = "";
            this.vehicle_data.name = "";
            this.vehicle_data.seat = "";
            this.vehicle_data.d_price = "";
            this.vehicle_data.w_price = "";
            this.vehicle_data.m_price = "";
            this.vehicle_data.gas = "";
            this.vehicle_data.transmission = "";

            this.$modal.hide('c-vehicle');

        },

        vehicle_create() {

            vehicle_create(this.vehicle_data).then((res) => {

                this.h_c_vehicle();

                this.$toastr.s(res.brand + ' ' + res.name + ' has been created');

                this.vehicle_list.unshift(res);


            }).catch((error) => {

                console.log(error);

            });

        },

        s_r_vehicle(vehicle, index) {

            this.vehicle_data.id = vehicle.id;
            this.vehicle_data.image = vehicle.image;
            this.vehicle_data.brand = vehicle.brand;
            this.vehicle_data.name = vehicle.name;
            this.vehicle_data.seat = vehicle.seats;
            this.vehicle_data.d_price = vehicle.d_price;
            this.vehicle_data.w_price = vehicle.w_price;
            this.vehicle_data.m_price = vehicle.m_price;
            this.vehicle_data.gas = vehicle.gas;
            this.vehicle_data.transmission = vehicle.transmission;
            this.vehicle_data.index = vehicle.index;

            this.$modal.show('r-vehicle');

        },

        h_r_vehicle() {

            this.vehicle_data.id = "";
            this.vehicle_data.image = "";
            this.vehicle_data.brand = "";
            this.vehicle_data.name = "";
            this.vehicle_data.seat = "";
            this.vehicle_data.d_price = "";
            this.vehicle_data.w_price = "";
            this.vehicle_data.m_price = "";
            this.vehicle_data.gas = "";
            this.vehicle_data.transmission = "";
            this.vehicle_data.index = "";

            this.$modal.hide('r-vehicle');

        },

        s_u_vehicle(vehicle, index) {

            this.vehicle_data.id = vehicle.id;
            this.vehicle_data.brand = vehicle.brand;
            this.vehicle_data.name = vehicle.name;
            this.vehicle_data.seat = vehicle.seats;
            this.vehicle_data.d_price = vehicle.d_price;
            this.vehicle_data.w_price = vehicle.w_price;
            this.vehicle_data.m_price = vehicle.m_price;
            this.vehicle_data.gas = vehicle.gas;
            this.vehicle_data.transmission = vehicle.transmission;
            this.vehicle_data.index = index.index;

            this.$modal.show('u-vehicle');

        },

        h_u_vehicle() {

            this.vehicle_data.image = "";
            this.vehicle_data.brand = "";
            this.vehicle_data.name = "";
            this.vehicle_data.seat = "";
            this.vehicle_data.d_price = "";
            this.vehicle_data.w_price = "";
            this.vehicle_data.m_price = "";
            this.vehicle_data.gas = "";
            this.vehicle_data.transmission = "";
            this.vehicle_data.index = "";

            this.$modal.hide('u-vehicle');

        },

        vehicle_update() {

            vehicle_update(this.vehicle_data).then((res) => {

                this.$toastr.s(res.brand + ' ' + res.name + ' has been updated');

                this.$set(this.vehicle_list, this.vehicle_data.index, res);

                this.h_u_vehicle();

            }).catch((error) => {

                console.log(error);

            });

        },

        vehicle_delete() {

            vehicle_delete(this.vehicle_data.id).then((res) => {

                this.$toastr.s('Item has been deleted');

                this.h_r_vehicle();

                this.vehicle_list.splice(this.vehicle_data.index, 1);


            }).catch((error) => {


            });

        }

    },

    computed: {

        vehicle_list() {

            return this.$store.getters.vehicle_list;

        },

    },

    created() {

        if(this.vehicle_list.length == 0) {

            vehicle_all().then((res) => {

                this.$store.commit("vehicle_payload", res);

            }).catch((error) => {

                this.$toastr.e(error.error);

            });


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

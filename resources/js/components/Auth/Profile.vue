<template>

    <div id="profile-app">

        <br />
        <br />
        <br />
        <br />
        <br />
        <br />

        <div class="container">

            <div class="row">

                <div class="col-lg-5 col-sm-12">

                  <div class="card" style="width: 18rem;">
                      <p @click="s_avatar()"
                      class="text-primary font-weight-light" style="cursor: pointer">Edit</p>
                      <img v-if="current_user.avatar !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + current_user.avatar" :alt="current_user.fname + ' ' + current_user.lname">
                      <img v-else class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" src="/tools/noavatar.png" alt="Gaano No Image Profile">
                      <hr>
                      <div class="card-body">

                          <p @click="s_profile"
                          class="text-primary font-weight-light" style="cursor: pointer">Edit</p>
                          <p>Name: {{ current_user.fname }} {{ current_user.mname }} {{ current_user.lname }}</p>
                          <p>Birthday: {{ current_user.bday }}</p>
                          <p>Gender: <template v-if="current_user.gender === 1">Male</template> <template v-else>Female</template></p>
                          <p>Phone: {{ current_user.phone }}</p>

                          <hr>


                              <p @click="s_email"
                              class="text-primary font-weight-light" style="cursor: pointer">Edit</p>



                          <p>Email: {{ current_user.email }}</p>
                          <p>Verified: <template v-if="current_user.email_verified_at === null">Not Verified Yet</template><template v-else>Verified</template></p>

                          <hr>
                          <p @click="s_password"
                          class="text-primary font-weight-light" style="cursor: pointer">Edit Password</p>

                          <hr>
                          <p @click="s_u_license" class="text-primary font-weight-light" style="cursor: pointer">Edit License</p>
                          <img v-if="current_user.license !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + current_user.license" :alt="current_user.fname + ' ' + current_user.lname">
                          <img v-else class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" src="/tools/noavatar.png" alt="Gaano No Image Profile">

                          <hr>
                          <p @click="s_u_government" class="text-primary font-weight-light" style="cursor: pointer">Edit Government ID</p>
                          <img v-if="current_user.government_id !== null" class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" :src="'../../storage/' + current_user.government_id" :alt="current_user.fname + ' ' + current_user.lname">
                          <img v-else class="card-img-top shadow-lg p-3 mb-5 bg-white rounded" src="/tools/noavatar.png" alt="Gaano No Image Profile">


                      </div>
                  </div>

                </div>

            </div>

        </div>

        <modal name="update-avatar">

            <form @submit.prevent="avatar_update" enctype="multipart/form-data">

                <div class="container">

                    <p class="h3 text-dark text-center mb-5">Update Avatar</p>

                    <img @click="onRemoveFile" style="height: auto; width: 30%;"
                    class="shadow-lg p-3 mb-5 bg-white rounded img-thumbnail"
                    v-if="avatar" :src="avatar" />

                    <input v-if="uploadReady" ref="fileupload" type="file" @change="onFileChange" />

                    <button type="submit" class="btn btn-dark text-dark bg-transparent btn-small">Edit</button>

                </div>

            </form>

        </modal>

        <modal scrollable
        :height="300"
        :width="600"
        :adaptive="true"
        name="update-profile" @before-open="b_profile_o">

            <div class="container">

              <form @submit.prevent="profile_update" enctype="multipart/form-data">

                  <p class="h3 text-dark text-center mb-5">Update Profile</p>

                  <div class="row mt-3">

                      <div class="col-lg-4 col-sm-12"><input v-model="profile_data.fname"
                      type="text" class="form-control mb-3" placeholder="Firstname" required></div>

                      <div class="col-lg-4 col-sm-12"><input v-model="profile_data.mname"
                      type="text" class="form-control mb-3" placeholder="Middlename(Optional)"></div>

                      <div class="col-lg-4 col-sm-12"><input v-model="profile_data.lname"
                      type="text" class="form-control mb-3" placeholder="Lastname" required></div>

                      <div class="col-lg-4 col-sm-12"><select v-model="profile_data.gender"
                       class="form-control mb-3" required>
                          <option value="">Gender</option>
                          <option value="1">Male</option>
                          <option value="2">Female</option>
                      </select></div>

                      <div class="col-lg-4 col-sm-12"><input v-model="profile_data.bday"
                       type="date" class="form-control mb-3" required></div>

                      <div class="col-lg-4 col-sm-12"><input v-model="profile_data.phone"
                      type="text" class="form-control mb-3" placeholder="Phone" required></div>

                      <div class="col-lg-4 col-sm-12"><button type="submit" class="btn btn-dark text-dark bg-transparent btn-small">
                        Edit</button></div>

                  </div>

              </form>

            </div>

        </modal>

        <modal name="update-email" @before-open="b_email_o">

            <form @submit.prevent="email_update">

               <div class="form-group row">

                   <label for="password" class="col-md-4 col-form-label text-md-right">Email:</label>

                   <div class="col-lg-6">

                       <input type="email" v-model="email"
                       class="form-control" placeholder="Email" required autofocus>

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

        </modal>

        <modal name="update-password">

            <form @submit.prevent="password_update">

                <div class="form-group row">

                    <label for="password" class="col-md-4 col-form-label text-md-right">Current Password:</label>

                    <div class="col-lg-6">

                        <input id="current_password" type="password" v-model="password_data.current_password"
                        class="form-control" placeholder="Current Password" required autofocus>

                    </div>

                </div>

                <div class="form-group row">

                    <label for="password" class="col-md-4 col-form-label text-md-right">Password:</label>

                    <div class="col-lg-6">

                        <input id="password" type="password" v-model="password_data.password"
                        class="form-control" placeholder="Password" required autofocus>

                    </div>

                </div>

                <div class="form-group row">

                    <label for="password" class="col-md-4 col-form-label text-md-right">Password Confirmation:</label>

                    <div class="col-lg-6">

                        <input id="password_confirmation" type="password" v-model="password_data.password_confirmation"
                        class="form-control" placeholder="Password Confirmation" required autofocus>

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

        </modal>

        <modal name="u-government" height="auto" :scrollable="true">

            <div class="card">

                <div class="card-header">
                    <h5 class="text-center">Update {{ current_user.fname }} {{ current_user.lname }}`s
                      Government ID</h5>
                </div>

                <div class="card-body">

                    <form @submit.prevent="credential_update" enctype="multipart/form-data">

                       <div class="form-group row">

                           <label for="avatar" class="col-md-4 col-form-label text-md-right">Government ID:</label>

                           <div class="col-lg-6">

                               <input id="avatar" type="file" @change="on_govern_file_select"
                               accept="image/x-png,image/gif,image/jpeg"
                               class="form-control" required autofocus>

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

        <modal name="u-license" height="auto" :scrollable="true">

            <div class="card">

                <div class="card-header">
                    <h5 class="text-center">Update {{ current_user.fname }} {{ current_user.lname }}`s
                      Driver License</h5>
                </div>

                <div class="card-body">

                    <form @submit.prevent="credential_update" enctype="multipart/form-data">

                       <div class="form-group row">

                           <label for="avatar" class="col-md-4 col-form-label text-md-right">License:</label>

                           <div class="col-lg-6">

                               <input id="avatar" type="file" @change="on_license_file_select"
                               accept="image/x-png,image/gif,image/jpeg"
                               class="form-control" required autofocus>

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

import Utility from '../../mixins/utility';
import {avatar_update} from '../../helpers/profile';
import {profile_update} from '../../helpers/profile';
import {email_update} from '../../helpers/profile';
import {password_update} from '../../helpers/profile';
import {credential_update} from '../../helpers/profile';

export default {

    data() {

        return {

            avatar: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png',

            uploadReady: true,

            avatar_file: null,

            profile_data: {

                fname: null,
                mname: null,
                lname: null,
                gender: "",
                bday: null,
                phone: null,

            },

            email: null,

            password_data: {

                password: null,
                password_confirmation: null,
                current_password: null,

            },

            credentials: {

                government_id: null,
                license: null

            },

        }

    },

    methods: {

        onFileChange(e) {
            const file = e.target.files[0];
            this.avatar_file = e.target.files[0];
            this.avatar = URL.createObjectURL(file);
        },

        onRemoveFile() {
            this.avatar = null;
            this.uploadReady = false
            this.$nextTick(() => {
                this.uploadReady = true
            });
        },

        s_avatar() {

            this.$modal.show('update-avatar');

        },

        h_avatar() {

            this.$modal.hide('update-avatar');

        },

        s_profile() {

            this.$modal.show('update-profile', { profile: this.current_user });

        },

        b_profile_o(event) {

            this.profile_data.fname = event.params.profile.fname;
            this.profile_data.mname = event.params.profile.mname;
            this.profile_data.lname = event.params.profile.lname;
            this.profile_data.gender = event.params.profile.gender;
            this.profile_data.bday = event.params.profile.bday;
            this.profile_data.phone = event.params.profile.phone;

        },

        h_profile() {

            this.$modal.hide('update-profile');

        },

        s_email() {

            this.$modal.show('update-email', { profile: this.current_user.email });

        },

        b_email_o(event) {


            this.email = event.params.profile;

        },

        h_email() {

            this.$modal.hide('update-email');

        },

        s_password() {

            this.$modal.show('update-password');

        },

        h_password() {

            this.$modal.hide('update-password');

        },

        s_u_government() {

            this.$modal.show('u-government');

        },

        h_u_government() {

            this.$modal.hide('u-government');

        },

        on_govern_file_select(e) {

            this.credentials.government_id = e.target.files[0];

        },

        s_u_license() {

            this.$modal.show('u-license');

        },

        h_u_license() {

            this.$modal.hide('u-license');

        },

        on_license_file_select(e) {

            this.credentials.license = e.target.files[0];

        },

        avatar_update() {

            this.$store.dispatch('profile_update');

            avatar_update(this.avatar_file, this.current_user.token).then((res) => {

                this.h_avatar();

                this.$toastr.s(res.user.fname + ' ' + res.user.lname + ' Avatar Updated');

                this.$store.commit("update_profile_info_success", res);

            }).catch((error) => {

                console.log(error);

                this.$store.commit("update_profile_info_failed");

            });

        },

        profile_update() {

            this.$store.dispatch('profile_update');

            profile_update(this.profile_data, this.current_user.token).then((res) => {

                this.$toastr.s(res.user.fname + ' ' + res.user.lname + ' Profile Updated');

                this.$store.commit("update_profile_info_success", res);

                this.$router.push(`/profile/${res.user.fname}-${res.user.lname}`);

            }).catch((error) => {

                console.log(error);

                this.$store.commit("update_profile_info_failed");

            });

        },

        email_update() {

            if(this.email != this.current_user.email) {

                this.$store.dispatch('profile_update');

                email_update(this.email, this.current_user.token).then((res) => {

                    this.h_email();

                    this.$toastr.i(res.user.fname + ' ' + res.user.lname + ' Verify Your New Email!');

                    this.$store.commit("update_profile_info_success", res);

                }).catch((error) => {

                    this.$store.commit("update_profile_info_failed");

                    this.$toastr.e(error.errors.email[0]);

                });

            } else {

                this.$toastr.w("Same Email");

            }

        },

        password_update() {

            this.$store.dispatch('profile_update');

            password_update(this.password_data, this.current_user.token).then((res) => {

                this.$toastr.s(res.user.fname + ' ' + res.user.lname + ' Password Updated');

                this.$store.commit("update_profile_info_success", res);

            }).catch((error) => {

                this.$store.commit("update_profile_info_failed");

                for(let i = 0; i < Object.values(error.errors).length; i++) {

                    this.$toastr.e(Object.values(error.errors)[i][0]);
                }

            });


        },

        credential_update() {

            this.$store.dispatch('profile_update');

            credential_update(this.credentials, this.current_user.token).then((res) => {

                this.$toastr.s(res.user.fname + ' ' + res.user.lname + ' Credentials Updated');

                this.$store.commit("update_profile_info_success", res);

            }).catch((error) => {

                this.$store.commit("update_profile_info_failed");

            });



        },

    },

    computed: {

        current_user() {

            return this.$store.getters.current_user;

        },


    },

    created() {

    },

    destroyed () {

    }

}

</script>

<style lang="scss" scoped>

</style>

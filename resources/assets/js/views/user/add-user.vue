<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Thêm người dùng</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item active">Thên người dùng</li>
                </ol>
            </div>
        </div>

            <form @submit.prevent="updateProfile">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit Profile</h4>
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input class="form-control" type="text" value="" v-model="profileForm.first_name">
                                </div>
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input class="form-control" type="text" value="" v-model="profileForm.last_name">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input class="form-control" type="text" value="" v-model="profileForm.email">
                                </div>
                                <div class="form-group">
                                    <label for="">Date of Birth</label>
                                    <datepicker :bootstrapStyling="true" v-model="profileForm.date_of_birth"></datepicker>
                                </div>
                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <div class="radio radio-info">
                                        <input type="radio" value="male" id="gender_male" v-model="profileForm.gender">
                                        <label for="gender_male"> Male </label>
                                    </div>
                                    <div class="radio radio-success">
                                        <input type="radio" value="female" id="gender_female" v-model="profileForm.gender">
                                        <label for="gender_female"> Female </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Facebook Profile</label>
                                    <input class="form-control" type="text" value="" v-model="profileForm.facebook_profile">
                                </div>
                                <div class="form-group">
                                    <label for="">Twitter Profile</label>
                                    <input class="form-control" type="text" value="" v-model="profileForm.twitter_profile">
                                </div>
                                <div class="form-group">
                                    <label for="">Google Plus Profile</label>
                                    <input class="form-control" type="text" value="" v-model="profileForm.google_plus_profile">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Change Password</h4>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input class="form-control" type="password" value="" v-model="profileForm.password">
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input class="form-control" type="password" value="" v-model="profileForm.password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Tạo user</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </div>
</template>

<script>
    import datepicker from 'vuejs-datepicker'
    import ClickConfirm from 'click-confirm'

    export default {
        components : { datepicker, ClickConfirm },
        data() {
            return {
                passwordForm: new Form({
                }),
                profileForm: new Form({
                    first_name: '',
                    last_name: '',
                    email: '',
                    date_of_birth: '',
                    gender: '',
                    facebook_profile: '',
                    twitter_profile: '',
                    google_plus_profile: '',
                    password: '',
                    password_confirmation: ''
                }, false),
            };
        },
        mounted(){
        },
        methods: {
            updateProfile() {
                this.profileForm.post('/api/add-user').then(response => {
                    console.log(this.profileForm);
                    toastr['success'](response.message);
                }).catch(response => {
                    toastr['error'](response.message);
                });
            }
        }
    }
</script>

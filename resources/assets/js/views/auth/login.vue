<template>
    <section id="wrapper">
        <div class="login-register" style="background-image:url(/images/background/background.jpg);">
            <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" @submit.prevent="submit">
                    <h3 class="box-title m-b-20">Đăng nhập</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="text" name="email" class="form-control" placeholder="Email" v-model="loginForm.email"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" name="password" class="form-control" placeholder="Password" v-model="loginForm.password"> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Đăng nhập</button>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p><router-link to="/password" class="text-info m-l-5"><b>Quên mật khẩu?</b></router-link></p>
                        </div>
                    </div>
                </form>
            </div>
            <guest-footer></guest-footer>
          </div>
        </div>

    </section>
</template>

<script>
    import helper from '../../services/helper'
    import GuestFooter from '../../layouts/guest-footer.vue'

    export default {
        data() {
            return {
                loginForm: {
                    email: '',
                    password: ''
                }
            }
        },
        components: {
            GuestFooter
        },
        mounted(){
        },
        methods: {
            submit(e){
                axios.post('/api/auth/login', this.loginForm).then(response =>  {
                    localStorage.setItem('auth_token',response.data.token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
                    toastr['success'](response.data.message);
                    this.$router.push('/order')
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            }
        }
    }
</script>

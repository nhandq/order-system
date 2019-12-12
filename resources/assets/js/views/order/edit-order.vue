<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Chi tiết đơn</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/order">Đơn hàng</router-link></li>
                    <li class="breadcrumb-item active">Chi tiết đơn</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Thông tin đơn</h4>
                        <form @submit.prevent="updateOrder(orderForm.data.id)">
                            <div class="form-group">
                                <label for="">Visa</label>
                                <input class="form-control" type="text"  v-model="orderForm.data.number_of_visa">
                            </div>
                            <div class="form-group">
                                <label for="">Mục đích</label>
                                <select name="purpose" class="form-control" v-model="orderForm.data.purpose">
                                    <option value="tourist visa">Du lịch</option>
                                    <option value="business visa">Công tác</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Loại visa</label>
                                <select name="process_type" class="form-control" v-model="orderForm.data.process_type">
                                    <option value="normal">bình thường</option>
                                    <option value="urgent">Xử lý nhanh</option>
                                    <option value="supper urgent">Xử lý cấp bách</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày khởi hành</label>
                                <datepicker v-model="orderForm.data.date_of_arrival" @input="formatArrivalDate()"  :bootstrapStyling="true"></datepicker>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày đến</label>
                                <datepicker v-model="orderForm.data.date_of_departure" @input="formatDepartureDate()" :bootstrapStyling="true"></datepicker>
                            </div>
                            <div class="form-group">
                                <label for="">Dịch vụ thủ tục nhanh</label>
                                <div class="radio radio-info">
                                    <input type="radio" value="yes" id="airport_fast_track_y" v-model="orderForm.data.airport_fast_track" :checked="orderForm.data.airport_fast_track === 'yes'">
                                    <label for="airport_fast_track_y"> Có </label>
                                </div>
                                <div class="radio radio-success">
                                    <input type="radio" value="no" id="airport_fast_track_n" v-model="orderForm.data.airport_fast_track" :checked="orderForm.data.airport_fast_track === 'no'">
                                    <label for="airport_fast_track_n"> Không </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Dịch vụ đỗ xe</label>
                                <div class="radio radio-info">
                                    <input type="radio" value="null" id="car_pick_up_n" v-model="orderForm.data.car_pick_up" :checked="orderForm.data.car_pick_up == null">
                                    <label for="car_pick_up_n"> Không </label>
                                </div>
                                <div class="radio radio-success">
                                    <input type="radio" value="4 seat" id="car_pick_up_4" v-model="orderForm.data.car_pick_up" :checked="orderForm.data.car_pick_up === '4 seat'">
                                    <label for="car_pick_up_4"> Xe 4 chỗ </label>
                                </div>
                                <div class="radio radio-success">
                                    <input type="radio" value="7 seat" id="car_pick_up_7" v-model="orderForm.data.car_pick_up" :checked="orderForm.data.car_pick_up === '7 seat'">
                                    <label for="car_pick_up_7"> Xe 7 chỗ </label>
                                </div>
                                <div class="radio radio-success">
                                    <input type="radio" value="16 seat" id="car_pick_up_16" v-model="orderForm.data.car_pick_up" :checked="orderForm.data.car_pick_up === '16 seat'">
                                    <label for="car_pick_up_16"> Xe 16 chỗ </label>
                                </div>
                                <div class="radio radio-success">
                                    <input type="radio" value="24 seat" id="car_pick_up_24" v-model="orderForm.data.car_pick_up" :checked="orderForm.data.car_pick_up === '24 seat'">
                                    <label for="car_pick_up_24"> Xe 24 chỗ </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">updateOrder</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" v-for="each in orderDetailForm">
                    <div class="card-body">
                        <h4 class="card-title">Chi tiết hộ chiếu <u :id="'password-name-' + each.id">{{ each.passport_full_name }} </u></h4>
                        <form @submit.prevent="UpdatePassportDetail(each.id)">
                            <div class="form-group">
                                <label for="">Tên hộ chiếu</label>
                                <input :class="'form-control password-name-' + each.id" value="" v-model="each.passport_full_name">
                            </div>
                            <div class="form-group">
                                <label for="">Giới tính</label>
                                <div class="radio radio-info">
                                    <input type="radio" value="male" :id="'passport_gender_m_' + each.id" v-model="each.passport_gender" :checked="each.passport_gender === 'male'">
                                    <label :for="'passport_gender_m_' + each.id"> Nam </label>
                                </div>
                                <div class="radio radio-success">
                                    <input type="radio" value="female" :id="'passport_gender_fm_' + each.id" v-model="each.passport_gender" :checked="each.passport_gender === 'female'">
                                    <label :for="'passport_gender_fm_' + each.id"> Nữ </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày sinh</label>
                                <datepicker class="form-control" value="" v-model="each.passport_date_of_birth" @input="formatDateOfBirth()" :bootstrapStyling="true"></datepicker>
                            </div>
                            <div class="form-group">
                            <label for="">Quốc tịch</label>
                                <input class="form-control" value="" v-model="each.nationality">
                            </div>
                            <div class="form-group">
                                <label for="">Số hộ chiếu</label>
                                <input class="form-control" value="" v-model="each.passport_number">
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Lưu thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import helper from '../../services/helper'
    import datepicker from 'vuejs-datepicker'

    export default {
        components : { datepicker },
        data() {
            return {
                id: this.$route.params.id,
                orderDetailForm: new Form({
                    passport_full_name : '',
                    passport_gender : '',
                    nationality : '',
                    passport_number : '',
                    passport_date_of_birth : ''
                }),
                orderForm: new Form({
                    number_of_visa: '',
                    process_type: '',
                    purpose: '',
                    status_order: '',
                    airport_arrival: '',
                    process_type: '',
                    is_full_packet_service: '',
                    airport_fast_track: '',
                    car_pick_up: '',
                    date_of_arrival: '',
                    date_of_departure: ''
                }, false)
            };
        },
        mounted(){
            this.getOrderForm();
        },
        methods: {
            getOrderForm() {
                // let url = helper.getFilterURL(this.filterOrderForm);
                axios.get('/api/order/' + this.$route.params.id).then(response => this.orderForm = response.data).then(response => this.orderDetailForm = response.data.children );
            },
            formatArrivalDate: function(){
                var self = this;
                var d = new Date(self.orderForm.date_of_arrival);
                self.orderForm.date_of_arrival =  moment(d).format('YYYY-MM-DD');
            },
            formatDepartureDate: function(){
                var self = this;
                var d = new Date(self.orderForm.date_of_departure);
                self.orderForm.date_of_departure =  moment(d).format('YYYY-MM-DD');
            },
            formatDateOfBirth: function(){
                var self = this;
                var d = new Date(self.orderDetailForm.passport_date_of_birth);
                self.orderDetailForm.passport_date_of_birth =  moment(d).format('YYYY-MM-DD');
            },
            updateOrder(id) {
                axios.put('/api/order/' + id, this.orderForm).then(response => {
                    if (response.data.status) {
                        toastr['success'](response.data.message);
                    } else {
                        toastr['error'](response.data.message);
                    }
                }).catch(response => {
                    toastr['error'](response.data.message);
                });
            },
            UpdatePassportDetail(id) {
                axios.put('/api/order-detail/' + id, this.orderDetailForm).then(response => {
                    if (response.data.status) {
                        toastr['success'](response.data.message);
                    } else {
                        toastr['error'](response.data.message);
                    }
                }).catch(response => {
                    toastr['error'](response.data.message);
                });
            }
        }
    }
</script>

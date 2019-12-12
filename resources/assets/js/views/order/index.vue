<style>
    .table-customize {
        margin: 0;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 0 0 1px #ccc inset;
    }
    .table-customize > thead > tr {
        background-color: #535353;
        border-radius: 3px 3px 0 0;
    }
    .table-customize > thead > tr > th {
        color: #fff;
        border-bottom: none;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 400;
        border: 1px solid rgba(0, 0, 0, 0.2);
    }
    .table-customize > thead > tr > th:first-child {
        border-radius: 3px 0 0 0;
        border-top: 1px solid rgba(0, 0, 0, 0.2);
    }
    .table-customize > thead > tr > th:last-child {
        border-radius: 0 3px 0 0;
    }
    .table-customize > tbody > tr > td {
        vertical-align: middle;
        padding: 15px 14px;
        color: #ccc;
        font-size: 14px;
        color: #000;
        border: 1px solid #ccc;
    }
    .table-customize > tbody > tr > td a {
        text-decoration: none;
    }

    @media (min-width: 320px) and (max-width: 767px) {
    .table-responsive,
    .table-responsive thead,
    .table-responsive tbody,
    .table-responsive th,
    .table-responsive td,
    .table-responsive tr {
        display: block;
    }
    .table-responsive > thead > tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    .table-responsive > tbody > tr {
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
    }
    .table-responsive > tbody > tr:first-child {
        border-radius: 3px 3px 0 0;
        border-top: none;
    }
    .table-responsive > tbody > tr:last-child {
        border-radius: 0 0 3px 3px;
        border-bottom: none;
    }
    .table-responsive > tbody > tr td {
        border: none;
        border-bottom: 1px solid #ccc;
        position: relative;
        padding-left: 30% !important;
        width: 100%;
        overflow: hidden;
    }
    .table-responsive > tbody > tr td:before {
        content: attr(data-title);
        position: absolute;
        top: 15px;
        left: 14px;
        width: 30%;
        padding-right: 10px;
        white-space: nowrap;
        font-size: 14px;
    }
    .table-responsive > tbody > tr td:first-child {
        text-align: left;
    }
    .table-responsive.table-order > tbody > tr:nth-child(-n + 3) > td:first-child {
        padding: 25px 0 25px 30% !important;
        background-position: left 32% center;
    }
    .table-responsive.table-order > tbody > tr:nth-child(-n + 3) > td:first-child span {
        left: 32%;
    }
    }

</style>

<template>
	<div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Đơn hàng</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item active">Đơn hàng</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bộ lọc</h4>

                        <div class="row m-t-40">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Ngày đến</label>
                                    <datepicker v-model="filterOrderForm.date_of_arrival" @input="formatArrivalDate()" @change="getOrders" :bootstrapStyling="true"></datepicker>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Ngày đăng ký</label>
                                    <datepicker v-model="filterOrderForm.date_of_departure" @input="formatDepartureDate()" @change="getOrders" :bootstrapStyling="true"></datepicker>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Trạng thái thanh toán</label>
                                    <select name="status" class="form-control" v-model="filterOrderForm.status_order" @change="getOrders">
                                        <option value="">All</option>
                                        <option value="success">Đã thanh toán</option>
                                        <option value="pending">Chưa thanh toán</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Danh sách đơn hàng</h4>
                        <h6 class="card-subtitle" v-if="orders.total">Total {{orders.total}} result found!</h6>
                        <h6 class="card-subtitle" v-else>No result found!</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-customize table-responsive" v-if="orders.total">
                                <thead>
                                    <tr>
                                        <th>Visa</th>
                                        <th>Mục đích</th>
                                        <th>Sân bay</th>
                                        <th>Thời gian xử lý</th>
                                        <th>Dịch vụ</th>
                                        <th>Thời gian</th>
                                        <th>Chi phí</th>
                                        <th style="width:150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in orders.data">
                                        <td data-title="Visa" v-html="getVisaFormat(order.number_of_visa, order.visa_type, order.applicant)"></td>
                                        <td data-title="Mục đích" v-html="getPurposeFormat(order.purpose)"></td>
                                        <td data-title="Sân bay" v-text="order.airport_arrival"></td>
                                        <td data-title="Tg xử lý" v-html="getProcessTimeFormat(order.process_type)"></td>
                                        <td data-title="Dịch vụ" v-html="getServiceFormat(order.is_full_packet_service, order.airport_fast_track, order.car_pick_up)"></td>
                                        <td data-title="Thời gian" v-html="getTimeFormat(order.date_of_arrival, order.date_of_departure)"></td>
                                        <td data-title="Chi phí" v-text="order.total_money"></td>
                                        <td data-title="Hành động">
                                            <router-link v-bind:to="'/edit-order/' + order.id">
                                            <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Order"><i class="fa fa-edit"></i></button>
                                            </router-link>
                                            <click-confirm yes-class="btn btn-success" no-class="btn btn-danger">
                                                <button class="btn btn-danger btn-sm" @click.prevent="deleteOrder(order.id)" data-toggle="tooltip" title="Delete Order"><i class="fa fa-trash"></i></button>
                                            </click-confirm>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="orders" :limit=3 v-on:pagination-change-page="getOrders"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control" v-model="filterOrderForm.pageLength" @change="getOrders" v-if="orders.total">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import ClickConfirm from 'click-confirm'
    import datepicker from 'vuejs-datepicker'

    export default {
        components : { datepicker, pagination, ClickConfirm },
        data() {
            return {
                orders: {},
                filterOrderForm: {
                    sortBy : 'id',
                    order: 'desc',
                    status: '',
                    title: '',
                    pageLength: 5,
                    date_of_arrival: '',
                    date_of_departure: '',
                    status_order: ''
                }
            }
        },
        mounted() {
            this.getOrders();
        },
        methods: {
            formatArrivalDate: function(){
                var self = this;
                var d = new Date(self.filterOrderForm.date_of_arrival);
                self.filterOrderForm.date_of_arrival =  moment(d).format('YYYY-MM-DD');
            },
            formatDepartureDate: function(){
                var self = this;
                var d = new Date(self.filterOrderForm.date_of_departure);
                self.filterOrderForm.date_of_departure =  moment(d).format('YYYY-MM-DD');
            },
            getOrders(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterOrderForm);
                axios.get('/api/order?page=' + page + url)
                    .then(response => this.orders = response.data );
            },
            getVisaFormat(number_of_visa, visa_type, applicant) {
                return '<p>Số visa: ' + number_of_visa + '</p><p>Loại visa: ' + visa_type + '</p><p>Số người làm đơn: ' + applicant + '</p>';
            },
            getPurposeFormat(purpose) {
                if(purpose == 'tourist visa')
                    return '<p>Du lịch</p>';
                else if(purpose == 'business visa')
                    return '<p>Công tác</p>';
                else if(purpose == 'other')
                    return '<p>Khác</p>';
                else
                    return;
            },
            getProcessTimeFormat(process_type) {
                if(process_type == 'normal')
                    return '<p>Bình thường</p>';
                else if(process_type == 'urgent')
                    return '<p>Gấp</p>';
                else if(process_type == 'supper urgent')
                    return '<p>Khẩn cấp</p>';
                else
                    return;
            },
            getServiceFormat(is_full_packet_service, airport_fast_track, car_pick_up) {
                var html = '';
                if (is_full_packet_service == 'yes') {
                    return '<p>Thủ tục nhanh</p><p>Chỗ đỗ xe sẵn có</p>';
                }
                if (airport_fast_track == 'yes') {
                    html += '<p>Thủ tục nhanh</p>';
                }
                if (car_pick_up == 'yes') {
                    html += '<p>Chỗ đỗ xe sẵn có</p>';
                }
                if (html == '') {
                    html += '<p>Không phát sinh dịch vụ thêm</p>';
                }

                return html;
            },
            getTimeFormat(date_of_arrival, date_of_departure) {
                return '<p>Khởi hành: ' + date_of_departure + '</p><p>Đến: ' + date_of_arrival + '</p>';
            },
            deleteOrder(orderId){
                axios.delete('/api/order/'+orderId).then(response => {
                    toastr['success'](response.data.message);
                    this.getOrders();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            }
        },
        filters: {
            moment(date) {
                return helper.formatDate(date);
            },
            ucword(value) {
                return helper.ucword(value);
            }
        }
    }
</script>

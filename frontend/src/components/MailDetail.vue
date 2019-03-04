<template>
    <div>
        <section class="internal-page-banner-main col-xs-12">
            <!--Header-->
            <div class="jumbotron">
                <i class="fa fa-envelope fa-stack-1x"></i>
                <h2 align="left">Mail List/Detail</h2>
            </div>

            <!--Content-->
            <div class="modal-body row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                            LIST
                        </a>
                        <template v-for="(mailData, index) in mailList">
                            <a v-on:click="showDetail(mailData.uuid)" href="javascript:void(0)" class="list-group-item list-group-item-action">
                                {{mailData.subject}}
                            </a>
                        </template>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-group">
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action active detailTitle">
                            MAIL DETAIL
                        </a>
                    </div>
                    <template v-for="(mailDetail, index) in mailContent">
                        <div class="row">
                        <div class="detailTitle">

                            <!--MAIL FROM-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>MAIL FROM : </span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>{{mailDetail.mail_from}}</span>
                            </div>
                            </div>
                            <div class="clearfix"></div>

                            <!--MAIL TO-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>MAIL TO : </span>
                            </div>
                            <template v-for="(mailTo, index) in mailDetail.mail_to">
                                <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                    <span>{{mailTo}}</span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                    <!--NO DATA-->
                                </div>
                            </template>
                            </div>
                            <div class="clearfix"></div>

                            <!--SUBJECT-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>SUBJECT : </span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>{{mailDetail.subject}}</span>
                            </div>
                            </div>
                            <div class="clearfix"></div>

                            <!--STATUS-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>STATUS : </span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>{{mailDetail.status}}</span>
                            </div>
                            </div>
                            <div class="clearfix"></div>

                            <!--CREATED DATE-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>CREATED DATE : </span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>{{mailDetail.created_date}}</span>
                            </div>
                            </div>
                            <div class="clearfix"></div>

                            <!--SENT AT-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>SENT AT : </span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>{{mailDetail.sent_at}}</span>
                            </div>
                            </div>
                            <div class="clearfix"></div>

                            <!--TEMPLATE-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>TEMPLATE : </span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>{{mailDetail.template}}</span>
                            </div>
                            </div>
                            <div class="clearfix"></div>

                            <!--ATTACHEMENTS-->
                            <div class="col-xs-12 col-md-12 col-xl-12 col-sm-12 boxItem">
                            <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                <span>ATTACHEMENTS : </span>
                            </div>
                            <template v-for="(attachements, index) in mailDetail.attachements">
                                <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                    <span>{{attachements}}</span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-6 col-md-6 col-xl-6 col-sm-6">
                                    <!--NO DATA-->
                                </div>
                            </template>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="container">

            </div>
        </section>
    </div>
</template>
<script>
    import Vue from "vue";
    import {HTTP} from '../http-common';
    import axios from 'axios';
    export default {
        name: 'contact',
        data() {
            return {
                mailList : [],
                mailContent : [],
            }
        },
        beforeMount: function () {

        },
        mounted: function () {
            var self = this;
            self.loadMailDetails();
            // self.showDetail();
            $(".mailContent").hide();
            $(".detailTitle").show();
        },
        methods : {
            loadMailDetails : function() {
                var self = this;
                HTTP.get("/listmail")
                    .then(function (response) {
                        self.mailList = response.data.content;
                    })
                    .catch(function (err) {
                        console.log(err.response.headers);
                        if (err.response.status == 0) {
                            self.error = "Remote server can not be reachable";
                        } else {
                            //redirect to login page if user not authenticated
                            if (err.response.status == 401) {

                            }
                            self.error = err.response.data.message;
                        }
                    });
            },

            showDetail : function (uuid) {
                var self = this;
                var data = {
                    'uuid' : uuid,
                }
                HTTP.post("/showmaildetail", data)
                    .then(function (response) {
                        self.mailContent = response.data.content;
                        if (self.mailContent != '') {
                            $(".mailContent").show();
                        }
                        console.log(self.mailContent);
                    })
                    .catch(function (err) {
                        console.log(err.response.headers);
                        if (err.response.status == 0) {
                            self.error = "Remote server can not be reachable";
                        } else {
                            //redirect to login page if user not authenticated
                            if (err.response.status == 401) {

                            }
                            self.error = err.response.data.message;
                        }
                    });
            },
        },
    }
</script>
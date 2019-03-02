<template>
    <div>
        <section class="internal-page-banner-main col-xs-12">
            <!--Header-->
            <div class="jumbotron">
                <i class="fa fa-envelope fa-stack-1x"></i>
                <h2 align="left">Mail Detail</h2>
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
                    <span>hello</span>
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
            self.showDetail();
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
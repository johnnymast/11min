<template>
    <div class="is-fullwidth">
        <div class="block" v-show="days">
            <p class="digit">{{ days | two_digits }}</p>
            <p class="text">Days</p>
        </div>
        <div class="block">
            <p class="digit">{{ hours | two_digits }}</p>
            <p class="text">Hours</p>
        </div>
        <div class="block">
            <p class="digit">{{ minutes | two_digits }}</p>
            <p class="text">Minutes</p>
        </div>
        <div class="block">
            <p class="digit">{{ seconds | two_digits }}</p>
            <p class="text">Seconds</p>
        </div>
      <!--  <div style="clear: both; width: 100%">&nbsp;</div>-->
        <modal v-if="expired" @close="retireAccount" title="Mailbox expired" body="Your mailbox has expired. You can choose your increase the time with your mailbox or to close it for a new one. Please make your choice.">
            <footer class="modal-card-foot">
                <a class="button is-primary" @click="addTime">Reset time</a>
                <a class="button is-danger" @click="retireAccount">Retire mailbox</a>
            </footer>
        </modal>
        <a class="button is-fullwidth is-large" @click="addTime">INCREASE TIME +10 MINUTES</a>
    </div>
</template>

<script>

    Vue.filter('two_digits', function (value) {
        if(value.toString().length <= 1)
        {
            return "0"+value.toString();
        }
        return value.toString();
    });

    export default {
        props: {
            date: null,
        },
        data() {
            return {
                countdown_interval: null,
                remaining_interval: null,
                now: Math.trunc((new Date()).getTime() / 1000),
                event: this.date
            }
        },
        methods: {
            addTime() {
                axios.get('/add_time').then(response => this.event = response.data.expires_at);
            },
            resetTime() {
                axios.get('/resetTime').then();
            },
            retireAccount() {
                window.location.href = '/retire';
            }
        },
        computed: {
            expired() {
                if ((this.now - this.calculateDate) >= 0) {
                    this.showModal = true;
                    return true;
                }
                return false;
            },
            calculateDate() {
                this.event = Math.trunc(Date.parse(this.event) / 1000);
                return this.event;
            },
            seconds() {
                return (this.calculateDate - this.now) % 60;
            },

            minutes() {
                return Math.trunc((this.calculateDate - this.now) / 60) % 60;
            },

            hours() {
                return Math.trunc((this.calculateDate - this.now) / 60 / 60) % 24;
            },
            days() {
                return Math.trunc((this.calculateDate - this.now) / 60 / 60 / 24);
            }
        },
        mounted() {

            this.remaining_interval = window.setInterval(() => {
                if (this.expired == false)
                    axios.get('/remaining_time').then(response => this.event = response.data.expires_at);
            }, 5000);

            this.countdown_interval = window.setInterval(() => {
                if (this.expired == false)
                    this.now = Math.trunc((new Date()).getTime() / 1000);
            }, 1000);
        }
    }


</script>


<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto+Condensed:400|Roboto:100);

    .block {
        margin: 19px;
        margin-top: 0px;
        float: left;
    }

    .text {
        color: #1abc9c;
        font-size: 20px;
        font-family: 'Roboto Condensed', serif;
        margin-top:10px;
        margin-bottom: 10px;
        text-align: center;
    }

    .digit {
        color: #ecf0f1;
        font-size: 35px;
        font-weight: 700;
        font-family: 'Roboto', serif;
        margin: 10px;
        text-align: center;
        color: #00b89c;
    }
</style>
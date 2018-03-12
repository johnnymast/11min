<template>
    <table class="table is-bordered is-hoverable is-fullwidth">
        <thead>
        <tr>
            <th>From</th>
            <th>Subject</th>
            <th>When</th>
        </tr>
        </thead>
        <tbody>
        <tr class="mail_row" v-for="email in emails" :class="{ unread: email.unread }" @click="readEmail(email)" v-if="emails.length > 0" >
            <td>
                <span class="icon is-small is-hidden-mobile">
                    <i v-if="email.unread" class="fa fa-envelope-o"></i>
                    <i v-else class="fa fa-envelope-open-o"></i>
                </span>
                {{ email.from }}
            </td>
            <td>{{ email.subject}}</td>
            <td>{{ email.when}}</td>
        </tr>
        <tr class="mail_row" v-show="emails.length == 0">
            <td colspan="3" class="text-center"><span class="icon is-small"><i class="fa fa-battery-empty" aria-hidden="true"></i></span>  There are no items in this mailbox (yet)</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
	import saveState from 'vue-save-state';

    export default {
        mixins: [saveState],
        data() {
            return {
                emails: [],
                check_interval: 1000 * 3, /* 3 sec */
                expired: false,
            }
        },
        methods: {
        	getSaveStateConfig() {
				return {
					'cacheKey': 'mailbox'
				}
			},
            readEmail(email) {
                window.location.href = '/email/'+email['msgid'];
            }
        },
        computed: {
            isExpired() {
               return this.expired;
            }
        },
        mounted() {
            var self = this;

            Event.listen('expired', (expired) => {
                this.expired = expired;
            });

            /**
             * Get the initial messages on page load.

             axios.get('/system/messages').then(
             	response => this.emails = response.data
             );
             */

            /**
             * Listen to the donations.channel where
             * we sent events about new donations for this user.
             */
            Echo.private('emails.pipeline')
                .listen('NewEmailEvent', function (e) {
                    self.emails = e.emails;
                });

            Event.fire('mailbox_ready');
        }
    }
</script>

<style>
    .mail_row { cursor: pointer; }
    .mail_row .icon.is-small { line-height: 24px !important; width: auto !important;}
    .mail_row.unread { font-weight: bold; }
    .mail_row .text-center { text-align: center; }
</style>
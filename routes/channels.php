<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::routes(['middleware' => ['web', 'auth:mailboxes']]);

/*
 * Authenticate the user's personal channel...
 */
Broadcast::channel('emails.pipeline',  function () {
    if (true) { // Replace with real ACL
        return true;
    }
});
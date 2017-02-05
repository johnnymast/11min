<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Notifications\ContactRequestMail;
use Illuminate\Notifications\Notifiable;

class ContactController extends Controller
{
    use Notifiable;

    /**
     * @var mixed|string
     */
    public $email = '';


    public function __construct()
    {
        $this->email = config('custom.admin_email');
    }


    /**
     * @param ContactFormRequest $request
     */
    public function store(ContactFormRequest $request)
    {
        $this->notify(new ContactRequestMail($request));
        return \Redirect::route('contact')->with('message', 'Thanks for contacting us!');
    }


    /**
     *
     */
    public function show()
    {
        return view('contact.show');
    }
}

<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\contactRequest;
use App\Mail\Support\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(contactRequest $request)
    {
        $data = $request->validated();

        Mail::to('orderreadystore@gmail.com')->send(new ContactFormMail($data));
        return back()->with('success', 'Your message has been sent successfully!');
    }
}

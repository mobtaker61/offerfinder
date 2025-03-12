<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\Mime\Part\HtmlPart;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\FcmToken;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::orderBy('created_at', 'desc')->get();
        return view('newsletter.index', compact('newsletters'));
    }

    public function create()
    {
        return view('newsletter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required'
        ]);

        Newsletter::create($request->all());

        return redirect()->route('newsletters.index')->with('success', 'Newsletter created successfully.');
    }
    
    public function send(Newsletter $newsletter)
    {
        $subscribers = User::where('newsletter', true)->pluck('email')->toArray();
    
        foreach ($subscribers as $email) {
            Mail::send([], [], function ($message) use ($newsletter, $email) {
                $message->to($email) // ✅ Explicitly setting recipient
                        ->subject($newsletter->subject)
                        ->html($newsletter->content);
            });
        }
    
        $newsletter->update(['sent' => true]);
    
        return redirect()->route('newsletters.index')->with('success', 'Newsletter sent successfully.');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'fcm_token' => 'nullable|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If user exists, update newsletter field to true
            $user->update(['newsletter' => true]);
        } else {
            // If user doesn't exist, create a new user with email and newsletter true
            $user = User::create([
                'name' => 'Guest User',
                'email' => $request->email,
                'password' => bcrypt('guest_password'), // Default password (not used)
                'newsletter' => true
            ]);
        }

        // Save FCM Token (if provided)
        if ($request->filled('fcm_token')) {
            FcmToken::updateOrCreate(
                ['token' => $request->fcm_token],
                ['user_id' => $user->id]
            );
        }

        return back()->with('success', 'You have subscribed to the newsletter and push notifications!');
    }
}

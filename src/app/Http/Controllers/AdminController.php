<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\ShopRepresentative;
use App\Mail\NotificationMail;
use Mail;
use Spatie\Permission\Models\Role;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function admin()
    {
        $user = Auth::user();

        return view('admin.admin', compact('user'));
    }

    public function register(Request $request)
    {
        $password = $request->password;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        $user->roles()->attach(2);

        return redirect()->route('admin.done');
    }

    public function done()
    {
        return view('admin.done');
    }

    public function notificationMail(Request $request)
    {
        $users = User::doesntHave('roles')->get();
        $text = $request->text;

        Mail::to($users)->send(new NotificationMail($text));

        return redirect()->back()->with('message','お知らせメールを送信しました');
    }
}

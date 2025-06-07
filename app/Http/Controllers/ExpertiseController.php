<?php

namespace App\Http\Controllers;

use App\Models\UserExpertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Don't forget to import Log

class ExpertiseController extends Controller
{
    /**
     * نمایش فرم اضافه کردن تخصص.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.add_expertise'); // This returns the view with the form
    }

    public function show()
    {
        $expertises = UserExpertise::all();
        return view('user.expertises', compact('expertises'));
    }


    /**
     * ذخیره تخصص جدید در دیتابیس.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response // Changed return type to Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'required|string|max:255',
        ]);

        UserExpertise::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
        ]);

        return redirect()->route('user.expertise')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد!',
                'title' => 'Success'
            ]
        ]);
    }
}

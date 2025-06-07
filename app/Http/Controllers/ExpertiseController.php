<?php

namespace App\Http\Controllers;

use App\Models\UserExpertise;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    /**
     * نمایش فرم اضافه کردن تخصص.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.add_expertise'); // به view مربوطه ریدایرکت می‌کنیم
    }

    /**
     * ذخیره تخصص جدید در دیتابیس.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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

        return redirect()->route('user.dashboard')->with('success', 'Expertise added successfully!');
    }
}

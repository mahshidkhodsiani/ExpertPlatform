<?php

namespace App\Http\Controllers;

use App\Models\UserExpertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class ExpertiseController extends Controller
{
    /**
     * نمایش فرم اضافه کردن تخصص.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.add_expertise');
    }

    public function show(Request $request)
    {
        $query = UserExpertise::where('user_id', auth()->id());

        // فیلتر بر اساس عنوان
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // فیلتر بر اساس دسته‌بندی
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // لیست دسته‌بندی‌های موجود
        $categories = [
            'web_development' => 'Web Development',
            'mobile_development' => 'Mobile Development',
            'data_science' => 'Data Science',
            // سایر دسته‌بندی‌ها...
        ];

        $expertises = $query->latest()->paginate(10);

        return view('user.expertises', compact('expertises', 'categories'));
    }

    /**
     * ذخیره تخصص جدید در دیتابیس.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse // Changed return type to RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request->all()); // Check all incoming request data

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd('Validation passed!'); // Check if validation is succeeding

        $imagePaths = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile('image' . $i)) {
                $imageFile = $request->file('image' . $i);
                $path = $imageFile->store('expertise_images', 'public');
                $imagePaths['image_path_' . $i] = $path;
            } else {
                $imagePaths['image_path_' . $i] = null;
            }
        }

        // dd($imagePaths); // Check the generated image paths

        UserExpertise::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category,
            'image_path_1' => $imagePaths['image_path_1'],
            'image_path_2' => $imagePaths['image_path_2'],
            'image_path_3' => $imagePaths['image_path_3'],
        ]);

        // dd('Expertise created successfully!'); // Check if creation happened

        return redirect()->route('user.expertise')->with([
            'toast' => [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد!',
                'title' => 'Success'
            ]
        ]);
    }
}

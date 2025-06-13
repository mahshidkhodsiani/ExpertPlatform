<?php

namespace App\Http\Controllers;

use App\Models\UserExpertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Import the Storage facade
use App\Models\Category;

class ExpertiseController extends Controller
{
    /**
     * نمایش فرم اضافه کردن تخصص.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all(); // یا ->orderBy('name')->get()
        return view('user.add_expertise', compact('categories'));
    }


    public function show(Request $request)
    {
        $query = UserExpertise::where('user_id', auth()->id());

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // دریافت دسته‌بندی‌ها از جدول categories
        $categories = Category::pluck('name', 'id')->toArray();

        $expertises = $query->latest()->paginate(10);

        return view('user.expertises', compact('expertises', 'categories'));
    }



    
    public function showAll(Request $request)
    {
        $query = UserExpertise::query()->with('user'); // اضافه کردن with('user') برای رابطه

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $categories = Category::pluck('name', 'id')->toArray();
        $expertises = $query->latest()->paginate(10);

        return view('user.all_expertises', compact('expertises', 'categories'));
    }


    public function showDetails(UserExpertise $expertise)
    {
        return view('user.details', [
            'expertise' => $expertise,
            'user' => $expertise->user // فرض میکنیم رابطه user با expertise تعریف شده است
        ]);
    }




    public function edit(UserExpertise $expertise)
    {
        $categories = [
            // لیست دسته‌بندی‌های شما
        ];

        return view('user.expertise.edit', [
            'expertise' => $expertise,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, UserExpertise $expertise)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'category_id' => 'required|integer',
            // اعتبارسنجی تصاویر اگر نیاز است
        ]);

        $expertise->update($validated);

        return redirect()->route('user.expertise.show')
            ->with('success', 'Expertise updated successfully!');
    }

    public function destroy(ExUserExpertiseertise $expertise)
    {
        // حذف تصاویر مرتبط اگر نیاز است
        $expertise->delete();

        return redirect()->route('user.expertise.show')
            ->with('success', 'Expertise deleted successfully!');
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


        // $request->merge([
        //     'number' => (int) $request->number,
        //     'category' => (int) $request->category,
        // ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'required|integer|exists:categories,id',
            'number' => 'required|string|max:20', // ✅ حالا رشته است
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Example: Allow up to 5MB (5 * 1024 = 5120KB)
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
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
            'number' => $request->number,
            'category_id' =>  $request->category,
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

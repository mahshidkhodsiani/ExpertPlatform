<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\UserExpertise;
use App\Models\Category; // Import Category model

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    public function profile(Request $request) // Make sure to inject Request
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Start with the user's expertises and eager load the category relationship
        $expertisesQuery = $user->expertises()->with('category');

        // Apply search filter if present
        if ($request->filled('search')) {
            $search = $request->input('search');
            $expertisesQuery->where('title', 'like', '%' . $search . '%');
        }

        // Apply category filter if present
        if ($request->filled('category')) {
            $categoryId = $request->input('category');
            $expertisesQuery->where('category_id', $categoryId);
        }

        // Apply pagination
        $expertises = $expertisesQuery->paginate(10); // Change 10 to your desired items per page

        // Get categories for the filter dropdown
        // Assuming your 'categories' table has 'id' and 'name' columns
        $categories = Category::orderBy('name')->pluck('name', 'id')->toArray();

        // Return the view with user, paginated expertises, and categories
        return view('user.profile', compact('user', 'expertises', 'categories'));
    }

    // متد برای نمایش فرم ویرایش (اغلب میتونه همون profile باشه یا یک متد جدا)
    // اگر فرم نمایش و ویرایش در یک صفحه است، نیازی به این متد جداگانه نیست.
    // اما برای clarity، فرض می کنیم یک متد برای ویرایش هم داریم.
    public function editProfile()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('user.edit_profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // اعتبار سنجی اطلاعات ورودی
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'family' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'price' => ['nullable', 'integer', 'min:0'], // تغییر max به min برای قیمت
            'per' => ['required', 'in:h,s'], // اعتبارسنجی مقدار per
            'biography' => ['nullable', 'string', 'max:1000'],
            'introduction' => ['nullable', 'file', 'mimes:mp4,mov,avi', 'max:10240'], // 10MB max
        ]);

        // بروزرسانی اطلاعات کاربر
        $user->name = $request->input('name');
        $user->family = $request->input('family');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->price = $request->input('price');
        $user->biography = $request->input('biography');

        // تنظیم مقادیر perHour و perSession
        $user->perHour = ($request->input('per') === 'h') ? 1 : 0;
        $user->perSession = ($request->input('per') === 's') ? 1 : 0;

        // آپلود ویدیو معرفی
        if ($request->hasFile('introduction')) {
            // حذف فایل قبلی اگر وجود دارد
            if ($user->introduction) {
                Storage::delete('public/' . $user->introduction);
            }

            // ذخیره فایل جدید
            $file = $request->file('introduction');
            $path = $file->store('introductions', 'public');

            // بررسی مدت زمان ویدیو (حداکثر 1 دقیقه)
            try {
                $getID3 = new \getID3;
                $fileInfo = $getID3->analyze($file->getPathname());

                if (isset($fileInfo['playtime_seconds']) && $fileInfo['playtime_seconds'] > 60) {
                    Storage::delete('public/' . $path);
                    return redirect()->back()->with('error', 'Video duration must be 1 minute or less.');
                }

                $user->introduction = $path;
            } catch (\Exception $e) {
                Storage::delete('public/' . $path);
                return redirect()->back()->with('error', 'Could not process video file.');
            }
        }

        // تغییر رمز عبور اگر وارد شده باشد
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Your profile has been updated successfully!');
    }
}

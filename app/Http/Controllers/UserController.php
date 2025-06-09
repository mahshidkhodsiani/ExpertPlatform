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


    // ذخیره تغییرات پروفایل کاربری
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // اعتبار سنجی اطلاعات ورودی
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // ایمیل باید منحصر به فرد باشد به جز برای خود کاربر
            ],
            // اگر فیلدهای دیگری دارید، اینجا اضافه کنید. مثلاً 'phone', 'address'
            'phone' => ['nullable', 'string', 'max:20'], // مثال: فیلد تلفن
            'bio' => ['nullable', 'string', 'max:1000'], // مثال: فیلد بیوگرافی
        ]);

        // بروزرسانی اطلاعات کاربر
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone'); // مطمئن شوید این فیلدها در مدل User شما وجود دارند
        $user->bio = $request->input('bio');

        // اگر فیلد رمز عبور در فرم وجود دارد و کاربر آن را پر کرده است
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' نیاز به فیلد 'password_confirmation' دارد
            ]);
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        // ریدایرکت به صفحه پروفایل با پیام موفقیت
        return redirect()->route('user.profile')->with('success', 'Your profile has been updated successfully!');
    }
}

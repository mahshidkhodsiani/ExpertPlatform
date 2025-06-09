@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- پیام موفقیت --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- نمایش ارورهای ولیدیشن --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            {{-- اگر عکس پروفایل دارید، اینجا نمایش بدید --}}
                            <div class="flex-shrink-0">
                                <img src="{{ asset('path/to/default/profile.jpg') }}" alt="Profile Image"
                                    class="rounded-circle" width="80" height="80">
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <h2 class="mb-1">Hello, {{ $user->name }}!</h2>
                                <p class="text-muted mb-0">Manage your profile and expertises here.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">My Profile Information</h4>
                        {{-- دکمه ای برای ویرایش اطلاعات پروفایل --}}
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Name:</strong>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong>
                                <p>{{ $user->email }}</p>
                            </div>
                            {{-- فیلدهای اختیاری دیگر --}}
                            @if ($user->phone)
                                <div class="col-md-6 mb-3">
                                    <strong>Phone:</strong>
                                    <p>{{ $user->phone }}</p>
                                </div>
                            @endif
                            @if ($user->bio)
                                <div class="col-12 mb-3">
                                    <strong>Bio:</strong>
                                    <p>{{ $user->bio }}</p>
                                </div>
                            @endif
                            <div class="col-12">
                                <strong>Member Since:</strong>
                                <p>{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">My Expertises</h4>
                        <a href="{{ route('user.expertise') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Add New Expertise
                        </a>
                    </div>

                    {{-- فیلترهای جستجو --}}
                    <div class="card-body border-bottom">
                        <form action="{{ route('user.profile') }}" method="GET"> {{-- فرم جستجو به همین صفحه ارسال شود --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="search" class="form-label">Search by Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search"
                                            placeholder="Enter expertise title..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="category" class="form-label">Filter by Category</label>
                                    <select class="form-select" id="category" name="category"
                                        onchange="this.form.submit()">
                                        <option value="">All Categories</option>
                                        {{-- $categories باید از کنترلر به ویو ارسال شود --}}
                                        @foreach ($categories as $id => $name)
                                            {{-- اینجا $id و $name استفاده می کنیم --}}
                                            <option value="{{ $id }}"
                                                {{ request('category') == $id ? 'selected' : '' }}>
                                                {{ $name }} {{-- نام دسته بندی را نمایش می دهیم --}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        @if ($expertises->isEmpty())
                            <div class="alert alert-info text-center" role="alert">
                                You haven't added any expertises yet. Click "Add New Expertise" to get started!
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped border">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expertises as $index => $expertise)
                                            <tr>
                                                <th scope="row">{{ $expertises->firstItem() + $index }}</th>
                                                {{-- برای شماره ردیف صحیح در pagination --}}
                                                <td>{{ $expertise->title }}</td>
                                                <td>
                                                    @if ($expertise->category)
                                                        {{-- مطمئن شوید که دسته بندی وجود دارد --}}
                                                        <span class="badge bg-info text-dark">
                                                            {{ $expertise->category->name }} {{-- نام دسته بندی را نمایش می دهیم --}}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{ $expertise->created_at->format('M d, Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.expertise.show', $expertise->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-1" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('user.expertise.edit', $expertise->id) }}"
                                                        class="btn btn-outline-warning btn-sm me-1" title="Edit Expertise">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.expertise.destroy', $expertise->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            title="Delete Expertise"
                                                            onclick="return confirm('Are you sure you want to delete this expertise? This action cannot be undone.');">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $expertises->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Your Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone (Optional)</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio (Optional)</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <hr>
                        <p class="text-muted">Leave password fields blank if you don't want to change it.</p>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

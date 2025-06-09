@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <h2 class="mb-1">List of all expertises</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">My Expertises</h4>
                        <a href="{{ route('user.expertise') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Add New Expertise
                        </a>
                    </div>

                    <!-- فیلترهای جستجو -->
                    <div class="card-body border-bottom">
                        <form action="{{ route('user.expertise.show') }}" method="GET">
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
                                        @foreach ($categories as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ request('category') == $value ? 'selected' : '' }}>
                                                {{ ucwords(str_replace('_', ' ', $label)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        {{-- Success message display --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

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
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $expertise->title }}</td>
                                                <td>
                                                    <span class="badge bg-info text-dark">
                                                        {{ ucwords(str_replace('_', ' ', $expertise->category)) }}
                                                    </span>
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

                                <!-- Pagination -->
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
@endsection

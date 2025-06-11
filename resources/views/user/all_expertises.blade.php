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
                                <h2 class="mb-1">List of All Expertises</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0 text-primary">All Expertises</h4>
                    </div>

                    <!-- فیلترهای جستجو -->
                    <div class="card-body border-bottom">
                        <form action="{{ route('expertises.show') }}" method="GET">
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
                        @if ($expertises->isEmpty())
                            <div class="alert alert-info text-center" role="alert">
                                No expertises found.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped border">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User</th>
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
                                                <td>{{ $expertise->user->name }}</td>
                                                <td>{{ $expertise->title }}</td>
                                                <td>
                                                    <span class="badge bg-info text-dark">
                                                        @isset($categories[$expertise->category_id])
                                                            {{ $categories[$expertise->category_id] }}
                                                        @else
                                                            Unknown
                                                        @endisset
                                                    </span>
                                                </td>
                                                <td>{{ $expertise->created_at->format('M d, Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.expertise.details', $expertise->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-1" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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

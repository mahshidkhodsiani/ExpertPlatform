@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Edit Expertise</h4>
                            <a href="{{ route('user.expertise.show') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('user.expertise.update', $expertise->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $expertise->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('category_id', $expertise->category_id) == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="body" class="form-label">Description</label>
                                <textarea class="form-control" id="body" name="body" rows="5">{{ old('body', $expertise->body) }}</textarea>
                            </div>

                            <!-- بخش تصاویر (در صورت نیاز) -->
                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div class="row">
                                    @if ($expertise->image_path_1)
                                        <div class="col-md-4 mb-2">
                                            <img src="{{ asset('storage/' . $expertise->image_path_1) }}"
                                                class="img-thumbnail" width="100%">
                                        </div>
                                    @endif
                                    <!-- تکرار برای image_path_2 و image_path_3 -->
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Update Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Expertise</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

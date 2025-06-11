@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Expertise Details</h4>
                            <a href="{{ route('user.expertise.show') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <a href="{{ route('user.profile', $expertise->user->id) }}" class="text-decoration-none">
                                    <i class="fas fa-user me-2"></i>{{ $expertise->user->name }}
                                </a>
                            </h5>

                            <div class="d-flex align-items-center mb-3">
                                <h2 class="mb-0 me-3">{{ $expertise->title }}</h2>
                                <span class="badge bg-info text-dark fs-6">
                                    {{ $categories[$expertise->category_id] ?? 'Unknown' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <p class="text-muted mb-1"><small>Created:
                                        {{ $expertise->created_at->format('M d, Y') }}</small></p>
                                <p class="text-muted"><small>Last Updated:
                                        {{ $expertise->updated_at->format('M d, Y') }}</small></p>
                            </div>
                        </div>

                        <!-- بخش نمایش تصاویر -->
                        @if ($expertise->image_path_1 || $expertise->image_path_2 || $expertise->image_path_3)
                            <div class="border-top pt-3 mb-3">
                                <h5 class="mb-3">Images</h5>
                                <div class="row g-3">
                                    @if ($expertise->image_path_1)
                                        <div class="col-md-4">
                                            <div class="image-container">
                                                <img src="{{ asset('storage/' . $expertise->image_path_1) }}"
                                                    alt="Expertise Image 1" class="img-fluid rounded">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($expertise->image_path_2)
                                        <div class="col-md-4">
                                            <div class="image-container">
                                                <img src="{{ asset('storage/' . $expertise->image_path_2) }}"
                                                    alt="Expertise Image 2" class="img-fluid rounded">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($expertise->image_path_3)
                                        <div class="col-md-4">
                                            <div class="image-container">
                                                <img src="{{ asset('storage/' . $expertise->image_path_3) }}"
                                                    alt="Expertise Image 3" class="img-fluid rounded">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="border-top pt-3">
                            <h5 class="mb-3">Description</h5>
                            <p class="lead">{{ $expertise->body ?? 'No description provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .image-container {
            position: relative;
            padding-bottom: 100%;
            /* نسبت تصویر مربعی */
            overflow: hidden;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

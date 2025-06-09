@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <h2 class="mb-1">Add new Expertise to my profile</h2>
                            </div>
                      
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Add New Expertise</h5>
                    </div>
                    <div class="card-body">


                        <form action="{{ route('user.expertise.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="body" class="form-label">Description</label>
                                <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                 <label for="number" class="form-label">My number</label>
                                <input type="number" class="form-control" id="number" name="number" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select a category</option>
                                    <option value="web_development">Web Development</option>
                                    <option value="mobile_development">Mobile Development</option>
                                    <option value="data_science">Data Science</option>
                                    <option value="artificial_intelligence">Artificial Intelligence</option>
                                    <option value="cybersecurity">Cybersecurity</option>
                                    <option value="cloud_computing">Cloud Computing</option>
                                    <option value="devops">DevOps</option>
                                    <option value="ui_ux_design">UI/UX Design</option>
                                    <option value="digital_marketing">Digital Marketing</option>
                                    <option value="content_writing">Content Writing</option>
                                    <option value="project_management">Project Management</option>
                                    <option value="financial_analysis">Financial Analysis</option>
                                    <option value="human_resources">Human Resources</option>
                                    <option value="legal_services">Legal Services</option>
                                    <option value="healthcare">Healthcare</option>
                                    <option value="education">Education</option>
                                    <option value="sales">Sales</option>
                                    <option value="customer_service">Customer Service</option>
                                    <option value="business_consulting">Business Consulting</option>
                                    <option value="graphic_design">Graphic Design</option>
                                    <option value="video_editing">Video Editing</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image1" class="form-label">Image 1 (Optional)</label>
                                <input type="file" class="form-control" id="image1" name="image1" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="image2" class="form-label">Image 2 (Optional)</label>
                                <input type="file" class="form-control" id="image2" name="image2" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="image3" class="form-label">Image 3 (Optional)</label>
                                <input type="file" class="form-control" id="image3" name="image3" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary">Save Expertise</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

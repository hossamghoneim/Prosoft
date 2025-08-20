@extends('partials.dashboard.master')

@section('title', __('Create Solution Hero Section'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Create Solution Hero Section') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('dashboard.solution-hero-sections.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="submitted-form" action="{{ route('dashboard.solution-hero-sections.store') }}" method="POST" data-redirection-url="{{ route('dashboard.solution-hero-sections.index') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solution_id">{{ __('Solution') }} <span class="text-danger">*</span></label>
                                        <select class="form-control @error('solution_id') is-invalid @enderror" id="solution_id" name="solution_id" required>
                                            <option value="">{{ __('Select Solution') }}</option>
                                            @foreach($solutions as $solution)
                                                <option value="{{ $solution->id }}" {{ old('solution_id') == $solution->id ? 'selected' : '' }}>
                                                    {{ $solution->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('solution_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="button_text">{{ __('Button Text') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text') }}" required>
                                        @error('button_text')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="button_url">{{ __('Button URL') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('button_url') is-invalid @enderror" id="button_url" name="button_url" value="{{ old('button_url') }}" required>
                                        @error('button_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="video_url">{{ __('Video') }} <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" accept="video/*" required>
                                @error('video_url')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="fas fa-save"></i> {{ __('Create') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Category</div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($category_data->id) ?  route('category.store','id='. $category_data->id) : route('category.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="perent_id" class="col-md-4 col-form-label text-md-right">Perent Id</label>
                            <div class="col-md-6">
                                <select class="form-control @error('perent_id') is-invalid @enderror" id="perent_id" name="perent_id" value="{{ old('perent_id') }}">
                                    <option value="0">Select Perent Category</option>
                                    @foreach ($category as $ca)
                                    <option value="{{ $ca->id }}" @if($ca->id == old('perent_id', isset($category_data->perent_id)?$category_data->perent_id:''))
                                        selected="selected"
                                        @endif>{{ $ca->name }}</option>
                                    @endforeach
                                </select>
                                @error('perent_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($category_data->name)? $category_data->name : old('name') }}" autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" value="{{ old('status') }}">
                                    <option value="Active" @if('Active' == old('status', isset($category_data->status)?$category_data->status:''))
                                        selected="selected"
                                        @endif>Active</option>
                                    <option value="Inactive" @if('Inactive' == old('status', isset($category_data->status)?$category_data->status:''))
                                        selected="selected"
                                        @endif>Inactive</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $btn }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="mx-5">
    <div class="card" style="padding-bottom: 10px;">
        <div class="card-header p-0">
            <div class="col-md-6 heading" style="float: left"><h2> Category</h2></div>
            <div class="col-md-6 heading-link heading-link-all" style="float: right;text-align: right;">
                <a class="btn btn-success" href="{{ url('category/create') }}" > Create</a>
            </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card-body">
            <!--<div class="table-responsive">-->
            <table class="table table-striped table-bordered dt-responsive nowrap" id="category_data">
                <thead>
                    <tr>
                        <th>Name </th>
                        <th>Parent Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
            <!--</div>-->
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/category.js') }}"></script>
@endsection
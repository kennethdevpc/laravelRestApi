@extends('layouts.app')

@section('template_title')
    Create Researcher
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('warning'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Researcher</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('researchers.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('researcher.formNew')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

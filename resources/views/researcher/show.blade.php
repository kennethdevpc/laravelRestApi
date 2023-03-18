@extends('layouts.app')

@section('template_title')
    {{ $researcher->name ?? 'Show Researcher' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Researcher</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('researchers.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>name:</strong>
                            {{ $researcher->name }}
                        </div>
                        <div class="form-group">
                            <strong>familyName:</strong>
                            {{ $researcher->familyName }}
                        </div>

                        <div class="form-group">
                            <strong>email:</strong>
                            {{ $researcher->email }}
                        </div>

                        <div class="form-group">
                            <strong>keywords:</strong>

                            @foreach ($researcher->keywords as $researchery)
                                <ul>
                                    <li>
                                        {{ $researchery }}
                                    </li>
                                </ul>

                            @endforeach
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

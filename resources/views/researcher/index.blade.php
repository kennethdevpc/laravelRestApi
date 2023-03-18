@extends('layouts.app')

@section('template_title')
    Researcher
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Researcher') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('researchers.create') }}" class="btn btn-primary btn-sm float-right"
                                   data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>No</th>

                                    <th>Nombre</th>
                                    <th>name</th>
                                    <th>familyName</th>
                                    <th>keywords</th>
                                    <th>email</th>

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($researchers as $researcher)
                                    <tr>
                                        <td>{{ ++$i }}</td>

                                        <td>
                                            @foreach ($researcher->keywords as $researchery)
                                                <ul>
                                                    <li>
                                                        {{ $researchery }}
                                                    </li>
                                                </ul>

                                            @endforeach

                                        </td>
                                        <td>
                                            {{$researcher->name}}
                                        </td>
                                        <td>
                                            {{$researcher->familyName}}
                                        </td>

                                        <td>
                                            {{$researcher->email}}
                                        </td>


                                        <td>
                                            <form action="{{ route('researchers.destroy',$researcher->id) }}"
                                                  method="POST">
                                                <a class="btn btn-sm btn-primary "
                                                   href="{{ route('researchers.show',$researcher->id) }}"><i
                                                        class="fa fa-fw fa-eye"></i> Show</a>
                                                <a class="btn btn-sm btn-success"
                                                   href="{{ route('researchers.edit',$researcher->id) }}"><i
                                                        class="fa fa-fw fa-edit"></i> Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="fa fa-fw fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        @foreach ($links as $link)
                            <div class="float-right">
                                @if($link->label=='Next &raquo;'||$link->label =='&laquo; Previous')
                                @else
                                    <a href="{{ route('documents',$link->label) }}"
                                       class="btn btn-primary btn-sm float-right"
                                       data-placement="left">
                                        {{$link->label}}
                                    </a>
                                @endif

                            </div>
                        @endforeach

                    </div>

                </div>



            </div>
        </div>
    </div>
@endsection

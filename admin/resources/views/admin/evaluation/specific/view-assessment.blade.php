@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('evaluations.index')}}">All Assessment</a></li>
                <li class="breadcrumb-item"><a href="{{route('evaluations.search', ['assessmentTypeID' => $assessmentTypeSearch->id])}}">{{$assessmentTypeSearch->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$assessor->firstname}} {{$assessor->lastname}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$assessor->lastname}}, {{$assessor->firstname}} {{$assessor->middlename}}</h1>
            <blockquote class="blockquote">
                <p class="mb-0">{{$assessmentTypeSearch->name}}</p>
            </blockquote>
            @if ($role)
                @if ($role_all)
                @foreach ($role as $roles)
                    @foreach ($role_all as $roleCount)
                        @if ($roles->id == $roleCount->assessorRoleID)
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h3 class="text-center">Role: {{$roles->name}}</h3>
                                        <table id="employee-datatables-{{$roles->id}}" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="50%">Competency</th>
                                                    <th width="25%">Weight - Level</th>
                                                    <th width="25%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assessmentEvaluation as $item)
                                                    @foreach ($competency as $competencyItem)
                                                        @foreach ($level as $levelItem)
                                                            @if ($roles->id == $item->assessorRoleID && $competencyItem->id == $item->competencyID && $levelItem->id == $item->givenLevelID)  
                                                                <tr>
                                                                    <td>{{$competencyItem->name}}</td>
                                                                    <td>{{$levelItem->weight}} / {{$levelItem->name}}</td>
                                                                    <td><div style = "display: flex;"><a style = "float: right;" href = "delete/{{$item->id}}"><div class = "btn-danger btn">DELETE</div></a></div></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>   
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
                @else
                    <p>No Assessment Found.</p>
                @endif
                
            @else
                <p>No Assessment Found.</p>
            @endif
        </div>
    </div>
</div>


@endsection

@section('scripts')

@if ($role)
    @if ($role_all)
        @foreach ($role as $roles)
            @foreach ($role_all as $roleCount)
                @if ($roles->id == $roleCount->assessorRoleID)
                    <script>
                        $(document).ready(function() {
                            $('#employee-datatables-{{$roles->id}}').DataTable();
                        });
                    </script>
                @endif
            @endforeach
        @endforeach
    @endif
@endif

@endsection
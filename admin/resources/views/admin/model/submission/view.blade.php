@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('models.submissions.index')}}">Model Submissions</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$orderModel->roleName}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$group->name}} - {{$orderModel->roleName}}</h1>
            <blockquote class="blockquote">
                <p class="mb-0">Ticket ID: <b>{{$orderModel->ticketID}}</b><br>
                Sender: @if($employee == null)
                <b>N/A</b>
                @else
                    <b>{{$employee->employeeID}}</b> - {{$employee->firstname}} {{$employee->lastname}}
                @endif</p>
            </blockquote>

            @if($orderModelCompetency)
                @if($competencyType)
                    @foreach($competencyType as $division)
                        <div class="card">
                            <h3 class="card-header text-center">{{$division->name}}</h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-head-bg-primary">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th scope="col" style="width:60%">Competency</th>
                                                <th scope="col" style="width:40%">Target Proficiency</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($competency as $item)
                                                @foreach ($orderModelCompetency as $row)
                                                    @foreach ($level as $target)
                                                        @if($row->competencyID == $item->id && $division->id == $row->competencyTypeID && $row->targetProficiencyID == $target->id)
                                                            <tr>
                                                                <td>{{$item->name}}</td>
                                                                <td>{{$target->weight}} | {{$target->name}}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <p class="card-text">{{$division->definition}}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No data Available</p>
                @endif
            @else
                <p>No data Available</p>
            @endif
            <br>
        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection
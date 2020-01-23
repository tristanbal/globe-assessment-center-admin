@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('completionTrackers.index')}}">Completion Tracker</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$group->name}}</li>
        </ol>
    </nav>
    <h1 class="text-uppercase ">Completion Tracker</h1> 
    <form action="{{route('completionTrackers.groups.view.generate', ['groupID' => $group->id])}}" method="GET">
            <h3 class="">Summary</h3>
        <div class="row">
            <div class="col-md-8">    
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="all-groups-summary" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Roles</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div class="selectgroup selectgroup-pills">
                                    @foreach ($modelBasis as $rolesView)
                                        @foreach ($role as $roleItem)
                                            @if ($rolesView->roleID == $roleItem->id)
                                                <tr>
                                                    <td>{{$roleItem->name}}</td>
                                                    <td>
                                                        <div style = "display: flex;">
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="roleselect[]" value="{{ $roleItem->id}}" class="selectgroup-input" >
                                                                <span class="selectgroup-button">Click to Select</span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Completion Tracker Generation</h3>
                        <p>Click a role to add it to the selected completion tracker summary.</p>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </form>
                    <form action="{{route('completionTrackers.groups.view.generate', ['groupID' => $group->id])}}" method="GET">
                        <input type="text" name="roleselect" value="N/A" hidden>
                        <button class="btn btn-primary" type="submit">Select All</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#all-groups-summary').DataTable();
        });
        $(document).ready(function() {
            $('#all-employee').DataTable();
        });
        
    </script>
@endsection
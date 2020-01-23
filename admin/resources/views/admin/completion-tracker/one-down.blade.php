@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('completionTracker.index')}}">Completion Tracker</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$group->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Completion Tracker</h1>
            
            <div class="table-responsive">
                <table id="all-employee" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $divisionItem)
                            <tr>
                                <td>{{$divisionItem->name}}</td>
                                <td><div style = "display: flex;"> <a style = "float: left;" href = "evaluation/view/{{$divisionItem->id}}"><div class = "btn-success btn">VIEW</div></a>
                                    <a style = "float: left;" href = "evaluation/view/{{$divisionItem->id}}"><div class = "btn-info btn">DIVISIONS</div></a>
                                    
                                </div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#assessment-type-datatables').DataTable();
        });
        $(document).ready(function() {
            $('#all-employee').DataTable();
        });
        
    </script>
@endsection
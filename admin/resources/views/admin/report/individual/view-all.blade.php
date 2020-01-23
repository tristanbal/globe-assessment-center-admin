@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('reports.view')}}">Invidual Gap Analysis</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$group->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$group->name}} Employees</h1>
            {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#selectedModal">
              Selected
            </button> --}}
            <br><br>
            <div class="table-responsive">
                <table id="view-all" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>Employee ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selected</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('filtered.employees')}}">
                @csrf
                <div class="modal-body" id="selectedTable">
                    <table>
                        <thead>
                            <tr>
                                <th>employee ID</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('inc.settings')

@endsection

@section('scripts')
@include('inc.settingScript')
<script type="text/javascript">
    $(document).ready(function() {
         $('#view-all').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('reports.ajaxdata',['id'=>$id])}}",
            "columns":[
                // { 
                //     data: "id",                   
                //     "render": function ( data, type, row ) {
                //         var employeeID = row.employeeID;
                //         var firstname = row.firstname+' '+row.lastname;
                //         var check  = '<input type="checkbox" name="" class="chk" onchange="check(this, '+employeeID+')" value="'+row.id+'">'; 
                //         return check;
                //     }
                // },
                { data: "employeeID"},
                { data: "firstname"},
                { data: "lastname"},
                { data: "email"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var employeeID = row.employeeID;
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "{{url("admin/report/individual/employee")}}/'+row.id+'"><div class = "btn-info btn">VIEW</div></a>'; 
                        return view;
                    }
                }
                
            ]
         });
    });
</script>

<script type="text/javascript">
    function check(elem, id, firstname)
    {
        var table = document.getElementById("selectedTable");
        // var filteredButton = document.getElementById("filteredbutton");

        var ctr = $('.chk:checked').length;

        if(elem.checked)
        {
            table.innerHTML +=  "<tr id='"+ctr+"'>"+
                                "<td>"+id+"</td>"+
                                "<td><input type='text' name='selected[]' hidden value='"+id+"'></td>"+
                                "</tr>";
            // filteredButton.disabled = false;
        }
    }
</script>
@endsection
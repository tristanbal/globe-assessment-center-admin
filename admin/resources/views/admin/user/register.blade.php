@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Register Users</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Register Users</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'UsersController@store'))}}
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Rights:</label>
                    <select id="rightsDropdown" class="form-control dropdown-right" name="rightsDropdown" style="width:100%;" required>
                        @if(count($right) > 0)
                            <option value = "" disabled selected>Select a User</option>
    
                                @foreach($right as $row)
                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No User found</option>
                        @endif
                    </select>

                    

                    <div  id = "employeesDropdownDiv">
                        <label>Employee:</label>
                        <select id="test2" class="form-control dropdown-employee" name="employeesDropdown" style="width:100%;" >
                            @if(count($employee) > 0)
                                <option value = "" disabled selected>Select a Employee</option>
        
                                    @foreach($employee as $row)
                                        <option value = "{{$row->employeeID}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
                                    @endforeach
                            @else
                                <option value = "" disabled selected>No Employee found</option>
                            @endif
                        </select>
                    </div>
                    <div  id = "emailDiv">
                        <br>
                        <label for="email" class="placeholder">Email</label>
                        <input id="email" name="email" type="email" class="form-control" >
                        <small id="email" class="form-text text-muted">Please inputa valid email.</small>
                        
                    </div>

                    <label for="password" class=" left-align">{{ __('Password') }}</label>
                    <input id="password" type="password" class=" validate browser-default constantInputField  form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <label for="password-confirm" class="left-align">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control validate browser-default constantInputField " name="password_confirmation" required>
                    <br><br>
                    <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                    <button class=" btn btn-success " type="submit">Add</button>
                </div>
            </div>
        </div>
        
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.dropdown-right').select2();
        }); 
        $(document).ready(function() {
            $('.dropdown-employee').select2();
        }); 
    </script>

<script>
    $(document).ready(function() {
        $("#emailDiv").hide();
        $('#rightsDropdown').on('change', function() {
            if($('#rightsDropdown').val()=="1") {
                $("#employeesDropdownDiv").show();
                $("#emailDiv").hide();
            }
            if($('#rightsDropdown').val()=="2" || $('#rightsDropdown').val()=="3") {
                $("#employeesDropdownDiv").hide();
                $("#emailDiv").show();
            }
        });
    });
</script>
@endsection
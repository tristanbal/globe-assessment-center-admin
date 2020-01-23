@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Competency Library Uploader</h1>
            <form action="{{ url('/admin/uploader/library/import') }}" method="post" enctype="multipart/form-data" >
                @csrf
            
                <div>
                        <div class = "blockquote">REMINDERS: Take note of the required column arrangement. Header should not be included in the CSV file.</div>
                    
                </div>
                <div class="table-responsive">
                    <table id="intervention-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Group</th>
                                <th>Division</th>    
                                <th>Department</th>
                                <th>Section</th>
                                <th>Employee ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Name Suffix</th>
                                <th>Role</th>
                                <th>Band</th>
                                <th>Supervisor ID</th>
                                <th>E-mail</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Human Resources</td>
                                    <td>Globe University</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>10003622</td>
                                    <td>CASTANO</td>
                                    <td>DANNY</td>
                                    <td>GURA</td>
                                    <td>N/A</td>
                                    <td>Learning Manager</td>
                                    <td>Band C</td>
                                    <td>10005309</td>
                                    <td>dgcastano@globe.com.ph</td>
                                    <td>N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <hr>
                <br>
                <div class = "levelThreeFontSize grey-text text-darken-1">UPLOADER</div>
                <input type="file" name="import_file" />
                <button class="btn globeDarkBlueBackgroundColor">Import File</button>
                <br>
                <br>
            </form>
        </div>
    </div>
</div>
@endsection

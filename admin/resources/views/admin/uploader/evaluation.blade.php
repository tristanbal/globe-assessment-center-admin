@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Model Uploader</h1>
            <form action="{{ url('/admin/uploader/evaluation/migrate') }}" method="post" enctype="multipart/form-data" >
                @csrf
            
                <div>
                    <div class = "blockquote">REMINDERS: Take note of the required column arrangement. Header should not be included in the CSV file.</div>
                    
                </div>
                <div class="table-responsive">
                    <table id="intervention-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Assessee</th>
                                <th>Assessor</th>    
                                <th>Competency</th>
                                <th>GivelLevelID</th>
                                <th>TargetLevelID</th>
                                <th>WeightedScore</th>
                                <th>Role Name</th>
                                <th>Competency Type</th>
                                <th>Original Created Timestamp</th>
                                <th>Original Updated Timestamp</th>
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

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Competency-Intervention Uploader</h1>
            <form action="{{ url('/admin/uploader/intervention/import') }}" method="post" enctype="multipart/form-data" >
                @csrf
            
                <div>
                        <div class = "blockquote">REMINDERS: Take note of the required column arrangement. Header should not be included in the CSV file.</div>
                    
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

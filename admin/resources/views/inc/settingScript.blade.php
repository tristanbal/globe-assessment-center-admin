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

<script type="text/javascript">

    $(document).ready(function() {
        var max_fields      = {{count($assessmentTypes)}}; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="col-md-7" id="first'+x+'"> <div class="form-group form-floating-label"> <select class="form-control input-border-bottom" id="selectFloatingLabel" name="assessmentType[]" required=""> <option value="">&nbsp;@foreach($assessmentTypes as $assessmentType) <option value="{{$assessmentType->id}}">{{$assessmentType->name}}</option> @endforeach </select> <label for="selectFloatingLabel" class="placeholder">Choose your assessment type.</label> </div> </div> <div class="col-md-3" id="second'+x+'"> <div class="form-group form-floating-label"> <input id="inputFloatingLabel" name="percentage[]" type="text" class="form-control input-border-bottom" required=""> <label for="inputFloatingLabel" class="placeholder">Percentage</label> </div> </div> <div class="col-md-1" id="third'+x+'"> <a href="#" class="remove_field btn btn-danger btn-sm">x</a> </div></div>'); //add input box
            }
        });
        
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); 
            $("#first"+x+"").remove(); 
            $("#second"+x+"").remove(); 
            $("#third"+x+"").remove(); 
            x--;
        })
    });

    var selected, desc;
    var gapSettingName = {
        @foreach($gapanalysisSettings as $gapanalysisSetting)
        '{{$gapanalysisSetting->id}}' :     '<div class="form-group">'+
                                                '<label for="largeInput">Description:</label>'+
                                                '<textarea class="form-control" id="largeInput" disabled="" style="color: black; background-color: #FFF !important;" rows="3">{{strToUpper($gapanalysisSetting->description)}}</textarea>'+
                                            '</div>'+

                                            '<br>'+
                                            '<div class="card">'+
                                                '<div class="card-body">'+
                                                    
                                                '<h5><i class="fa fa-info-circle" aria-hidden="true"></i> Note: In generating report, gap computation is based on the percentage allowance of:'+

                                                    '@foreach($gapSettingsAssessmentTypes as $gapSettingsAssessmentType)'+
                                                        '@if($gapSettingsAssessmentType->gapAnalysisSettingID == $gapanalysisSetting->id)'+
                                                            '@foreach($assessmentTypes as $assessmentType)'+
                                                                '@if($assessmentType->id == $gapSettingsAssessmentType->assessmentTypeID)'+
                                                                '<br>'+
                                                                    '{{$gapSettingsAssessmentType->percentAssigned}}% for {{$assessmentType->name}}'+
                                                                '@endif'+
                                                            '@endforeach'+
                                                        '@endif'+
                                                    '@endforeach'+
                                                    
                                                '</h5>'+
                                                '</div>'+
                                            '</div>',
        @endforeach 
    };
        
    $('#selectFloatingLabel2').change(function() {
        selected = $(this).val();
        desc = gapSettingName[selected];
        $('#description').html(desc);
    });

</script>
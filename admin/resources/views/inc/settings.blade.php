<!-- Custom template | don't include it in your project! -->
	<div class="custom-template">
		<div class="title">Settings</div>
		<div class="custom-content">
			<div class="switcher">
				<div class="switch-block">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
	                  <li class="nav-item">
	                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Setting Customization</a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Add New Setting</a>
	                  </li>
	                </ul>
					<div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{route('gapanalysis.settings.active')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="selectFloatingLabel2">Select Your Assessment Setting</label>
                                        <select class="form-control form-control" name="activeSetting" id="selectFloatingLabel2">
                                            <option disabled="" value="">&nbsp;</option>
                                            @foreach($gapanalysisSettings as $gapanalysisSetting)
                                                @if($gapanalysisSetting->is_active == 1)
                                                    <option value="{{$gapanalysisSetting->id}}" selected="">{{$gapanalysisSetting->name}}</option>
                                                @else
                                                    <option value="{{$gapanalysisSetting->id}}">{{$gapanalysisSetting->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    {{-- <h6>DESCRIPTION:</h6> --}}
                                    <div id="description">
                                        @foreach($gapanalysisSettings as $gapanalysisSetting)
                                            @if($gapanalysisSetting->is_active == 1)
	                                            <div class="form-group">
													<label for="largeInput">Description:</label>
													<textarea class="form-control" id="largeInput" disabled="" style="color: black; background-color: #FFF !important;" rows="3">{{strToUpper($gapanalysisSetting->description)}}</textarea>
												</div>
                                            @endif
                                        @endforeach
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                
                                            <h5><i class="fa fa-info-circle" aria-hidden="true"></i> Note: In generating report, gap computation is based on the percentage allowance of:

                                            @foreach($gapSettings as $gapSetting)
                                                @foreach($gapSettingsAssessmentTypes as $gapSettingsAssessmentType)
                                                    @if($gapSettingsAssessmentType->gapAnalysisSettingID == $gapSetting->id && $gapSetting->is_active == 1)
                                                        @foreach($assessmentTypes as $assessmentType)
                                                            @if($assessmentType->id == $gapSettingsAssessmentType->assessmentTypeID)
                                                            <br>
                                                                {{$gapSettingsAssessmentType->percentAssigned}}% for {{$assessmentType->name}}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endforeach
                                                
                                            </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col text-center">
                                        <button class="btn btn-info" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <br>
                        <form method="POST" action="{{route('gapanalysis.settings.create')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Name</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Type in the name of your assessment setting." aria-label="name" name="name" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Description</span>
                                    </div>
                                    <textarea class="form-control" placeholder="Describe the functionality of your assessment setting." name="description" aria-label="With textarea"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        
                        <h5 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Note: To add another assessment type kindly click the plus sign
                        </h5>
                        <br>

                        <div class="row input_fields_wrap">
                            <div class="col-md-7">
                                <div class="form-group form-floating-label">
                                    <select class="form-control input-border-bottom" id="selectFloatingLabel" name="assessmentType[]" required="">
                                        <option value="">&nbsp;</option>
                                        @foreach($assessmentTypes as $assessmentType)
                                        <option value="{{$assessmentType->id}}">{{$assessmentType->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="selectFloatingLabel" class="placeholder">Choose your assessment type.</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group form-floating-label">
                                    <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" name="percentage[]" required="">
                                    <label for="inputFloatingLabel" class="placeholder">Percentage</label>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <button class="add_field_button btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="col text-center">
                            <button class="btn btn-info" type="submit">Save</button>
                        </div>

                        </form>
                    </div>
                </div>
				</div>
			</div>
		</div>
		<div class="custom-toggle">
			<i class="flaticon-settings"></i>
		</div>
	</div>

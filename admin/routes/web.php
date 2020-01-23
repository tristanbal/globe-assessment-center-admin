<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/index',function () {
    return view('index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

//Manual generated routes
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/uploader/masterlist', 'UploaderMasterlistController@showUploaderForm')->name('uploader.masterlist');
Route::post('/admin/uploader/masterlist/import', 'UploaderMasterlistController@import')->name('uploader.masterlist.import');

Route::get('/admin/uploader/library', 'UploaderLibraryController@showUploaderForm')->name('uploader.library');
Route::post('/admin/uploader/library/import', 'UploaderLibraryController@import')->name('uploader.library.import');

Route::get('/admin/uploader/intervention', 'UploaderInterventionController@showUploaderForm')->name('uploader.intervention');
Route::post('/admin/uploader/intervention/import', 'UploaderInterventionController@import')->name('uploader.intervention.import');

Route::get('/admin/uploader/model', 'UploaderModelController@showUploaderForm')->name('uploader.model');
Route::post('/admin/uploader/model/import', 'UploaderModelController@import')->name('uploader.model.import');

Route::get('/admin/uploader/evaluation', 'OldDatabaseMigratorController@showUploaderForm')->name('migrator.evaluation');
Route::post('/admin/uploader/evaluation/migrate', 'OldDatabaseMigratorController@import')->name('migrator.evaluation.import');

Route::get('/admin/assessment-type','AssessmentTypeController@index')->name('assessmentTypes.index');
Route::get('/admin/assessment-type/add','AssessmentTypeController@create')->name('assessmentTypes.create');
Route::get('/admin/assessment-type/view/{id}','AssessmentTypeController@show');
Route::get('/admin/assessment-type/edit/{id}','AssessmentTypeController@edit');
Route::get('/admin/assessment-type/delete/{id}','AssessmentTypeController@destroy');
Route::get('/admin/assessment-type/ajax','AssessmentTypeController@getAll')->name('assessmentTypes.ajaxdata');

Route::get('/admin/training','TrainingController@index')->name('training.index');
Route::get('/admin/training/add','TrainingController@create')->name('training.create');
Route::get('/admin/training/view/{id}','TrainingController@show');
Route::get('/admin/training/edit/{id}','TrainingController@edit');
Route::get('/admin/training/delete/{id}','TrainingController@destroy');
Route::get('/admin/training/ajax','TrainingController@getAll')->name('training.ajaxdata');

Route::get('/admin/relationship-type','RelationshipController@index')->name('relationshipTypes.index');
Route::get('/admin/relationship-type/add','RelationshipController@create')->name('relationshipTypes.create');
Route::get('/admin/relationship-type/view/{id}','RelationshipController@show');
Route::get('/admin/relationship-type/edit/{id}','RelationshipController@edit');
Route::get('/admin/relationship-type/delete/{id}','RelationshipController@destroy');
Route::get('/admin/relationship-type/ajax','RelationshipController@getAll')->name('relationshipTypes.ajaxdata');

Route::get('/admin/band','BandController@index')->name('bands.index');
Route::get('/admin/band/add','BandController@create')->name('bands.create');
Route::get('/admin/band/view/{id}','BandController@show');
Route::get('/admin/band/edit/{id}','BandController@edit');
Route::get('/admin/band/delete/{id}','BandController@destroy');
Route::get('/admin/band/ajax','BandController@getAll')->name('bands.ajaxdata');

Route::get('/admin/role','RoleController@index')->name('roles.index');
Route::get('/admin/role/add','RoleController@create')->name('roles.create');
Route::get('/admin/role/view/{id}','RoleController@show');
Route::get('/admin/role/edit/{id}','RoleController@edit');
Route::get('/admin/role/delete/{id}','RoleController@destroy');
Route::get('/admin/role/ajax','RoleController@getAll')->name('roles.ajaxdata');

Route::get('/admin/job','JobController@index')->name('jobs.index');
Route::get('/admin/job/add','JobController@create')->name('jobs.create');
Route::get('/admin/job/view/{id}','JobController@show');
Route::get('/admin/job/edit/{id}','JobController@edit');
Route::get('/admin/job/delete/{id}','JobController@destroy');
Route::get('/admin/job/ajax','JobController@getAll')->name('jobs.ajaxdata');

Route::get('/admin/group','GroupController@index')->name('groups.index');
Route::get('/admin/group/add','GroupController@create')->name('groups.create');
Route::get('/admin/group/view/{id}','GroupController@show');
Route::get('/admin/group/edit/{id}','GroupController@edit');
Route::get('/admin/group/delete/{id}','GroupController@destroy');
Route::get('/admin/group/ajax','GroupController@getAll')->name('groups.ajaxdata');

Route::get('/admin/cluster','ClusterController@index')->name('clusters.index');
Route::get('/admin/cluster/add','ClusterController@create')->name('clusters.create');
Route::get('/admin/cluster/view/{id}','ClusterController@show');
Route::get('/admin/cluster/edit/{id}','ClusterController@edit');
Route::get('/admin/cluster/delete/{id}','ClusterController@destroy');
Route::get('/admin/cluster/ajax','ClusterController@getAll')->name('clusters.ajaxdata');

Route::get('/admin/division','DivisionController@index')->name('divisions.index');
Route::get('/admin/division/add','DivisionController@create')->name('divisions.create');
Route::get('/admin/division/view/{id}','DivisionController@show');
Route::get('/admin/division/edit/{id}','DivisionController@edit');
Route::get('/admin/division/delete/{id}','DivisionController@destroy');
Route::get('/admin/division/ajax','DivisionController@getAll')->name('divisions.ajaxdata');

Route::get('/admin/user','UsersController@index')->name('users.index');
Route::get('/admin/user/add','UsersController@create')->name('users.create');
Route::get('/admin/user/view/{id}','UsersController@show');
Route::get('/admin/user/edit/{id}','UsersController@edit');
Route::get('/admin/user/delete/{id}','UsersController@destroy');
Route::get('/admin/user/ajax','UsersController@getAll')->name('users.ajaxdata');

Route::get('/admin/subcluster','SubclusterController@index')->name('subclusters.index');
Route::get('/admin/subcluster/add','SubclusterController@create')->name('subclusters.create');
Route::get('/admin/subcluster/view/{id}','SubclusterController@show');
Route::get('/admin/subcluster/edit/{id}','SubclusterController@edit');
Route::get('/admin/subcluster/delete/{id}','SubclusterController@destroy');
Route::get('/admin/subcluster/ajax','SubclusterController@getAll')->name('subclusters.ajaxdata');

Route::get('/admin/competency-type','CompetencyTypeController@index')->name('competencyTypes.index');
Route::get('/admin/competency-type/add','CompetencyTypeController@create')->name('competencyTypes.create');
Route::get('/admin/competency-type/view/{id}','CompetencyTypeController@show');
Route::get('/admin/competency-type/edit/{id}','CompetencyTypeController@edit');
Route::get('/admin/competency-type/delete/{id}','CompetencyTypeController@destroy');
Route::get('/admin/competency-type/ajax','CompetencyTypeController@getAll')->name('competencyTypes.ajaxdata');

Route::get('/admin/level','LevelController@index')->name('levels.index');
Route::get('/admin/level/add','LevelController@create')->name('levels.create');
Route::get('/admin/level/view/{id}','LevelController@show');
Route::get('/admin/level/edit/{id}','LevelController@edit');
Route::get('/admin/level/delete/{id}','LevelController@destroy');
Route::get('/admin/level/ajax','LevelController@getAll')->name('levels.ajaxdata');

Route::get('/admin/competency','CompetencyController@index')->name('competencies.index');
Route::get('/admin/competency/add','CompetencyController@create')->name('competencies.create');
Route::get('/admin/competency/view/{id}','CompetencyController@show');
Route::get('/admin/competency/edit/{id}','CompetencyController@edit');
Route::get('/admin/competency/delete/{id}','CompetencyController@destroy');
Route::get('/admin/competency/ajax','CompetencyController@getAll')->name('competencies.ajaxdata');

Route::get('/admin/talent-segment','TalentSegmentController@index')->name('talentSegments.index');
Route::get('/admin/talent-segment/add','TalentSegmentController@create')->name('talentSegments.create');
Route::get('/admin/talent-segment/view/{id}','TalentSegmentController@show');
Route::get('/admin/talent-segment/edit/{id}','TalentSegmentController@edit');
Route::get('/admin/talent-segment/delete/{id}','TalentSegmentController@destroy');
Route::get('/admin/talent-segment/ajax','TalentSegmentController@getAll')->name('talentSegments.ajaxdata');

Route::get('/admin/proficiency','ProficiencyController@index')->name('proficiencies.index');
Route::get('/admin/proficiency/add','ProficiencyController@create')->name('proficiencies.create');
Route::get('/admin/proficiency/view/{id}','ProficiencyController@show');
Route::get('/admin/proficiency/edit/{id}','ProficiencyController@edit');
Route::get('/admin/proficiency/delete/{id}','ProficiencyController@destroy');
Route::get('/admin/proficiency/ajax','ProficiencyController@getAll')->name('proficiencies.ajaxdata');

Route::get('/admin/model/submission','OrderModelController@index')->name('models.submissions.index');
Route::get('/admin/model/submission/approve/{id}','OrderModelController@show')->name('models.submissions.approve');
Route::post('/admin/model/submission/approve/not-approve/{id}','OrderModelController@notAccept')->name('models.submissions.approve.not-accept');
Route::get('/admin/model/submission/approved/ajax','OrderModelController@getApproved')->name('models.submissions.approved.ajax');
Route::get('/admin/model/submission/pending-approval/ajax','OrderModelController@getPendingApproval')->name('models.submissions.pending-approval.ajax');
Route::get('/admin/model/submission/not-approved/ajax','OrderModelController@getNotApproved')->name('models.submissions.not-approved.ajax');

Route::get('/admin/employee-relationship','EmployeeRelationshipController@index')->name('employee-relationships.index');
Route::get('/admin/employee-relationship/add','EmployeeRelationshipController@create')->name('employee-relationships.create');
Route::get('/admin/employee-relationship/view/{id}','EmployeeRelationshipController@show');
Route::get('/admin/employee-relationship/edit/{id}','EmployeeRelationshipController@edit');
Route::get('/admin/employee-relationship/delete/{id}','EmployeeRelationshipController@destroy');
Route::get('/admin/employee-relationship/ajax','EmployeeRelationshipController@getAll')->name('employee-relationships.ajaxdata');

Route::get('/admin/employee-relationship/search/{employeeID}/{takerID}/{relationshipID}/{id}/view','EmployeeRelationshipController@showSearch')->name('employee-relationships.search.show');
Route::get('/admin/employee-relationship/search/{employeeID}/{takerID}/{relationshipID}/{id}/edit','EmployeeRelationshipController@editSearch')->name('employee-relationships.search.edit');
Route::get('/admin/employee-relationship/search/{employeeID}/{takerID}/{relationshipID}/{id}/update','EmployeeRelationshipController@updateSearch')->name('employee-relationships.search.update');
Route::get('/admin/employee-relationship/search/{employeeID}/{takerID}/{relationshipID}/{id}/delete','EmployeeRelationshipController@destroySearch')->name('employee-relationships.search.destroy');
Route::post('/admin/employee-relationship/search/','EmployeeRelationshipController@searchEmployee')->name('employee-relationships.search');
Route::get('/admin/employee-relationship/search/{employeeID}/{taker}/{relationshipID}','EmployeeRelationshipController@searchResult')->name('employee-relationships.search.index');
Route::get('/admin/employee-relationship/search/add','EmployeeRelationshipController@create')->name('employee-relationships.search.create');


Route::get('/admin/employee','EmployeeDataController@index')->name('employees.index');
Route::get('/admin/employee/add','EmployeeDataController@create')->name('employees.create');
Route::get('/admin/employee/view/{id}','EmployeeDataController@show');
Route::get('/admin/employee/edit/{id}','EmployeeDataController@edit')->name('employees.edit');
Route::get('/admin/employee/delete/{id}','EmployeeDataController@destroy')->name('employees.delete');
Route::get('/admin/employee/ajax','EmployeeDataController@getAll')->name('employees.ajaxdata');

Route::get('/admin/intervention','InterventionController@index')->name('interventions.index');
Route::get('/admin/intervention/add','InterventionController@create')->name('interventions.create');
Route::get('/admin/intervention/view/{id}','InterventionController@show');
Route::get('/admin/intervention/edit/{id}','InterventionController@edit');
Route::get('/admin/intervention/delete/{id}','InterventionController@destroy');
Route::get('/admin/intervention/ajax','InterventionController@getAll')->name('interventions.ajaxdata');

Route::get('/admin/evaluation/employee/ajax/','EvaluationController@getAllEmployee')->name('evaluations.employee.ajaxdata');
Route::get('/admin/evaluation/assessment/ajax/{id}','EvaluationController@getAssessmentSearch')->name('evaluations.assessment.ajaxdata');
Route::get('/admin/evaluation','EvaluationController@index')->name('evaluations.index');
Route::get('/admin/evaluation/employee','EvaluationController@assessmentIndividual')->name('evaluations.employee');
Route::get('/admin/evaluation/employee/{employeeID}','EvaluationController@evaluationEmployeeView')->name('evaluations.employee.view');
Route::get('/admin/evaluation/{assessmentTypeID}','EvaluationController@assessmentSearch')->name('evaluations.search');
Route::get('/admin/evaluation/view/{employeeID}','EvaluationController@evaluationSpecificView')->name('evaluations.search.employee');


Route::get('/admin/evaluation/add','EvaluationController@create')->name('evaluations.create');
//Route::get('/admin/evaluation/view/{id}','EvaluationController@show');
Route::get('/admin/evaluation/edit/{id}','EvaluationController@edit');
Route::get('/admin/evaluation/delete/{id}','EvaluationController@destroy');
Route::get('/admin/evaluation/ajax','EvaluationController@getAll')->name('evaluations.ajaxdata');

Route::get('/admin/assessment/specific/{id}/{employeeID}','AssessmentController@update')->name('assessments.specific.update');
Route::post('/admin/assessment/specific/{employeeID}/version-update','AssessmentController@changeVersion')->name('assessments.specific.versioning');

Route::get('/admin/completion-tracker/','CompletionTrackerController@index')->name('completionTrackers.index');
Route::get('/admin/completion-tracker/{groupID}','CompletionTrackerController@oneDown')->name('completionTrackers.oneDown');
Route::get('/admin/completion-tracker/{groupID}/view/generate','CompletionTrackerController@groupPerRoleSummaryTrack')->name('completionTrackers.groups.view.generate');
Route::get('/admin/completion-tracker/{groupID}/view','CompletionTrackerController@groupPerRoleSummary')->name('completionTrackers.groups.view');
Route::get('/admin/completion-tracker/{groupID}/view/generate/export','CompletionTrackerController@export')->name('completionTrackers.export');
Route::get('/admin/completion-tracker/{groupID}/view/generate/export/breakdown','CompletionTrackerController@breakdown')->name('completionTrackers.export.breakdown');

Route::get('/admin/target-source','TargetSourceController@index')->name('targetSources.index');
Route::get('/admin/target-source/add','TargetSourceController@create')->name('targetSources.create');
Route::get('/admin/target-source/view/{id}','TargetSourceController@show');
Route::get('/admin/target-source/edit/{id}','TargetSourceController@edit');
Route::get('/admin/target-source/delete/{id}','TargetSourceController@destroy');
Route::get('/admin/target-source/ajax','TargetSourceController@getAll')->name('targetSources.ajaxdata');

Route::get('/admin/competency-role-target','CompetencyPerRoleTargetController@index')->name('competencyRoleTargets.index');
Route::get('/admin/competency-role-target/add','CompetencyPerRoleTargetController@create')->name('competencyRoleTargets.create');
Route::get('/admin/competency-role-target/view/{id}','CompetencyPerRoleTargetController@show');
Route::get('/admin/competency-role-target/edit/{id}','CompetencyPerRoleTargetController@edit');
Route::get('/admin/competency-role-target/delete/{id}','CompetencyPerRoleTargetController@destroy');
Route::get('/admin/competency-role-target/ajax','CompetencyPerRoleTargetController@getAll')->name('competencyRoleTargets.ajaxdata');

Route::get('/admin/report/view-employee-per-group', 'ReportController@viewEmployeePerGroup')->name('reports.view');
Route::get('/admin/report/individual/view-all/{id}', 'ReportController@viewAll');
Route::get('/admin/report/individual/employee/{id}', 'ReportController@reportEmployeeView')->name('report.employee.view');
Route::get('/admin/report/ajax/{id}','ReportController@getEmployeePerGroup')->name('reports.ajaxdata');
Route::post('/admin/report/individual/filtered-employees', 'ReportController@filteredEmployees')->name('filtered.employees');

Route::post('/admin/gapanalysis-settings/create', 'GapanalysisController@create')->name('gapanalysis.settings.create');
Route::post('/admin/gapanalysis-settings/update', 'GapanalysisController@update')->name('gapanalysis.settings.active');

Route::get('/admin/report/group/view-all-groups', 'ReportController@viewAllGroups')->name('reports.group.view');
Route::get('/admin/report/group/view-groups-per-role/{groupID}', 'ReportController@viewGroupsPerRole');
Route::post('/admin/report/group/filtered-roles', 'ReportController@filteredRoles')->name('filteredRoles');

Route::get('/admin/model','ListOfCompetenciesPerRoleController@index')->name('listOfCompetenciesPerRoles.index');
Route::get('/admin/model/add','ListOfCompetenciesPerRoleController@create')->name('listOfCompetenciesPerRoles.create');
Route::get('/admin/model/view/{groupID}/{roleID}','ListOfCompetenciesPerRoleController@show');
Route::get('/admin/model/edit/{groupID}/{roleID}','ListOfCompetenciesPerRoleController@edit');
Route::get('/admin/model/edit/{groupID}/{roleID}/add','ListOfCompetenciesPerRoleController@storeCompetency')->name('listOfCompetenciesPerRoles.edit.add.competency');
Route::get('/admin/model/delete/{groupID}/{roleID}','ListOfCompetenciesPerRoleController@destroy');
Route::get('/admin/model/ajax','ListOfCompetenciesPerRoleController@getAll')->name('listOfCompetenciesPerRoles.ajaxdata');

Route::get('/admin/report/group/viewRole/{id}', 'ReportController@viewRole');


Route::get('/admin/data-extract','DataExtractorController@index')->name('data-extract.index');
Route::get('/admin/data-extract/competency-library/summary','DataExtractorController@competencyLibrary')->name('data-extract.competency-library');
Route::get('/admin/data-extract/masterlist/summary','DataExtractorController@masterlist')->name('data-extract.masterlist');
Route::get('/admin/data-extract/model/summary','DataExtractorController@model')->name('data-extract.model');
Route::get('/admin/data-extract/evaluation/raw-data','DataExtractorController@evaluationRawData')->name('data-extract.evaluation-raw-data');


Route::get('/admin/evaluation-competency/delete/{id}','EvaluationCompetencyController@destroy')->name('evaluationCompetencies.destroy');

Route::get('/admin/group-gap-analysis-setting','GroupsPerGapAnalysisSettingController@index')->name('groupsPerGapAnalysisSettings.index');
Route::get('/admin/group-gap-analysis-setting/add','GroupsPerGapAnalysisSettingController@create')->name('groupsPerGapAnalysisSettings.create');
Route::get('/admin/group-gap-analysis-setting/view/{id}','GroupsPerGapAnalysisSettingController@show');
Route::get('/admin/group-gap-analysis-setting/edit/{id}','GroupsPerGapAnalysisSettingController@edit')->name('groupsPerGapAnalysisSettings.edit');
Route::get('/admin/group-gap-analysis-setting/delete/{id}','GroupsPerGapAnalysisSettingController@destroy')->name('groupsPerGapAnalysisSettings.delete');
//Route::get('/admin/group-gap-analysis-setting/ajax','GroupsPerGapAnalysisSettingController@getAll')->name('groupsPerGapAnalysisSettings.ajaxdata');

Route::get('/admin/group-gap-analysis-setting-role','GroupsPerGapAnalysisSettingRoleController@index')->name('groupsPerGapAnalysisSettingRoles.index');
Route::get('/admin/group-gap-analysis-setting-role/add','GroupsPerGapAnalysisSettingRoleController@create')->name('groupsPerGapAnalysisSettingRoles.create');
Route::get('/admin/group-gap-analysis-setting-role/view/{id}','GroupsPerGapAnalysisSettingRoleController@show');
Route::get('/admin/group-gap-analysis-setting-role/edit/{id}','GroupsPerGapAnalysisSettingRoleController@edit')->name('groupsPerGapAnalysisSettingRoles.edit');
Route::get('/admin/group-gap-analysis-setting-role/delete/{id}','GroupsPerGapAnalysisSettingRoleController@destroy')->name('groupsPerGapAnalysisSettingRoles.delete');

Route::get('/admin/completion-tracker-assignment','CompletionTrackerAssignmentController@index')->name('completionTrackerAssignments.index');
Route::get('/admin/completion-tracker-assignment/add','CompletionTrackerAssignmentController@create')->name('completionTrackerAssignments.create');
Route::get('/admin/completion-tracker-assignment/view/{id}','CompletionTrackerAssignmentController@show');
Route::get('/admin/completion-tracker-assignment/edit/{id}','CompletionTrackerAssignmentController@edit')->name('completionTrackerAssignments.edit');
Route::get('/admin/completion-tracker-assignment/delete/{id}','CompletionTrackerAssignmentController@destroy')->name('completionTrackerAssignments.delete');

});


//Resources Routes
Route::resources([
    'apTypes'=> 'AssessmentTypeController',
    'relTypes'=> 'RelationshipController',
    'employee' => 'EmployeeDataController',
    'cluster' => 'ClusterController',
    'subcluster' => 'SubclusterController',
    'group' => 'GroupController',
    'division' => 'DivisionController',
    'job' => 'JobController',
    'role' => 'RoleController',
    'band' => 'BandController',
    'level' => 'LevelController',
    'proficiency' => 'ProficiencyController',
    'competency' => 'CompetencyController',
    'competencyType' => 'CompetencyTypeController',
    'competencyRoleTarget' => 'CompetencyPerRoleTargetController',
    'listOfCompetenciesPerRole' => 'ListOfCompetenciesPerRoleController',
    'evaluation' => 'EvaluationController',
    'evaluationCompetency' => 'EvaluationCompetencyController',
    'orderModel' => 'OrderModelController',
    'user' => 'UsersController',
    'talentSegment' => 'TalentSegmentController',
    'targetSource' => 'TargetSourceController',
    'uploaderMasterlist' => 'UploaderMasterlistController',
    'uploaderModel' => 'UploaderModelController',
    'trainings' => 'TrainingController',
    'employee-relationship' => 'EmployeeRelationshipController',
    'intervention' => 'InterventionController',
    'assessment' => 'AssessmentController',
    'completionTracker' => 'CompletionTrackerController',
    'groupsPerGapAnalysisSetting' => 'GroupsPerGapAnalysisSettingController',
    'groupsPerGapAnalysisSettingRole' => 'GroupsPerGapAnalysisSettingRoleController',
    'completionTrackerAssignments' => 'CompletionTrackerAssignmentController',
    'overallTracker' => 'OverallTrackerController'
]);

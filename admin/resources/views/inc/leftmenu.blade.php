<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      
      <ul class="nav nav-primary">
        <li class="nav-item">
          <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Home</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="dashboard">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('home')}}">
                  <span class="sub-item">Dashboard 1</span>
                </a>
              </li>
              <li>
                <a href="">
                  <span class="sub-item">Dashboard 2</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Components</h4>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#base">
            <i class="icon-people"></i>
            <p>Employee</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="base">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('employees.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('employees.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#sidebarLayouts">
            <i class="icon-user"></i>
            <p>User</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="sidebarLayouts">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('users.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('users.create')}}">
                  <span class="sub-item">Register</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#forms">
            <i class="icon-globe"></i>
            <p>Group</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="forms">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('groups.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('groups.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#tables">
            <i class="icon-globe"></i>
            <p>Division</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="tables">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('divisions.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('divisions.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#maps">
            <i class="icon-notebook"></i>
            <p>Role</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="maps">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('roles.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('roles.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#charts">
            <i class="icon-briefcase"></i>
            <p>Job</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="charts">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('jobs.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('jobs.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#bands">
            <i class="far fa-chart-bar"></i>
            <p>Band</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="bands">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('bands.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('bands.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#intervention">
            <i class="far fa-chart-bar"></i>
            <p>Intervention</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="intervention">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('interventions.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('interventions.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{route('training.index')}}">
            <i class="icon-cloud-upload"></i>
            <p>Training</p>
          </a>
        </li>
        

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Evaluations</h4>
        </li>
        <li class="nav-item">
          <a href="{{route('evaluations.index')}}">
            <i class="far fa-chart-bar"></i>
            <p>All Evaluations</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('completionTrackers.index')}}">
            <i class="far fa-chart-bar"></i>
            <p>Completion Tracker</p>
          </a>
        </li>


        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Assessments</h4>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#AssessmentType">
            <i class="far fa-chart-bar"></i>
            <p>Assessment Type</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="AssessmentType">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('assessmentTypes.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('assessmentTypes.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#EmployeeRelationship">
            <i class="fas fa-desktop"></i>
            <p>Employee Relationship</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="EmployeeRelationship">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('employee-relationships.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('employee-relationships.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        
        <li class="nav-item">
          <a data-toggle="collapse" href="#RelationshipType">
            <i class="fas fa-chart-bar"></i>
            <p>Relationship Type</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="RelationshipType">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('relationshipTypes.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('relationshipTypes.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        
        
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Models</h4>
        </li>
        <li class="nav-item">
          <a href="{{route('listOfCompetenciesPerRoles.index')}}">
            <i class="icon-login"></i>
            <p>All Models</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('models.submissions.index')}}">
            <i class="icon-login"></i>
            <p>Submissions</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="https://globeuniversity.globe.com.ph/assessment-model/">
            <i class="fas fa-desktop"></i>
            <p>Model Builder</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="widgets.html">
            <i class="icon-cloud-upload"></i>
            <p>Uploader</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Competencies</h4>
        </li>

        <li class="nav-item">
          <a data-toggle="collapse" href="#Cluster">
            <i class="icon-layers"></i>
            <p>Cluster</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Cluster">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('clusters.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('clusters.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#Subcluster">
            <i class="icon-layers"></i>
            <p>Subcluster</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Subcluster">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('subcluster.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('subcluster.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#Competency">
            <i class="icon-badge"></i>
            <p>Competency</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Competency">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('competencies.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('competencies.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#TargetSource">
            <i class="icon-badge"></i>
            <p>Target Source</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="TargetSource">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('targetSources.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('targetSources.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#Competency-Role-Target">
            <i class="icon-badge"></i>
            <p>Competency-Role Target</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Competency-Role-Target">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('competencyRoleTargets.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('competencyRoleTargets.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#compperrole">
            <i class="icon-list"></i>
            <p>Competencies Per Role</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="compperrole">
            <ul class="nav nav-collapse">
              <li>
                <a href="">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#Type">
            <i class="flaticon-pen"></i>
            <p>Competency Type</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Type">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('competencyTypes.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('competencyTypes.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#level">
            <i class="flaticon-technology-1"></i>
            <p>Level</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="level">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('levels.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('levels.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-toggle="collapse" href="#Proficiency">
            <i class="flaticon-graph"></i>
            <p>Proficiency</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Proficiency">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('proficiencies.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('proficiencies.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-toggle="collapse" href="#TalentSegment">
            <i class="flaticon-graph"></i>
            <p>Talent Segment</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="TalentSegment">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('talentSegments.index')}}">
                  <span class="sub-item">View All</span>
                </a>
              </li>
              <li>
                <a href="{{route('talentSegments.create')}}">
                  <span class="sub-item">Add</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">GAP Analysis</h4>
        </li>
        <li class="nav-item">
          <a href="{{route('reports.view')}}">
            <i class="far fa-chart-bar"></i>
            <p>Employee</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('reports.group.view')}}">
            <i class="far fa-chart-bar"></i>
            <p>Groups Per Role</p> 
          </a>
        </li>


        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Uploaders</h4>
        </li>
        <li class="nav-item">
          <a href="{{route('uploader.masterlist')}}">
            <i class="icon-cloud-upload"></i>
            <p>Masterlist</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('uploader.library')}}">
            <i class="icon-cloud-upload"></i>
            <p>Library</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('uploader.model')}}">
            <i class="icon-cloud-upload"></i>
            <p>Model</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{route('uploader.intervention')}}">
            <i class="icon-cloud-upload"></i>
            <p>Intervention</p>
          </a>
        </li>
        
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->
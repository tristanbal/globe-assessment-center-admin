<script type="text/javascript">
  /**
  * Define export function
  */
  
  function exportReport() {
      document.getElementById('exportButton').style.display = "none";
      document.getElementById('showExportLoader').style.display = "inline";
  
      // So that we know export was started
      console.log("Starting export...");
  
      // Define IDs of the charts we want to include in the report
      var ids = [
                @if($ctrDevA > 0)
                 "DevelopmentalAreasClusterChart",
                @endif
  
                @if($ctrStr > 0)
                 "StrengthsClusterChart",
                @endif
                  @if($competencyTypes)
                    @foreach($competencyTypes as $competencyType) 
                      "{{$competencyType->name}}RadarChart",
                      "{{$competencyType->name}}ClusterChart",
                    @endforeach
                  @endif
                 ];
  
      // Collect actual chart objects out of the AmCharts.charts array
      var charts = {},
        charts_remaining = ids.length;
      for (var i = 0; i < ids.length; i++) {
        for (var x = 0; x < AmCharts.charts.length; x++) {
          if (AmCharts.charts[x].div.id == ids[i])
            charts[ids[i]] = AmCharts.charts[x];
        }
      }
  
      // Trigger export of each chart
      for (var x in charts) {
        if (charts.hasOwnProperty(x)) {
          var chart = charts[x];
          if(chart.name == 'DevelopmentalAreas' && chart.type == 'serial')
          {
            chart["export"].capture({}, function() {
             
                this.toJPG({
                    multiplier: 2,
                    height: 700,
                    width: 1800,
                    // height: 1300,
                }, function(data) {
  
                  // Save chart data into chart object itself
                  this.setup.chart.exportedImage = data;
  
                  // Reduce the remaining counter
                  charts_remaining--;
  
                  // Check if we got all of the charts
                  if (charts_remaining == 0) {
                    // Yup, we got all of them
                    // Let's proceed to putting PDF together
                    generatePDF();
                  }
  
                });
  
            });
          }
          else if(chart.name == 'Strengths' && chart.type == 'serial' && chart.number <= 9)
          {
              chart["export"].capture({}, function() {
               
                  this.toJPG({
                      multiplier: 2,
                      height: 700,
                      width: 1800,
                      // height: 1300,
                  }, function(data) {
  
                    // Save chart data into chart object itself
                    this.setup.chart.exportedImage = data;
  
                    // Reduce the remaining counter
                    charts_remaining--;
  
                    // Check if we got all of the charts
                    if (charts_remaining == 0) {
                      // Yup, we got all of them
                      // Let's proceed to putting PDF together
                      generatePDF();
                    }
  
                  });
  
              });
          }
          else if(chart.name == 'Strengths' && chart.type == 'serial' && chart.number > 9)
          {
              chart["export"].capture({}, function() {
               
                  this.toJPG({
                      multiplier: 2,
                      height: 900,
                      width: 1800,
                      // height: 1300,
                  }, function(data) {
  
                    // Save chart data into chart object itself
                    this.setup.chart.exportedImage = data;
  
                    // Reduce the remaining counter
                    charts_remaining--;
  
                    // Check if we got all of the charts
                    if (charts_remaining == 0) {
                      // Yup, we got all of them
                      // Let's proceed to putting PDF together
                      generatePDF();
                    }
  
                  });
  
              });
          }
          else if(chart.type == 'serial' && chart.name == 'COREClusterChart')
          {
            chart["export"].capture({}, function() {
             
                this.toJPG({
                    multiplier: 2,
                    height: 1200,
                    width: 1800,
                    // height: 1300,
                }, function(data) {
  
                  // Save chart data into chart object itself
                  this.setup.chart.exportedImage = data;
  
                  // Reduce the remaining counter
                  charts_remaining--;
  
                  // Check if we got all of the charts
                  if (charts_remaining == 0) {
                    // Yup, we got all of them
                    // Let's proceed to putting PDF together
                    generatePDF();
                  }
  
                });
  
            });
          }
          else if(chart.type == 'serial')
          {
            chart["export"].capture({}, function() {
             
                this.toJPG({
                    multiplier: 2,
                    height: 1500,
                    width: 1900,
                    // height: 1300,
                }, function(data) {
  
                  // Save chart data into chart object itself
                  this.setup.chart.exportedImage = data;
  
                  // Reduce the remaining counter
                  charts_remaining--;
  
                  // Check if we got all of the charts
                  if (charts_remaining == 0) {
                    // Yup, we got all of them
                    // Let's proceed to putting PDF together
                    generatePDF();
                  }
  
                });
  
            });
          }
          else
          {
            chart["export"].capture({}, function() {
             
                this.toJPG({
                    multiplier: 2,
                    height: 550,
                    width: 1400,
                    // height: 1300,
                }, function(data) {
  
                  // Save chart data into chart object itself
                  this.setup.chart.exportedImage = data;
  
                  // Reduce the remaining counter
                  charts_remaining--;
  
                  // Check if we got all of the charts
                  if (charts_remaining == 0) {
                    // Yup, we got all of them
                    // Let's proceed to putting PDF together
                    generatePDF();
                  }
  
                });
  
            });
          }
        }
      }
  
  
      function generatePDF() {
        // Log
        var scaleBy = 5;
        var imgToExport = document.getElementById('imgToExport');
        var canvas = document.createElement('canvas');
                canvas.width = imgToExport.width; 
                canvas.height = imgToExport.height; 
                canvas.getContext('2d').drawImage(imgToExport, 0, 0);
                // canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
  
          canvas.toDataURL('image/png');
  
        // Initiliaze a PDF layout
        var layout = {
          footer: function (pageCount) {  
            var columns = 
              [
                { 
                canvas: 
                  [
                    { 
                      type: 'line', x1: 10, y1: 10, x2: 595-10, y2: 10, lineWidth: 0.5,
                      color: "#3E48A2",
                    }
                  ] 
                },
              
                {
                  text:  'Competency Assessment Report | Page ' + pageCount,
                  alignment: 'right',
                  margin: [0, 10, 40, 0],
                  color: "#3E48A2",
                }
              ]
            return columns;
          },
          "content": [],
          "pageMargins": [60, 80, 60, 50],
          header: 
            {
              margin: [0, 10, 0, 0],
              alignment: 'center',
              image: canvas.toDataURL('image/png'),
              fit: [125, 125],
            },
          fontSize: 11,
  
        };
  
        layout.content.push({
                color: '#000',
                "fontSize": 11,
                table: {
                    body: [
                              [
                                {
                                  table: {
                                    widths: [225, 225],
                                    body: [
                                      [
                                          {
                                            text: 'Name: {{ucwords(strtolower($employee->firstname))}} {{ucwords(strtolower($employee->lastname))}}', 
                                            border: [true, true, false, false]
                                          }, 
                                          {
                                            margin: [0,0,0,0],
                                            text: 'Assessment Date: {{$assessmentDate}}',border: [false, true, true, false]
                                          },
                                      ],
                                      [
                                          {text: 'Role Cluster: {{$role}}', border: [true, false, false, false]}, 
                                          {text: 'Immediate Supervisor: {{ucwords(strtolower($supervisor->firstname))}} {{ucwords(strtolower($supervisor->lastname))}}', border: [false, false, true, false]}
                                      ],
                                      [
                                          {text: 'Group: {{$group->name}}', border: [true, false, false, true]},
                                          {text: '', border: [false, false, true, true]},
                                      ]
                                    ]
                                  },
                                  layout: {
                                      hLineWidth: function(i, node) { return 1.5; },
                                      vLineWidth: function(i, node) { return 1.5; },
                                      hLineColor: function(i, node) { return '#3E48A2'; },
                                      vLineColor: function(i, node) { return '#3E48A2'; }
                                  }
                                }
                              ]
                          ]
                },
                layout: {
                    hLineWidth: function(i, node) { return 1.5; },
                    vLineWidth: function(i, node) { return 1.5; },
                    hLineColor: function(i, node) { return '#3E48A2'; },
                    vLineColor: function(i, node) { return '#3E48A2'; }
                }
        });
  
        layout.content.push({
          alignment: 'justify',
          "text": "\n\nHi {{ucwords(strtolower($employee->firstname))}},\n\n Thank you for taking the competency assessment! We are happy to share with you the results and we appreciate your commitment in taking the first step to your development journey with Globe. Rest assured that the results of this exercise will be used for the sole purpose of helping you build your competencies and eventually chart your career in Globe. The results, will in no way impact your performance evaluation.\n\n The result of the competency assessment is not the end but rather, the start of an exciting journey towards your personal development. Now, we’d like you to go through the report and schedule a meeting with your IS to talk about questions that you may have and discuss how the result will feed into your IDP (myIDP).\n\n As a ka-Globe, you are expected to own your development and take the driver’s seat in chartering your path inside the organization. This means, you should initiate development conversations with your IS and actively look for opportunities to further grow your competencies. Opportunities can take the form of training programs, a person who can mentor you or projects/assignments that will provide you a venue to showcase your talents. Your IS will be with you as you create/update your IDP (myIDP), and as you identify and complete development activities that can help you bridge competency gaps that may exist or fortify strengths that you already have. Globe’s HR team will be enabling you and your leader as you take on this journey together with tools and other forms of support that you’ll need to make you successful.\n\n\n Globe University",
          pageBreak: 'after',
            
        });
  
        layout.content.push({
          fontSize: 20,
          color: '#3E48A2',
          text: "COMPETENCY PROFILE\n\n"
        });
        
        layout.content.push({
          alignment: 'justify',
          text: [
            {
                text: "You were assessed as @if($role[0] == 'A' || $role[0] == 'E' || $role[0] == 'I' || $role[0] == 'O' || $role[0] == 'U' ) an @else a @endif {{$role}}. Your role has a total of {{$ctrAll}} competencies, Core = {{$ctrCore}}, Support = {{$ctrSupp}}, Developmental = {{$ctrDev}}. The ",
            },
            {
                bold: true,
                text: "core"
            },
            {
                text: " competencies are the essential competencies for you to perform your job in your particular role as {{$role}}. On the other hand, the ",
            },
            {
                bold: true,
                text: "support ",
            },
            {
                text: "competencies will enhance and improve the quality of your output. Lastly, the ",
            },
            {
                bold: true,
                text: "developmental ",
            },
            @if(count($assessmentTypes)==1)
              {
                  text: "competencies will enable you to practice skills that might be of use in the future. The competency scores were derived from your {{$assessmentTypes[0]->name}} scores.\n\n",
              },
              @elseif(count($assessmentTypes)>1 && count($assessmentTypes)<3)
              {
                  text: "competencies will enable you to practice skills that might be of use in the future. The competency scores were derived from your {{$assessmentTypes[0]->name}} scores and {{$assessmentTypes[1]->name}} scores.\n\n",
              },
              @else
              {
                  text: "competencies will enable you to practice skills that might be of use in the future. The competency scores were derived from your self-assessment scores and your IS' assessment scores.\n\n",
              },
              @endif
          ],
        });
  
  
        layout.content.push({
          alignment: 'justify',
          text: "The following  @if($ctrStr > 0 && $ctrDevA > 0)charts @else chart @endif @if($ctrStr > 0 && $ctrDevA > 0) show @elseif($ctrStr > 0) shows @elseif($ctrDevA > 0) shows @endif the @if($ctrStr > 0 && $ctrDevA > 0) strengths and developmental areas @elseif($ctrStr > 0) strengths @elseif($ctrDevA > 0) developmental areas @endif that can be inferred from the results of your competency assessment. However, your complete assessment on the {{$ctrAll}} competencies for your role can be found in the competency profile section of this report. For your reference, you may check the definition of these competencies found at the end of this report.\n\n",
          @if($ctrStr > 9)
          pageBreak: 'after',
          @endif
        });
  
        @if($ctrStr > 0)
        layout.content.push({
          color: '#3E48A2',
          decoration: 'underline',
          text: "Strengths\n\n"
        }); 
  
        layout.content.push({
          // alignment: 'center',
          // width: 600,
          // height: 370,
          margin: 0,
          marginLeft: -30,
          @if($ctrStr <= 9)
          width: 900,
          height: 450,
          @else
          width: 900,
          height: 670,
          @endif
          image: charts["StrengthsClusterChart"].exportedImage,
          pageBreak: 'after',
          // fit: [600, 900]
        });
        @endif
  
        @if($ctrDevA > 0)
        layout.content.push({
          color: '#3E48A2',
          decoration: 'underline',
          text: "Developmental Areas\n\n"
        }); 
  
        layout.content.push({
          // alignment: 'center',
          // width: 600,
          // height: 370,
          margin: 0,
          width: 900,
          marginLeft: -30,
          height: 670,
          image: charts["DevelopmentalAreasClusterChart"].exportedImage,
          pageBreak: 'after',
          // fit: [600, 900]
  
        });
        @endif
  
        layout.content.push({
          fontSize: 20,
          color: '#3E48A2',
          text: "COMPETENCY PROFILE\n\n"
        });
  
        layout.content.push({
          alignment: 'justify',
          text: "The following charts contain the results of your competency assessment. \n\n"
        });
  
        layout.content.push({
          widths: [ 210, 380 ],
          table: {
              
                body: [
                    [
                        {
                            text : "What's Inside?\n",
                            border: [true, true, false, true],
                            
                        },
                        {
                            text: "",
                            border: [false, true, true, false],
                        },
                    ],
                    [
                        {
                            text : "A. Radar Chart\n",
                            border: [true, false, false, false],
                            
                        },
                        {
                            text: "",
                            border: [false, true, true, false],
                        },
                    ],
                    [
                        {
                            text : "B. Cluster Chart\n",
                            border: [true, false, false, false],
                            
                        },
                        {
                            text: "",
                            border: [false, false, true, false],
                        },
                    ],
                    [
                        {
                            text : "C. Recommended Interventions\n",
                            border: [true, false, false, false],
                            
                        },
                        {
                            text: "",
                            border: [false, false, true, false],
                        },
                    ],
                    [
                        {
                            text : "D. Competency Definitions\n",
                            border: [true, false, false, true],
                            
                        },
                        {
                            text: "",
                            border: [false, false, true, true],
                        },
                    ],
                ],
            },
        });
  
        layout.content.push({
          fontSize: 20,
          text: "\nA. Radar Chart\n",
        });
  
        layout.content.push({
          alignment: 'justify',
          text: "This visually places the comparison between your attained score and target proficiency per competency. You will see how far your scores are from the target proficiency.\n\n",
        });
  
        @if($competencyTypes)
          @foreach($competencyTypes as $competencyType) 
            @if($ctrCore > 0 && $competencyType->name == 'CORE' || $ctrSupp > 0 && $competencyType->name == 'SUPPORT' || $ctrDev > 0 && $competencyType->name == 'DEVELOPMENTAL')
  
            if('{{$competencyType->name}}' == 'SUPPORT' || '{{$competencyType->name}}' == 'support')
            {
                // layout.content.push({
                //   text: "\n\n\n",
                // });
  
                layout.content.push({
                fontSize: 15,
                decoration: 'underline',
                text: "{{$competencyType->name}} COMPETENCIES\n",
              });
  
              layout.content.push({
                // alignment: 'center',
                margin: 0,
                // width: 850,
                // height: 320,
                width: 820,
                height: 320,
                image: charts["{{$competencyType->name}}RadarChart"].exportedImage,
                marginLeft: -100,
              });
            }
            else
            {
              layout.content.push({
                fontSize: 15,
                decoration: 'underline',
                text: "{{$competencyType->name}} COMPETENCIES\n",
              });
  
              layout.content.push({
                // alignment: 'center',
                margin: 0,
                // width: 850,
                // height: 320,
                width: 820,
                height: 350,
                image: charts["{{$competencyType->name}}RadarChart"].exportedImage,
                marginLeft: -80,
                pageBreak: 'after',
              });
            }
  
            @endif
          @endforeach
        @endif
  
        layout.content.push({
          fontSize: 20,
          text: "B. Cluster Chart\n",
          pageBreak: 'before',
        });
  
        layout.content.push({
          alignment: 'justify',
          text: "This shows the comparison of your total attained weight score with the target proficiency level, your supervisor assessment score, your self-assessment score, and some industry benchmarks (if any).\n\n",
        });
  
        @if($competencyTypes)
          @foreach($competencyTypes as $competencyType)
            @if($ctrCore > 0 && $competencyType->name == 'CORE' || $ctrSupp > 0 && $competencyType->name == 'SUPPORT' || $ctrDev > 0 && $competencyType->name == 'DEVELOPMENTAL')
            
            // if("{{$competencyType->name}}" == "SUPPORT" || "{{$competencyType->name}}" == "DEVELOPMENTAL")
            // {
            //   layout.content.push({
            //     text: "\n\n\n\n\n\n",
            //   });
            // }
  
            layout.content.push({
              fontSize: 15,
              decoration: 'underline',
              text: "{{$competencyType->name}} COMPETENCIES\n",
            });
  
            if('{{$competencyType->name}}' == 'CORE')
            {
              layout.content.push({
                // alignment: 'center',
                margin: 0,
                // width: 810,
                // height: 550,
                width: 920,
                height: 600,
                image: charts["{{$competencyType->name}}ClusterChart"].exportedImage,
                pageBreak: 'after',
                marginLeft: -20,
              });
          }
            else
            {
              layout.content.push({
                // alignment: 'center',
                margin: 0,
                // width: 810,
                // height: 550,
                width: 920,
                height: 690,
                image: charts["{{$competencyType->name}}ClusterChart"].exportedImage,
                marginLeft: -20,
                pageBreak: 'after',
              });
          }
  
            @endif
          @endforeach
        @endif
  
        @if($verbatimChecker)
        layout.content.push({
          fontSize: 20,
          text: "C. Verbatim Assessments\n",
        });
        layout.content.push({
          alignment: 'justify',
          "text": "This sub-section shows the different given verbatim by the assessors found on each competency together with the attained proficiency level. It generally provides examples of how the competency is being applied.",
        });
        layout.content.push({
          widths: [200, 200],
          table:{
                body: [
                        [
                          {
                            text: "Competency",
                            fillColor: '#0759a7',
                            color: "#fff",
                          },
                          {
                            text: "Score/Level",
                            fillColor: '#0759a7',
                            color: "#fff",
                          },
                          {
                            text: "Verbatim Feedback",
                            fillColor: '#0759a7',
                            color: "#fff",
                          },
                          {
                            text: "Assessor",
                            fillColor: '#0759a7',
                            color: "#fff",
                          },
                        ],
                        <?php $compIds = array(); 
                              $trArr = array();
                        ?>
                          @if($gapanalysis)  
                            @foreach($gapanalysis as $gapforverbatim)
                              @if($gapforverbatim->verbatim != 'N/A')
                              
                              [
                                {
                                    text: "{{ preg_replace( '/\r|\n/', '',$gapforverbatim->competencyName)}}",
                                },
                                {
                                    text: "{{$gapforverbatim->givenLevelID-1}} | {{$gapforverbatim->levelName}}",
                                },
                                {
                                    text: "{{ preg_replace( '/\r|\n/', '',$gapforverbatim->verbatim)}}",
                                },
                                {
                                    text: "{{$gapforverbatim->assessorFirstName}} {{$gapforverbatim->assessorLastName}} | {{$gapforverbatim->name}}"
                                },
                              ],
                              @endif
                            @endforeach
                          @endif
                              
                            
                      ],
                },
                layout: {
                  fillColor: function (i, node) {
                    return (i % 2 === 0) ? '#fafafe' : null;
                  },
                  hLineColor: function (i, node) {
                    return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                  },
                  vLineColor: function(i, node) {
                    return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                  }
  
                },
                pageBreak: 'after',
        });
        @endif
        
        @if($verbatimChecker)
          layout.content.push({
            fontSize: 20,
            text: "D. Recommended Interventions\n",
          });
          @else
          layout.content.push({
            fontSize: 20,
            text: "C. Recommended Interventions\n",
          });
          @endif
    
          layout.content.push({
            alignment: 'justify',
            text: "This section shows the recommended interventions for each competency. It follows the 70-20-10 model of learning.\n\n 70% of learning or “experiential learning” happens through hands-on experiences, on the job trainings and immersions. 20% of learning or “social learning” happens through relationships by observing others, sharing knowledge, coaching and nurturing mentorships. 10% of learning or “formal learning” happens through structured training courses and programs.\n\n Effective learning comes with mixing both informal (70% and 20%) and formal (10%) learning. You may discuss with your IS the different opportunities for informal learning that may help you improve your competencies. As for formal learning, the table below shows the recommended trainings you may attend to develop your competencies.\n\n",
          });
    
          layout.content.push({
          widths: [200, 200],
          table:{
                body: [
                        [
                          {
                            text: "Competency",
                            fillColor: '#0759a7',
                            color: "#fff",
                          },
                          {
                            text: "Learning Interventions",
                            fillColor: '#0759a7',
                            color: "#fff",
                          },
                        ],
                        <?php $compIds = array(); 
                              $trArr = array();
                        ?>
                        @if($competencies)
                                @foreach($competencies as $competency)
                                  @foreach ($interventions as $intervention)
                                        @if($competency->competencyID == $intervention->competencyID)
                                          @if($intervention->groupID == 19)
                                          [
                                              {
                                                <?php $compId = $intervention->getAttribute("competencyID"); 
                                                if(!in_array($compId, $compIds))
                                                {
                                                  array_push($compIds,$compId);
                                                ?>
                                                  text: "{{$competency->name}}",
                                                <?php 
                                                }
                                                ?>
                                              },
    
                                              @foreach($trainings as $training)
                                                @if($intervention->trainingID == $training->id) 
                                                  {
                                                    <?php 
                                                  $trim = str_replace("&", "and", $training->name);
                                                   ?>
                                                  text: "{{$trim}}",
                                                  },
                                                @endif
                                              @endforeach
                                            ],
                                          @elseif($group->id == $intervention->groupID)
                                            @foreach($divisions as $division)
                                              @if($intervention->divisionID == $division->id)
                                              [
                                                {
                                                  <?php $compId = $intervention->getAttribute("competencyID"); 
                                                  if(!in_array($compId, $compIds))
                                                  {
                                                    array_push($compIds,$compId);
                                                  ?>
                                                    text: "{{$competency->name}}",
                                                  <?php 
                                                  }
                                                  ?>
                                                },
    
                                                @foreach($trainings as $training)
                                                  @if($intervention->trainingID == $training->id) 
                                                    {
                                                      <?php 
                                                    $trim = str_replace("&", "and", $training->name);
                                                    ?>
                                                    text: "{{$trim}}",
                                                    },
                                                  @endif
                                                @endforeach
                                              ],
                                              @endif
                                            @endforeach
                                          @endif
                                            
                                        @endif
                                  @endforeach
                                @endforeach
                              @endif
                      ],
                },
                layout: {
                  fillColor: function (i, node) {
                    return (i % 2 === 0) ? '#fafafe' : null;
                  },
                  hLineColor: function (i, node) {
                    return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                  },
                  vLineColor: function(i, node) {
                    return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                  }
    
                },
                pageBreak: 'after',
        });
    
  
      @if($verbatimChecker)
        layout.content.push({
          fontSize: 20,
          text: "E. Competency Definitions\n",
        });
      @else
        layout.content.push({
          fontSize: 20,
          text: "D. Competency Definitions\n",
        });
  
      @endif
  
  
  
        layout.content.push({
          alignment: 'justify',
          text: "The following tables contain the competencies and its definitions, arranged per competency type.\n\n",
        });
  
        @if($competencyTypes)
          @foreach($competencyTypes as $competencyType)
              @if($ctrCore > 0 && $competencyType->name == 'CORE' || $ctrSupp > 0 && $competencyType->name == 'SUPPORT' || $ctrDev > 0 && $competencyType->name == 'DEVELOPMENTAL')
  
              layout.content.push({
                fontSize: 15,
                text: "{{$competencyType->name}}\n",
                decoration: 'underline',
              });
              @endif
              layout.content.push({
                widths: [200, 200],
                table: {
                      body: [
                              @if($competencies)
                                  @foreach($competencies as $competency)
                                    @if($ctrCore > 0 && $competencyType->name == 'CORE' || $ctrSupp > 0 && $competencyType->name == 'SUPPORT' || $ctrDev > 0 && $competencyType->name == 'DEVELOPMENTAL')
                                      @if($competency->compTypeName == $competencyType->name)
                                      <?php
                                        $trim = str_replace("\n", " ", $competency->definition);
                                        $trim1 = str_replace("\r", " ", $trim);
                                        $trim2 = str_replace("&", "and", $trim1);
                                        $trim3 = str_replace("'", "`", $trim2);
  
                                      ?>
  
                                      [
                                        {
                                          text: "{{$competency->name}}",
                                        },
                                        {
                                          text: "{{$trim3}}",
                                        },
                                      ],
                                    @endif
                                  @else
                                  [
                                  ],
                                  @endif
                                @endforeach
                              @endif
                      ],
                  },
                  layout: {
                    fillColor: function (i, node) {
                      return (i % 2 === 0) ? '#fafafe' : null;
                    },
                    hLineColor: function (i, node) {
                      return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                    },
                    vLineColor: function(i, node) {
                      return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                    }
  
                  },
              });
              @if($ctrCore > 0 && $competencyType->name == 'CORE' || $ctrSupp > 0 && $competencyType->name == 'SUPPORT' || $ctrDev > 0 && $competencyType->name == 'DEVELOPMENTAL')
  
              layout.content.push({
                text: "\n\n\n",
              });
  
              @endif
            @endforeach
        @endif
        
        chart["export"].toPDF(layout, function(data) {
          this.download(data, "application/pdf", "{{$employee->firstname}} {{$employee->lastname}} - {{$role}}.pdf");
        });
  
        document.getElementById('exportButton').style.display = "inline";
        document.getElementById('showExportLoader').style.display = "none";
  
      }
  }
              
    </script>
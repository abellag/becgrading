@extends('app')

@section('content')
@if(isset($gradeStat) && isset($subjects))
 <?php $Statgrade =  $gradeStat -> status ?>
    @if(count($subjects)>0)
        @foreach($subjects as $subject)
              <?php $Statsubjects = $subject -> status ?>
          
        @endforeach
    @else
        <?php $Statsubjects = '' ?>
        <?php $Statgrade =  '' ?>
    @endif

@else
    <?php $Statsubjects = "0" ?>
    <?php $Statgrade =  "0" ?>
    
     
@endif

@section('scripts')
<script  type="text/javascript">
    
    window.onload = function () {
        enable_input(false,'all',{{ $Statgrade }},{{ $Statsubjects }});
        scrollDiv_init();
    }// my custom script
</script>
@stop
<div class="container_fluid">
    <div class="row">
        <div class="col-md-3">

            <div class ="list-group" style="padding-left: 20px">
                <div class="list-group-item active" style="background-color:#333300"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><b> Dashboard</b></div>    
                <div class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#college" aria-expanded="true" aria-controls="college">College</a>

                    <ul class="list-group collapse" id="college" role="tabpanel" aria-labelledby="college">

                       <?php $x = 1;   ?>
                @if(count($loads)>0)    
                  @foreach($loads as $load)
                        <?php $x++ ?>
                        <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$x}}" aria-expanded="false" aria-controls="collapse{{$x}}">{{ $load->name }}</a>
                                    <div  id="collapse{{$x}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$x}}">
                                        
                                    @if(count($data)>0)    
                                   @foreach($data as $datas)
                                        
                                        @if($datas->instructor == $load->instructor)
                                         <li><a href="{{url('/viewgradeApprover',array($datas->scheduleid,$datas->subject,0))}}">{{ $datas->subject }}</a></li>  
                                        @endif
                                   @endforeach
                                   @endif
                                   </div>
                        </ul>
                        @endforeach
                        @endif


                        </ul>

                </div>
                
                @for($i = 1; $i < 4; $i++)
                <?php
                $department;
                switch($i){
                    case 1: $department = "Senior High School"; $codeDept = "shs"; break;
                    case 2: $department = "Junior High School"; $codeDept = "jhs";break;
                    case 3: $department = "Primary Education"; $codeDept = "psgs";break;
                }
                
                ?>
                <div class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#{{$codeDept}}" aria-expanded="true" aria-controls="{{$codeDept}}">{{$department}}</a>

                    <ul class="list-group collapse"  id="{{$codeDept}}" role="tabpanel" aria-labelledby="{{$codeDept}}">

                       <?php $x = 1;  $y = 1; $z = 1; ?>
                @if(count($teacher > 0))
                  @foreach($teacher as $teachers)
                        <?php $x++ ?>
                        
                        @if(($teachers->accesslevel== env('SENIOR_HIGH_SCHOOL') && $department == "Senior High School") || $teachers->accesslevel== env('OTHERS') )
                        <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$codeDept}}{{$x}}" aria-expanded="false" aria-controls="collapse{{$codeDept}}{{$x}}">{{ $teachers->name }}</a>
                        </ul>
                            @elseif(($teachers->accesslevel== env('JUNIOR_HIGH_TEACHER') && $department == "Junior High School" ) || $teachers->accesslevel== env('OTHERS') )
                         <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$codeDept}}{{$x}}" aria-expanded="false" aria-controls="collapse{{$codeDept}}{{$x}}">{{ $teachers->name }}</a>
                        </ul>
                             @elseif(($teachers->accesslevel== env('PRIMARY_TEACHER') && $department == "Primary Education" ) || $teachers->accesslevel== env('OTHERS') )
                         <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$codeDept}}{{$x}}" aria-expanded="false" aria-controls="collapse{{$codeDept}}{{$x}}">{{ $teachers->name }}</a>
                        </ul>
                        @endif
                            <div  id="collapse{{$codeDept}}{{$x}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$x}}">
                                        
                                    @if(count($subject1)>0)    
                                   @foreach($subject1 as $subjects1)
                                        <?php $y++ ?>
                                        @if($subjects1->instructorid == $teachers->instructorid && $subjects1-> department == $department)
                                        <li><ul><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$codeDept}}{{$x}}{{$y}}" aria-expanded="false" aria-controls="collapse{{$codeDept}}{{$x}}{{$y}}">{{ $subjects1->subject }}</a>
                                             <div  id="collapse{{$codeDept}}{{$x}}{{$y}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$x}}{{$y}}">
                                                 @if(count($teacherdata)>0) 
                                                @foreach($teacherdata as $teacherdatas)
                                                @if($teacherdatas->subject == $subjects1->subject)
                                                <li><a href="{{url('/viewgradeApprover1',array($teacherdatas->id,$teacherdatas->level,$teacherdatas->section,$teacherdatas->subject,$teachers->instructorid,0))}}">{{ $teacherdatas->level }} - {{ $teacherdatas->section }}</a></li>  
                                                @endif
                                                @endforeach
                                                @endif
                                                 </div>
                                         
                                            </ul>
                                         </li>  
                                        @endif
                                   @endforeach
                                   @endif
                                   </div>
                        
                       
                        @endforeach
                        @endif


                       
                        </ul>

                </div>
                
                @endfor
                
                
                
                
                
                <div class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#setup" aria-expanded="true" aria-controls="setup">SetUp</a>
                    <ul class="list-group collapse"  id="setup" role="tabpanel" aria-labelledby="setup">
                        <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#quarterly" aria-expanded="false" aria-controls="quarterly">Quarterly</a>
                            <ul class="list-group collapse"  id="quarterly" role="tabpanel" aria-labelledby="quarterly">
                    
                                
                            
                                          <li><a href="{{url('/setup/quarterly',array('college'))}}" >College</a></li>  
                                          <li><a href="{{url('/setup/quarterly',array('diploma'))}}" >Diploma</a></li>  
                                          <li><a href="{{url('/setup/quarterly',array('shs'))}}">Senior High School</a></li> 
                                          <li><a href="{{url('/setup/quarterly',array('jhs'))}}">Junior High School</a></li> 
                                          <li><a href="{{url('/setup/quarterly',array('psgs'))}}">Primary Education</a></li> 
                            </ul>
                            </ul>
                        <ul class="list-group-item">
                            <a href="{{url('/add/school/attended')}}">Previous School</a>
                        </ul>
                        <!--ul class="list-group-item">
                            <a href="#" onclick="getPhoto()">Student Photo</a>
                        </ul-->
                        <ul class="list-group-item">
                            <a href="#" onclick="getRegister()">Add Instructor</a>
                        </ul>
                        
                        <!--FOR BACK INCASE NEEDED-->
                        <!--ul class="list-group-item">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#prevSchool" aria-expanded="false" aria-controls="prevSchool">Previous School</a>
                            <ul class="list-group collapse"  id="prevSchool" role="tabpanel" aria-labelledby="prevSchool">
                    
                                
                            
                                          <li><a href="#" onclick="getSearch()">TOR</a></li>  
                                          <li><a href="#" onclick="getSearchTeacher()">List Per Subject</a></li> 
                                          <li><a href="#" onclick="getGrade()">Summary Grade Report</a></li> 
                                          <li><a href="">Report Card</a></li> 
                            </ul>
                        </ul-->
                        
                        </ul>
                        
                    </ul>
                    <!--a href="{{url('/add/school/attended')}}">Set up</a-->
                </div>
                
                
                
                <div class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#reports" aria-expanded="true" aria-controls="reports">Reports</a>

                    <ul class="list-group collapse" id="reports" role="tabpanel" aria-labelledby="reports">

                       <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseReports" aria-expanded="false" aria-controls="collapseReports"></a>
                                         <li><a href="#" onclick="getSearch()">TOR</a></li>  
                                          <li><a href="#" onclick="getSearchTeacher()">List Per Subject</a></li> 
                                          <li><a href="#" onclick="getGrade()">Summary Grade Report</a></li> 
                                          <li><a href="#" onclick="viewCertificate()">Certification of Grades</a></li>
                                          <!--li><a href="">Report Card</a></li--> 
                         </ul>
                       
                            <!--onclick="setQuarterly('college')" {{url('/setup/quarterly',array('college'))}}-->
                        </ul>

                </div>
                
            </div>    
        </div>
        @if (session('message'))
            <div class="col-lg-8 alert alert-{{session('alert')}}">
                {{ session('message') }}
            </div>
         @endif
         <div id="div1">
         
        
        @yield('content1')
        </div>
        
    </div>   
</div>    

    


@stop

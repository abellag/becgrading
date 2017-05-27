@extends('app')

@section('content')
<?php
use App\Http\Controllers\ReportController;
?>
<style>
    @media print{
        @page{
        margin-top:-1mm;
        margin-right: -1mm;
        margin-left: 4mm;
        margin-bottom: 1mm;
        }
      
        
    }
    
     #table #tr, #th, #td {
    border-style : solid;
    border-color :black;
    border-width : 1px;
    
        }
        
        .block{
            float:left;
            width: 48%;
        } 
      
        #table{
            width:100%;
        }
        #th{
            height: 40px;
            text-align: center;
        }
        
       #td{height: 20px;}
       #td1{
           text-align: center;
       }
       
</style>
<div class="col-lg-2"></div>
<div class="col-lg-8"  id="grade" >
    <div class="panel" style="font-family: 'Georgia', Georgia, serif;">
        <div class="panel-heading" >
            <br/>
            <br/>
        
             <table>
                <tr>
                    <td style="width: 25%" align="right" ><img   src="{{URL::asset('images/logo.jpg')}}" alt="profile Pic"></td>
                    <td style="width: 50%;" align="center"><p>
            Republic of the Philippines<br/>
            <b><span style="font-size:16px;">DEPARTMENT OF EDUCATION</span></b><br/>
            REGION IV-A (CALABARZON)<br/>
            <b>Division of Batangas </b><br/>
            </p>
            <p>
                <b><span style="font-size:16px;">BATANGAS EASTERN COLLEGES</span><br/>
            Pre-School and Grade School Department <br/>
            San Juan, Batangas </b><br/>
            </p></td>
                    <td style="width: 25%">LRN:12345678910
                    <?php $photo = $studentid.'-'.$department.'.jpg'; ?> 
                    <img style="width: 60%; height: auto;"  src="/images/studentphoto/<?php echo $photo?>" alt="profile Pic">                   
                    
                    </td>
                </tr> 
                
            </table>
            
            
            
           
        </div>
        <div id="panelBody" class="panel-body" style=" background-position: center !important; background-repeat: no-repeat !important; background-image:url(/images/1batangas-eastern-colleges-logo.jpg) !important;background-size: 60%">
            <div class="row">
                <div class="col-md-12">
                   <p align="center" style="font-size:18px;"><b>ELEMENTARY SCHOOL PERMANENT RECORD </b><br/></p>
                </div>
            </div>
            @if(count($studentInfo)>0)
                @foreach($studentInfo as $studentInfos)
                    
                
            <div class="row">
                <div class="col-md-8">Name: &nbsp;<b>{{$studentInfos->lastName}}, {{$studentInfos->firstName}} &nbsp; {{$studentInfos->middleName}}</b></div>
                <div class="col-md-4">Sex: &nbsp;{{$studentInfos->gender}}</div>
            </div>
            <div class="row">
                <div class="col-md-4">Date of Birth: &nbsp;{{$studentInfos->birthDate}}</div>
                <div class="col-md-4">Nationality: &nbsp;{{$studentInfos->nationality}}</div>
                <div class="col-md-4">Date Entered: &nbsp;June 06, 2011</div>
            </div>
            <div class="row">
                <div class="col-md-12">Place of Birth: &nbsp;{{$studentInfos->birthPlace}}</div>
            </div>
            <div class="row">
                <div class="col-md-12">Parent / Guardian: &nbsp;{{$studentInfos->mother}} / {{$studentInfos->father}} / {{$studentInfos->parent}}</div>
            </div>
            <div class="row">
                <div class="col-md-12">Address: &nbsp;{{$studentInfos->address}}</div>
            </div>

                @endforeach
            @endif
            <div>
                <br/>
                <p align="center"><b>ELEMENTARY SCHOOL PROGRESS</b></p>
            
            
            <table id="table">
                <tr id="tr" style="font: bold;"><th id="th">School Year</th><th id="th">School Attended</th><th id="th">Level</th><th id="th">School Days</th><th id="th">Days Present</th><th id="th">Final Rating</th></tr>
                @if(count($schoolRecord) > 0)
                    @foreach($schoolRecord as $schoolRecords)
                        <tr id="tr">
                            <td id="td">{{$schoolRecords->schoolyear}}</td><td id="td">{{$schoolRecords->schoolAttended}}</td>
                            <td id="td">{{$schoolRecords->level}}</td><td id="td">{{$schoolRecords->schoolDays}}</td>
                            <td id="td">{{$schoolRecords->presentDays}}</td><td id="td">{{$schoolRecords->finalrating}}</td>
                        </tr>
                    @endforeach
                @endif
                
            </table>
            </div>
            
            <div><br/>
                <div class="row">
                    <?php
                    $level1 = substr($level,-1);
                    $wordLevel = ucfirst(ReportController::getWordNumber($level1));
                    $nextLevel = ucfirst(ReportController::getWordNumber($level1+1));
                    $dateToday = date("F d, Y");
                    ?>
                    
                    <div class="col-md-8">Grade:&nbsp;{{$wordLevel}}</div>
                    <div class="col-md-4">School Year: {{$schoolyear}}</div>
                </div>
                <br/>
                <table id="table" style="width: 100%;">
                <tr id="tr"><th id="th">LEARNING AREAS</th><th id="th">1</th><th id="th">2</th><th id="th">3</th><th id="th">4</th><th id="th">Final Rating</th></tr>
                <?php $c = 0; $average = 0;?>
                @foreach($grade as $grades)
                <?php $finalrating = ($grades->firstQTRN + $grades->secondQTRN + $grades->thirdQTRN + $grades->fourthQTRN) / 4;
                      $rating = round($finalrating);
                      if($grades->subject == 'Music' || $grades->subject == 'Art' || $grades->subject == 'Physical Education' || $grades->subject == 'Health')
                      { $c = $c + 0;
                        $average = $average + 0;
                      }else{
                        $c = $c + 1;
                        $average = $average + $rating;
                      }
                ?>
                <tr id="tr">
                @if($grades->subject == 'Music' || $grades->subject == 'Art' || $grades->subject == 'Physical Education' || $grades->subject == 'Health')
                <td  id="td" style="padding-left: 5%">{{$grades->subject}}</td>
                @else
                <td  id="td">{{$grades->subject}}</td>
                @endif
                    <td  id="td">{{$grades->firstQTRN}}</td>
                    <td  id="td">{{$grades->secondQTRN}}</td><td>{{$grades->thirdQTRN}}</td>
                    <td  id="td">{{$grades->fourthQTRN}}</td>
                    <td  id="td">{{$rating}}</td></tr>
                
                
                @endforeach
             </table>
                <table id="table">
                    <tr>
                        <?php
                        
                        if($average == 0){
                            $genAverage = 0;
                        }else{
                        $genAverage = $average / $c;
                        }
                        ?>
                    
                        <td id="td1">General Average:{{$genAverage}}</td>
                        <td id="td1">Days of School:{{$grades->totalDaysSchool}}</td>
                        <td id="td1">Days Present:{{$grades->totalDaysPresent}}</td>
                    </tr>
                    <tr>
                        <td id="td1">E-06-08-15</td>
                        <td id="td1">L-04-01-16</td>
                        <td id="td1"></td>
                    </tr>
                </table>
                
                <hr  style="height: 5px; background-color: black;">
                
                <div>
                    <p align="center"><b>CERTIFICATION OF TRANSFER</b></p>
                    <p><b>TO WHOM IT MAY CONCERN</b></p>
                    <p>This is to certify that this is a true copy of the Elementary School Permanent Record of
                        <b> {{$studentInfos->firstName}}&nbsp;&nbsp; {{$studentInfos->middleName}}&nbsp;&nbsp;{{$studentInfos->lastName}}.</b>This student is eligible for admission to 
                        <span style=" border-bottom: 2px solid black;">&nbsp; &nbsp;Grade &nbsp;{{$nextLevel}}&nbsp; &nbsp;</span>    
                        <br/><br/>Date: &nbsp; {{$dateToday}}<br/>
                    <br/>Remarks: Copy for San Juan West Central School.<br/><br/>
                    </p>
                    <p>
                    <table style="width: 100%;">
                        <tr>
                            <td align="center">Prepared by:</td>
                            <td align="center">Verified by:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="center">CECILLE G. MATUTO</td>
                            <td align="center">JOY J. ALDAY</td>
                            <td align="center">MARIA CRISANTA R. ISLA</td>
                        </tr>
                        <tr>
                            <td align="center">Academic Clerk</td>
                            <td align="center">Assistant Registrar</td>
                            <td align="center">Registrar</td>
                        </tr>
                       
                    </table>
                    </p>
                    
                </div>
                
            </div>
            
        </div>     
    </div>
    <br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>


</div>






@stop
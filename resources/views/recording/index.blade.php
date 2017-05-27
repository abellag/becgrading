
@extends('app')


@section('content')

@if(isset($gradeStat) && isset($quarter))
 @if(count($gradeStat)>0)
        @foreach($gradeStat as $gradeStats)
              <?php $Statgrade = $gradeStats -> status ?>
        @endforeach
    @else
        <?php $Statgrade =  "0" ?>
    @endif
 <?php
 
        ?>
    @if(count($quarter)>0)
        @foreach($quarter as $quarters)
              <?php 
              $start = $quarters->startDate;   
              $end = $quarters->endDate;
              $dateStart = new DateTime($start);
              $dateEnd = new DateTime($end);
              $now = new DateTime();

              if($now->format('y-m-d') >= $dateStart->format('y-m-d') && 
                      $now->format('y-m-d') <= $dateEnd->format('y-m-d') ){
                  
                  $dateDiff = $now->diff($dateEnd)->format("%d");
                  $dateLeft = $now->diff($dateEnd)->format("%d days");
                  $messageEncode = 'Days Left for Grade Encoding :';
              }else if($now->format('y-m-d') < $dateStart->format('y-m-d') ){
                   $dateDiff = -1;
                   $dateLeft = $dateStart->format('y/m/d').'-'.$dateEnd->format('y/m/d');
                   $messageEncode = 'Grade Encoding will start on :';
              }else{
                  $dateDiff = -1;
                  $dateLeft = '';
                  $messageEncode = 'Encoding already finish.';
              }
               
              $SemQuarter = $quarters->quarter;
               $Statsubjects = $quarters -> quarter;
              
                      ?>
        @endforeach
    @else
        <?php $dateDiff = -1 ?>
    <?php $dateLeft = ''; ?>
     <?php $SemQuarter = ''; ?>
        <?php $Statsubjects = '' ?>
        <?php $Statgrade =  '0' ?>
        <?php $messageEncode = ''; ?>
    @endif

@else
<?php $dateLeft = ''; ?>
    <?php $SemQuarter = ''; ?>
    <?php $dateDiff = -1 ?>
    <?php $Statsubjects = "0" ?>
    <?php $Statgrade =  '0' ?>
    <?php $messageEncode = ''; ?>
    
     
@endif


<script type="text/javascript">
    
    window.onload = function () {
        //scrollDiv_init();
        <?php
        $countSubjects = 0;
        
        if(isset($subjects))
            $countSubjects = count($subjects);
            
        ?>
        //getSubjectSched(<?php// echo $countSubjects?>);
        
        enable_input(false,'all',<?php echo $Statgrade ?>,<?php echo "'".$Statsubjects."'"; ?>,<?php echo $dateDiff;?>);
        
    }// my custom script
</script>




<div class="container_fluid">
    <div class="row">
        <div class="col-md-3">

            <div class ="list-group" style="padding-left: 20px">
                <div class="list-group-item active" style="background-color:#333300"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><b> Dashboard</b></div>    
                <div class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Your Courses	

                    <ul style="overflow:auto;height:150px" class="list-group">
                        <?php $batch = '';
                            if(isset($id)){
                                $sentId = $id;
                            }
                            else{
                                $sentId = '';
                            }
                        ?>
                        @if(count($loads)>0)    
                        @foreach($loads as $load)
                        <li class="list-group-item"><a href="{{url('viewgrade',array($load->scheduleid,$load->subject))}}">{{ $load->subject }}-Batch <b>{{$load->batch}}</b></a></li>
                        <?php
                            if($load->scheduleid == $sentId){
                                $batch = $load->batch;
                            }
                        ?>
                        @endforeach
                        @endif
                    </ul>

                </div>
                <!--div onMouseOver="pauseDiv()" onMouseOut="resumeDiv()" class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Messages	

                    <ul class="list-group" id="MyDivName" style="overflow:auto;height:150px">
                        @if(count($message)>0)    
                            @foreach($message as $messages)
                            @if($messages -> statuses == 2)
                            <li class="list-group-item" style="background-color: #f2f2f2">
                            @else
                            <li class="list-group-item">
                            @endif
                                <a href="{{url('viewNotification',array($messages->scheduleid,$messages->name))}}">{{str_limit($messages->comment,20 ,'.....') }}</a></li>
                            @endforeach
                        @endif
                    </ul>

                </div-->
            </div>    
        </div>
        <div class="col-lg-9">
            @if (session('message1'))
            <div class="col-lg-8 alert alert-success">
                {{ session('message1') }}
            </div>
         @endif
         
         
            @if(isset($subjects))
            @if(count($subjects)>0)
            <div style="float:left;"><h4> Subject : <span style="color:red">{{$currentsubject}} - Batch <b>{{$batch}}</b></span></h4></div>
            <div style="float:right; padding-right: 10%"><h4> {{$messageEncode}} <span style="color:red">{{$dateLeft}}</span></h4></div>
            
            <table class="table table-striped" style="padding-right:10px"><tr><td>Select</td><td>Student ID</td><td>Student Name</td><td>Prelim</td><td>Midterm</td><!--td>Semifinal</td--><td>Final</td><!--td align="center">Subject Schedule</td--></tr>
                <?php $x = 0;?>
                @foreach($subjects as $subject)
                <?php
                    $x = $x + 1;
                ?>
                <tr><td>
                        @if($subject->attendanceStatus == 0)
                        <input type="checkbox" id="attendanceStatus" checked="true" form="userform" onclick="updateAttendanceStatus({{$subject->studentid}},'{{$subject->id2}}')" name="studentsCheck[]" value="{{$subject->studentid}}" /></td>
                        @else
                        <input type="checkbox" id="attendanceStatus" form="userform" onclick="updateAttendanceStatus({{$subject->studentid}},'{{$subject->id2}}')" name="studentsCheck[]" value="{{$subject->studentid}}" /></td>
                        
                        @endif
                    <td>{{$subject->studentid}}</td><td><?php echo strtoupper($subject->lastName)?>, <?php echo ucwords(strtolower($subject->firstName))?></td>
                    <td>
                        @if($SemQuarter == 'Prelim')
                        <input  type="text" class="prelim" id="prelim" name="prelim"  maxlength="4" size="4" value= "{{$subject->prelim}}" onkeyup="addGrade('{{$subject->id2}}', '1', this.value)">
                        @else
                        {{ $subject->prelim }}
                        @endif
                    </td>

                    <td>
                        @if($SemQuarter == 'Midterm')
                        <input type="text" style="text-align:center" id="midterm" name="midterm" class="midterm"  maxlength="4" size="4" value= "{{$subject->midterm}}"  onkeyup="addGrade('{{$subject->id2}}', '2', this.value)">
                        @else
                        {{ $subject->midterm }}
                        @endif
                    </td>
                    <!--td>
                        @if($subject->status == '3')
                        <input type="text" id="semifinals" name="semifinals"   style="text-align:center"  maxlength="4" size="4" value= "{{$subject->semifinals}}"  onkeyup="addGrade('{{$subject->id2}}', '3', this.value)">
                        @else
                        {{ $subject->semifinals }}
                        @endif
                    </td-->
                    <td>
                        @if($SemQuarter == 'Final')
                        <input type="text" id="finals" maxlength="4" class="finals" name="finals"  style="text-align:center"   size="4" value= "{{$subject->finals}}"  onkeyup="addGrade('{{$subject->id2}}', '4', this.value)">
                        @else
                        {{ $subject->finals }}
                        @endif
                    </td>
                     <!--td><select form="userform" id="subjectSched{{$x}}" name="subjectSched[]" class='form-control'>
                            <option>Select Subject Schedule</option>
                           </select>     
                                                       
                     </td-->
        
                    


                </tr>
                @endforeach
            </table>  
            <form id="userform" name="userform" method="POST" action="{{url('/recording/update/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$id}}" name="schedid" />
                <div class="checkbox">
                    <label><input type="checkbox" name="check1" class="checkbox" onclick="enable_input(this.checked, 'submit', 0, 0)"/>  Submit Final Grade</label>
                </div>
                <!--div class="checkbox">
                    <label><input type="checkbox" name="check2" class="checkbox" onclick="enable_input(this.checked, 'comment', 0, 0)"/> Add Comment</label>
                </div>
                <textarea form="userform" class="form-control" rows="5" name="comment" placeholder="Insert important message for grades...."></textarea--> <br />
                <button form="userform" name="button" id="button" class=" btn btn-primary" type="submit" value="submit">Submit</button>
                
                <button form="userform" name="button1" class="btn btn-primary" onclick="updateSubjectSched()" type="button" value="update">Update</button>
                <a href="{{url('/view/gradesheet/college',array($id))}}" ><button name="button2" class="btn btn-primary" type="button" value="view">View Grade Sheet</button></a>
                
                <!--nput type="submit" class="btn btn-primary" value="Submit" name="submit"-->


            </form>
            @endif
            @endif

        </div> 
        
        <div class="col-lg-9">
            @if(isset($notification))
            @if(count($notification)>0)
            
            <h4> Sender : <span style="color:red">{{$name}}</span></h4>
            <h4> Subject : <span style="color:red"><a href="{{url('viewgrade',array($fetchsubjects->scheduleid,$fetchsubjects->subject))}}">{{$fetchsubjects->subject}}</a></span></h4>
            
            
            <table class="table table-striped" style="padding-right:10px">
                <tr><td>Message</td><td>Date Sent</td></tr>
                @foreach($notification as $notify)
                <tr><td>
                        {{$notify->comment}}
                    </td>

                    <td>
                        {{$notify->createdat}}
                    </td>
              </tr>
                @endforeach
            </table>  
        @endif
            @endif

        </div> 
    </div>   
</div>    

<script>
    

</script>

@stop
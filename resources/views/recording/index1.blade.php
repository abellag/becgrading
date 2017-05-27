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
                  
                  $dateDiff = $now->diff($dateEnd)->format("d");
                  $dateLeft = $now->diff($dateEnd)->format("%d");
                  $messageEncode = 'Days Left for Encoding :';
                  
              }else if($now->format('y-m-d') < $dateStart->format('y-m-d') ){
                   $dateDiff = -1;
                   $dateLeft = $dateStart->format('y/m/d').'-'.$dateEnd->format('y/m/d');
                   $messageEncode = 'Encoding starts on :';
                   
              }else{
                  $dateDiff = -1;
                  $dateLeft = '';
                  $messageEncode = 'Encoding already finish.';
                  
              }
              
              $SemQuarter = $quarters->quarter;
              $Statsubjects = $quarters -> quarter ?>
        @endforeach
    @else
        <?php $dateDiff = -1 ?>
        <?php $Statsubjects = '' ?>
        <?php $Statgrade =  '' ?>
    @endif

@else
    <?php $dateDiff = -1 ?>
    <?php $Statsubjects = "0" ?>
    <?php $Statgrade =  "0" ?>
    
     
@endif


<script type="text/javascript">
    
    window.onload = function () {
        enable_input1(false,'all',<?php echo $Statgrade ?>,<?php echo "'".$Statsubjects."'";?>,<?php echo $dateDiff ?>);
        scrollDiv_init();
        
    }// my custom script
</script>

<div class="container_fluid">
    <div class="row">
        <div class="col-md-3">
            
        <div class ="list-group" style="padding-left: 20px">
            <div class="list-group-item active" style="background-color:#333300"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><b> Dashboard</b></div>    
	<div class = "list-group-item" id="profile">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Your Courses	
             
            <ul class="list-group">
                <?php $x = 1;   ?>
                @if(count($loads)>0)    
                  @foreach($loads as $load)
                                
                        <?php $x++ ?>
                    <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$x}}" aria-expanded="false" aria-controls="collapse{{$x}}">{{ $load->subject }}</a>
                        <div  id="collapse{{$x}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$x}}">
                                      
                            @if(count($data)>0) 
                                @foreach($data as $datas)
                                        @if($datas->subject == $load->subject)
                                         <li><a href="{{url('viewgrade1',array($datas->level,$datas->section,$load->subject,$datas->id))}}">{{ $datas->level }} - {{ $datas->section }}</a></li>  
                                        @endif
                                   @endforeach
                                   @endif
                                    </div>
                        
                        
        </ul>
            @endforeach
                        @endif    
        </div>
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
            <div style="float:left; padding-right: 10%"><h3> Subject : <span style="color:red">{{$subject}}</span></h3></div>
            <div style="float:right;"><h3> {{$messageEncode}} <span style="color:red">{{$dateLeft}}</span></h3></div>
            
            <table class="table table-striped" style="padding-right:10px"><tr><td>Student ID</td><td>Student Name</td><td>First Qtr</td><td>Second Qtr</td><td>Third Qtr</td><td>Fourth Qtr</td></tr>
                @foreach($subjects as $subject1)
                <tr><td>{{$subject1->studentid}}</td><td><?php echo strtoupper($subject1->lastname)?> , <?php echo ucwords(strtolower($subject1->firstname))?></td>
                   
                    
                    <td>
                        @if($SemQuarter == 'First Quarter')
                         <input  type="text" id="firstQTRN"  class="firstQTRN" maxlength="4" size="4" value= "{{$subject1->firstQTRN}}" onkeyup="addGrade('{{$subject1->id}}','1', this.value)">
                        @else
                           {{ $subject1->firstQTRN }}
                        @endif
                    </td>
                   
                    <td>
                        @if($SemQuarter == 'Second Quarter')
                        <input type="text" style="text-align:center" id="secondQTRN" class="secondQTRN"  maxlength="4" size="4" value= "{{$subject1->secondQTRN}}"  onkeyup="addGrade('{{$subject1->id}}','2', this.value)">
                        @else
                           {{ $subject1->secondQTRN }}
                        @endif
                    </td>
                    <td>
                        @if($SemQuarter == 'Third Quarter')
                         <input type="text" id="thirdQTRN" class="thirdQTRN"   style="text-align:center"  maxlength="4" size="4" value= "{{$subject1->thirdQTRN}}"  onkeyup="addGrade('{{$subject1->id}}','3', this.value)">
                        @else
                           {{ $subject1->thirdQTRN }}
                        @endif
                    </td>
                    <td>
                        @if($SemQuarter == 'Fourth Quarter')
                         <input type="text" id="fourthQTRN" class="fourthQTRN" maxlength="4"  style="text-align:center"   size="4" value= "{{$subject1->fourthQTRN}}"  onkeyup="addGrade('{{$subject1->id}}','4', this.value)">
                        @else
                           {{ $subject1->fourthQTRN }}
                        @endif
                    </td>
                    
                         <!--input type="text" id="finalMarkN" class="finalMarkN" maxlength="4"  style="text-align:center"   size="4" value= "{{$subject1->finalMarkN}}"  onkeyup="addGrade('{{$subject1->id}}','5', this.value)"-->
                           <?php
                           
                           ?>
                        
                    
                    
                </tr>
                @endforeach
            </table>    
            <form id="userform" name="userform" method="POST" action="{{url('/recording/update/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$schedid}}" name="schedid" />
                
                <div class="checkbox">
                    <label><input type="checkbox" name="check1" class="checkbox" onclick="enable_input1(this.checked, 'button', 0, 0,{{$dateDiff}})"/>  Submit Final Grade</label>
                </div>
                <button form="userform" name="button" id="button" class=" btn btn-primary" type="submit" value="submit">Submit</button>
                <a href="{{url('/view/gradesheet/highelem',array($schedid))}}" ><button name="button1" class="btn btn-primary" type="button" value="view">View Grade Sheet</button></a>
                
                <!--nput type="submit" class="btn btn-primary" value="Submit" name="submit"-->


            </form>
            @endif
            @endif
        </div>    
     </div>   
</div>    
<script>
    function addGrade(id, type, value1){
            $.ajax({
            type: "GET", 
            url: "/recording1/update/" + id + "/"+ type +"/"+ value1, 
            success:function(data){
                //alert(data);
    }
            });
 }

</script>


@stop
@extends('/recording/approver')

@section('content1')        

<script>

function addGrade1(id, type, value1){
                                    $.ajax({
                                    type: "GET",
                                            url: "/recording/update/" + id + "/" + type + "/" + value1,
                                            success:function(data){
                                            //alert(data);
                                            }
                                    });
                                    }

</script>

<div class="col-lg-9" id="grade">
            @if(isset($subjects))
            @if(count($subjects)>0)
            <h3> Subject : <span style="color:red">{{$currentsubject}}</span></h3>
            <table class="table table-striped" style="padding-right:10px"><tr><td>Student ID</td><td>Student Name</td><td>first Qtr</td><td>second Qtr</td><td>third Qtr</td><td>fourth Qtr</td><td>Finals</td><td>Action</td></tr>
                @foreach($subjects as $subject)
                <tr><td>{{$subject->studentid}}</td><td><?php echo strtoupper($subject->lastname)?> , <?php echo ucwords(strtolower($subject->firstname))?></td>
                    
                        @if($subject->status == '1' && $subject->firstQTRN < 75)
                            <td style="color: red">
                        @elseif($subject->status == '1')
                        <td style="background-color: #f2f2f2">
                        @endif
                        @if($edit==1 && $subject->status == '1')
                         <input  type="text" style="text-align:center" id="firstQTRN" name="firstQTRN" class="firstQTRN" maxlength="4" size="4" value="{{$subject->firstQTRN}}" onkeyup="addGrade1('{{$subject->id}}','1', this.value)">
                       
                        @else
                        {{ $subject->firstQTRN }}
                        @endif
                    </td>

                    <td>
                        @if($subject->status == '2' && $subject->secondQTRN < 75)
                          <td style="color: red">
                          @elseif($subject->status == '2')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status == '2')
                        <input type="text" style="text-align:center" id="secondQTRN"  maxlength="4" size="4" value= "{{$subject->secondQTRN}}"  onkeyup="addGrade('{{$subject->id}}','2', this.value)">
                        @else
                           {{ $subject->secondQTRN }}
                        @endif
                        
                    </td>
                    <td>
                        @if($subject->status == '3' && $subject->thirdQTRN < 75)
                         <td style="color: red">
                          @elseif($subject->status == '3')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status == '3')
                        <input type="text" id="thirdQTRN"   style="text-align:center"  maxlength="4" size="4" value= "{{$subject->thirdQTRN}}"  onkeyup="addGrade('{{$subject->id}}','3', this.value)">
                        @else
                           {{ $subject->thirdQTRN }}
                        @endif
                    </td>
                    <td>
                       @if($subject->status == '4' && $subject->fourthQTRN < 75)
                            <td style="color: red">
                            @elseif($subject->status == '4')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status == '4')
                       <input type="text" id="fourthQTRN" maxlength="4"  style="text-align:center"   size="4" value= "{{$subject->fourthQTRN}}"  onkeyup="addGrade('{{$subject->id}}','4', this.value)">
                        @else
                           {{ $subject->fourthQTRN }}
                        @endif
                    </td>
                    <td>
                       @if($subject->status == '5' && $subject->finalMarkN < 75)
                            <td style="color: red">
                            @elseif($subject->status == '5')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status == '5')
                       <<input type="text" id="finalMarkN" maxlength="4"  style="text-align:center"   size="4" value= "{{$subject->finalMarkN}}"  onkeyup="addGrade('{{$subject->id}}','5', this.value)">
                        @else
                           {{ $subject->finalMarkN }}
                        @endif
                    </td>
                    <td><?php
                    $newLev = intval(substr($level, -2));?>
                    @if($newLev<7)
                        <a href="{{url('/tor/elementary',array($subject->studentid,$level,$subject->department))}}" >view TOR</a>
                    @else
                        <a href="{{url('/tor/highschool',array($subject->studentid,$subject->department))}}" >view TOR</a>
                    @endif
                    </td>
                      
                    
                    


                </tr>
                @endforeach
            </table>  
            
             <form id="userform" name="userform" method="GET" action="{{url('/')}}">
                <!--input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$id}}" name="schedid" />
                <textarea form="userform" class="form-control" rows="5" name="comment" placeholder="Remarks...."></textarea> <br /-->
                <div style="float:left;"> <button  form="userform" name="button" class="btn btn-primary" type="submit" value="close">Close</button>
                   </form>
            </div> 
                <div style="float:left; margin-left: 2%">
                        <a href="{{url('/viewgradeApprover1',array($id,$level,$section,$currentsubject,$instructorid,  1))}}"><button name="button" class="btn btn-primary" value="edit">Edit</button></a> 
                        </div>
                
            
            <!--button name="button" class="btn btn-primary" onclick="showInput({{$id}}, '{{$currentsubject}}', 1)" value="edit">Edit</button-->
            
            
        @endif
        @endif
        </div>  

@stop
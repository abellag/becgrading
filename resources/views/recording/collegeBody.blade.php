@extends('/recording/approver')

@section('content1')        


<div class="col-lg-9" id="grade">
    <?php $color = "";?>
            @if(isset($subjects))
            @if(count($subjects)>0)
            <h3> Subject : <span style="color:red">{{$currentsubject}}</span></h3>
            <table class="table table-striped" style="padding-right:10px"><tr><td>Student ID</td><td>Student Name</td><td>Prelim</td><td>Midterm</td><!--td>Semifinal</td--><td>Final</td><td>Action</td></tr>
                @foreach($subjects as $subject)
                @if($subject->attendanceStatus == 1)
                    <?php $color = 'grey';?>
                @else
                    <?php $color = 'black';?>
                @endif
                <tr><td><font color = "<?php echo $color;?>">{{$subject->studentid}}</td><td><font color = "<?php echo $color;?>"><?php echo strtoupper($subject->lastName)?> , <?php echo ucwords(strtolower($subject->firstName))?></td>
                    
                        @if($subject->status2 == '1' && $subject->prelim > 3)
                            <td style="color: red">
                        @elseif($subject->status2 == '1')
                        <td style="background-color: #f2f2f2">
                        @endif
                        @if($edit==1 && $subject->status2 == '1')
                        <input  type="text" class="prelim" id="prelim" name="prelim"  maxlength="4" size="4" value= "{{$subject->prelim}}" onkeyup="addGrade('{{$subject->id2}}', '1', this.value)">
                       
                        @else
                       <font color = "<?php echo $color;?>"> {{ $subject->prelim }}
                        
                           @endif
                    </td>

                    <td>
                        @if($subject->status2 == '2' && $subject->midterm > 3)
                          <td style="color: red">
                          @elseif($subject->status2 == '2')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status2 == '2')
                         <input  type="text" class="midterm" id="midterm" name="midterm"  maxlength="4" size="4" value= "{{$subject->midterm}}" onkeyup="addGrade('{{$subject->id2}}', '1', this.value)">
                        @else
                       <font color = "<?php echo $color;?>"> {{ $subject->midterm }}
                        @endif
                        
                    </td>
                    <!--td>
                        @if($subject->status == '3' && $subject->semifinals < 75)
                         <td style="color: red">
                          @elseif($subject->status == '3')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status == '3')
                        <input  type="text" class="semifinals" id="semifinals" name="semifinals"  maxlength="4" size="4" value= "{{$subject->semifinals}}" onkeyup="addGrade('{{$subject->id2}}', '1', this.value)">
                        @else
                          {{ $subject->semifinals }}
                        @endif
                    </td-->
                    <td>
                       @if($subject->status2 == '4' && $subject->finals > 3)
                            <td style="color: red">
                            @elseif($subject->status2 == '4')
                        <td style="background-color: #f2f2f2">
                        @endif
                         @if($edit==1 && $subject->status2 == '4')
                        <input  type="text" class="finals" id="finals" name="finals"  maxlength="4" size="4" value= "{{$subject->finals}}" onkeyup="addGrade('{{$subject->id2}}', '1', this.value)">
                        @else
                       <font color = "<?php echo $color;?>"> {{ $subject->finals }}
                        @endif
                    </td>
                    <td>
                        <a href="{{url('/tor/college',array($subject->studentid,$subject->department))}}" >view</a>
                    </td>
                      
                    
                    


                </tr>
                @endforeach
            </table>  
            
             <form id="userform" name="userform" method="GET" action="{{url('/')}}">
                <!--input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$id}}" name="schedid" />
                <textarea form="userform" class="form-control" rows="5" name="comment" placeholder="Remarks...."></textarea> <br /-->
                <div style="float:left;"> <button name="button" class="btn btn-primary" type="submit" value="close">Close</button>
                   </form>
</div> 
                <div style="float:left; margin-left: 2%">
            <a href="{{url('/viewgradeApprover',array($id, $currentsubject, 1))}}"><button name="button" class="btn btn-primary" value="edit">Edit</button></a> 
                        </div>
                
            
            <!--button name="button" class="btn btn-primary" onclick="showInput({{$id}}, '{{$currentsubject}}', 1)" value="edit">Edit</button-->
            
            
        @endif
        @endif
        </div>  

@stop
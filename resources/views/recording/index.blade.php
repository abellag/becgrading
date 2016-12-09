
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
    <?php $Statsubjects = "''" ?>
    <?php $Statgrade =  "''" ?>
    
     
@endif

@section('scripts')
<script  type="text/javascript">
    
    window.onload = function () {
        scrollDiv_init();
        enable_input(false,'all',{{ $Statgrade }},{{ $Statsubjects }});
        
    }// my custom script
</script>
@stop



<div class="container_fluid">
    <div class="row">
        <div class="col-md-3">

            <div class ="list-group" style="padding-left: 20px">
                <div class="list-group-item active" style="background-color:#333300"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><b> Dashboard</b></div>    
                <div class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Your Courses	

                    <ul style="overflow:auto;height:150px" class="list-group">
                        @if(count($loads)>0)    
                        @foreach($loads as $load)
                        <li class="list-group-item"><a href="{{url('viewgrade',array($load->scheduleid,$load->subject))}}">{{ $load->subject }}</a></li>
                        @endforeach
                        @endif
                    </ul>

                </div>
                <div onMouseOver="pauseDiv()" onMouseOut="resumeDiv()" class = "list-group-item" id="profile">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Messages	

                    <ul class="list-group" id="MyDivName" style="overflow:auto;height:150px">
                        @if(count($message)>0)    
                            @foreach($message as $messages)
                            @if($messages -> status == 2)
                            <li class="list-group-item" style="background-color: #f2f2f2">
                            @else
                            <li class="list-group-item">
                            @endif
                                <a href="{{url('viewNotification',array($messages->scheduleid))}}">{{str_limit($messages->comment,15 ,'.....') }}</a></li>
                            @endforeach
                        @endif
                    </ul>

                </div>
            </div>    
        </div>
        <div class="col-lg-9">
            @if(isset($subjects))
            @if(count($subjects)>0)
            <h3> Subject : <span style="color:red">{{$currentsubject}}</span></h3>
            <table class="table table-striped" style="padding-right:10px"><tr><td>Student ID</td><td>Student Name</td><td>Prelim</td><td>Midterm</td><td>Semifinal</td><td>Final</td></tr>
                @foreach($subjects as $subject)
                <tr><td>{{$subject->studentid}}</td><td>{{$subject->lastName}}, {{$subject->firstName}}</td>
                    <td>
                        @if($subject->status == '1')
                        <input  type="text" class="prelim" id="prelim" name="prelim"  maxlength="4" size="4" value= "{{$subject->prelim}}" onkeyup="addGrade('{{$subject->id2}}', '1', this.value)">
                        @else
                        {{ $subject->prelim }}
                        @endif
                    </td>

                    <td>
                        @if($subject->status == '2')
                        <input type="text" style="text-align:center" id="midterm" name="midterm"  maxlength="4" size="4" value= "{{$subject->midterm}}"  onkeyup="addGrade('{{$subject->id2}}', '2', this.value)">
                        @else
                        {{ $subject->midterm }}
                        @endif
                    </td>
                    <td>
                        @if($subject->status == '3')
                        <input type="text" id="semifinals" name="semifinals"   style="text-align:center"  maxlength="4" size="4" value= "{{$subject->semifinals}}"  onkeyup="addGrade('{{$subject->id2}}', '3', this.value)">
                        @else
                        {{ $subject->semifinals }}
                        @endif
                    </td>
                    <td>
                        @if($subject->status == '4')
                        <input type="text" id="finals" maxlength="4" name="finals"  style="text-align:center"   size="4" value= "{{$subject->finals}}"  onkeyup="addGrade('{{$subject->id2}}', '4', this.value)">
                        @else
                        {{ $subject->finals }}
                        @endif
                    </td>


                </tr>
                @endforeach
            </table>  
            <form id="userform" name="userform" method="POST" action="{{url('/recording/update/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$id}}" name="schedid" />
                <div class="checkbox">
                    <label><input type="checkbox" name="check1" class="checkbox" onclick="enable_input(this.checked, 'button', 0, 0)"/>  Submit Final Grade</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="check2" class="checkbox" onclick="enable_input(this.checked, 'comment', 0, 0)"/> Add Comment</label>
                </div>
                <textarea form="userform" class="form-control" rows="5" name="comment" placeholder="Insert important message for grades...."></textarea> <br />
                <button name="button" class="btn btn-primary" type="submit" value="submit">Submit</button>
                <!--input type="submit" class="btn btn-primary" value="Submit" name="submit"-->


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
                                            url: "/recording/update/" + id + "/" + type + "/" + value1,
                                            success:function(data){
                                            //alert(data);
                                            }
                                    });
                                    }

</script>


@stop
@extends('app')


@section('content')


<div class="container_fluid">
    <div class="row">
        <div class="col-md-3">
            
        <div class ="list-group" style="padding-left: 20px">
            <div class="list-group-item active" style="background-color:#333300"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><b> Dashboard</b></div>    
	<div class = "list-group-item" id="profile">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Your Courses	
             
            <ul class="list-group">
         @if(count($loads)>0)       
            @foreach($loads as $load)
            <li class="list-group-item"><a href="{{url('viewgrade1',array($load->level,$load->subject))}}">{{$load->level}} - {{$load->subject}}</a></li>
         @endforeach
         @endif
        </ul>
                
        </div>
            </div>    
        </div>
        <div class="col-lg-9">
            @if(isset($subjects))
            @if(count($subjects)>0)
            <h3> Subject : <span style="color:red">{{$subject}}</span></h3>
            <table class="table table-striped" style="padding-right:10px"><tr><td>Student ID</td><td>Student Name</td><td>first Qtr</td><td>second Qtr</td><td>third Qtr</td><td>fourth Qtr</td><td>Finals</td></tr>
                @foreach($subjects as $subject1)
                <tr><td>{{$subject1->studentid}}</td><td>{{$subject1->lastName}} , {{$subject1->firstName}}</td>
                    <td>
                        @if($subject1->status == '1')
                         <input  type="text" id="firstQTRN"  maxlength="4" size="4" value= "{{$subject1->firstQTRN}}" onkeyup="addGrade('{{$subject1->id2}}','1', this.value)">
                        @else
                           {{ $subject1->firstQTRN }}
                        @endif
                    </td>
                   
                    <td>
                        @if($subject1->status == '2')
                        <input type="text" style="text-align:center" id="secondQTRN"  maxlength="4" size="4" value= "{{$subject1->secondQTRN}}"  onkeyup="addGrade('{{$subject1->id2}}','2', this.value)">
                        @else
                           {{ $subject1->secondQTRN }}
                        @endif
                    </td>
                    <td>
                        @if($subject1->status == '3')
                         <input type="text" id="thirdQTRN"   style="text-align:center"  maxlength="4" size="4" value= "{{$subject1->thirdQTRN}}"  onkeyup="addGrade('{{$subject1->id2}}','3', this.value)">
                        @else
                           {{ $subject1->thirdQTRN }}
                        @endif
                    </td>
                    <td>
                        @if($subject1->status == '4')
                         <input type="text" id="fourthQTRN" maxlength="4"  style="text-align:center"   size="4" value= "{{$subject1->fourthQTRN}}"  onkeyup="addGrade('{{$subject1->id2}}','4', this.value)">
                        @else
                           {{ $subject1->fourthQTRN }}
                        @endif
                    </td>
                    <td>
                        @if($subject1->status == '5')
                         <input type="text" id="finalMarkN" maxlength="4"  style="text-align:center"   size="4" value= "{{$subject1->finalMarkN}}"  onkeyup="addGrade('{{$subject1->id2}}','5', this.value)">
                        @else
                           {{ $subject1->finalMarkN }}
                        @endif
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
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
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> For Approval	

                    <ul class="list-group">

                        @if(count($loads)>0)    
                        @foreach($loads as $load)
                        <?php $x = 1;
                        
                        $x++ ?>
                        <ul class="list-group-item"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$x}}" aria-expanded="false" aria-controls="collapse{{$x}}">{{ $load->instructorid }}</a>
                                    <div  id="collapse{{$x}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$x}}">
                                        
                                    @if(count($data)>0)    
                                   @foreach($data as $datas)
                                        
                                        @if(
                                        $datas->instructorid == $load->instructorid)
                                         <li><a href="{{url('viewgradeApprover',array($datas->scheduleid,$datas->subject))}}">{{ $datas->subject }}</a></li>  
                                        @endif
                                   @endforeach
                                   @endif
                                   </div>
                        </ul>
                        @endforeach
                        @endif


                        <li class="list-group-item"></li>

                        `</ul>

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
                    
                        @if($subject->status == '1' && $subject->prelim < 75)
                        <td style="background-color: red">
                        @elseif($subject->status == '1')
                        <td style="background-color: #f2f2f2">
                        @endif
                        {{ $subject->prelim }}
                    </td>

                    <td>
                        @if($subject->status == '2' && $subject->midterm < 75)
                        <td style="background-color: red">
                        @elseif($subject->status == '2')
                        <td style="background-color: #f2f2f2">
                        @endif
                        {{ $subject->midterm }}
                    </td>
                    <td>
                        @if($subject->status == '3' && $subject->semifinals < 75)
                        <td style="background-color: red">
                        @elseif($subject->status == '3')
                        <td style="background-color: #f2f2f2">
                        @endif
                        {{ $subject->semifinals }}
                    </td>
                    <td>
                       @if($subject->status == '4' && $subject->finals < 75)
                        <td style="background-color: red">
                        @elseif($subject->status == '4')
                        <td style="background-color: #f2f2f2">
                        @endif
                        {{ $subject->finals }}
                    </td>


                </tr>
                @endforeach
            </table>  
             <form id="userform" name="userform" method="POST" action="{{url('/recording/update/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$id}}" name="schedid" />
                <textarea form="userform" class="form-control" rows="5" name="comment" placeholder="Remarks...."></textarea> <br />
                <button name="button" class="btn btn-primary" type="submit" value="approve">Approve</button>
                <button name="button" class="btn btn-primary" type="submit" value="disapprove">Disapprove</button>
                
            </form>
        @endif
        @endif
        </div>    
    </div>   
</div>    



@stop

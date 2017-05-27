@extends('app')

@section('content')
<style>
     @media print{
        @page{
       margin-top:1mm;
        margin-right: 3mm;
        margin-left: 3mm;
        margin-bottom: 0mm;
        }
      }
     #table,  #tr, #th, #td {
    border-style : solid;
    border-color :black;
    border-width : 1px;
    height: 20px;
         }
         
         #table{
             width:100%;
         }
         
         #tr, #th, #td {
             width:7%;
         }
         #th{
             height: 30px;
    
         }
         
</style>

<div class="col-lg-2"></div>
<div class="col-lg-8"  id="grade" >
    <div class="panel" style="font-family: 'Georgia', Georgia, serif;padding-left:3%;">
        <div class="panel-heading" >
            <br/>
            <br/>
        
              <table>
                <tr>
                    <td style="width: 40%; padding-right: 8%;" align="right"><img   src="{{URL::asset('images/logo.jpg')}}" alt="profile Pic"></td>
                    <td style="width: 50%;" align="center"><p>
                <b><span style="font-size:16px;">BATANGAS EASTERN COLLEGES</span><br/>
            San Juan, Batangas </b><br/><br/>
            <b>COLLEGE DEPARTMENT</b>
            </p></td>
                    <td style="width: 10%;"></td>
                  
                </tr> 
                
            </table>
            
            
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                   <p align="center" style="font-size:18px;"><b>GRADE SHEET</b><br/></p>
                </div>
            </div>
             
            <table style="width: 100%;">
                @if(count($details)>0)
                @foreach($details as $detail)
                    <tr>
                        <td width="50%" ><div style="float:left; width: 10%">Professor:</div><div style="height: 17px ; padding-left: 10%; float:left; width: 85%;border-bottom:1px solid;">{{$detail->fname}}&nbsp; {{$detail->lname}}</div></td>
                        <td width="50%"><div style="float:left; width: 15%">Course:</div><div style="height: 17px ; float:left;width: 80%;border-bottom:1px solid;">{{$detail->course}}</div></td>
                    </tr>
                    <tr>
                        <td width="50%"><div style="float:left; width: 30%">Subject:</div><div style="height: 17px ; float:left;width: 65%;border-bottom:1px solid;">{{$detail->subject}}</div></td>
                        <td width="50%"><div style="float:left; width: 35%">Description:</div><div style="height: 17px ; font-size: 10px; float:left;width: 60%;border-bottom:1px solid;"></div></td>
                    </tr>
                    <tr>
                        <td><div style="float:left; width: 25%">Day and Time:</div><div style="height: 17px ; float:left;width: 70%;border-bottom:1px solid;">{{$detail->scheduleday}}-{{$detail->scheduletime}}</div></td>
                        <td><div style="float:left; width: 25%">Room:</div><div style="height: 17px ; float:left;width: 70%;border-bottom:1px solid;">{{$detail->room}}</div></td>
                    </tr>
                 @endforeach
                 @endif
                </table>
                
            <br/>
            
           <br/>
            <div style="margin-left:1%; margin-right: 4%;">
                <table id="table">
                    <tr id="tr">
                        <th id="th">No</th>
                        <th id="th" width="40%">Name</th>
                        <th id="th">Prelim</th>
                        <th id="th">Midterm</th>
                        <th id="th">Final</th>
                        <th id="th">Remarks</th>
                    </tr>
                    <?php $x = 0; $sumQuarter = 0;?>
                    @if(isset($subjects))
                        @if(count($subjects)>0)
                            @foreach($subjects as $subject)
                            <?php $x= $x+1;?>
                        <tr id="tr">
                            <td id="td">{{$x}}</td>
                            <td id="td" width="40%"><?php echo strtoupper($subject->lastName)?> , <?php echo ucwords(strtolower($subject->firstName))?></td>
                            <td id="td">{{$subject->prelim}}</td>
                            <td id="td">{{ $subject->midterm }}</td>
                            <td id="td">{{ $subject->finals }}</td>
                            <?php $sumQuarter = ($subject->prelim + $subject->midterm + $subject->finals)/3;
                                if($sumQuarter > 3 || $sumQuarter == 0){
                                    $remarks = 'Failed';
                                }  else
                                {
                                    $remarks = 'Passed';
                                }
                                
                            ?>
                            <td id="td">{{$remarks}}</td>
                        </tr> 
                            @endforeach
                        @endif
                    @endif
                    @while($x < 52)
                    <tr id="tr">
                        <td id="td"></td><td id="td"></td><td id="td"></td>
                        <td id="td"></td><td id="td"></td><td id="td"></td>
                    </tr>
                        
                        <?php $x++;?>
                @endwhile
                    
                </table>
            </div>
            <div>
                <br/>
                
                <br/>
                <div>
                   
                </div>
                <p>
                    <table style="width: 100%;">
                        <?php
                        $dateToday = date("F d, Y");
                        ?>
                        <tr>
                            <td align="center" style="height: 17px ; float:left; width: 80%;border-bottom:1px solid;">{{$dateToday}}</td>
                            <td></td>
                            <td align="center" style="height: 17px ; float:left; width: 80%;border-bottom:1px solid;"></td>
                            
                        </tr>
                        <tr>
                            <td align="center" style="padding-right:8%;">Date of Submission</td>
                            <td></td>
                            <td align="center" style="padding-right:8%;">Professor's Signature</td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center" style="height: 17px ; float:left; width: 80%;border-bottom:1px solid;"></td>
                            <td align="center"></td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center" style="padding-right:8%;">Department Head</td>
                            <td align="center"></td>
                        </tr>
                        
                    </table>
                    </p>
                    <div>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                
                    
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
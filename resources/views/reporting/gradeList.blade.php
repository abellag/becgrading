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
        
            
            
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                   <p align="center" style="font-size:18px;"><b>Grade Per Subject</b><br/></p>
                </div>
            </div>
             
            <table style="width: 100%;">
                @if(count($details)>0)
                @foreach($details as $detail)
                    <tr>
                        <td width="50%" ><div style="float:left; width: 10%">Teacher</div><div style="height: 17px ; padding-left: 10%; float:left; width: 85%;border-bottom:1px solid;">{{$detail->fname}}&nbsp; {{$detail->lname}}</div></td>
                        <td width="50%"><div style="float:left; width: 30%">Grade & Section:</div><div style="height: 17px ; float:left;width: 60%;border-bottom:1px solid;">{{$detail->level}}-{{$detail->section}}</div></td>
                    </tr>
                    <tr>
                        <td width="50%"><div style="float:left; width: 30%">Subject:</div><div style="height: 17px ; float:left;width: 65%;border-bottom:1px solid;">{{$detail->subject}}</div></td>
                        <td width="50%"><div style="float:left; width: 35%"></div></td>
                    </tr>
                    
                 @endforeach
                 @endif
                </table>
                
            <br/>
            
           <bry
            <div style="margin-left:1%; margin-right: 4%;">
                <table id="table">
                    <tr id="tr">
                        <th id="th">NO</th>
                        <th id="th" width="40%">LEARNER'S NAME</th>
                        <th id="th">First Quarter</th>
                        <th id="th">Second Quarter</th>
                        <th id="th">Third Quarter</th>
                        <th id="th">Fourth Quarter</th>
                        <th id="th">Final Quarter</th>
                        <th id="th">Remarks</th>
                    </tr>
                    <?php $x = 0;?>
                    @if(isset($subjects))
                        @if(count($subjects)>0)
                            @foreach($subjects as $subject)
                            <?php $x= $x+1;?>
                        <tr id="tr">
                            <td id="td">{{$x}}</td>
                            <td id="td" width="40%"><?php echo strtoupper($subject->lastname)?> , <?php echo ucwords(strtolower($subject->firstname))?></td>
                            <td id="td">{{$subject->firstQTRN}}</td>
                            <td id="td">{{ $subject->secondQTRN }}</td>
                            <td id="td">{{$subject->thirdQTRN}}</td>
                            <td id="td">{{ $subject->fourthQTRN }}</td>
                            <td id="td">{{ $subject->finalMarkN }}</td>
                            <td id="td">Failed</td>
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
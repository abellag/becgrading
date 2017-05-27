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

<div class="col-lg-12"  id="grade" >
    <div class="panel" style="font-family: 'Georgia', Georgia, serif;">
        <div class="panel-heading" >
            <br/>
            <br/>
        
            
            
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                   <p align="center" style="font-size:18px;"><b>Summary Grade Per Section</b><br/></p>
                </div>
            </div>
             
            <table style="width: 100%;">
                @if(count($teachersDetail)>0)
                @foreach($teachersDetail as $teachersDetails)
                    <tr>
                        <td width="50%" ><div style="float:left; width: 10%">Adviser</div><div style="height: 17px ; padding-left: 10%; float:left; width: 85%;border-bottom:1px solid;">{{$teachersDetails->fname}}&nbsp; {{$teachersDetails->lname}}</div></td>
                        <td width="50%"><div style="float:left; width: 30%">Grade & Section:</div><div style="height: 17px ; float:left;width: 60%;border-bottom:1px solid;">{{$teachersDetails->level}}-{{$teachersDetails->section}}</div></td>
                    </tr>
                    <tr>
                        <td width="50%"><div style="float:left; width: 30%"></div></td>
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
                        <th id="th">Count</th>
                            <th id="th">Student Id</th>
                            <th id="th">Student Name</th>
                        <?php $i = 0;?>
                        @if(isset($subject))
                            @if(count($subject)>0)
                            @foreach($subject as $subjects)
                            <?php $i = $i + 1;
                            $subjectsArray[] = $subjects->subject;
                            ?>
                            <th id="th">{{$subjects->subject}}</th>
                            
                            @endforeach
                            @endif
                        @endif
                        <th id="th">Final Average</th>
                        <th id="th">Remarks</th>
                    </tr>
                   <?php $x = 0; $y=0; $arrayGrade[]=array(); $arrayNumber= array(); $average=0; $finalAverage=0;?>
                    @if(isset($student))
                        @if(count($student)>0)
                            @foreach($student as $students)
                            <?php $x= $x+1;?>
                        <tr id="tr">
                            <td id="td">{{$x}}</td>
                            <td id="td">{{$students->studentid}}</td> 
                            <td id="td"><?php echo strtoupper($students->lastname)?> , <?php echo ucwords(strtolower($students->firstname))?></td>
                            
                            @if(isset($gradeDetails))
                                @if(count($gradeDetails)>0)
                                
                                    @foreach($gradeDetails as $gradeDetail)
                                    <?php $y = 0;?>
                                        @while($y<$i)
                                        <?php 
                                        
                                        if ($gradeDetail->studentid == $students->studentid && $gradeDetail->subject == $subjectsArray[$y])
                                        {$arrayGrade[$y] = '<td id="td">'.$gradeDetail->final.'</td>'; 
                                         $arrayNumber[] = $y;
                                         $average = $average + $gradeDetail->final;
                                         }
                                        
                                        $y = $y+1; ?>
                                        @endwhile  
                                        <?php ?>
                                    @endforeach
                                    <?php $y = 0;?>
                                            
                                        @while($y<$i)
                                           <?php
                                            if (in_array($y, $arrayNumber)) {
                                                 echo $arrayGrade[$y];
                                            }else{
                                                echo '<td id="td">No Grade</td>';
                                            }
                                                $y = $y+1; 
                                            ?>
                                        @endwhile
                                       
                                    
                                    
                                @endif
                            @endif
                            <?php 
                            $finalAverage = $average/$i;
                            $roundAverage = round($finalAverage,2);            
                            if($roundAverage > 74){
                                $remarks = 'Passed';}
                            else{$remarks = 'Failed';}
                            
                            
                            ?>
                            <td id="td">{{$roundAverage}}</td>
                            <?php $roundAverage = 0;
                                  $average = 0;
                            ?>
                            <td id="td">{{$remarks}}</td>
                            </tr> 
                            @endforeach
                        @endif
                    @endif
                   
                    
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
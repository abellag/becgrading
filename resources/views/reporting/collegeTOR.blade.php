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
        #tdhdr{
            width: 50%;
        }
        
    }
</style>

<style>
   
    

#table #th{
    border-style : solid;
    border-color :black;
    border-width : 1px;
    
        }

#th {
    border: 1px solid;
    height: 5%;
    text-align:center;
   
}

#td{
    border-left: 1px solid ;
    border-right: 1px solid;
    height: 5%;
    padding-left: 2%;
    text-align:left;
   
}

#tr:last-child {
    border-bottom: 1px solid;
    height: 90%;
}

.newtable{
    border: none;
    width: 100%;
    border-bottom: none;
    border-left: none;
    border-right: none;
    border-top: none;
}

#table{
            width:100%;
        }
        #th{
            height: 40px;
            text-align: center;
        }
        
       #td{height: 20px;}
       #td1{
           text-align: center;
       }

       #tdDiv{
            position: absolute;
    border-bottom: 1px solid;
       }

 .td3 {
            width: 100%;
            border-bottom: 5px solid red;
            position: relative;
        }
 
        .td3:after {
            content: '';
            position: absolute;
            width: 200px;
            bottom:-10px;
            left:-20%;
            
            border: 5px solid white;
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
                    <td id="tdhdr" align="right" style="padding-right:5%;width: 25%;"><img  src="{{URL::asset('images/logo.jpg')}}" alt="logo Pic"></td>
                    <td style="width: 50%;" align="center"><p>
                <b><span style="font-size:16px;">BATANGAS EASTERN COLLEGES</span><br/>
            San Juan, Batangas </b><br/>
            <b>OFFICE OF THE REGISTRAR</b>
            </p></td>
                   <?php $photo = $studentid.'-'.$department.'.jpg'; ?> 
                    <td id="tdhdr" align="right" style="padding-right:3%;width: 25%;"><img style="width: 80%; height: auto; border: 1px solid;"   src="/images/studentphoto/<?php echo $photo?>" alt="profile Pic" border="5"></td>
                    
                  
                </tr> 
                
            </table>
            
            
        </div>
        <div id="panelBody">
            <div class="row">
                <div class="col-md-12">
                   <p align="center" style="font-size:18px;"><b>OFFICIAL TRANSCRIPT OF RECORDS</b><br/></p>
                </div>
            </div>
             
            @if(count($studentInfo)>0)
                @foreach($studentInfo as $studentInfos)
               
                <table style="width: 100%;">
                    <tr>
                        <td width="50%" ><div style="float:left; width: 10%">Name:</div><div style="height: 17px ; float:left; width: 80%;padding-left: 5%;border-bottom:1px solid;"><?php echo ucwords(strtolower($studentInfos->lastName))?>, <?php echo ucwords(strtolower($studentInfos->firstName))?>&nbsp;&nbsp; <?php echo ucwords(strtolower($studentInfos->middleName))?></div></td>
                        <td width="50%"><div style="float:left; width: 15%">Address:</div><div style="height: 17px ; float:left;width: 80%;border-bottom:1px solid;"><?php echo ucwords(strtolower($studentInfos->address))?></div></td>
                    </tr>
                    <tr>
                        <td width="50%"><div style="float:left; width: 35%">Date of Addmission:</div><div style="height: 17px ; float:left;width: 55%;border-bottom:1px solid;">{{$studentInfos->semester}}, {{$studentInfos->schoolyear}}</div></td>
                        <td width="50%"><div style="float:left; width: 40%">Entrance Credentials:</div><div style="height: 17px ; font-size: 10px; float:left;width: 55%;border-bottom:1px solid;"><b>Form 137-A form</b></div></td>
                    </tr>
                    <tr>
                        <?php
                            $date=date_create($studentInfos->birthDate);
                           // echo date_format($date,"Y/m/d H:i:s");
                         ?> 
                        <td><div style="float:left; width: 25%">Date of Birth:</div><div style="height: 17px ; float:left;width: 70%;border-bottom:1px solid;"><?php echo date_format($date, 'F d, Y'); ?></div></td>
                        <td><div style="float:left; width: 25%">Place of Birth:</div><div style="height: 17px ; float:left;width: 70%;border-bottom:1px solid;"><?php echo ucwords(strtolower($studentInfos->birthPlace))?></div></td>
                    </tr>
                    
                </table>
                
            <br/>
            
            <table width="100%">
                <tr>
                    <td> <b>PRELIMINARY EDUCATION/ACADEMIC RECORD:</b></td>
            </tr>
            </table>
            
            <table style="width: 100%;">
                <?php $x = 0; ?>
                @if(count($schoolRecord) > 0)
                @foreach($schoolRecord as $schoolRecords)
                        @if($x == 0)
                     <tr>
                        <td width="50%" ><div style="float:left; width: 30%">Elementary School</div><div style="height: 17px ; float:left; width: 65%;border-bottom:1px solid;">{{$schoolRecords->schoolAttended}}</div></td>
                        <td width="50%"><div style="float:left; width: 25%">Date Graduated</div><div style="height: 17px ; float:left;width: 70%;border-bottom:1px solid;">{{$schoolRecords->schoolyear}}</div></td>
                    </tr>
                    @elseif($x == 1)
                    <tr>
                        <td width="50%"><div style="float:left; width: 20%">High School</div><div style="height: 17px ; float:left;width: 75%;border-bottom:1px solid;">{{$schoolRecords->schoolAttended}}</div></td>
                        <td width="50%"><div style="float:left; width: 25%">Date Graduated</div><div style="height: 17px ; float:left;width: 70%;border-bottom:1px solid;">{{$schoolRecords->schoolyear}}</div></td>
                    </tr>
                    @else
                    <tr>
                        <td><div style="float:left; width: 35%">Degree/Title Earned</div><div style="height: 17px ; float:left;width: 60%;border-bottom:1px solid;">{{$schoolRecords->schoolAttended}}</div></td>
                        <td><div style="float:left; width: 30%">Date of Graduation</div><div style="height: 17px ; float:left;width: 65%;border-bottom:1px solid;">{{$schoolRecords->schoolyear}}</div></td>
                    </tr>
                    @endif
                    <?php $x++;?>
                    @endforeach
                @endif
                
                    
                    
                    
                </table>
            
            <br/>
            <table style="width: 100%;">
                    <tr>
                        <td width="100%" ><div style="float:left; width: 10%">Major:</div><div style="height: 17px ; float:left; width: 85%;border-bottom:1px solid;"></div></td>
                        </tr>
                    
                </table>
               
                </div>
            
                @endforeach
            @endif
            <br/>
            <div style="margin-left:1%; margin-right: 4%; background-position: center !important; background-repeat: no-repeat !important; background-image:url(/images/1batangas-eastern-colleges-logo.jpg) !important;background-size: 50% !important">
                <table id="table" >
                    <tr id="tr"><th id="th" rowspan="2">TERM</th><th id="th" rowspan="2">SUBJECTS</th><th id="th" colspan="2">Grades</th><th id="th" rowspan="2">CREDITS</th>
                        </tr>
                        <tr><th id="th">Final</th><th id="th">RE-EXAM</th></tr>
                       @if(count($SYrecord)>0)
                        @foreach($SYrecord as $SYrecords)
                        <tr id="tr">
                            <td id="td"></td>
                            <td id="td" style="text-align:center; text-decoration: underline;"><b>{{$SYrecords->semester}}<br>
                                    {{$SYrecords->schoolyear}}</b>
                            </td>
                            <td id="td"></td>
                            <td id="td"></td>
                            <td id="td"></td>
                        </tr> 
                        <?php $tempSubject = "";?>
                        @if(count($records)>0)
                        @foreach($records as $record)
                        @if($record->semester == $SYrecords->semester && $record->schoolYear == $SYrecords->schoolyear)
                        <tr id="tr">
                            @if($tempSubject == $record->subject)
                            
                            @else
                            <td id="td">{{$record->subjcode}}</td>
                            <td id="td">{{$record->subject}}</td>
                            <?php 
                            $tempSubject = $record->subject;
                            $final = $record->prelim + $record->midterm + $record->finals;
                            $finalAve = $final/4;
                            ?>
                            <td id="td">{{$finalAve}}</td>
                            <td id="td"></td>
                            <td id="td">{{$record->unit}}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                       @endif
                        <tr id="tr">
                            <td id="td"></td>
                            <td id="td1"><b>xxxxx END OF TRANSCRIPT xxxxx<br/><br/>
                            <!--Graduated with One Year Nursing Aide<br/>
                            Special Order(D)(R-IV) No.1406-0307 s. 2007 dated <br/>
                            May 21, 2007.-->
                                </b></td>
                              <td id="td"></td>
                               <td id="td"></td>
                                <td id="td"></td>
                        </tr>
                </table>
            </div>
            <div>
                <br/>
                
                <br/>
                <div>
                    <table id="table">
                        <caption style="color:black;"><b>GRADING SYSTEM:</b></caption>
                        <tr>
                            <td>1.00 - 99-100</td>
                            <td>1.50 - 93-95</td>
                            <td>2.00 - 87-89</td>
                            <td>2.50 - 81-83</td>
                            <td>3.00 - 75-77</td>
                        </tr>
                        <tr>
                            <td>1.25 - 96-98</td>
                            <td>1.75 - 90-92</td>
                            <td>2.25 - 84-86</td>
                            <td>2.75 - 78-80</td>
                            <td>5.00 - 74 and below</td>
                        </tr>
                        <tr>
                            <td>INC - Incomplete</td>
                            <td>DRP - Dropped</td>
                            <td>OD - Officially Dropped</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>75-100 - Competent</td>
                            <td>74 and below - Not Competent</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                        
                        
                        <td></td>
                        <td></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <br/>
                    <div><b>REMARKS:</b></div>
                    <br/>
                    </div>
                
                <p>
                    <table style="width: 100%;">
                        <tr>
                            <td><b>(NOT VALID WITHOUT SCHOOL SEAL)</b></td>
                            <td></td>
                            <td></td>
                            
                        </tr>
                        <tr>
                            <td align="center">Prepared by:</td>
                            <td>Checked and verified by:</td>
                            <td align="center"></td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center" style="text-decoration: underline;">JOY J. ALDAY</td>
                            <td align="center" style="text-decoration: underline;"> &nbsp;&nbsp;&nbsp;MARIA CRISANTA R. ISLA&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center">Assistant Registrar</td>
                            <td align="center">Registrar</td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center" style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("F d, Y"); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center">Date</td>
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
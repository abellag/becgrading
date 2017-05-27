/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function enable_input(status, name, gradeStat, subjectStat, dateDiff){
    status=!status;
    
    
    if(name === "comment"){
        document.userform.comment.disabled=status;
    }else if(name === "button"){
        document.userform.button.disabled=status;
        
    }else if(((name === 'all') && ((gradeStat === 1 ) || (gradeStat === 2)))||dateDiff < 0){
        if(subjectStat === 'Prelim'){
            var x = document.getElementsByClassName("prelim");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 'Midterm'){
            var x = document.getElementsByClassName("midterm");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 3){
            var x = document.getElementsByClassName("semifinals");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 'Final'){
            var x = document.getElementsByClassName("finals");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else{
          //  document.userform.comment.disabled=status;
             document.userform.button.disabled=status;
        }
        
        
        document.userform.check1.disabled=status;
      //  document.userform.check2.disabled=status;
      //  document.userform.comment.disabled=status;
        document.userform.button.disabled=status;
        
    }else if(name === 'all'){
        document.userform.button.disabled=status;
        //document.userform.comment.disabled=status;
        
    }else if(dateDiff > 0){
        alert(dateDiff);
    }
    
   
}


function enable_input1(status, name, gradeStat, subjectStat,dateDiff){
    status=!status;
    
    
    if(name === "comment"){
        document.userform.comment.disabled=status;
    }else if(name === "button"){
        document.userform.button.disabled=status;
        
    }else if((name === 'all') && ((gradeStat === 1 ) || (gradeStat === 2))||dateDiff < 00){
        if(subjectStat === 'First Quarter'){
            var x = document.getElementsByClassName("firstQTRN");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 'Second Quarter'){
            var x = document.getElementsByClassName("seconQTRN");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 'Third Quarter'){
            var x = document.getElementsByClassName("thirdQTRN");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 'Fourth Quarter'){
            var x = document.getElementsByClassName("fourthQTRN");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
                
            }
            document.userform.button.disabled=status;
        }else if(subjectStat === 'Final Mark'){
            var x = document.getElementsByClassName("finalMarkN");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.userform.button.disabled=status;
        }else{
            document.userform.comment.disabled=status;
            document.userform.button.disabled=status;
        }
        document.userform.check1.disabled=status;
     //   document.userform.check2.disabled=status;
      //  document.userform.comment.disabled=status;
     //   document.userform.button.disabled=status;
        
        
    }else if(name === 'all'){
        document.userform.button.disabled=status;
        
    }
    
   
}

    
    
ScrollRate = 100;

function scrollDiv_init() {
	DivElmnt = document.getElementById('MyDivName');
	ReachedMaxScroll = false;
	
	DivElmnt.scrollTop = 0;
	PreviousScrollTop  = 0;
	
	ScrollInterval = setInterval('scrollDiv()', ScrollRate);
}

function scrollDiv() {
	
	if (!ReachedMaxScroll) {
		DivElmnt.scrollTop = PreviousScrollTop;
		PreviousScrollTop++;
		
		ReachedMaxScroll = DivElmnt.scrollTop >= (DivElmnt.scrollHeight - DivElmnt.offsetHeight);
	}
	else {
		ReachedMaxScroll = (DivElmnt.scrollTop == 0)?false:true;
		
		DivElmnt.scrollTop = PreviousScrollTop;
		PreviousScrollTop--;
	}
}

function pauseDiv() {
	clearInterval(ScrollInterval);
}

function resumeDiv() {
	PreviousScrollTop = DivElmnt.scrollTop;
	ScrollInterval    = setInterval('scrollDiv()', ScrollRate);
}


function getValue(level){
        console.log(level);
        var section = "ctrSection";
        var subject = "ctrSubjects";
        var i;

            $.ajax({
                    type: "GET",
                     url: "/register/grades/" + level+"/"+section ,
                     success:function(data){
                         $('#section').empty();
                         $.each(data, function(index, items) {
                            $('#section').append('<option value="'+items.section+'">'+items.section+'</option>');
                         });
                            
                       }
                    });
                    
             $.ajax({
                    type: "GET",
                     url: "/register/grades/" + level+"/"+subject ,
                     success:function(data){
                         $('#subject').empty();
                         $.each(data, function(index, items) {
                            
                            $('#subject').append('<tr><td><input type="checkbox" name="ch[]" value="'+items.subject+'"/></td><td>'+items.subject+'</td></tr>');
                            });
                       }
                    });
                };
                
                
function showInput(id,currentsubject,edit){
    $.ajax({
    type: "GET",
    url: "/viewgradeApprover/" + id + "/" + currentsubject + "/" +edit,
    success: function(data) {
        alert(data);
        document.location='/recording/collegeSetup';
      //load(document.('/setup/quarterly/')) + '#grade');
    }
       
    });
    //document.getElementById("demo").innerHTML = "<input type='text'>";
                       
}




function addGrade(id, type, value1){
                                    $.ajax({
                                    type: "GET",
                                            url: "/recording/update/" + id + "/" + type + "/" + value1,
                                            success:function(data){
                                            //alert(data);
                                            }
                                    });
                                    }
                                    
 
        


     

function getSearchTeacher(){
$.ajax({
         type:"GET",
         url:"/view/teacher/search/",
          success:function(data){   
              $("#div1").empty();
              $("#div1").html(data);
}
});
};



function getTeacher(event){
       if (event.keyCode == 13) {
           var teacher =   document.getElementById("teacher");
            event.preventDefault();
            $.ajax({
                type: "GET",
                    url: "/view/teacher/list/"+teacher.value,
                    success:function(data){
                        $('#teacherData').empty();
                        $.each(data, function(index,items)
                        {
                            
                            $('#teacherData').append('<tr><td>'+items.instructorid+'</td><td>'+items.fname+' '+items.lname+'</td><td>'+items.subject+'</td>\n\
                                                 <td>'+items.level+'</td><td>'+items.section+'</td>\n\
                                                 <td><a href="/view/teacher/gradeList/'+items.id+'";>View</td></tr>');
                        });
                    }
            });
            
        }
}






        
function searchTeacherRecord($id){
    $.ajax({
        type:"GET",
        url:"/view/teacher/gradeList/"+$id
       
        
    });
}


function getGrade(){
    $.ajax({
        type:"GET",
        url:"/view/grade/",
          success:function(data){   
              $("#div1").empty();
              $("#div1").html(data);
}
       
        
    });
}

     
 function getGradeRecord(event){
       if (event.keyCode == 13) {
           var grade =   document.getElementById("grade");
            event.preventDefault();
            $.ajax({
                type: "GET",
                    url: "/view/grade/record/"+grade.value,
                    success:function(data){
                        $('#gradeData').empty();
                        $.each(data, function(index,items)
                        {
                            $('#gradeData').append('<tr><td>'+items.level+'</td><td>'+items.section+'</td><td>'+items.fname+' '+items.lname+'</td>\n\
                                                 \n\
                                                 <td><a href="/view/grade/record/list/'+items.id+'";>View</td></tr>');
                        });
                    }
            });
            
        }
}    
     
     
     
   
function getSearch(){
$.ajax({
         type:"GET",
         url:"/test",
          success:function(data){   
              $("#div1").empty();
              $("#div1").html(data);
}
});
};

function getRegister(){
$.ajax({
         type:"GET",
         url:"/get/user",
          success:function(data){   
              $("#div1").empty();
              $("#div1").html(data);
}
});
};

      
      function deleteSchoolRecord(studentId,id){
     $.ajax({
         type:"DELETE",
            url:"/delete/schoolrecord/"+studentId+"/"+id,
            data:{
                 "_token": $('#token').val()
            },
            success:function(data){
                $('#school').empty();
                $.each(data,function(index,items)
                {
                    $('#school').append('<tr><td>'+items.schoolyear+'</td><td>'+items.schoolAttended+'</td>\n\
                                                 <td>'+items.level+'</td><td>'+items.schoolDays+'</td><td>'+items.presentDays+'</td>\n\
                                                 <td>'+items.finalrating+'</td><td><a href="#" onclick="deleteSchoolRecord('+items.studentid+','+items.id+')">Delete</td></tr>');
                });
            }
     });
 }
 
 
        
 function checkValue(toYear){
     var fromYear =   document.getElementById("fromYear");
          
     if (toYear < fromYear.value){
       $("select.toYear").val('1950');
       
         alert("Please Select To Year Greater than From Year");
        }
    
 }
 function checkValues(fromYear){
     var toYear =   document.getElementById("toYear");
           
     if (toYear.value < fromYear){
         $("select.toYear").val('1950');
       
         alert("Please Select To Year Greater than From Year");
     }
 }
        
        
function getTOR(event){
    //event.preventDefault();
     if (event.keyCode === 13) {
           var department =   document.getElementById('department');
           var studentName = document.getElementById("studentName");
           var link;
            event.preventDefault();
            $.ajax({
                type: "GET",
                url: "/view/tor/"+department.value+"/"+studentName.value,
                processData: false,
                contentType: false,
                success:function(data){
                        $('#student').empty();
                        $.each(data, function(index,items)
                        {   if(items.department === 'College' || items.department === 'Diploma'){
                              link = '/tor/college/'+items.studentid+'/'+items.department;
                            }else if(items.department === 'Junior High School' || items.department === 'Senior High School'){
                            link = '/tor/highschool/'+items.studentid+'/'+items.department;
                            }else{
                             link = '/tor/elementary/'+items.studentid+'/'+items.level+'/'+items.department;
                               
                            }
                            
                            
                            $('#student').append('<tr><td>'+items.studentid+'</td><td>'+items.name+'</td><td>'+items.department+'</td>\n\
                                                 \n<td><img  src="/images/studentphoto/'+items.studentid+'-'+items.department+'.jpg")}}" alt="Student Photo" style="width:50%; heigh:100px;"></td>\
                                                 <td><a href="#" onclick="getPhoto('+ items.studentid+',\''+items.department+'\')">Add Image</a> || <a href="'+link+'">View TOR</a></td></tr>');
                        });
                    }
            });
            
        }
       /*if (event.keyCode == 13) {
          document.forms[0].submit();
        }*/
}


function getStudentId(event){
       if (event.keyCode === 13) {
           
           var studentId = document.getElementById("studentId");
            
        event.preventDefault();
            $.ajax({
                type: "GET",
                    url: "/get/student/school/"+studentId.value,
                    success:function(data){
                        $('#school').empty();
                        $.each(data, function(index,items)
                        {
                            
                            $('#school').append('<tr><td>'+items.schoolyear+'</td><td>'+items.schoolAttended+'</td>\n\
                                                 <td>'+items.level+'</td><td>'+items.schoolDays+'</td><td>'+items.presentDays+'</td>\n\
                                                 <td>'+items.finalrating+'</td><td><a href="#" onclick="deleteSchoolRecord('+items.studentid+','+items.id+')";>Delete</td></tr>');
                        });
                    }
            });
            
        }
        
      }
 


function submitPhoto(studentId, department) {

        var form = $('#uploadPhotoForm')[0];
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
        //data.append("CustomField", "This is some extra data, testing");

		// disabled the submit button
        $("#btnSubmit").prop("disabled", true);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/save/upload/photo/"+studentId+'/'+department,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
              $("#div1").empty();
              $("#div1").html(data);

            },
            error: function (e) {

                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);

            }
            
        });

}






   
function getPhoto(studentid, department){

$.ajax({
         type:"GET",
         url:"/view/upload/photo/"+studentid+"/"+department,
          success:function(data){   
              $("#div1").empty();
              $("#div1").html(data);
}
});
};
 


function getSubjectSched(countSubjects){
     
     var x = 1;
    $.ajax({
                    type: "GET",
                     url: "/get/subject/sched/" ,
                     success:function(data){
                         while(x<=countSubjects){
                         $('#subjectSched'+x).empty();
                         $.each(data, function(index, items) {
                            $('#subjectSched'+x).append("<option value='"+items.scheduleid+"'>"+items.subject+'  '+'('+items.scheduleday+' / '+items.scheduletime+')'+'</option>');
                         });
                     
                         x = x + 1;
                         }
                            
                       }
                    });
}
 

function updateSubjectSched() {

        var form = $('#userform')[0];
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
        //data.append("CustomField", "This is some extra data, testing");

		// disabled the submit button
        $("#btnSubmit").prop("disabled", true);

        $.ajax({
            type: "POST",
            url: "/update/subject/sched/",
            data: data,
            dataType:'json',
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
               // window.location.href = "http://localhost:8000/";
                
                // 
 // 
// $("#div1").empty();
             // $("#div1").html(data);

            }
            
        });

}

function viewCertificate(){
$.ajax({
         type:"GET",
         url:"/view/certificate/",
          success:function(data){   
              $("#div1").empty();
              $("#div1").html(data);
}
});
};

function searchCertificate(event){
       if (event.keyCode == 13) {
           var studentName =   document.getElementById("studentName");
           var department = document.getElementById("department");
           var schoolyear = document.getElementById("schoolyear");
            event.preventDefault();
            $.ajax({
                type: "GET",
                    url: "/search/certificate/"+studentName.value+"/"+department.value+"/"+schoolyear.value,
                    success:function(data){
                        $('#studentCertificate').empty();
                        $.each(data, function(index,items)
                        {
                            $('#studentCertificate').append('<tr><td>'+items.studentid+'</td><td>'+items.name+'</td>\n\
                                    <td>'+items.department+'</td><td>'+items.semester+'</td><td>'+items.schoolyear+'</td>\n\
                                    <td><a href="/view/certificate/list/'+items.studentid+'/'+items.department+'/'+items.semester+'/'+items.schoolyear+'";>View</td></tr>');
                        });
                    }
            });
            
        }
}    

function updateAttendanceStatus(studentId, scheduleId){
    
    var attendanceStatus;
    attendanceStatus = 0;
    if(document.getElementById('attendanceStatus').checked) {
        attendanceStatus = 0;
    } else {
        attendanceStatus = 1;
    }
    
    $.ajax({
       type:"GET" ,
       url:"/update/attendance/status/"+studentId+"/"+scheduleId+"/"+attendanceStatus,
       success:function(data){
           
       }
    });
    
}




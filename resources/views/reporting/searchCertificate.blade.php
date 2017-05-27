<br/>
<br/>
<br/>
<div class="col-lg-1">
    
</div>
<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">Search Certificate of Grade</div>
				<div class="panel-body">
				
                                    <form class="form-horizontal" name="formCertificate" role="formCertificate" id="formCertificate" method="GET" action="{{url('/view/tor')}}">
				        
                                        <div class="form-group">
							<label class="col-md-3 control-label">Department</label>
							<div class="col-md-9">
                                                            <select form="formCertificate" id="department" name="department" class='form-control'>
                                                                <option>Select Department</option>
                                                                <option value="College">College</option>
                                                                <option value="Diploma">Diploma</option>
                                                            </select>     
                                                        </div>
				            </div>
                                        <div class="form-group">
							<label class="col-md-3 control-label">School Year</label>
							<div class="col-md-9">
                                                            <select form="formCertificate" id="schoolyear" name="schoolyear" class='form-control'>
                                                                <option>Select School Year</option>
                                                                <option value="2014 - 2015">2014 - 2015</option>
                                                                <option value="2015 - 2016">2015 - 2016</option>
                                                                <option value="2016 - 2017">2016 - 2017</option>
                                                            </select>     
                                                        </div>
				            </div>
                                        
                                        <label style="text-align: center;"class="col-md-3 control-label">Student Name</label>
							<div class="col-md-9" align="left">
                                                            
                                                            <input class='form-control' form="formCertificate" text="text" name="studentName" onkeypress="searchCertificate(event)"  id="studentName"/>
                                                            
                                                
                                                        </div>    
                                        
                                        
                                        
                                            
                                    </form>  
                                    
                                    <div class="form-group">
							<div class="col-md-12">
                                                            <table class="table table-striped" style="padding-right:10px"> 
                                                                <caption>Select Student</caption>
                                                                <tr><th width="30%">Student ID</th><th width="30%">Name</th><th width="40%">Department</th>
                                                                    <th>Semester</th><th>School Year</th>
                                                                    <th colspan="2" width="5%">Action</th>
                                                                </tr>
                                                                
                                                           </table>
                                                        </div>
                                                </div>
                                    
                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <table name="studentCertificate" class="table table-striped" id="studentCertificate" style="padding-right:10px"> 
                                                                        </table>
                                                                    </div>
                                                </div>
                                    
                                                
					
				</div>
			</div>
		</div>
	

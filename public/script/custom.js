/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function enable_input(status, name, gradeStat, subjectStat){
    status=!status;
    if(name === "comment"){
        document.userform.comment.disabled=status;
    }else if(name === "submit"){
        document.userform.submit.disabled=status;
    }else if((name === 'all') && ((gradeStat === 1 ) || (gradeStat === 2))){
        if(subjectStat === 1){
            var x = document.getElementsByClassName("prelim");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            
        }else if(subjectStat === 2){
            var x = document.getElementsByClassName("midterm");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
        }else if(subjectStat === 3){
            var x = document.getElementsByClassName("semifinals");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
        }else{
            var x = document.getElementsByClassName("finals");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
        }
        
        document.userform.check1.disabled=status;
        document.userform.check2.disabled=status;
        document.userform.comment.disabled=status;
        document.userform.button.disabled=status;
        
    }else{
        document.userform.comment.disabled=status;
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
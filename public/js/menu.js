

function showTime(){
    myDate = new Date();
    hours = myDate.getHours();
    minutes = myDate.getMinutes();
    seconds = myDate.getSeconds();
    if (hours < 10) hours = 0 + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;
    document.getElementById("time").innerHTML = hours+ ":" +minutes+ ":" +seconds;
    setTimeout("showTime()", 1000);
    
}

function requiredTrue(date){
    date1 = document.getElementById("date1");
    date2 = document.getElementById("date2");
    if (date1 == null && date2 == null){
        date1.required = false;
        date2.required = false;
    }
    else {
        document.getElementById(date).required = true;
    }
}

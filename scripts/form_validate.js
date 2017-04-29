var frmvalidator  = new Validator("register");
frmvalidator.EnableOnPageErrorDisplay();
frmvalidator.EnableMsgsTogether();
//require 
frmvalidator.addValidation("LastName","req","Please provide your Last Name");
frmvalidator.addValidation("FirstName","req","Please provide your First Name");
frmvalidator.addValidation("Email","req","Please provide your email");
frmvalidator.addValidation("Username","req","Please create your Username");
frmvalidator.addValidation("Password","req","Please create your Password");
frmvalidator.addValidation("RePassword","req","Please reenter your Password");
frmvalidator.addValidation("Month","dontselect=month","Please select month");
frmvalidator.addValidation("Day","dontselect=day","Please select day");
frmvalidator.addValidation("Year","dontselect=year","Please select year");
//validate email
frmvalidator.addValidation("Email","email","Please enter valid email");
//validate Name
frmvalidator.addValidation("FirstName","alpha_s","Name must contain only letters");
frmvalidator.addValidation("LastName","alpha_s","Name must contain only letters");
//validate username
frmvalidator.addValidation("Username","alnum","Username must contain only letters and digits");
frmvalidator.addValidation("Username","minlen=7","Username must contain from 7 to 16 characters");
frmvalidator.addValidation("Username","maxlen=16","Username must contain from 7 to 16 characters");
//compare passwords
frmvalidator.addValidation("RePassword","eqelmnt=Password","The confirmed password is not same as password");

var lfrmvalidator  = new Validator("login");
lfrmvalidator.EnableOnPageErrorDisplay();
lfrmvalidator.EnableMsgsTogether();
//req
lfrmvalidator.addValidation("LUsername","req","Please provide your Username");
lfrmvalidator.addValidation("LPassword","req","Please create your Password");
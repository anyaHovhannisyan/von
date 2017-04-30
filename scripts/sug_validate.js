var frmvalidator  = new Validator("register");
frmvalidator.EnableOnPageErrorDisplay();
frmvalidator.EnableMsgsTogether();
//require 
frmvalidator.addValidation("Word","req","Please enter word");
frmvalidator.addValidation("Meaning","req","Please enter meaning");
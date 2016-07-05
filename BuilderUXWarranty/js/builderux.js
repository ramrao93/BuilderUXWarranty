

var mysubdivision = "";

var myemail = "";

var page= "";

var error_page = "";

var beback = false;

var submitform = false;
 
function addjs(js) {

    var headID = document.getElementsByTagName("head")[0];    

    var newScript = document.createElement('script');

    newScript.type = 'text/javascript';

   newScript.src = js;

    headID.appendChild(newScript);

}

function checkemail(){



    var email = $('input[name="builder[Email]"]').val();

    var Subdivision = $("input[name='builder[CommunityNumber]']").val();

    var url = $('input[name="builder[checkemail]"]').val()+"?Email="+email+"&CommunityNumber="+Subdivision;

    var ret = 1;

    $.ajax({

        type: "GET",

        url: url,

        async: false

    }).done(function (data) {

        if(data=='1') {

            alert('Thank you for coming back ....');

            ret = 1;

        } else {

            ret = 0;

        }

    });

    if(ret)

            return false;

    else

            return true;



}



function getEmail(Email,Subdivision){

    var url = $('input[name="builder[checkemail]"]').val()+"?Email="+Email+"&CommunityNumber="+Subdivision;

    console.log(Email);

    console.log(Subdivision);

    console.log(url);

    $.ajax({

        type: "GET",

        url: url,

        async: false

    }).done(function (data) {

        console.log(data);

        return data;

    })

}

function reveal(myobject){

     id = myobject.id;  

     jQuery('#customize'+id).slideToggle('500', "linear", function () {

        if (jQuery('#customize').is(':visible'))

          jQuery('#customize').css('display','inline-block');

     });

}

var forms = document.getElementsByTagName('form');

for (var i = 0; i < forms.length; i++) {

	forms[i].noValidate = true;

	if(forms[i].name=="builder-contact-form") {

		formid = forms[i].id;

			jQuery("#"+formid).validate();

	}
};

function validateForm(formid) {

    $('#'+formid).validate();

}

function nwarranty_request(e){ 

   var data = { 

            action: 'my_beback_save', 

            subdivision: jQuery("#subdivision").val(), 

            email: jQuery("#email").val(), 

            warranty_request: jQuery("#warranty_request").val(),

			page  :jQuery("#frm_warranty_request #page").val(),

			error_page : jQuery("#error_page").val()

    }; 
          
	     var currenturl =  window.location.href; 
 		 var currenturlfull = [];
		 currenturlfull = currenturl.split("?");
 		 var mainpageurl = currenturlfull[0];
 		 var currenturlarr = mainpageurl.replace("builderux-warranty-request/","");
 	     var MyAjax1 = currenturlarr+"wp-admin/admin-ajax.php"; 
	      
		jQuery.post(MyAjax1,data,function(response){
		 
		  
		  alert("Thanks For Submitting Your Warranty Request. The Warranty Coordinator Has Been Notified.");

	        jQuery(".frm_warranty_request").trigger("reset");

            jQuery("warranty_request").val("");
		
		    window.location.href = data['page'];
		   
		         
		 submitform = false; 
		
    });

}


function checkbeback(e){

	 if(e.value!=""){

 		page = jQuery('input[name="builder[page]"]').val();

		error_page = jQuery('input[name="builder[error_page]"]').val();

		 
        var data = {

            action: 'my_beback',

            subdivision: jQuery('input[name="builder[CommunityNumber]"]').val(),

            email: e 

        };

        mysubdivision = jQuery('input[name="builder[CommunityNumber]"]').val();

        myemail = e;    

        jQuery.post(MyAjax.ajaxurl,data,function(response){
         
		   if(response == "false"){

			 alert('Invalid email address.');

			} else {

		   var currenturl =  window.location.href;

	       currenturl = currenturl.slice(0, currenturl.lastIndexOf('/'));

           var siteurl = currenturl.slice(0, currenturl.lastIndexOf('/'));

		   var newsiteurl = siteurl+'/builderux-warranty-request/';          

		   window.location.href = newsiteurl+'?Subdivision='+mysubdivision+'&Email='+myemail+'&ClientInfo='+response+'&page='+page+'&error_page='+error_page;

    }
  }); 
 }
}

jQuery('.builder-contact-form .btn.btn-success').click(function(){ 

	var emailadd = jQuery('.builder-contact-form input[name="builder[Email]"]').val();	//alert(emailadd);

	 checkbeback(emailadd);

});  
 
jQuery(".builder-contact-form").trigger("reset");

jQuery(".builder-contact-form").submit(function( event ) {

        console.log("submitting");

        if(beback==true) {

    		submitform = true;

           	var mythis = document.getElementById(myformid+"Email");

            checkbeback(mythis);

            event.preventDefault();

        } else {

       }
}); 
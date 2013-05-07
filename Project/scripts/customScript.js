// JavaScript Document
$(document).ready(function(e) {
    
	$("#homelink").addClass("active");

	//zet de div voor booschappen zonder javascript op onzichtbaar, mogen enkel
	// getoond worden als javascript is uitgeschakeld
	$("div #error").hide();
	
	// was om de hover op de homescreen-elementen, de opacity te veranderen
/*	$('.actionItem').on('mouseenter', function(){
		$(this).stop().animate({backgroundPosition: 'top'},200);
		$(this).css({
					opacity:1,
					khtmlOpacity:1,
					mozOpacity:1, 
 					msFilter:"alpha(opacity=100)"
		});
	});
	
	$('.actionItem').on('mouseleave', function(){
		$(this).animate({backgroundPosition: 'center'},400);
		$(this).css({
					opacity:0.60,
					khtmlOpacity:.60,
					mozOpacity:.60, 
 					msFilter:"alpha(opacity=60)"
		});
	});*/
	
	// bij het klikken op 1 van de elementen op de homescreens
	// wordt deze link actief en de rest inactief
	$('.actionItem').on('click', function(){
			var pId = $(this).attr("id") ;
			var links = $('#linkList li').map(function(){
      					return this.id;
   					  }).get();
			//$("#results").load('./include_' + pId + '.php');
			
			for(var i=0; i< links.length ;i++)
			{
				if(links[i] != "")
				{
					$("#"+links[i]).removeClass("active");
				}
			}
			$("#" + $(this).attr("id") + "link").addClass("active");

	});
	
	
	$("#linkList li").on('click', function(){
		// over alle id's van de li's itereren om ze allemaal non-active te maken
		var links = $('#linkList li').map(function(){
      					return this.id;
   					  }).get();
					  
		for(var i=0;i< links.length;i++)
		{
			if(links[i] != "")
			{
				$("#"+links[i]).removeClass("active");
			}
		}
		//en dan de li active-klasse geven wanneer op deze geklikt wordt
		$(this).addClass("active");
	});
	
	// deze functies waren om de geselecteerde rij in een tabel een kleur te geven
	// en dan de id selecteren om het daarna te verwijderen of te updaten
	// gaat beter met data-attr dan de hidden input!!!
	
/*	$("#teacherTable .cRow").on("click", function(){
		var rows = $('#teacherTable tr').map(function(){
      					return this.className;
   					  }).get();
		
			for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("selectedRow");
			}
			$(this).addClass("selectedRow");
			
		$("#deleteRow").val($(".selectedRow .teacherId").html());
		
		$('#deleteTeacherForm button:submit').attr("disabled", false);

	});*/
	
/*	$("#studentTable .cRow").on("click", function(){
		var rows = $('#studentTable tr').map(function(){
      					return this.className;
   					  }).get();
		
			for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("selectedRow");
			}
			$(this).addClass("selectedRow");
			
		$("#deleteRow").val($(".selectedRow .studentId").html());
		$('#getAbsenceForm input:submit').attr("disabled", false);
	});*/
	
	/*$("#absenceTable .cRow").on("click", function(){
		var rows = $('#absenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		
			for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("selectedRow");
			}
			$(this).addClass("selectedRow");
			
		$("#deleteRow").val($(".selectedRow .absenceId").html());
		
		$('#deleteTeacherAbsenceForm button:submit').attr("disabled", false);

	});*/
	

/*	$("#absenceTable .cRow").on('dblclick', function(){
		var rows = $('#absenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		
			for(var i=0; i< rows.length ;i++)
			{
					$("#absenceTable tr.selectedRow p").attr("contenteditable","false");
					$(".cRow").removeClass("selectedRow");
			}
			$(this).addClass("selectedRow");
		$("#absenceTable tr.selectedRow p").attr("contenteditable","true");
	});
	*/
	
		/*$("#studentabsenceTable .cRow").on("click", function(){
		var rows = $('#studentabsenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		
			for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("selectedRow");
			}
			$(this).addClass("selectedRow");
			
		$("#deleteRow").val($(".selectedRow .absenceId p").html());
		$('#deleteStudentAbsenceForm input:submit').attr("disabled", false);
		$('#deleteStudentAbsenceForm button:submit').attr("disabled", false);
	});*/
	
	
	// hidden input leegmaken zodat er geen data in zit van de vorige keer.
	//beter met data-attr dan hidden input (extra)
	$("#deleteRow").val('');

	// de feedback en errors die worden gegenereerd door de php code laten verschijnen met humane, jacked-up
	if($("#feedbackResult").val() != "" && $("#feedbackResult").val() != undefined)
	{
		humane.log($("#feedbackResult").val());
	}
	
	
/*	$('#btnDeleteTeacher').on('click', function(e){
		var tId = $("#deleteTeacherForm #deleteRow").val();
		
		if(arrayExt[1] != 'csv' && arrayExt[1] != 'txt')
		{
			humane.log('Bestand had niet de juiste extentie. </br>Alleen .csv en .txt bestanden zijn toegelaten.');
				e.preventDefault();
		}
	
	});*/
	
	/*$('#searchStudentForm').on('click', function (e) {
		if($("#keyword").val() == '')
		{
			humane.log("Vul eerst een sleutelwoord in!");
		}
		
	});
	*/
	
	
	// wanneer er geklikt wordt op de zoekknop bij een tabel verschijnt er een foutmelding wanneer het zoekveld niet is ingevuld.
	$('#btnSearch').on('click', function (e) {
		var searchKey = $("#keyword").val();
		if( searchKey == '')
		{
			humane.log("Vul eerst een sleutelwoord in!");
			e.preventDefault();
		}
	/*	else
		{
			 $.ajax({ // create an AJAX call...
					data: {keyword : searchKey}, // get the form data
					type: "GET", // GET or POST
					url: "overviewStudents.php",
					dataType:"html",
					error: function( xhr, status ) {
						humane.log("status: " + status + " xhr " + xhr.status);
						//e.preventDefault();
					 }, // the file to call
					success: function(response) { // on success
						humane.log('success');
					}
			});//einde ajax	
		}*/
		
	});

	//alle afwezigheden ophalen afhankelijk van user
	$('.viewAbs').on('click', function (e) {
		
		// eerst weten welke rij geselecteerd is door er een klasse aan te geven
		var rows = $('#studentTable tr').map(function(){
      					return this.className;
   					  }).get();
		
		for(var i=0; i< rows.length ;i++)
			{//isSelected
					$(".cRow").removeClass("isSelected");
			}
			
		$(this.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageEdit").show();
			
		// beter met data-attr dan hidden input
		// hierin wordt de id gestoken van de user waarvan we de afwezigheden willen zien.
		$("#deleteRow").val($(".isSelected .studentId").html());
		 if ($("#deleteRow").val() == '' ) {
			 humane.log("Selecteer eerst een student!");
			return false;
			e.preventDefault();
		} 
		else 
		{
			//als de id niet leeg is worden de afwezigheden opgehaald
			var userId = $("#deleteRow").val();
			var request = $.ajax({ // create an AJAX call...
							data: {user_id : userId}, // get the form data
							type: "GET", // GET or POST
							url: "ajax/check_student_absences.php",//$(this).attr('action'),
							dataType: "json",
							error: function( xhr, status ) {
								humane.log("Kon de actie niet uitvoeren.");
								return false;
								e.preventDefault();
							 }, // the file to call
							success: function(response) { // on success..
								//showAbsences();
								//humane.log("Was een succes!");
							}
						});//einde ajax
			request.done(function(msg) {
			   if(msg.status == 'success')
			  {
				  //wanneer de afwezigheden met success zijn opgehaald
				  // dan navigeren we naar de viewAbsences.php pagina met de userid
				  // daar worden de afwezigheden dan gedisplayed in een tabel
				   $.ajax({ // create an AJAX call...
							data: {user_id : userId}, // get the form data
							type: "GET", // GET or POST
							url: "viewAbsences.php",
							error: function( xhr, status ) {
								//e.preventDefault();
								humane.log(msg.text);
							//	humane.log("Was een fout1!");
								$(".isSelected .loadingImageEdit").hide();
								return false;
							 }, // the file to call
							success: function(response) { // on success..
								//showAbsences();
								$(".isSelected .loadingImageEdit").hide();
								$(location).attr("href", "viewAbsences.php?user_id=" + userId);
								//humane.log(msg.text);
							}
					});//einde ajax		
				//	humane.log('succes');
						
			  }
			  else
			  {
				  $(".isSelected .loadingImageEdit").hide();
				  humane.log(msg.text);
				  e.preventDefault();
			  }
			});
			
			e.preventDefault();
			
		}//einde else
		
	});	
	
	
	
	// was om de beschikbaarheid van de username te laten zien
	// maar komt een beetje lelijk in beeld
	/*$('#username').on("keyup", function(e){
		
		$("#loadingImage").show();
		var text = $("#username").val();
		
		$(".usernameFeedback").fadeIn();
		
		//ajax call, post username naar php pagina
		var request = $.ajax({
			  url: "ajax/check_username.php",
			  type: "POST",
			  data: {username : text}, // username verwijst naar $_POST['username']
			  dataType: "json" // data structureren --> json, html-> text doorsturen
		});
		
		
		request.done(function(msg) {
			// in ajax call php page echo 'ok' teruggevan, hier dan de message opmaken, is enkel 1 stuk tekst,
			// geen array (dan moet het via json gedaan worden en hier opgehaalde worden)
			//console.log(msg);
			
			$("#loadingImage").hide();
			$(".usernameFeedback span").removeClass("ok notok");
			if(msg.status == "success" )
			{
				$("#addTeacherForm fieldset").css("width","606px");
				$(".usernameFeedback span").text(msg.text).addClass("ok");
			}
			else
			{
				$("#addTeacherForm fieldset").css("width","636px");
				$(".usernameFeedback span").text(msg.text).addClass("notok");
			}
			
		});
		
		if(text == '')
		{
			$("#loadingImage").hide();
			$("#addTeacherForm fieldset").css("width","365px");
			$(".usernameFeedback span").text('');
			$(".usernameFeedback span").removeClass("ok notok");
		}
		
	});
	*/
	
	
	// hierbij de filename van de geselecteerde file (voor attesten of studenten)
	// displayen in een inputfield
	$("#file").on('change', function(){
					//alert($("#file").val());
		$("#fileName").val($("#file").val());
	});
	

	
	// geen selectedRow gebruiken dat de rij rood kleurt maar, gewone klasse ter onderscheiding: isSelected
	// om te bewerken worden de waarden van de geselecteerde rij gekopieerd naar de bijhorende input veldjes in de 
	// editTr div
	
	$('.edit').on('click', function(e){
		var rows = $('#studentabsenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement.parentElement.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageEdit").show();
			
		var fields  = $('#studentabsenceTable .isSelected').children();
		
		
		$("#deleteRow").val($(".isSelected .absenceId").html());
		//$("#editTr").css('display','block');
		$("#editTr").toggle();
		$("#editid").val(parseInt(fields[0].innerHTML));
		$("#editfrom").val(fields[1].innerHTML);
		$("#editto").val(fields[2].innerHTML);
		$("#editreason").val(fields[3].innerHTML);
		
		$('#editAbsence input:submit').attr("disabled", false);
		//$("#editnote").val(fields[4]);
		$(".isSelected .loadingImageEdit").hide();
		$("#decorativeBottom").hide();
		e.preventDefault();
	});
	
	
	
	$('.editA').on('click', function(e){
		var rows = $('#absenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement.parentElement.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageEdit").show();
			
		var fields  = $('#absenceTable .isSelected').children();
		
		
		$("#deleteRow").val($(".isSelected .absenceId").html());
		//$("#editTr").css('display','block');
		$("#editTr").toggle();
		$("#editid").val(parseInt(fields[0].innerHTML));
		$("#editfrom").val(fields[1].innerHTML);
		$("#editto").val(fields[2].innerHTML);
		
		$('#editAbsence input:submit').attr("disabled", false);
		//$("#editnote").val(fields[4]);
		$(".isSelected .loadingImageEdit").hide();
		
		$("#decorativeBottom").hide();
		e.preventDefault();
	});
	
	$('.editB').on('click', function(e){
		var rows = $('#courseTable tr').map(function(){
      					return this.className;
   					  }).get();
		
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement.parentElement.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageEdit").show();
			
		var fields  = $('#courseTable .isSelected').children();
		
		$("#deleteRow").val($(".isSelected .courseId").html());
		$("#editTr").css('display','block');
		//$("#editTr").toggle();
		$("#editid").val(parseInt(fields[0].innerHTML));
		$("#editclass").val(fields[1].innerHTML);
		var vak = $('.isSelected .class1').data('vak');
		$("select#editclass").val(vak)
		var sem = parseInt(fields[2].innerHTML);
		//$("#editsemester").val(sem);
		if(sem == 1)
		{
			$("#editsemester1").attr('checked', true);
		}
		else
		{
			$("#editsemester2").attr('checked', true);
		}
		$("#editgroup").val(fields[3].innerHTML);
		
		$('#editCourse input:submit').attr("disabled", false);
		//$("#editnote").val(fields[4]);
		$(".isSelected .loadingImageEdit").hide();
		
		$("#decorativeBottom").hide();
		e.preventDefault();
	});
	
	// als er dan op de edit geklikt wordt, dan wordt het bewerkingsdiv'je getoond
	$(".isSelected .edit").on('click', function(e){
			$("#editTr").toggle();
	});
	
	// bij het annulleren van de bewerking worden de veldjes terug leeggemaakt 
	// en wordt de div verborgen
	$('#btnCancelEdit').on('click', function(e){
		//$("#editTr").css('display','none');
		$("#editTr").toggle();
		$("#editfrom").val('');
		$("#editto").val('');
		$("#editreason").val('');
		
		$('#editAbsence input:submit').attr("disabled", true);

		$("#decorativeBottom").show();
		e.preventDefault();
	});
	
	
	$('#btnCancelEditCourse').on('click', function(e){
		//$("#editTr").css('display','none');
		$("#editTr").toggle();
		$("#editsemester").val('');
		$("#editclass").val('');
		$("#editgroup").val('');
		
		$('#editCourse input:submit').attr("disabled", true);

		$("#decorativeBottom").show();
		e.preventDefault();
	});
	
	// bij de delete wordt de id van de geselecteerde rij via ajax verstuurd.
	// om dat de gewenste rij te verwijderen in de tabel en in de database
	$('.delete').on('click', function(e){
		var rows = $('#studentabsenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		// geen selectedRow gebruiken dat de rij rood kleurt maar, gewone klasse ter onderscheiding: isSelected
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement.parentElement.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageDelete").show();
		
		var uId = parseInt($("#hiddenId").val());
		var abId = parseInt($(".isSelected .absenceId").html());
		
		var request = $.ajax({ // create an AJAX call...
							data: {user_id : uId, ab_id : abId}, // get the form data
							type: "POST", // GET or POST
							url: "ajax/delete_absence.php",//$(this).attr('action'),
							dataType: "json"/*,
							error: function( xhr, status ) {
								humane.log("Kon de actie niet uitvoeren.");
								return false;
								e.preventDefault();
							 }, // the file to call
							success: function(response) { // on success..
								//showAbsences();
								//humane.log("Was een succes!");
								//$(location).attr("href", "studentAbsences.php?id=" + uId);
							}*/
					});//einde ajax
					
		request.done(function(msg) {
			   if(msg.status == 'success') 
			  {
				   $.ajax({ // create an AJAX call...
							data: {id : uId}, // get the form data
							type: "GET", // GET or POST
							url: "studentAbsences.php",
							error: function( xhr, status ) {
								//e.preventDefault();
								humane.log(msg.text);
							//	humane.log("Was een fout1!");
	
								return false;
							 }, // the file to call
							success: function(response) { // on success..
								//showAbsences();
								$(".isSelected .loadingImageDelete").hide();
								//$(location).attr("href", "studentAbsences.php?id=" + uId);
								$(".isSelected").remove();
								//humane.log(msg.text);
							}
					});//einde ajax		
				//	humane.log('succes');	
			  }
			  else
			  {
				  humane.log(msg.text);
				  e.preventDefault();
			  }
			});
		e.preventDefault();
	});
	
	$('.deleteA').on('click', function(e){
		var rows = $('#absenceTable tr').map(function(){
      					return this.className;
   					  }).get();
		// geen selectedRow gebruiken dat de rij rood kleurt maar, gewone klasse ter onderscheiding: isSelected
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement.parentElement.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageDelete").show();
		
		var uId = parseInt($("#hiddenId").val());
		var abId = parseInt($(".isSelected .absenceId").html());
		
		var request = $.ajax({ // create an AJAX call...
							data: {user_id : uId, ab_id : abId}, // get the form data
							type: "POST", // GET or POST
							url: "ajax/delete_absence.php",//$(this).attr('action'),
							dataType: "json"/*,
							error: function( xhr, status ) {
								humane.log("Kon de actie niet uitvoeren.");
								return false;
								e.preventDefault();
							 }, // the file to call
							success: function(response) { // on success..
								//showAbsences();
								//humane.log("Was een succes!");
								//$(location).attr("href", "studentAbsences.php?id=" + uId);
							}*/
					});//einde ajax
					
		request.done(function(msg) {
			   if(msg.status == 'success')
			  {
				   $.ajax({ // create an AJAX call...
							data: {id : uId}, // get the form data
							type: "GET", // GET or POST
							url: "overviewTeacherAbsences.php",
							error: function( xhr, status ) {
								//e.preventDefault();
								humane.log(msg.text);
							//	humane.log("Was een fout1!");
	
								return false;
							 }, // the file to call
							success: function(response) { // on success..
								//showAbsences();
								$("#editTr").hide();
								$(".selectedRow .loadingImageDelete").hide();
								//$(location).attr("href", "overviewTeacherAbsences.php?id=" + uId);
								$(".isSelected").remove();
								//humane.log(msg.text);
							}
					});//einde ajax		
				//	humane.log('succes');	
			  }
			  else
			  {
				  humane.log(msg.text);
				  e.preventDefault();
			  }
			});
			
		
		e.preventDefault();
	});
	
	$(".removeT").on('click', function(e){
		var rows = $('#teacherTable tr').map(function(){
      					return this.className;
   					  }).get();
		// geen selectedRow gebruiken dat de rij rood kleurt maar, gewone klasse ter onderscheiding: isSelected
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageDelete").show();
		
		var uId = parseInt($(".isSelected .teacherId").html());
		
		var request = $.ajax({ // create an AJAX call...
							data: {user_id : uId }, 
							type: "POST", // GET or POST
							url: "ajax/delete_teacher.php",//$(this).attr('action'),
							dataType: "json",
							 error : function(XMLHttpRequest, textStatus, errorThrown) {
									console.log("XMLHttpRequest", XMLHttpRequest);
									console.log("textStatus", textStatus);
									console.log("errorThrown", errorThrown);
									$(".isSelected .loadingImageDelete").hide();    
            					},
							success: function(response) { // on success..
								$(".isSelected .loadingImageDelete").hide();
								//$(location).attr("href", "deleteTeacher.php");
								$(".isSelected").remove();
								humane.log(response.text);
							}
					});//einde ajax
		
		
		e.preventDefault();
	});
	
	
	$(".deleteB").on('click', function(e){
		var rows = $('#courseTable tr').map(function(){
      					return this.className;
   					  }).get();
		// geen selectedRow gebruiken dat de rij rood kleurt maar, gewone klasse ter onderscheiding: isSelected
		for(var i=0; i< rows.length ;i++)
			{
					$(".cRow").removeClass("isSelected");
			}
		$(this.parentElement.parentElement.parentElement).addClass("isSelected");
		
		$(".isSelected .loadingImageDelete").show();
		
		var cId = parseInt($(".isSelected .courseId").html());
		var uId = parseInt($("#hiddenCourse").val());
		
		var request = $.ajax({ // create an AJAX call...
							data: {course_id : cId }, 
							type: "POST", // GET or POST
							url: "ajax/delete_course.php",//$(this).attr('action'),
							dataType: "json",
							 error : function(XMLHttpRequest, textStatus, errorThrown) {
								 
									console.log("XMLHttpRequest", XMLHttpRequest);
									console.log("textStatus", textStatus);
									console.log("errorThrown", errorThrown);
									$(".isSelected .loadingImageDelete").hide();    
            					},
							success: function(response) { // on success..
							$("#editTr").hide();
								$(".isSelected .loadingImageDelete").hide();
								$(".isSelected").remove();
								//$(location).attr("href", "viewCourses.php?id=" + uId);
								humane.log(response.text);
							}
					});//einde ajax
		
		
		e.preventDefault();
	});
	
	// om de bewerking op te slaan, worden de bewerkte veldjes van de editTr div doorgestuurd
	// via ajax en achter de schermen geupdate 
	// na de ajax request worden de waarden vanuit de input velden gekopieerd naar de td's in de tabel
	// zodat zonder refresh de tabel wordt geupdate
	$('#btnSaveEdit').on('click', function(e){
		var usertype = $("#typeUser").val();
		var uId = parseInt($("#hiddenId").val());
		var id = parseInt($("#editid").val());
		var from = $("#editfrom").val();
		var to = $("#editto").val();
		
		var dateformFrom = $("#editfrom").val().split('/'); //mm/dd/yyyy
		var dateformTo = $("#editto").val().split('/');
		var editfrom = dateformFrom[1] + '/' + dateformFrom[0] + '/' + dateformFrom[2];
		var editto = dateformTo[1] + '/' + dateformTo[0] + '/' + dateformTo[2];
		
		var reason = $("#editreason").val();
		if(reason == undefined || reason == '')
		{
			reason = "leeg";
		}
		$(".loadingImageSave").show();
		
		var request = $.ajax({ // create an AJAX call...
							data: {id : id, from : from, to : to, reason : reason, user_id : uId, type : usertype }, 
							type: "POST", // GET or POST
							url: "ajax/update_absence.php",
							dataType: "json",
							/*error: function( xhr, status ) {
								humane.log(status);
								return false;
								e.preventDefault();
							 }, // the file to call*/
							 error : function(XMLHttpRequest, textStatus, errorThrown) {
									console.log("XMLHttpRequest", XMLHttpRequest);
									console.log("textStatus", textStatus);
									console.log("errorThrown", errorThrown);
										$(".loadingImageSave").hide();    
            					},
							success: function(response) { // on success..
								//humane.log("Was een succes!");
								$("#editTr").hide();
									$(".loadingImageSave").hide();
									if(usertype == 'student')
									{
										//$(location).attr("href", "studentAbsences.php?id=" + uId);
											$(".loadingImageSave").hide();
											$(".isSelected .from").html(editfrom);
											$(".isSelected .to").html(editto);
											$(".isSelected .reason").html(reason);
									}
									else
									{
										//$(location).attr("href", "overviewTeacherAbsences.php?id=" + uId);
											$(".loadingImageSave").hide();
											$(".isSelected .from").html(editfrom);
											$(".isSelected .to").html(editto);
									}
							}
					});//einde ajax

		e.preventDefault();
	});
	
	$('#btnSaveEditCourse').on('click', function(e){
		var uId = parseInt($("#hiddenCourse").val());
		
		var id = parseInt($("#editid").val());
		var semester = $('input[name=editsemester]:radio:checked').val();
		var class_1 = $("select#editclass").val();//$("#editclass").val();
		var group = $("#editgroup").val();
		var classname = $("#editclass option:selected").text();
		$(".loadingImageSave").show();
		
		var request = $.ajax({ // create an AJAX call...
							data: {id : id, semester : semester, class_1 : class_1, group : group, user_id : uId }, // get the form data
							type: "POST", // GET or POST
							url: "ajax/update_course.php",//$(this).attr('action'),
							dataType: "json",
							 error : function(XMLHttpRequest, textStatus, errorThrown) {
									console.log("XMLHttpRequest", XMLHttpRequest);
									console.log("textStatus", textStatus);
									console.log("errorThrown", errorThrown);
										$(".loadingImageSave").hide();    
            					},
							success: function(response) { // on success..
								//humane.log("Was een succes!");
									$("#editTr").hide();
									$(".loadingImageSave").hide();
									$(".isSelected .class1").html(classname);
									$(".isSelected .semester").html(semester);
									$(".isSelected .group").html(group);
								//	$("#editTr").toggle();
									//$(location).attr("href", "viewCourses.php?id=" + uId);
							}
					});//einde ajax

		e.preventDefault();
	});
	
	// hier worden alle buttons die gekoppeld zijn aan een formulier als disabled gezet
	// zodat er pas op geklikt kan worden als alle inputs ingevuld zijn
	disableButtons();
	// hier wordt dan gecheckt of de inputs ingevuld zijn en dan pas wordt de matching knop op enabled gezet
	checkTeacherFields();
	checkAbsenceFields();

});
			
			
	function disableButtons()
	{
		$('#getAbsenceForm input:submit').attr("disabled", true);
		$('#deleteTeacherForm button:submit').attr("disabled", true);
		$('#addTeacherForm input:submit').attr("disabled", true);
		$('#addAbsenceTeacherForm input:submit').attr("disabled", true);
		$('#deleteTeacherAbsenceForm input:submit').attr("disabled", true);
		$('#deleteStudentAbsenceForm input:submit').attr("disabled", true);
		$('#deleteStudentAbsenceForm button:submit').attr("disabled", true);
		$('#editAbsence input:submit').attr("disabled", true);
	}
	
	function checkTeacherFields()
	{

		var fields  = $('#addTeacherForm .inputField').map(function(){
      		return this.id;
   		}).get();
		
		$(".inputField").on('keyup', function(){
			if($("#" + fields[0]).val() != '' && $("#" + fields[1]).val() != '' 
				&& $("#" + fields[2]).val() != '' && $("#" + fields[3]).val() != '')
			{
				$('#addTeacherForm input:submit').attr("disabled", false);
			}
			else
			{
				$('#addTeacherForm input:submit').attr("disabled", true);
			}
		});
		
	}
	
	function checkAbsenceFields()
	{
		var fields  = $('#addAbsenceTeacherForm .inputField').map(function(){
      		return this.id;
   		}).get();
		
		$(".inputField").on('change', function(){
			if($("#" + fields[0]).val() != '' && $("#" + fields[1]).val() != '')
			{
				$('#addAbsenceTeacherForm input:submit').attr("disabled", false);
			}
			else
			{
				$('#addAbsenceTeacherForm input:submit').attr("disabled", true);
			}
			
			
		var fieldsS  = $('#addAbsenceStudentForm .inputField').map(function(){
      		return this.id;
   		}).get();
		
		$(".inputField").on('change', function(){
			if($("#" + fieldsS[0]).val() != '' && $("#" + fieldsS[1]).val() != '' &&  $("#" + fieldsS[2]).val() != ''
				&& $("#" + fieldsS[3]).val() != '')
			{
				$('#addAbsenceStudentForm input:submit').attr("disabled", false);
			}
			else
			{
				$('#addAbsenceStudentForm input:submit').attr("disabled", true);
			}
		});
		
	});
}
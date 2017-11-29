/*var handleDataTableResponsive=function(){
	"use strict";
	if($("#users_management").length!==0){
		$("#users_management").DataTable({
			responsive:true
		})
	}
};

var TableManageResponsive=function(){
	"use strict";
	return{
		init:function(){
		handleDataTableResponsive()}
	}
}()*/

$(document).ready(function() {
    $('#users_management').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "scripts/server_processing.php"
    } );
} );
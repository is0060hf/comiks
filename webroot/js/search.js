function clearSearchElementsInSeikyuu(){
	document.getElementById( "deliveryman_name" ).selectedIndex = 0;
	document.getElementById( "customers_name" ).selectedIndex = 0;
	document.getElementById( "delivery_dest" ).selectedIndex = 0;
	document.getElementById( "appendix" ).value = "" ;
	document.getElementById( "upper_created" ).value = "" ;
	document.getElementById( "under_created" ).value = "" ;
}

function clearSearchElementsInUser(){
	document.getElementById( "mail_address" ).value = '';
	document.getElementById( "login_name" ).value = '';
}

function clearSearchElementsInPageName() {
	document.getElementById( "page_name" ).value = '';
	document.getElementById( "user_id" ).selectedIndex = 0;
}

function clearEventSearchElements() {
	document.getElementById("mail_address").value = '';
	document.getElementById("region").selectedIndex = 0;
	document.getElementById("prefecture").selectedIndex = 0;
}

function clearUserNoticeSearchElements() {
	document.getElementById("notice_level").selectedIndex = 0;
}

function clearPostSearchElements() {
	document.getElementById("title").value = '';
	document.getElementById("category_name_id").value = '-1';
	document.getElementById("upper_open_date").value = '';
	document.getElementById("under_open_date").value = '';
}

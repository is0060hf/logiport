function clearSearchElementsInSeikyuu(){
	document.getElementById( "deliveryman_name" ).selectedIndex = 0;
	document.getElementById( "customers_name" ).selectedIndex = 0;
	document.getElementById( "delivery_dest" ).selectedIndex = 0;
	document.getElementById( "cargo_dest" ).selectedIndex = -1;
	document.getElementById( "appendix" ).value = "" ;
	document.getElementById( "upper_created" ).value = "" ;
	document.getElementById( "under_created" ).value = "" ;
}

function clearSearchElementsInUser(){
	document.getElementById( "deliveryman_name" ).selectedIndex = 0;
}

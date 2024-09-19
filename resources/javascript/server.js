function createServerObject() {
	var xmlHttp;
	if (window.ActiveXObject) {
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		xmlHttp = new XMLHttpRequest();
	}
	return xmlHttp;
}
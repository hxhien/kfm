function submitForm(){
	var oNodeForm = document.getElementById("node_form");
	var msg = new Array();
	var node_name =	oNodeForm.node_name.value;
	node_name = node_name.trim();
	if (isEmpty(node_name)){
		oNodeForm.node_name.className = "form_input_error";
		msg.push("Page Name is required");
	}
	if (msg.length > 0){
		alert(msg[0]);
		oNodeForm.node_name.focus();
	}else{
		oNodeForm.submit();
	}
	return;
	var title_text, body_text;
	var languages = ['en','kr','vi'];
	for(var i = 0; i < languages.length; i++){
		body_text = eval('CKEDITOR.instances.body_' + languages[i] + '.getData();');
		title_text = eval('oNodeForm.title_' + languages[i] + '.value');
	}
}
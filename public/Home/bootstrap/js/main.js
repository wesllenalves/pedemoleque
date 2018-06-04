$(function(){
    // equivalente ao Load da página
	/* $("#modal_01").modal("show");
	setTimeout(function(){
		$("#modal_01").modal("hide");
	}, 3000); */
	//$("#modal_01").modal({backdrop: false, keyboard:false});
	//$(".ttp").tooltip();
	//$(".ttp").tooltip({animation:false});
	$(".ttp").tooltip({animation:false,
		delay: {show : 1000, hide : 3000},
		title : "Título Padrão",
		trigger : 'click'
	});
	//$(".ppv").popover();
	/*$(".ppv").popover({
		animation:false	
	});
	*/
	$(".ppv").popover({
		animation:false,
		delay : {show : 1000, hide : 3000},
		title : "Título padrão"
	});
	$(".btnjs").button();
	$("#aguarda").click(function(){
		var btn = $(this);
		btn.button("loading");
		setTimeout(function(){
			btn.button("reset");
		}, 3000);
	});
});
import "jstack";
import './adapters/bootstrap';
import "./directive/ckeditor";
import "app.datatables";
import "./directive/datepicker";
import "./directive/fileinputImg";
import "./directive/inputnumber";
import "./directive/selectpicker";
import "./directive/selectStyled";
import "./layout/widgets";
import "../js/functions";
import 'sweetalert';
import './adapters/nicescroll';

let routes = {
	"": require("./modules/index").default,

	"articles/all": require("./modules/articles/all").default,
	"articles/crud": require("./modules/articles/crud").default,
	
	"gifts/all": require("./modules/gifts/all").default,
	"gifts/crud": require("./modules/gifts/crud").default,
	
	"cards/all": require("./modules/cards/all").default,
	"cards/crud": require("./modules/cards/crud").default,
	"drivers/all": require("./modules/drivers/all").default,

	"users/all": require("./modules/users/all").default,
	
	"users/create": require("./modules/users/create").default,
	
	"passages/create": require("./modules/passages/create").default,
    
	"drivers/crud": require("./modules/drivers/crud").default,
	"history/update": require("./modules/history/update").default,
	
	"users/update": require("./modules/users/update").default,
	"users/update_user": require("./modules/users/update_user").default,
	"passages/all": require("./modules/passages/all").default,
};


//commons
window.addEventListener('error', function (e){
	let stack = e.error.stack;
	let message = e.error.toString();
	if (stack) {
		message += '\n' + stack;
	}
	alert(message);
});

//global ajax service fitting the current server-side route convention
window.$serviceJSON = function(uri,method,params,callback,ajaxOptions){
	let data = {};
	if(typeof(callback)!='function'&&typeof(params)=='undefined'&&typeof(method)=='function'){
		callback = method;
		method = null;
		if(typeof(callback)=='object'){
			ajaxOptions = callback;
			callback = null
		}
	}
	if(typeof(callback)=='undefined'&&typeof(params)=='function'){
		callback = params;
		params = null;
	}
	if(typeof(method)=='object'){
		if(typeof(params)=='function'){
			callback = params;
		}
		params = method;
		method = null;
	}
	if(method)
		data.method = method;
	if(params)
		data.params = params;
	if(uri.substr(-5)=='.json')
		uri = uri.substr(0,uri.length-5);
	const ajaxQuery = {
		url:uri+'.json',
		type:'POST',
		dataType:'json',
		data:data,
		success:callback
	};
	if(ajaxOptions)
		$.extend(true,ajaxQuery,ajaxOptions);
	return jstack.ajax(ajaxQuery);
};

window.$serviceXHR = function(url,data,success,ajax){
	if(typeof(success)=='object'){
		ajax = success;
		success = false;
	}
	ajax = ajax || {};
	ajax.dataType = 'json';
	ajax.type = 'POST';
	ajax.url = url;
	ajax.data = data;
	if(typeof(success)=='function'){
		ajax.success = success;
	}
	return jstack.ajax(ajax);
};

window.$sanitizeTableName = function(str){
	str = str
		.replace(/\s+/g, '_')           // Replace spaces with -
		.replace(/\-\-+/g, '_')         // Replace multiple - with single -
		.replace(/[^\w\-]+/g, '')       // Remove all non-word chars
		.replace(/^-+/, '')             // Trim - from start of text
		.replace(/-+$/, '')            // Trim - from end of text
		.snakeCase()
		.toLowerCase()
	;
	return str.trim('_');
	
};


$(document).ajaxError(function(event, jqxhr, settings, exception ){
	if(jqxhr.status==401){
		location.reload();
	}
});
$.ajaxSetup({
	error:function(XMLHttpRequest){
		if(XMLHttpRequest.status==401||XMLHttpRequest.status==400||XMLHttpRequest.status==0&&XMLHttpRequest.statusText=='abort') return;
		var msg = this.url+'<br>HTTP '+XMLHttpRequest.status+' '+XMLHttpRequest.statusText;
		if(XMLHttpRequest.responseText&&typeof(XMLHttpRequest.responseText)=='string'){
			var responseText = XMLHttpRequest.responseText;
			responseText = responseText.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2'); //nl2br
			msg += '<br>'+responseText;
		}
		
			
		switch(XMLHttpRequest.status){
			case 403:
				swal({
					title: "Action non authorisée",
					text: 'Contactez votre administrateur',
				});
			break;
			default:
				swal({
					title: "Oops !",
					text: '<div class="sweet-alert-error-box">'+msg+'</div>',
					html: true,
					type:'error',
					customClass:'swal-scrollable'
				});
			break;
		}
		$('.sa-error').click(function(){
			swal.close();
		});
		//if(console) console.log(XMLHttpRequest);
	}
});



if(jstack.isMobile()){
	$('html').addClass('ismobile');
}

//waiting loader
let spinner = $('<div class="waiting-loader"> <div></div><div></div><div></div> </div>');
$('body').append(spinner);
let fainter = $('[j-app]');
if(!fainter.length)
	fainter = $('main');
const is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
const animationBorderRadiusbugfix = function(){
	$('body').css('min-height','calc(100vh + 10px)');
	window.scrollTo(0,document.body.scrollHeight);
	window.scrollTo(0,0);
	$('body').css('min-height','0');
};
const spinnerOn = function(hide){
	spinner.show();
	if(is_firefox){
		animationBorderRadiusbugfix();
	}
	fainter.css('opacity','0.2');		
};
const spinnerOff = function(hide){
	if(spinner)
		spinner.hide();
	fainter.css('opacity','1');
};
$(window).on('unload',spinnerOn);

const container = $('[j-app]');

const app = container.attr('j-app');
	
if(!app){
	$(document.body).addClass('no-j-app');
	$(document.body).addClass('c-overflow');
}

$.autoNicescroll();

if(app){

	//working in js application mode

	$(document)
		.on('j:route:load',spinnerOn)
		.on('j:route:loaded',spinnerOff)
	;

	//saas
	$(document)
		.on('click','.sub-menu > a',function(e){
			e.preventDefault();
			$(this).next().slideToggle(200);
			$(this).parent().toggleClass('toggled');
		})
		.on('click', '.a-prevent', function(e){
			e.preventDefault();
		})
		.on('j:route:loaded', function(e){
			const builderWrap = $('#builder-main');
			if(!builderWrap.find('.c-overflow').length){
				//builderWrap.find('> *').addClass('c-overflow');			
				builderWrap.addClass('c-overflow');			
			}
			
			$.autoNicescroll();
		})
	;

	jstack.config.templatesPath = 'app/modules/';
	jstack.config.controllersPath = 'app/modules/';

	const router = new jstack.Router({
		el: '[j-app]',
		routes: routes
	});

	router.run();

}

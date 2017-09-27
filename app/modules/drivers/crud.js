import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./crud.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			id ? $serviceJSON('drivers/crud','load', [id]) : {},
		];
	}
	
	domReady(){
       var data = this.data;
		var form = $(this.element).find('form');
		form.validate({
			submitHandler: function(){
				$serviceJSON('drivers/crud','store',[data.driver],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.notify('Le chauffeur a bien été créé', "success");
						setTimeout(function(){
							jstack.route('drivers/crud',{id: r.id});
						},1000);
					}
				});

			},
			rules:{
				email: {
					email:true,
					remote: {
						url:'drivers/crud.json',
						type:'post',
						data: {
							method:'checkEmail',
							params:function(){
								return [form.find('input[name=email]').val()];
							}
						}
					}
				}
			},
			messages:{
				email: {
					remote: "Cette adresse email est déjà utilisée !"
				}
			}
		});
		
	}
};

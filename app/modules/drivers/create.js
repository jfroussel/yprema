import 'validate';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	template(){ return require('./create-update.jml'); }
	getData(){
		return [
		
		];
	}
	setData(){
		let data = this.data;
		data.driver = {
			
		};
	}
	domReady(){
		var data = this.data;
		var form = $(this.element).find('form');
		form.validate({
			submitHandler: function(){
				$serviceJSON('drivers/create','store',[data.driver],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.notify('Le chauffeur a bien été créé', "success");
						setTimeout(function(){
							jstack.route('drivers/update',{id: r.id});
						},1000);
					}
				});

			},
			rules:{
				email: {
					email:true,
					remote: {
						url:'drivers/create.json',
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

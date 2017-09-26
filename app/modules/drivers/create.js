import 'validate';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	template(){ return require('./create.jml'); }
	getData(){
		return [
		
		];
	}
	setData(){
		let data = this.data;
		data.user = {
			type:'saas',
		};
	}
	domReady(){
		var data = this.data;
		var form = $(this.element).find('form');
		form.validate({
			submitHandler: function(){
				$serviceJSON('drivers/create','store',[data.driver],function(r){
					if(r.id){
						jstack.route('drivers/update',{id: r.id});
					}
                    $.notify('Le chauffeur a bien été créé', "success");
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

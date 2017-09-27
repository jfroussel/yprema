import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./crud.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			id ? $serviceJSON('drivers/crud','load', [id]) : { driver: {} },
		];
	}
	
	domReady(){
        var data = this.data;
		var form = $(this.element).find('form');
		let driver = data.driver;
		
		$('.notifyjs-corner').empty(); //clean notify js the hard way
		
		form.find('input[name=nom], input[name=prenom]').on('j:input',function(){
			if(!(driver.nom&&driver.prenom)) return;
			$serviceJSON('drivers/crud','checkFullNameExists',[driver.nom,driver.prenom],function(id){
				if(id&&id!=driver.id){
					$.notify('Un chauffeur avec les mêmes nom et prénom existe déjà, <a href="/#drivers/crud?id='+id+'">cliquez ici consulter sa fiche</a>',{autoHideDelay: 20000});
				}
			});
		});
		form.find('input[name=email]').on('j:input',function(){
			if(!(driver.email)) return;
			$serviceJSON('drivers/crud','checkEmailExists',[driver.email],function(id){
				if(id&&id!=driver.id){
					$.notify('Un chauffeur avec les mêmes nom et prénom existe déjà, <a href="/#drivers/crud?id='+id+'">cliquez ici consulter sa fiche</a>',{autoHideDelay: 20000});
				}
			});
		});
		
		form.validate({
			submitHandler: function(){
				$serviceJSON('drivers/crud','store',[data.driver],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.extend(driver,r.driver);
						if(driver.id){
							$.notify('Le chauffeur a bien été mis à jour', "success");
						}
						else{
							$.notify('Le chauffeur a bien été créé', "success");
						}
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
								return [form.find('input[name=email]').val(), driver.id];
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

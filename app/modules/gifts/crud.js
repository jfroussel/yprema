import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./crud.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			id ? $serviceJSON('gifts/crud','load', [id]) : { gift: {} },
		];
	}
	
	domReady(){
        var data = this.data;
		var form = $(this.element).find('form');
		let gift = data.gift;
		
		$('.notifyjs-corner').empty(); //clean notify js the hard way
				
		form.validate({
			submitHandler: function(){
				$serviceJSON('gifts/crud','store',[data.gift],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.extend(gift,r.gift);
						if(gift.id){
							$.notify('La carte a bien été mis à jour', "success");
						}
						else{
							$.notify('La carte a bien été créé', "success");
						}
						setTimeout(function(){
							jstack.route('gifts/crud',{id: r.id});
						},1000);
					}
				});

			},
			rules:{
				barcode: {
					remote: {
						url:'gifts/crud.json',
						type:'post',
						data: {
							method:'checkBarcode',
							params:function(){
								return [form.find('input[name=barcode]').val(), data.gift.id];
							}
						}
					}
				}
			},
			messages:{
				barcode: {
					remote: "Ce code barre est déjà utilisé",
				}
			}
		});
		
	}
};

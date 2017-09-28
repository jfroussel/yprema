import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./crud.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			id ? $serviceJSON('cards/crud','load', [id]) : { card: {} },
		];
	}
	
	domReady(){
        var data = this.data;
		var form = $(this.element).find('form');
		let card = data.card;
		
		$('.notifyjs-corner').empty(); //clean notify js the hard way
				
		form.validate({
			submitHandler: function(){
				$serviceJSON('cards/crud','store',[data.card],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.extend(card,r.card);
						if(card.id){
							$.notify('La carte a bien été mis à jour', "success");
						}
						else{
							$.notify('La carte a bien été créé', "success");
						}
						setTimeout(function(){
							jstack.route('cards/crud',{id: r.id});
						},1000);
					}
				});

			},
			rules:{
				barcode: {
					remote: {
						url:'cards/crud.json',
						type:'post',
						data: {
							method:'checkBarcode',
							params:function(){
								return [form.find('input[name=barcode]').val(), data.card.id];
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

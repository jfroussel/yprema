import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./crud.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			id ? $serviceJSON('sites/crud','load', [id]) : { site: {} },
		];
	}
	
	domReady(){
        var data = this.data;
		var form = $(this.element).find('form');
		let site = data.site;
		
		$('.notifyjs-corner').empty(); //clean notify js the hard way
				
		form.validate({
			submitHandler: function(){
				$serviceJSON('sites/crud','store',[data.site],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.extend(site,r.site);
						if(site.id){
							$.notify('Le site a bien été mis à jour', "success");
						}
						else{
							$.notify('Le site a bien été créé', "success");
						}
						setTimeout(function(){
							jstack.route('sites/crud',{id: r.id});
						},1000);
					}
				});

			},
		});
		
	}
};

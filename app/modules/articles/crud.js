import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./crud.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			id ? $serviceJSON('articles/crud','load', [id]) : { article: {} },
		];
	}
	
	domReady(){
        var data = this.data;
		var form = $(this.element).find('form');
		let article = data.article;
		
		$('.notifyjs-corner').empty(); //clean notify js the hard way
				
		form.validate({
			submitHandler: function(){
				$serviceJSON('articles/crud','store',[data.article],function(r){
					if(r.error){
						$.notify('Erreur: '+r.error,'error');
					}
					else{
						$.extend(article,r.article);
						if(article.id){
							$.notify('Le matériau a bien été mis à jour', "success");
						}
						else{
							$.notify('Le matériau a bien été créé', "success");
						}
						setTimeout(function(){
							jstack.route('articles/crud',{id: r.id});
						},1000);
					}
				});

			},
		});
		
	}
};

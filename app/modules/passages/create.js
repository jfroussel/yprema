import 'chart.js';
import moment from 'moment';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	template(){ return require('./create.jml'); }
    getData(){
        return [
            $serviceJSON('passages/create','load'),
        ];

    }
    setData(json){
        $.extend(this.data,json);
        var data = this.data;
        data.driver = {};
        data.statut = '';
        data.passage = {
			barcode: '',
		};
    }
    domReady(){

        var self = this;
        var data = self.data;
		let passage = data.passage;


        // var element = self.element;
        let inputBarcode = $("input[name=barcode]");
        inputBarcode.focus();

        let barcode = $("#barcode");
		barcode.on('j:input',function(){
			if(passage.barcode){
			
				$serviceJSON('passages/create','getChauffeurInfo',[passage.barcode], function(r){
					
					if(!r) return;
					
					let driver = data.driver;
					$.extend(driver, r.driver || {});
					data.statut = driver.id?"Carte crée le " + moment(driver.date_creation).format('DD/MM/YYYY') + " son statut est  " + (driver.statut=='1'?'actif':'inactif'):'';
					
					if(driver.id){
						$("#success").show();
					}
					else{
						$("#success").hide();
					}
					
					if(driver.statut == 'actif'){
						$("#success").addClass('alert alert-success');
					}
					else if(driver.statut == 'inactif'){
						$("#success").addClass('alert alert-danger');
						$(".jumbotron").hide();
						$("#actualise").show();
						$("#actualise").on('click', function(){
							location.reload();
						});
					}
				});
			}
		});


        var form = $(this.element).find('form');
        form.validate({
            submitHandler: function(e){
                $serviceJSON('passages/create','store',[data.passage],function(r){
                    if($('#passage').length){
                        $.notify('Le passage a bien été enregistré avec la carte n°' + data.passage.barcode, "success");
                    }
                });
            }
        });

    }
};

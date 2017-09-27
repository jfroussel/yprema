import 'chart.js';
import moment from 'moment';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	template(){ return require('./tab-home.jml'); }
    getData(){
        return [
            $serviceJSON('home/tab-home','load'),
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



        // var element = self.element;
        let inputBarcode = $("input[name=barcode]");
        inputBarcode.focus();

        let barcode = $("#barcode");
		barcode.on('input',function(){
			let barcodeVal = barcode.val();
			if(barcodeVal){
			
				$serviceJSON('home/tab-home','getChauffeurInfo',[barcodeVal], function(r){
					
					let driver = data.driver = r || {};
					data.statut = driver.id?"Carte crée le " + moment(driver.date_creation).format('DD/MM/YYYY') + " son statut est  " + driver.statut:'';
					
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
                $serviceJSON('home/tab-home','store',[data.passage],function(r){
                    if($('#passage').length){
                        $.notify('Le passage a bien été enregistré avec la carte n°' + data.passage.barcode, "success");
                    }
                });
            }
        });

    }
};

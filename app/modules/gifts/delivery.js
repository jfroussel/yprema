import 'chart.js';
import moment from 'moment';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	template(){ return require('./delivery.jml'); }
    getData(){
        return [
            $serviceJSON('gifts/delivery','load'),
        ];

    }
    setData(json){
        $.extend(this.data,json);
        var data = this.data;
        data.driver = {};
        data.statut = '';
        data.solde_base = '';
        data.delivery = {
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
			
				$serviceJSON('gifts/delivery','getChauffeurInfo',[barcodeVal], function(r){
					
					if(!r) return;
					
					let driver = data.driver = r.driver || {};
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
                $serviceJSON('gifts/delivery','store',[data.delivery],function(r){
                    if($('#delivery').length){
                        $.notify('La remise de cadeau a bien été enregistré avec la carte n°' + data.delivery.barcode, "success");
                    }
                });
            }
        });

    }
};

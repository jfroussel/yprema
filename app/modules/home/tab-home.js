import 'chart.js';
import moment from 'moment';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'home/tab-home'; }
    getData(){
        return [
            $serviceJSON('home/tab-home','load'),
        ];
    }
    domReady(){

        var self = this;
        var data = self.data;
        // var element = self.element;
        console.log(data);
        var form = $(this.element).find('form');

        form.validate({
            submitHandler: function(e){
                $serviceJSON('home/tab-home','store',[data.passage],function(r){
                    if($('#passage').length){
                        $.notify('Le passage a bien été enregistré avec la carte n°' + data.passage.barcode, "success");
                    }
                });
                $('#passage').ajax.reload();
            }

        });

    }
};

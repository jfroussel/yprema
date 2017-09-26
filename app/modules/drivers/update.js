import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	templateUrl(){ return 'drivers/update'; }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			$serviceJSON('drivers/update','load', [id]),
		];
	}

	setData(){
	    super.setData(...arguments);
	    this.data.dateOfDay = moment().format('LL');
    }
	domReady(){
        let self = this;
        let data = self.data;

		var element = self.element;


        $('.driver-name').text(data.ct_intitule);
        $('.driver-adresse').text(data.ct_adresse);
        $('.driver-codepostal').text(data.ct_codepostal);
        $('.driver-ville').text(data.ct_ville);

		//jstack.log(data.contact);


		console.log(data);
		
	}
};

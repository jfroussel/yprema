import Module from 'module';

import 'validate';
import 'chart.js';
import moment from 'moment';

export default class extends Module {
	template(){ return require('./create-update.jml'); }
	
	getData(){
		var id = jstack.url.getParams(this.hash).id;
		return [
			$serviceJSON('drivers/update','load', [id]),
		];
	}
	
	domReady(){
        let self = this;
        let data = self.data;
		let element = self.element;
		
	}
};

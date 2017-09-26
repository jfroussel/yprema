import 'validate';

import Module from 'module';
export default class extends Module {
	template(){ return require('./parameters.jml'); }
	getData(){
		return [];
	}
	domReady(){

	}
};

import 'validate';

import Module from 'module';
export default class extends Module {
	template(){ return require('./update.jml'); }
	getData(){
		let params = jstack.url.getParams(this.hash);
		let id = params.id;
		let breadcrumb = params.breadcrumb;
		this.data.breadcrumb = breadcrumb;
		return [
			$serviceJSON('cards/update','load',[id,breadcrumb]),
		];
	}
	domReady(){
		

	}
};

import Module from 'module';
export default class extends Module {
	template(){ return require('./all.jml'); }
	getData(){
		return [
		];
	}
	getData(){
		return [
			$serviceJSON('drivers/all','load'),
		];
	}
	domReady(){

	}
};

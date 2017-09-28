import Module from "module";

export default class extends Module {
	template(){
		return require('./home/index.jml');
	}
	getData(){
		return [
			$serviceJSON('','load'),
		];
	}
	domReady(){
		let data = this.data;
        
	}
};

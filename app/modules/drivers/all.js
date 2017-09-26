import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'drivers/all'; }
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

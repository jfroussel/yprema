import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'parameters/articles/all'; }
    getData(){
		return [];
    }
    domReady(){

    }
};

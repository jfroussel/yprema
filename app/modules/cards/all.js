import Module from 'module';
export default class extends Module {
	template(){
		return require('./all.jml');
	}
	getData(){
		return [
		];
	}
	domReady() {

    }
};

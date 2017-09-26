import Module from 'module';
export default class extends Module {
	template(){ return require('./tab-folders.jml'); }
    getData(){
        var id = jstack.url.getParams(this.hash).id;
        return [
            $serviceJSON('home/tab-folders','load'),
        ];
    }
    domReady(){
		
	}
};

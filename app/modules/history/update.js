import 'validate';

import Module from 'module';
export default class extends Module {
	template(){ return require('./update.jml'); }
    getData(){
        var id = jstack.url.getParams(this.hash).id;
        return [
            $serviceJSON('history/update','load', [id])
        ];
    }
    domReady(){
        let self = this;
        let data = self.data;
        let element = self.element;



    }
};

import 'validate';

import Module from 'module';
export default class extends Module {
	template(){ return require('./tab-sites.jml'); }
    getData(){
        return [
        ];
    }
    domReady(){


    }
};

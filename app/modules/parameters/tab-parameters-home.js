import 'validate';

import Module from 'module';
export default class extends Module {
    template(){ return require('./tab-parameters-home.jml'); }
    getData(){
        return [];
    }
    domReady(){

    }
};

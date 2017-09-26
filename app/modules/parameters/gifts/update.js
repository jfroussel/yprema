import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	
	template(){ return require('./update.jml'); }
    
    getData(){

        let id = $(this.element).data('datatable-edit-id');
        //let id = jstack.url.getParams(this.hash).id;
        this.data.id = id;
        return [
            $serviceJSON('parameters/gift/update','load',[id]),
        ];
    }
    
    domReady(){

        var self = this;
        var data = this.data;
        var el = $(self.element);
        var form = $(this.element).find('form');

        console.log(form);
        form.validate({
            submitHandler: function(e){

                $serviceJSON('parameters/gift/update','store',[data.gift],function(r){
                    el.closest('.modal').modal('hide');
                    if($('#gift-table').length){
                        $('#gift-table').DataTable().ajax.reload();

                    }
                });

            }
        });



    }
};

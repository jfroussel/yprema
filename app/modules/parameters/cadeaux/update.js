import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	
	templateUrl(){ return 'parameters/cadeaux/update'; }
    
    getData(){

        let id = $(this.element).data('datatable-edit-id');
        //let id = jstack.url.getParams(this.hash).id;
        this.data.id = id;
        return [
            $serviceJSON('parameters/cadeaux/update','load',[id]),
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

                $serviceJSON('parameters/cadeaux/update','store',[data.cadeaux],function(r){
                    el.closest('.modal').modal('hide');
                    if($('#cadeaux-table').length){
                        $('#cadeaux-table').DataTable().ajax.reload();

                    }
                });

            }
        });



    }
};

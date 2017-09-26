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
            $serviceJSON('parameters/articles/update','load',[id]),
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

                $serviceJSON('parameters/articles/update','store',[data.articles],function(r){
                    el.closest('.modal').modal('hide');
                    if($('#articles-table').length){
                        $('#articles-table').DataTable().ajax.reload();

                    }
                });

            }
        });



    }
};

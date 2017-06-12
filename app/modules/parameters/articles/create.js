import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'parameters/articles/create'; }
    getData(){
		return [];
    }
    domReady(){
        let data = this.data;
        let form = $(this.element).find('form');
        form.validate({
            submitHandler: function(e){

                $serviceJSON('parameters/articles/update','store',[data.articles],function(r){
                    $('#articles-new').modal('hide');
                    if($('#articles-table').length){
                        $('#articles-table').DataTable().ajax.reload();

                    }
                });

            }
        });

    }
};

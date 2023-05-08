@extends('layouts.admin')

@section('title')
    BAD - STUDY
@endsection

@section('content')
    <h2>{{__('lang.all_agents')}}:</h2>
    <hr>
    <br>
    <div class="row" style="clear: both;">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" onclick="add()"><i class="fas fa-plus-square"></i> {{__('lang.new_agent')}}</a>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="model_table" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">{{__('lang.name')}}</th>
                <th width="15%">{{__('lang.class')}}</th>
                <th width="10%"></th>
            </tr>
            </thead>
        </table>
    </div>
    <br>
    <hr>
    <div class="modal fade" id="post-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Новый пользователь</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="Form" class="form-horizontal">
                        <input type="hidden" name="model_id" id="model_id">
                        <div class="form-group">
                            <label for="inputPhone">{{__('lang.last_name')}}</label>
                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name">
                        </div>
                        <div class="form-group">
                            <label for="inputPhone">{{__('lang.class')}}</label>
                            <input type="text"
                                   class="form-control"
                                   id="class"
                                   name="class">
                        </div>
                        <div class="form-group" id="form-errors">
                            <div class="alert alert-danger">
                                <ul>

                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col">
                        <div  class="collapse" id="collapseExample">
                            <button type="button" class="btn btn-danger" onclick="deleteModel()"> <i class="fas fa-trash"></i> {{__('lang.delete')}}</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="save()">{{__('lang.save')}}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>

        function add() {
            $('#form-errors').html("");
            $('#staticBackdropLabel').text("{{__('lang.new_aget')}}");
            $('#class').val('');
            $('#name').val('');
            $('#collapseExample').hide();
            $('#post-modal').modal('show');

        }

        function deleteModel() {
            var id = $('#model_id').val();
            let _url = `/admin/arduino-types/${id}`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $('#model_table').DataTable().ajax.reload();
                    $('#post-modal').modal('hide');
                }
            });
        }


        function editModel (event) {
            $('#collapseExample').show();
            $('#staticBackdropLabel').text("{{__('lang.edit_agent')}}");
            $('#form-errors').html("");
            var id  = $(event).data("id");
            let _url = `/admin/arduino-types/${id}/edit`;
            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        $('#model_id').val(response.id);
                        $('#name').val(response.name);
                        $('#class').val(response.class);
                        $('#post-modal').modal('show');
                    }
                }
            });
        }
        function save() {
            var id = $('#model_id').val();

            var name = $('#name').val();
            var class1 = $('#class').val();
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('admin.arduino-types.store') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    class : class1,
                    {{--agent_id: {{$agent->id}},--}}
                    _token: _token
                },
                success: function(response) {
                    if(response.code === 200) {
                        $('#model_id').val('');
                        $('#name').val('');
                        $('#class').val('');
                        $('#model_table').DataTable().ajax.reload();
                        $('#post-modal').modal('hide');
                    }
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>'+ value + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></div>';

                    $( '#form-errors' ).html( errorsHtml ); //appending to a <div id="form-errors"></div> inside form

                }
            });
        }
        $(document).ready(function() {

            $('#model_table').DataTable({
                @php $locale = session()->get('locale'); @endphp
                    @if($locale != 'en')
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
                },
                @endif
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.arduino-types.index')}}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'class',
                        name: 'class'
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endsection

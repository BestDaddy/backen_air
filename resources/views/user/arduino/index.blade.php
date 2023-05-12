@extends('layouts.admin')

@section('title')
    BAD - STUDY
@endsection

@section('content')
    <h2>{{__('lang.all_agents')}} :</h2>
    <hr>
    <br>
    <br>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="model_table" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">{{__('lang.name')}}</th>
                <th width="15%">{{__('lang.ip')}}</th>
                <th width="10%">{{__('lang.type')}}</th>
                <th width="10%">{{__('lang.last_seen_at')}}</th>
                <th width="15%"></th>
            </tr>
            </thead>
        </table>
    </div>
    <br>
    <hr>

@endsection


@section('scripts')
    <script>

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
                    url: "{{ route('user.arduino.index') }}",
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
                        data: 'ip',
                        name: 'ip'
                    },
                    {
                        data: 'type.name',
                        name: 'type.name',
                        orderable: false
                    },
                    {
                        data: 'last_seen_at',
                        name: 'last_seen_at'
                    },
                    {
                        data: 'more',
                        name: 'more',
                        orderable: false
                    },
                ]
            });
        });
    </script>
@endsection

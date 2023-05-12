@extends('layouts.admin')

@section('title')
    BAD - STUDY
@endsection

@section('content')
    <h2>{{$arduino->name}} : {{$arduino->last_seen_at}}</h2>
    <hr>
    <br>
    <br>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="model_table" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">PPM</th>
                <th width="15%">{{__('lang.created_at')}}</th>
            </tr>
            </thead>
        </table>
    </div>
    <br>
    <hr>

    {!! $chart->renderHtml() !!}
@endsection


@section('scripts')
    {!! $chart->renderChartJsLibrary() !!}

    {!! $chart->renderJs() !!}
    <script>

        $(document).ready(function() {

            $('#model_table').DataTable({
                @php $locale = session()->get('locale'); @endphp
                @if($locale != 'en')
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
                },
                @endif
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                @if(Auth::user()->role_id == \App\Models\Role::ROLE_USER_ID)
                    ajax: {
                        url: "{{ route('user.arduino.show', $arduino->id) }}",
                    },
                @endif
                @if(Auth::user()->role_id == \App\Models\Role::ROLE_ADMIN_ID)
                    ajax: {
                        url: "{{ route('admin.arduino.show', $arduino->id) }}",
                    },
                @endif

                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'ppm',
                        name: 'ppm'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ]
            });
        });
    </script>
@endsection

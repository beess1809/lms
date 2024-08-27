@extends('layouts.app')

@section('content-header')
    {{-- <div class="content-header-background">
        <div class="center-content">
            <h2>{{ $model->title }}</h2>
            <span>{{ $model->description }}</span>
        </div>
    </div> --}}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('training.submitNilai') }}" method="post">
                @csrf
                <input type="hidden" name="training_id" value="{{ base64_encode($training_id) }}">
                <input type="hidden" name="uuid" value="{{ base64_encode($uuid) }}">
                <input type="hidden" name="id" value="{{ base64_encode($id) }}">
                <table id="datatable" class="table table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-phintraco float-right">Submit Nilai</button>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $(function() {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    info: false,
                    paging: false,
                    language: {
                        "emptyTable": "Tidak Ada Data"
                    },
                    ajax: "{!! route('report.detailDatatables', ['id' => base64_encode($model->id . '|' . $uuid)]) !!}",
                    columns: [{
                        data: 'module',
                        name: 'module'
                    }, ]
                });
            });
        });

        function totalNilai() {
            var sum = 0;
            $('.nilai').each(function() {
                if (this.value) {
                    if (Number(this.value) > 100) {
                        this.value = 100
                    }

                    sum += parseFloat(this.value);
                } else {
                    sum += parseFloat(0);
                }
            });

            let count = $('.nilai').length
            var avg = parseFloat(sum) / parseFloat(count)
            $('#totNilai').val(sum)
            $('#avgNilai').val(avg.toFixed(2))
        }

        function maxValue(val) {
            if (Number(val.value) > 100) {
                val.value = 100
            }
        }
    </script>
@endpush

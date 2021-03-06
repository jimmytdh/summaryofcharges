@extends('app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/lib/Lobibox/lobibox.css"/>
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/loader.css"/>
    <style>
        .bg-gray {
            background: #cccccc;
        }
        table {
            margin-bottom: 20px;
        }
        table td,table th {
            padding: 2px 5px;
        }
        thead th {
            text-align: center;
        }
        .editable {
            text-decoration: none;
            border-bottom: dashed 1px #0357cc;
            color: #0357cc;
        }
        .custom-control {
            margin-bottom: 0px !important;
            margin-top: 2px;
        }
    </style>
@endsection

@section('body')
    <div id="loader-wrapper">
        <div id="loader"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ url('patients') }}" class="btn btn-space btn-secondary"><i class="s7-back-2"></i> Back</a>
            </div>
            <form method="POST" action="{{ url('charges/print/'.$id) }}" id="formSubmit">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading-divider">
                        GENERATE SOA <small class="text-danger">[ TOTAL: <span class="total">0</span>]</small>
                        <div class="tools">
                            <div class="form-group form-inline">
                                <input placeholder="Search items here..." autofocus type="text" id="search" class="form-control form-control-sm mr-2" />

                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="s7-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel-body">
                        <h4 style="color:#2a2a2a;">Patient Name: <font style="color:#7171c5">{{ ucwords($patient->lname) }}, {{ ucwords($patient->fname) }}</font></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <table border="1" width="100%">
                                    <thead class="bg-gray">
                                    <tr>
                                        <th width="60%">OPERATING ROOM CHARGES</th>
                                        <th width="20%">AMOUNT</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orcharge as $row)
                                        <tr class="search_item">
                                            <td>
                                                <label class="custom-control custom-checkbox custom-control-inline select-item">
                                                    <input type="checkbox"
                                                           name="items[{{ $row->id }}]"
                                                           data-amount="{{ $row->amount }}"
                                                           data-class="fixed-{{ $row->id }}"
                                                           class="custom-control-input">
                                                    <span class="custom-control-label">
                                                    {{ $row->name }}
                                                </span>
                                                </label>
                                            </td>
                                            <td>{{ number_format($row->amount,2) }}@if(strlen($row->type)>1)/{{ $row->type }} @endif</td>
                                            <td class="fixed-{{ $row->id }}"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-right" colspan="2">SUBTOTAL</th>
                                        <th class="fixed-sub">0.00</th>
                                    </tr>
                                    </tbody>
                                </table>

                                <table border="1" width="100%">
                                    <thead class="bg-gray">
                                    <tr>
                                        <th width="40%">PROCEDURES</th>
                                        <th width="20%">CHARGE</th>
                                        <th width="20%">QUANTITY</th>
                                        <th width="20%">AMOUNT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orprocedure as $row)
                                        <tr class="search_item">
                                            <td>{{ $row->name }}</td>
                                            <td>{{ number_format($row->amount,2) }}@if(strlen($row->type)>1)/{{ $row->type }} @endif</td>
                                            <td>
                                                <input type="number"
                                                       class="room-select"
                                                       value="0" min="0"
                                                       name="items[{{ $row->id }}]"
                                                       data-amount="{{ $row->amount }}"
                                                       data-id="{{ $row->id }}"
                                                       style="width:100%" />
                                            </td>
                                            <td class="room-{{ $row->id }}"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-right" colspan="3">SUBTOTAL</th>
                                        <th class="room-sub">0.00</th>
                                    </tr>
                                    </tbody>
                                </table>

                                <table border="1" width="100%">
                                    <thead class="bg-gray">
                                    <tr>
                                        <th width="40%">SUPPLIES</th>
                                        <th width="20%">UNIT PRICE</th>
                                        <th width="20%">QUANTITY</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orsupply as $row)
                                        <tr class="search_item">
                                            <td>{{ $row->name }}</td>
                                            <td>{{ number_format($row->amount,2) }}@if(strlen($row->type)>1)/{{ $row->type }} @endif</td>
                                            <td>
                                                <input type="number"
                                                       class="procedure-select"
                                                       value="0" min="0"
                                                       name="items[{{ $row->id }}]"
                                                       data-amount="{{ $row->amount }}"
                                                       data-id="{{ $row->id }}"
                                                       style="width:100%" />
                                            </td>
                                            <td class="procedure-{{ $row->id }}"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-right" colspan="3">SUBTOTAL</th>
                                        <th class="procedure-sub">0.00</th>
                                    </tr>
                                    </tbody>
                                </table>

                                <table border="1" width="100%">
                                    <thead class="bg-gray">
                                    <tr>
                                        <th width="40%">IV FLUIDS</th>
                                        <th width="20%">UNIT PRICE</th>
                                        <th width="20%">QUANTITY</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orfluid as $row)
                                        <tr class="search_item">
                                            <td>{{ $row->name }}</td>
                                            <td>{{ number_format($row->amount,2) }}@if(strlen($row->type)>1)/{{ $row->type }} @endif</td>
                                            <td>
                                                <input type="number"
                                                       class="fluid-select"
                                                       value="0" min="0"
                                                       name="items[{{ $row->id }}]"
                                                       data-amount="{{ $row->amount }}"
                                                       data-id="{{ $row->id }}"
                                                       style="width:100%" />
                                            </td>
                                            <td class="fluid-{{ $row->id }}"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-right" colspan="3">SUBTOTAL</th>
                                        <th class="fluid-sub">0.00</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table border="1" width="100%">
                                    <thead class="bg-gray">
                                    <tr>
                                        <th width="40%">SUTURES</th>
                                        <th width="20%">UNIT PRICE</th>
                                        <th width="20%">QUANTITY</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orsuture as $row)
                                        <tr class="search_item">
                                            <td>{{ $row->name }}</td>
                                            <td>{{ number_format($row->amount,2) }}@if(strlen($row->type)>1)/{{ $row->type }} @endif</td>
                                            <td>
                                                <input type="number"
                                                       class="equipment-select"
                                                       value="0" min="0"
                                                       name="items[{{ $row->id }}]"
                                                       data-amount="{{ $row->amount }}"
                                                       data-id="{{ $row->id }}"
                                                       style="width:100%" />
                                            </td>
                                            <td class="equipment-{{ $row->id }}"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-right" colspan="3">SUBTOTAL</th>
                                        <th class="equipment-sub">0.00</th>
                                    </tr>
                                    </tbody>
                                </table>

                                <table border="1" width="100%">
                                    <thead class="bg-gray">
                                    <tr>
                                        <th width="40%">MEDICINES</th>
                                        <th width="20%">UNIT PRICE</th>
                                        <th width="20%">QUANTITY</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ormedicine as $row)
                                        <tr class="search_item">
                                            <td>{{ $row->name }}</td>
                                            <td>{{ number_format($row->amount,2) }}@if(strlen($row->type)>1)/{{ $row->type }} @endif</td>
                                            <td>
                                                <input type="number"
                                                       class="medicine-select"
                                                       value="0" min="0"
                                                       name="items[{{ $row->id }}]"
                                                       data-amount="{{ $row->amount }}"
                                                       data-id="{{ $row->id }}"
                                                       style="width:100%" />
                                            </td>
                                            <td class="medicine-{{ $row->id }}"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-right" colspan="3">SUBTOTAL</th>
                                        <th class="medicine-sub">0.00</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script type="text/javascript">
        var sub_fixed = 0;
        var sub_room = 0;
        var sub_procedure = 0;
        var sub_equipment = 0;
        var sub_fluid = 0;
        var sub_medicine = 0;

        var total = 0;
        var rooms = [];
        var procedure = [];
        var equipment = [];
        var fluid = [];
        var medicine = [];

        $('input[type="checkbox"]').change(function () {
            var amount = $(this).data('amount');
            var cl = $(this).data('class');
            if(this.checked){
                $('.'+cl).html(decimal(amount));
                sub_fixed = sub_fixed + parseInt(amount);

            }else{
                $('.'+cl).html(decimal(''));
                sub_fixed = sub_fixed - parseInt(amount);
            }
            $('.fixed-sub').html(decimal(sub_fixed));
            totalAmount();
        });


        $('.room-select').on('keyup change',function () {
            var qty = $(this).val();
            var amount = $(this).data('amount');
            var id = $(this).data('id');

            amount = amount * qty;
            $('.room-'+id).html(decimal(amount));


            rooms[id] = amount;
            var tmp = 0;
            jQuery.each(rooms, function (index,amount) {
                if(amount){
                    tmp += amount;
                }
            });
            $('.room-sub').html(decimal(tmp));
            sub_room = tmp;
            totalAmount();
        });

        $('.procedure-select').on('keyup change',function () {
            var qty = $(this).val();
            var amount = $(this).data('amount');
            var id = $(this).data('id');

            amount = amount * qty;
            $('.procedure-'+id).html(decimal(amount));


            procedure[id] = amount;
            var tmp = 0;
            jQuery.each(procedure, function (index,amount) {
                if(amount){
                    tmp += amount;
                }
            });
            $('.procedure-sub').html(decimal(tmp));
            sub_procedure = tmp;
            totalAmount();
        });

        $('.fluid-select').on('keyup change',function () {
            var qty = $(this).val();
            var amount = $(this).data('amount');
            var id = $(this).data('id');

            amount = amount * qty;
            $('.fluid-'+id).html(decimal(amount));


            fluid[id] = amount;
            var tmp = 0;
            jQuery.each(fluid, function (index,amount) {
                if(amount){
                    tmp += amount;
                }
            });
            $('.fluid-sub').html(decimal(tmp));
            sub_fluid = tmp;
            totalAmount();
        });

        $('.equipment-select').on('keyup change',function () {
            var qty = $(this).val();
            var amount = $(this).data('amount');
            var id = $(this).data('id');

            amount = amount * qty;
            $('.equipment-'+id).html(decimal(amount));


            equipment[id] = amount;
            var tmp = 0;
            jQuery.each(equipment, function (index,amount) {
                if(amount){
                    tmp += amount;
                }
            });
            $('.equipment-sub').html(decimal(tmp));
            sub_equipment = tmp;
            totalAmount();
        });

        $('.medicine-select').on('keyup change',function () {
            var qty = $(this).val();
            var amount = $(this).data('amount');
            var id = $(this).data('id');

            amount = amount * qty;
            $('.medicine-'+id).html(decimal(amount));


            medicine[id] = amount;
            var tmp = 0;
            jQuery.each(medicine, function (index,amount) {
                if(amount){
                    tmp += amount;
                }
            });
            $('.medicine-sub').html(decimal(tmp));
            sub_medicine = tmp;
            totalAmount();
        });


        function totalAmount() {
            var total = sub_fluid + sub_fixed + sub_room + sub_procedure + sub_equipment + sub_medicine;
            $('.total').html(decimal(total));
        }

        function decimal(number) {
            var parts = number.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join(".");
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });


        $('#search').on('keyup', function () {
            searchFunction();
        });

        function searchFunction() {
            // Declare variables
            var input, filter, td, tr, a, i;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            td = document.getElementsByTagName('td');
            tr = document.getElementsByClassName('search_item');

            for(i=0; i < tr.length; i++){
                a = tr[i].innerHTML;
                if(a.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }

        }
    </script>
@endsection
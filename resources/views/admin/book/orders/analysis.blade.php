@extends('layouts.master')
@section('css')
@section('title')
حجم المبيعات
@stop
@endsection
@section('page-header')
<style>
    .link9h4 {
        font-size: 25px;
        color: #555;
    }

    .link9 {

        width: 5.55%;
    }

    .goal {
        align-items: center;
    }

    @media only screen and (max-width: 1300px) {
        .goal {
            width: 100%;
        }
    }

    @media only screen and (max-width: 600px) {
        .link9 {
            width: 10.11%;
        }

        .link9h4 {
            font-size: 20px;
            color: #555;
        }

        .goal {
            width: 100%;
            align-items: center;
        }
    }
</style>

<div class="page-title">
    <div class="row">
        <div class="col-sm-12" style="color:#dc3545 ; margin:10px auto; background-color: #dc3545; padding-top: 10px; padding-bottom: 10px;  border-radius:7px; display: flex; justify-content: space-around;">
            <h2 class="mb-0" style="color:#fff ; "> <i class="fa fa-home"></i> تحليل المبيعات </h2>

        </div>
    </div>

</div>

<div class="text-center" style="width:50% ;margin:0px auto ">
    <h4 class="link9h4"> اختر الصف الدراسي </h4>
</div>

<div class="row" style="width: 100%; margin: 15px auto; display: flex; justify-content: center;">
    <a href="{{route('getOrderFinishedAnalysis','four')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/3840/3840753.png" width="100%" class="pl-1 image" alt="Icon 1"></a>
    <a href="{{route('getOrderFinishedAnalysis','five')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/3840/3840754.png" width="100%" class="pl-1 image" alt="Icon 2"></a>
    <a href="{{route('getOrderFinishedAnalysis','six')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/3840/3840755.png" width="100%" class="pl-1 image" alt="Icon 3"></a>
    <a href="{{route('getOrderFinishedAnalysis','seven')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/3840/3840771.png" width="100%" class="pl-1 image" alt="Icon 4"></a>
    <a href="{{route('getOrderFinishedAnalysis','eight')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/3840/3840772.png" width="100%" class="pl-1 image" alt="Icon 5"></a>
    <a href="{{route('getOrderFinishedAnalysis','nine')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/3840/3840773.png" width="100%" class="pl-1 image" alt="Icon 6"></a>
    <a href="{{route('getOrderFinishedAnalysis','ten')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/6912/6912885.png" width="100%" class="pl-1 image" alt="Icon 7"></a>
    <a href="{{route('getOrderFinishedAnalysis','eleven')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/6912/6912910.png" width="100%" class="pl-1 image" alt="Icon 8"></a>
    <a href="{{route('getOrderFinishedAnalysis','twelve')}}" class="link9"><img src="https://cdn-icons-png.flaticon.com/128/6912/6912921.png" width="100%" class="pl-1 image" alt="Icon 9"></a>
</div>
@php
$name = request()->route('name');
@endphp


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




    <!-- breadcrumb -->
    @endsection
    @section('content')
    <!-- row -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered p-0" style="text-align:center">
                            <thead>
                                <tr>
                                    <th>اسم المعلم</th>
                                    <th>المذكرة </th>
                                    <th>الصف </th>
                                    <th> الكمية المباعة </th>
                                    <th>ارباح المعلم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr>
                                    <td>{{ $book->techer->name}}</td>
                                    <td>{{$book->name}}</td>
                                    <td>{{$book->classroom}}</td>
                                    @php
                                        $sum = 0;
                                        if ($book->ordersItem != null) {
                                            foreach ($book->ordersItem as $orderItem) {
                                                if ($orderItem->order != null) {
                                                    if ($orderItem->order->status == 'finish') {
                                                        $sum += $orderItem->quantity;
                                                    }
                                                }
                                            }
                                        }

                                        $package_id = \App\Models\PackageBook::where('book_id',$book->id)->first();
                                        if ($package_id != null) {
                                            $package = \App\Models\Package::where('id',$package_id)->first();
                                            $orders =  \App\Models\OrderBookDetail::where('status', 'finish')->whereHas('orderItem',function($query) use($package_id){
                                                $query->where('package_id',$package_id);
                                            })->with('orderItem')->get();
                                            if($orders != null){
                                                foreach ($orders as $order) {
                                                    if ($order->orderItem == null) {
                                                        $sum += $order->orderItem->sum('quantity');
                                                    }
                                                }
                                            }
                                        }

                                    @endphp
                                    <td>{{$sum}}</td>
                                    <th>{{ $sum * $book->Teacher_ratio }} دينار</th>

                                </tr>

                                @endforeach


                                </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- row closed -->
    @endsection
    @section('js')

    @endsection

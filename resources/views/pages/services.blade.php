@extends('layouts.app')

@section('content')
<div class='justify-content-md-around'>
            <div class="flex-center position-ref full-height">

                <div class="title m-b-md">
                    <h4> {{$title}}</h4>
                    @if(count($services)>0)
                        <ul class="list-group">
                            @foreach($services as $service)
                                <li class="list-group-item">{{$service}}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
</div>


@endsection

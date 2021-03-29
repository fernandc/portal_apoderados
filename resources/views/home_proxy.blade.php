<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")
    <style>
        .mrnull{
            margin: 0.2rem 0px !important;
        }
    </style>
    @if(isset($message))
        <script>
            $( document ).ready(function() {
                Swal.fire({
                    icon: '{{$message["typ"]}}',
                    title: '{{$message["tit"]}}',
                    text: '{{$message["mes"]}}'
                })
            });
        </script>
    @endif
@endsection

@section("context")
    
    
@endsection
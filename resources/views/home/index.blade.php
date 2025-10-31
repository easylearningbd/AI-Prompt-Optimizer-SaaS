@extends('home.home_master')
@section('home')

@include('home.layout.hero')
<!-- Stats Bar -->
@include('home.layout.stats_bar')
@include('home.layout.features')
@include('home.layout.how_it_works')
@include('home.layout.comparison')
@include('home.layout.pricing')
@include('home.layout.gallery')
@include('home.layout.testimonials')
@include('home.layout.cta')
@endsection
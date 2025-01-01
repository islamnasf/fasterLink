@component('mail::message')

<p><b>Brand name: </b> {{ $store->brand_name }}</p> 
<p><b>Code: </b> {{ $store->code }}</p> 
<p><b>Description: </b> {{ $store->business_description }}</p> 
<p><b>Category: </b> {{ $store->category->name }}</p> 

@endcomponent